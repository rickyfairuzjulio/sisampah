<?php

namespace App\Http\Controllers;

use App\Models\BankSampah;
use App\Models\BankSampahAdmin;
use App\Models\BankSampahDocument;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BankSampahRegistrationController extends Controller
{
    /**
     * Display the Bank Sampah registration form.
     */
    public function showForm()
    {
        return view('pendaftaran-bank-sampah.index');
    }

    /**
     * Store new Bank Sampah registration request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Identitas Pengelola
            'penanggung_jawab' => 'required|string|max:255',
            'email_pj' => 'required|email|max:255|unique:users,email',
            'telepon_pj' => 'required|string|max:50',
            'jabatan_pj' => 'nullable|string|max:100',
            'password' => 'required|string|min:8|confirmed',

            // Identitas Organisasi
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',

            // Alamat & Koordinat GPS
            'alamat' => 'required|string',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',

            // Operasional & Radius
            'jam_buka' => 'required|string',
            'jam_tutup' => 'required|string',
            'hari_operasional' => 'required|string',
            'radius_layanan' => 'required|integer|min:500|max:50000', // meters

            // Upload Dokumen Wajib
            'doc_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_legalitas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'doc_domisili' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_foto_lokasi' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'doc_rekening' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Generate registration code & slug
        $nomorRegistrasi = 'REG-BS-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $slug = Str::slug($validated['nama']) . '-' . Str::random(5);

        // 1. Create Bank Sampah record with 'submitted' status
        $bankSampah = BankSampah::create([
            'kode_bank' => 'BS-' . Str::upper(Str::random(4)),
            'nomor_registrasi' => $nomorRegistrasi,
            'nama' => $validated['nama'],
            'penanggung_jawab' => $validated['penanggung_jawab'],
            'telepon_pj' => $validated['telepon_pj'],
            'email_pj' => $validated['email_pj'],
            'slug' => $slug,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'email' => $validated['email'] ?? $validated['email_pj'],
            'telepon' => $validated['telepon'] ?? $validated['telepon_pj'],
            'whatsapp' => $validated['whatsapp'] ?? $validated['telepon_pj'],
            'alamat' => $validated['alamat'],
            'provinsi' => $validated['provinsi'],
            'kabupaten' => $validated['kabupaten'],
            'kecamatan' => $validated['kecamatan'],
            'desa' => $validated['desa'] ?? null,
            'kode_pos' => $validated['kode_pos'] ?? null,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'jam_buka' => $validated['jam_buka'],
            'jam_tutup' => $validated['jam_tutup'],
            'hari_operasional' => $validated['hari_operasional'],
            'radius_layanan' => $validated['radius_layanan'],
            'status' => 'nonaktif', // Requires Super Admin verification to activate
            'status_verifikasi' => 'submitted',
        ]);

        // 2. Upload mandatory documents
        $docTypes = [
            'doc_ktp' => 'ktp',
            'doc_legalitas' => 'legalitas',
            'doc_domisili' => 'domisili',
            'doc_foto_lokasi' => 'foto_lokasi',
            'doc_rekening' => 'rekening',
        ];

        foreach ($docTypes as $requestKey => $jenisDokumen) {
            if ($request->hasFile($requestKey)) {
                $filePath = $request->file($requestKey)->store('bank-sampah/dokumen/' . $bankSampah->id, 'public');
                BankSampahDocument::create([
                    'bank_sampah_id' => $bankSampah->id,
                    'jenis_dokumen' => $jenisDokumen,
                    'file_path' => $filePath,
                    'status_review' => 'pending',
                ]);
            }
        }

        // 3. Create Admin User account for primary manager
        $user = User::create([
            'name' => $validated['penanggung_jawab'],
            'email' => $validated['email_pj'],
            'password' => Hash::make($validated['password']),
            'nomor_telepon' => $validated['telepon_pj'],
            'alamat_lengkap' => $validated['alamat'],
            'bank_sampah_id' => $bankSampah->id,
            'saldo' => 0,
        ]);
        $user->assignRole('admin');

        // Link primary admin to bank_sampah_admins
        BankSampahAdmin::create([
            'bank_sampah_id' => $bankSampah->id,
            'user_id' => $user->id,
            'is_primary' => true,
            'assigned_at' => now(),
        ]);

        // Log Audit Trail
        AuditLogger::log(
            'REGISTRATION_SUBMITTED',
            'BankSampah',
            $bankSampah->id,
            null,
            ['status_verifikasi' => 'submitted', 'nomor_registrasi' => $nomorRegistrasi],
            "Pendaftaran Bank Sampah '{$bankSampah->nama}' diajukan oleh {$validated['penanggung_jawab']}."
        );

        return redirect()->route('pendaftaran_bank_sampah.tracking', ['reg' => $nomorRegistrasi])
            ->with('success', "Pendaftaran Bank Sampah '{$bankSampah->nama}' berhasil dikirim! Simpan Nomor Registrasi Anda: {$nomorRegistrasi}.");
    }

    /**
     * Display status tracking page.
     */
    public function trackingForm(Request $request)
    {
        $regCode = $request->input('reg');
        $bankSampah = null;

        if ($regCode) {
            $bankSampah = BankSampah::where('nomor_registrasi', $regCode)
                ->orWhere('kode_bank', $regCode)
                ->with(['documents', 'verifications'])
                ->first();
        }

        return view('pendaftaran-bank-sampah.tracking', compact('regCode', 'bankSampah'));
    }

    /**
     * Re-upload revised document from tracking page.
     */
    public function reuploadDocument(Request $request)
    {
        $validated = $request->validate([
            'document_id' => 'required|exists:bank_sampah_documents,id',
            'reg_code' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $document = BankSampahDocument::findOrFail($validated['document_id']);
        $bankSampah = BankSampah::where('nomor_registrasi', $validated['reg_code'])
            ->orWhere('kode_bank', $validated['reg_code'])
            ->firstOrFail();

        if ($document->bank_sampah_id !== $bankSampah->id) {
            return back()->with('error', 'Dokumen tidak valid untuk pendaftaran ini.');
        }

        $filePath = $request->file('file')->store('bank-sampah/dokumen/' . $bankSampah->id, 'public');

        $document->update([
            'file_path' => $filePath,
            'status_review' => 'pending',
            'catatan' => null,
        ]);

        $hasRevisions = BankSampahDocument::where('bank_sampah_id', $bankSampah->id)
            ->where('status_review', 'revision_requested')
            ->exists();

        if (!$hasRevisions) {
            $bankSampah->update(['status_verifikasi' => 'under_review']);
        }

        AuditLogger::log(
            'DOCUMENT_REUPLOADED',
            'BankSampahDocument',
            $document->id,
            null,
            ['jenis_dokumen' => $document->jenis_dokumen],
            "Dokumen {$document->jenis_dokumen} berhasil diunggah ulang oleh pendaftar."
        );

        return redirect()->route('pendaftaran_bank_sampah.tracking', ['reg' => $validated['reg_code']])
            ->with('success', "Dokumen " . strtoupper(str_replace('_', ' ', $document->jenis_dokumen)) . " berhasil diunggah ulang dan dikirim ke Super Admin!");
    }
}
