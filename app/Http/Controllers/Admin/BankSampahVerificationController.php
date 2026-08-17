<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BankSampahRevisionMail;
use App\Models\BankSampah;
use App\Models\BankSampahAdmin;
use App\Models\BankSampahDocument;
use App\Models\BankSampahVerification;
use App\Models\User;
use App\Services\AuditLogger;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BankSampahVerificationController extends Controller
{
    /**
     * Display registration review queue for Super Admin.
     */
    public function index(Request $request)
    {
        $query = BankSampah::withCount(['documents', 'verifications', 'admins']);

        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->input('status_verifikasi'));
        } else {
            $query->whereNotIn('status_verifikasi', ['draft']);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%")
                  ->orWhere('nomor_registrasi', 'like', "%{$search}%")
                  ->orWhere('email_pj', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total_submitted' => BankSampah::where('status_verifikasi', 'submitted')->count(),
            'under_review' => BankSampah::where('status_verifikasi', 'under_review')->count(),
            'meeting_scheduled' => BankSampah::where('status_verifikasi', 'meeting_scheduled')->count(),
            'verified' => BankSampah::whereIn('status_verifikasi', ['verified', 'active'])->count(),
        ];

        return view('admin.bank-sampah.verifications.index', compact('registrations', 'stats'));
    }

    /**
     * Detailed verification workbench.
     */
    public function show($id)
    {
        $bankSampah = BankSampah::with(['documents', 'verifications.verifier', 'admins.user'])
            ->findOrFail($id);

        return view('admin.bank-sampah.verifications.show', compact('bankSampah'));
    }

    /**
     * Update individual document review status.
     */
    public function reviewDocument(Request $request, $id, $docId)
    {
        $document = BankSampahDocument::where('bank_sampah_id', $id)->findOrFail($docId);

        $validated = $request->validate([
            'status_review' => 'required|in:approved,revision_requested,rejected',
            'catatan' => 'nullable|string',
        ]);

        $document->update([
            'status_review' => $validated['status_review'],
            'catatan' => $validated['catatan'] ?? null,
            'reviewed_by' => auth()->id(),
        ]);

        $bankSampah = BankSampah::findOrFail($id);
        $waUrl = null;

        if ($validated['status_review'] === 'revision_requested') {
            $bankSampah->status_verifikasi = 'document_revision';
            $bankSampah->save();

            // Format WhatsApp notification message
            $docName = strtoupper(str_replace('_', ' ', $document->jenis_dokumen));
            $trackingLink = route('pendaftaran_bank_sampah.tracking', ['reg' => $bankSampah->nomor_registrasi ?: $bankSampah->kode_bank]);
            
            $waMessage = "Halo *{$bankSampah->penanggung_jawab}*,\n\n"
                       . "Permohonan pendaftaran unit *{$bankSampah->nama}* memerlukan revisi pada dokumen *{$docName}*.\n\n"
                       . "📝 *Catatan Revisi Super Admin*:\n"
                       . "\"" . ($document->catatan ?: 'Mohon unggah dokumen perbaikan yang sesuai.') . "\"\n\n"
                       . "🔗 *Klik link berikut untuk mengunggah ulang dokumen perbaikan Anda*:\n"
                       . "{$trackingLink}\n\n"
                       . "Terima kasih,\n"
                       . "*Tim Admin SiSampah*";

            $phone = $bankSampah->telepon_pj ?: $bankSampah->whatsapp;
            if ($phone) {
                // Send automated WA notification via API (if TOKEN configured) or log
                WhatsAppService::sendNotification($phone, $waMessage);

                // Generate direct WA Click-to-Chat URL for Super Admin
                $waUrl = WhatsAppService::getWaUrl($phone, $waMessage);
            }

            // Also try sending email as fallback
            if ($bankSampah->email_pj) {
                try {
                    Mail::to($bankSampah->email_pj)->send(new BankSampahRevisionMail($bankSampah, $document));
                } catch (\Exception $e) {
                    Log::warning("Failed sending email fallback: " . $e->getMessage());
                }
            }
        }

        AuditLogger::log(
            'DOCUMENT_REVIEWED',
            'BankSampahDocument',
            $document->id,
            null,
            ['status_review' => $validated['status_review'], 'catatan' => $validated['catatan'] ?? null],
            "Dokumen {$document->jenis_dokumen} direview oleh Super Admin."
        );

        $redirect = back()->with('success', "Status dokumen {$document->jenis_dokumen} diperbarui.");
        if ($waUrl) {
            $redirect->with('wa_url', $waUrl)->with('wa_target', $bankSampah->telepon_pj);
        }

        return $redirect;
    }

    /**
     * Schedule online or offline meeting verification.
     */
    public function scheduleMeeting(Request $request, $id)
    {
        $bankSampah = BankSampah::findOrFail($id);

        $validated = $request->validate([
            'method' => 'required|in:online,offline',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        BankSampahVerification::create([
            'bank_sampah_id' => $bankSampah->id,
            'method' => $validated['method'],
            'scheduled_at' => $validated['scheduled_at'],
            'result' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'verified_by' => auth()->id(),
        ]);

        $bankSampah->update(['status_verifikasi' => 'meeting_scheduled']);

        AuditLogger::log(
            'MEETING_SCHEDULED',
            'BankSampah',
            $bankSampah->id,
            null,
            $validated,
            "Validasi pertemuan ({$validated['method']}) dijadwalkan pada {$validated['scheduled_at']}."
        );

        return back()->with('success', 'Jadwal pertemuan validasi berhasil disimpan.');
    }

    /**
     * Record result of verification meeting.
     */
    public function recordMeetingResult(Request $request, $id)
    {
        $bankSampah = BankSampah::findOrFail($id);
        $verification = BankSampahVerification::where('bank_sampah_id', $id)->latest()->firstOrFail();

        $validated = $request->validate([
            'result' => 'required|in:verified,rejected,revision',
            'notes' => 'nullable|string',
            'evidence' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('evidence')) {
            $validated['evidence_path'] = $request->file('evidence')->store('bank-sampah/verifications/' . $id, 'public');
        }

        $verification->update([
            'result' => $validated['result'],
            'notes' => $validated['notes'] ?? null,
            'evidence_path' => $validated['evidence_path'] ?? $verification->evidence_path,
            'completed_at' => now(),
        ]);

        AuditLogger::log(
            'MEETING_RESULT_RECORDED',
            'BankSampahVerification',
            $verification->id,
            null,
            $validated,
            "Hasil pertemuan dicatat: {$validated['result']}."
        );

        return back()->with('success', 'Hasil verifikasi pertemuan berhasil dicatat.');
    }

    /**
     * Final approval & activation of Bank Sampah.
     */
    public function approveAndActivate(Request $request, $id)
    {
        $bankSampah = BankSampah::findOrFail($id);

        $bankSampah->update([
            'status_verifikasi' => 'verified',
            'status' => 'aktif',
        ]);

        // Ensure primary admin user account is activated and role assigned
        $primaryAdminLink = BankSampahAdmin::where('bank_sampah_id', $id)->where('is_primary', true)->first();
        if ($primaryAdminLink) {
            $user = User::find($primaryAdminLink->user_id);
            if ($user) {
                $user->assignRole('admin');
            }
        }

        AuditLogger::log(
            'BANK_SAMPAH_ACTIVATED',
            'BankSampah',
            $bankSampah->id,
            ['status' => 'nonaktif', 'status_verifikasi' => $bankSampah->status_verifikasi],
            ['status' => 'aktif', 'status_verifikasi' => 'verified'],
            "Bank Sampah '{$bankSampah->nama}' secara resmi DISETUJUI & DIAKTIFKAN oleh Super Admin."
        );

        return redirect()->route('admin.verifikasi_bank_sampah.index')
            ->with('success', "Bank Sampah '{$bankSampah->nama}' berhasil disetujui & diaktifkan.");
    }

    /**
     * Reject registration request.
     */
    public function reject(Request $request, $id)
    {
        $bankSampah = BankSampah::findOrFail($id);
        $reason = $request->input('reason', 'Tidak memenuhi kriteria kelayakan.');

        $bankSampah->update([
            'status_verifikasi' => 'rejected',
            'status' => 'nonaktif',
        ]);

        AuditLogger::log(
            'BANK_SAMPAH_REJECTED',
            'BankSampah',
            $bankSampah->id,
            null,
            ['reason' => $reason],
            "Permohonan Bank Sampah '{$bankSampah->nama}' ditolak. Alasan: {$reason}"
        );

        return redirect()->route('admin.verifikasi_bank_sampah.index')
            ->with('success', "Permohonan Bank Sampah '{$bankSampah->nama}' telah ditolak.");
    }
}
