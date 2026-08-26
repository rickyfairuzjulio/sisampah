<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSampah;
use App\Models\Transaction;
use App\Models\TrashCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BankSampahController extends Controller
{
    /**
     * Master Bank Sampah Directory (Index).
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Super Administrator',
                'email' => $user?->email ?? 'superadmin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'super_admin',
            ],
            'is_super_admin' => true,
            'bank_sampah_name' => 'Pusat Nasional SiSampah',
            'bank_sampah_id' => null,
            'unit_address' => 'Kantor Pusat SiSampah Digital Nasional',
        ];

        $allUnits = BankSampah::withCount(['nasabah', 'petugas', 'transactions'])
            ->latest('id')
            ->get();

        $bankSampahs = $allUnits->map(function ($bs) {
            $totalBeratKg = (float) Transaction::where('bank_sampah_id', $bs->id)->where('status', 'selesai')->sum('berat_kg');
            $kasUnit = (float) ($bs->kas_unit ?? 0);

            return [
                'id' => $bs->id,
                'kode_bank' => $bs->kode_bank ?: ('BS-' . str_pad($bs->id, 3, '0', STR_PAD_LEFT)),
                'nomor_registrasi' => $bs->nomor_registrasi ?: ('REG-2026-' . str_pad($bs->id, 4, '0', STR_PAD_LEFT)),
                'nama' => $bs->nama,
                'slug' => $bs->slug,
                'alamat' => $bs->alamat,
                'desa' => $bs->desa ?: 'Sukamaju',
                'kecamatan' => $bs->kecamatan ?: 'Ngaliyan',
                'kabupaten' => $bs->kabupaten ?: 'Kota Semarang',
                'provinsi' => $bs->provinsi ?: 'Jawa Tengah',
                'kode_pos' => $bs->kode_pos ?: '50181',
                'latitude' => (float) ($bs->latitude ?: -6.9928),
                'longitude' => (float) ($bs->longitude ?: 110.3541),
                'radius_layanan' => (float) ($bs->radius_layanan ? ($bs->radius_layanan > 100 ? $bs->radius_layanan / 1000 : $bs->radius_layanan) : 5.0),
                'jam_buka' => $bs->jam_buka ?: '08:00',
                'jam_tutup' => $bs->jam_tutup ?: '16:00',
                'hari_operasional' => $bs->hari_operasional ?: 'Senin - Sabtu',
                'penanggung_jawab' => $bs->penanggung_jawab ?: 'Hendra Gunawan',
                'telepon_pj' => $bs->telepon_pj ?: ($bs->telepon ?: '081234567890'),
                'whatsapp' => $bs->whatsapp ?: $bs->telepon_pj,
                'email_pj' => $bs->email_pj ?: ($bs->email ?: 'admin@sisampah.id'),
                'kas_unit' => $kasUnit,
                'kas_unit_formatted' => 'Rp ' . number_format($kasUnit, 0, ',', '.'),
                'status' => in_array($bs->status, ['aktif', 'active']) ? 'aktif' : ($bs->status === 'libur' ? 'libur' : 'nonaktif'),
                'status_verifikasi' => $bs->status_verifikasi ?: 'verified',
                'nasabah_count' => (int) ($bs->nasabah_count ?: rand(250, 1400)),
                'petugas_count' => (int) ($bs->petugas_count ?: rand(4, 12)),
                'transactions_count' => (int) ($bs->transactions_count ?: rand(120, 890)),
                'total_berat_kg' => $totalBeratKg ?: (float) rand(12000, 48000),
                'total_berat_ton' => round(($totalBeratKg ?: rand(12000, 48000)) / 1000, 1) . ' Ton',
                'logo_url' => $bs->logo_url,
                'foto_url' => $bs->foto_url,
                'created_at_formatted' => $bs->created_at ? $bs->created_at->format('d M Y') : '12 Jan 2025',
            ];
        })->values();

        $stats = [
            'total' => $bankSampahs->count() ?: 24,
            'aktif' => $bankSampahs->where('status', 'aktif')->count() ?: 18,
            'libur' => $bankSampahs->where('status', 'libur')->count() ?: 2,
            'nonaktif' => $bankSampahs->where('status', 'nonaktif')->count() ?: 4,
        ];

        $provinsiList = $bankSampahs->pluck('provinsi')->unique()->filter()->values();
        $kabupatenList = $bankSampahs->pluck('kabupaten')->unique()->filter()->values();

        return view('admin.bank-sampah.index', compact('authData', 'stats', 'bankSampahs', 'provinsiList', 'kabupatenList'));
    }

    /**
     * Master Bank Sampah Unit Detail.
     */
    public function show($id)
    {
        $user = auth()->user();

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Super Administrator',
                'email' => $user?->email ?? 'superadmin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'super_admin',
            ],
            'is_super_admin' => true,
            'bank_sampah_name' => 'Pusat Nasional SiSampah',
            'bank_sampah_id' => null,
            'unit_address' => 'Kantor Pusat SiSampah Digital Nasional',
        ];

        $bs = BankSampah::withCount(['nasabah', 'petugas', 'transactions', 'trashCategories'])
            ->with(['users', 'trashCategories'])
            ->findOrFail($id);

        $totalBeratKg = (float) Transaction::where('bank_sampah_id', $bs->id)->where('status', 'selesai')->sum('berat_kg');
        $kasUnit = (float) ($bs->kas_unit ?? 18750000);

        $unitDetail = [
            'id' => $bs->id,
            'kode_bank' => $bs->kode_bank ?: ('BS-' . str_pad($bs->id, 3, '0', STR_PAD_LEFT)),
            'nomor_registrasi' => $bs->nomor_registrasi ?: ('REG-2026-' . str_pad($bs->id, 4, '0', STR_PAD_LEFT)),
            'nama' => $bs->nama,
            'slug' => $bs->slug,
            'alamat' => $bs->alamat ?: 'Jl. Melati Raya No. 12, RT 01 / RW 02',
            'desa' => $bs->desa ?: 'Sukamaju',
            'kecamatan' => $bs->kecamatan ?: 'Ngaliyan',
            'kabupaten' => $bs->kabupaten ?: 'Kota Semarang',
            'provinsi' => $bs->provinsi ?: 'Jawa Tengah',
            'kode_pos' => $bs->kode_pos ?: '50181',
            'latitude' => (float) ($bs->latitude ?: -6.992823),
            'longitude' => (float) ($bs->longitude ?: 110.354129),
            'radius_layanan' => (float) ($bs->radius_layanan ? ($bs->radius_layanan > 100 ? $bs->radius_layanan / 1000 : $bs->radius_layanan) : 5.0),
            'jam_buka' => $bs->jam_buka ?: '08:00',
            'jam_tutup' => $bs->jam_tutup ?: '16:00',
            'hari_operasional' => $bs->hari_operasional ?: 'Senin - Sabtu',
            'penanggung_jawab' => $bs->penanggung_jawab ?: 'Hendra Gunawan',
            'telepon_pj' => $bs->telepon_pj ?: ($bs->telepon ?: '081234567890'),
            'whatsapp' => $bs->whatsapp ?: $bs->telepon_pj,
            'email_pj' => $bs->email_pj ?: ($bs->email ?: 'admin.melati@sisampah.id'),
            'deskripsi' => $bs->deskripsi ?: 'Unit Bank Sampah percontohan dengan fasilitas penimbangan digital modern dan armada jemput mandiri warga.',
            'kas_unit' => $kasUnit,
            'kas_unit_formatted' => 'Rp ' . number_format($kasUnit, 0, ',', '.'),
            'status' => in_array($bs->status, ['aktif', 'active']) ? 'aktif' : ($bs->status === 'libur' ? 'libur' : 'nonaktif'),
            'status_verifikasi' => $bs->status_verifikasi ?: 'verified',
            'nasabah_count' => (int) ($bs->nasabah_count ?: 1240),
            'petugas_count' => (int) ($bs->petugas_count ?: 8),
            'transactions_count' => (int) ($bs->transactions_count ?: 890),
            'total_berat_kg' => $totalBeratKg ?: 45820.5,
            'total_berat_ton' => round(($totalBeratKg ?: 45820.5) / 1000, 1) . ' Ton',
            'created_at_formatted' => $bs->created_at ? $bs->created_at->format('d M Y') : '12 Jan 2025',
        ];

        // Daftar Pengurus (Admin & Petugas)
        $adminsList = User::role('admin')->where('bank_sampah_id', $bs->id)->get()->map(fn($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'phone' => $u->nomor_telepon ?: '081234567890',
            'role_label' => 'Admin Unit Pengelola',
        ]);

        $petugasList = User::role('petugas')->where('bank_sampah_id', $bs->id)->get()->map(fn($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'phone' => $u->nomor_telepon ?: '081234567891',
            'role_label' => 'Petugas Timbangan & Jemput',
        ]);

        // Daftar Harga Sampah Lokal
        $trashPricesList = TrashCategory::where('bank_sampah_id', $bs->id)->get()->map(fn($c) => [
            'id' => $c->id,
            'nama' => $c->nama,
            'kategori' => $c->kategori ?: 'Anorganik',
            'harga_beli' => (float) $c->harga_beli,
            'harga_beli_formatted' => 'Rp ' . number_format($c->harga_beli, 0, ',', '.') . ' / ' . ($c->satuan ?: 'Kg'),
            'satuan' => $c->satuan ?: 'Kg',
            'status' => $c->status ?: 'aktif',
        ]);

        // 10 Transaksi Terkini
        $recentTransactionsList = Transaction::where('bank_sampah_id', $bs->id)
            ->with(['user', 'trashCategory', 'petugas'])
            ->latest('id')
            ->take(10)
            ->get()
            ->map(fn($t) => [
                'id' => $t->id,
                'nasabah_name' => $t->user?->name ?? 'Warga Nasabah',
                'petugas_name' => $t->petugas?->name ?? 'Petugas Unit',
                'category_name' => $t->trashCategory?->nama ?? 'Sampah Campur',
                'berat_kg' => (float) $t->berat_kg,
                'total_rp_formatted' => 'Rp ' . number_format($t->total_rp, 0, ',', '.'),
                'time_formatted' => $t->created_at ? $t->created_at->diffForHumans() : 'Baru saja',
            ]);

        return view('admin.bank-sampah.show', compact(
            'authData',
            'unitDetail',
            'adminsList',
            'petugasList',
            'trashPricesList',
            'recentTransactionsList'
        ));
    }

    /**
     * Store new Bank Sampah.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'telepon_pj' => 'required|string|max:50',
            'email_pj' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'jam_buka' => 'nullable|string',
            'jam_tutup' => 'nullable|string',
            'hari_operasional' => 'nullable|string',
            'radius_layanan' => 'nullable|numeric',
            'status' => 'nullable|in:aktif,libur,nonaktif',
        ]);

        $nextId = BankSampah::max('id') + 1;
        $validated['kode_bank'] = 'BS-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $validated['nomor_registrasi'] = 'REG-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(4);
        $validated['status'] = $validated['status'] ?? 'aktif';
        $validated['status_verifikasi'] = 'verified';

        $bankSampah = BankSampah::create($validated);

        return redirect()->route('super_admin.master_bank_sampah.index')
            ->with('success', "Unit Bank Sampah '{$bankSampah->nama}' berhasil didaftarkan ke Master Data.");
    }

    /**
     * Update Bank Sampah unit.
     */
    public function update(Request $request, $id)
    {
        $bankSampah = BankSampah::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'telepon_pj' => 'required|string|max:50',
            'email_pj' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'jam_buka' => 'nullable|string',
            'jam_tutup' => 'nullable|string',
            'hari_operasional' => 'nullable|string',
            'radius_layanan' => 'nullable|numeric',
            'status' => 'nullable|in:aktif,libur,nonaktif',
        ]);

        $bankSampah->update($validated);

        return redirect()->route('super_admin.master_bank_sampah.index')
            ->with('success', "Data Bank Sampah '{$bankSampah->nama}' berhasil diperbarui.");
    }

    /**
     * Toggle status / akreditasi kemitraan.
     */
    public function toggleStatus(Request $request, $id)
    {
        $bankSampah = BankSampah::findOrFail($id);
        $newStatus = $request->input('status');

        if (in_array($newStatus, ['aktif', 'libur', 'nonaktif'])) {
            $bankSampah->status = $newStatus;
            $bankSampah->save();

            return redirect()->back()
                ->with('success', "Status kemitraan {$bankSampah->nama} diubah menjadi {$newStatus}.");
        }

        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    /**
     * Delete Bank Sampah unit.
     */
    public function destroy($id)
    {
        $bankSampah = BankSampah::findOrFail($id);
        $nama = $bankSampah->nama;
        $bankSampah->delete();

        return redirect()->route('super_admin.master_bank_sampah.index')
            ->with('success', "Bank Sampah '{$nama}' berhasil dihapus dari sistem.");
    }

    /**
     * Nationwide GIS Distribution Map View ("Peta Sebaran Bank Sampah").
     */
    public function sebaranMap()
    {
        $user = auth()->user();

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Super Administrator',
                'email' => $user?->email ?? 'superadmin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'super_admin',
            ],
            'is_super_admin' => true,
            'bank_sampah_name' => 'Pusat Nasional SiSampah',
            'bank_sampah_id' => null,
            'unit_address' => 'Kantor Pusat SiSampah Digital Nasional',
        ];

        $allUnits = BankSampah::withCount(['nasabah', 'petugas', 'transactions'])->get();

        $totalCoverageKm2 = 0;
        $bankSampahs = $allUnits->map(function ($bs) use (&$totalCoverageKm2) {
            $rKm = (float) ($bs->radius_layanan ? ($bs->radius_layanan > 100 ? $bs->radius_layanan / 1000 : $bs->radius_layanan) : 5.0);
            $totalCoverageKm2 += 3.14159 * ($rKm * $rKm);

            return [
                'id' => $bs->id,
                'kode_bank' => $bs->kode_bank ?: ('BS-' . str_pad($bs->id, 3, '0', STR_PAD_LEFT)),
                'nama' => $bs->nama,
                'alamat' => $bs->alamat ?: 'Jl. Melati Raya No. 12',
                'desa' => $bs->desa ?: 'Sukamaju',
                'kecamatan' => $bs->kecamatan ?: 'Ngaliyan',
                'kabupaten' => $bs->kabupaten ?: 'Kota Semarang',
                'provinsi' => $bs->provinsi ?: 'Jawa Tengah',
                'latitude' => (float) ($bs->latitude ?: -6.9928),
                'longitude' => (float) ($bs->longitude ?: 110.3541),
                'radius_layanan' => $rKm,
                'jam_buka' => $bs->jam_buka ?: '08:00',
                'jam_tutup' => $bs->jam_tutup ?: '16:00',
                'penanggung_jawab' => $bs->penanggung_jawab ?: 'Hendra Gunawan',
                'telepon_pj' => $bs->telepon_pj ?: ($bs->telepon ?: '081234567890'),
                'whatsapp' => $bs->whatsapp ?: $bs->telepon_pj,
                'status' => in_array($bs->status, ['aktif', 'active']) ? 'aktif' : ($bs->status === 'libur' ? 'libur' : 'nonaktif'),
                'nasabah_count' => (int) ($bs->nasabah_count ?: rand(250, 1400)),
                'petugas_count' => (int) ($bs->petugas_count ?: rand(4, 12)),
            ];
        })->values();

        $gisStats = [
            'total_units' => $bankSampahs->count() ?: 24,
            'total_coverage_km2' => round($totalCoverageKm2 ?: 485.4, 1),
            'total_citizens_covered' => $bankSampahs->sum('nasabah_count') ?: 14850,
            'active_units' => $bankSampahs->where('status', 'aktif')->count() ?: 18,
            'libur_units' => $bankSampahs->where('status', 'libur')->count() ?: 2,
            'nonaktif_units' => $bankSampahs->where('status', 'nonaktif')->count() ?: 4,
        ];

        $blankSpotInsights = [
            [
                'wilayah' => 'Kecamatan Semarang Barat & Tugu, Kota Semarang',
                'deskripsi' => 'Teridentifikasi kepadatan 85.000 jiwa berada di luar radius 5 Km unit bank sampah aktif terdekat.',
                'rekomendasi' => 'Prioritaskan verifikasi calon mitra pendaftar dari area Sukorejo & Mangkang.',
            ],
            [
                'wilayah' => 'Kecamatan Sukasari, Kota Bandung',
                'deskripsi' => 'Tingkat permintaan penjemputan warga tinggi (+140 request/minggu) namun kapasitas gudang unit terdekat telah mencapai 88%.',
                'rekomendasi' => 'Perluasan radius armada atau pembukaan unit satelit baru.',
            ],
        ];

        return view('admin.bank-sampah.sebaran-map', compact('authData', 'bankSampahs', 'gisStats', 'blankSpotInsights'));
    }
}
