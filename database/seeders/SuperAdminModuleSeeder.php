<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\BankSampah;
use App\Models\BankSampahDocument;
use App\Models\BankSampahVerification;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminModuleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::role('super_admin')->first() ?: User::first();

        // 1. Update existing bank sampah 1-5 to 'verified'
        BankSampah::whereIn('id', [1, 2, 3, 4, 5])->update([
            'status' => 'aktif',
            'status_verifikasi' => 'verified',
            'penanggung_jawab' => 'Hendra Gunawan',
            'telepon_pj' => '081234567890',
            'email_pj' => 'admin@sisampah.id',
        ]);

        // 2. Add sample new bank sampah registrations in various pipeline stages
        $newUnits = [
            [
                'kode_bank' => 'BS-BDG-006',
                'nomor_registrasi' => 'REG-2026-0812',
                'nama' => 'Bank Sampah Berkah Mandiri',
                'slug' => 'bank-sampah-berkah-mandiri',
                'penanggung_jawab' => 'H. Suwarno, S.Pd',
                'telepon_pj' => '081234567891',
                'email_pj' => 'suwarno.berkah@gmail.com',
                'deskripsi' => 'Inisiatif bank sampah warga RW 05 dengan fokus pemilahan sampah anorganik dan budidaya maggot.',
                'alamat' => 'Jl. Sukajadi No. 45, RT 03 / RW 05',
                'desa' => 'Pasteur',
                'kecamatan' => 'Sukajadi',
                'kabupaten' => 'Kota Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40161',
                'latitude' => -6.8928,
                'longitude' => 107.5941,
                'radius_layanan' => 3000,
                'kas_unit' => 2500000,
                'status' => 'nonaktif',
                'status_verifikasi' => 'submitted',
            ],
            [
                'kode_bank' => 'BS-SBY-007',
                'nomor_registrasi' => 'REG-2026-0810',
                'nama' => 'Bank Sampah Lestari Mandiri',
                'slug' => 'bank-sampah-lestari-mandiri',
                'penanggung_jawab' => 'Siti Aminah, S.T.',
                'telepon_pj' => '081987654322',
                'email_pj' => 'siti.aminah@lestari.id',
                'deskripsi' => 'Pengelolaan sampah terpadu skala kelurahan dengan armada motor roda tiga.',
                'alamat' => 'Jl. Rungkut Asri Timur No. 45, RT 02 / RW 04',
                'desa' => 'Rungkut Kidul',
                'kecamatan' => 'Rungkut',
                'kabupaten' => 'Kota Surabaya',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '60293',
                'latitude' => -7.3190,
                'longitude' => 112.7750,
                'radius_layanan' => 4000,
                'kas_unit' => 3800000,
                'status' => 'nonaktif',
                'status_verifikasi' => 'under_review',
            ],
            [
                'kode_bank' => 'BS-DPS-008',
                'nomor_registrasi' => 'REG-2026-0808',
                'nama' => 'Bank Sampah Asri Dewata',
                'slug' => 'bank-sampah-asri-dewata',
                'penanggung_jawab' => 'I Wayan Sudarma',
                'telepon_pj' => '085234567893',
                'email_pj' => 'wayan.dewata@gmail.com',
                'deskripsi' => 'Pusat daur ulang sampah plastik pariwisata dan edukasi pemilahan sampah banjar.',
                'alamat' => 'Banjar Kawan, Jl. Hayam Wuruk No. 88',
                'desa' => 'Sumerta Kelod',
                'kecamatan' => 'Denpasar Timur',
                'kabupaten' => 'Kota Denpasar',
                'provinsi' => 'Bali',
                'kode_pos' => '80239',
                'latitude' => -8.6500,
                'longitude' => 115.2300,
                'radius_layanan' => 5000,
                'kas_unit' => 5200000,
                'status' => 'nonaktif',
                'status_verifikasi' => 'meeting_scheduled',
            ],
            [
                'kode_bank' => 'BS-MDN-009',
                'nomor_registrasi' => 'REG-2026-0715',
                'nama' => 'Bank Sampah Hijau Deli',
                'slug' => 'bank-sampah-hijau-deli',
                'penanggung_jawab' => 'Rina Marlina',
                'telepon_pj' => '081398765434',
                'email_pj' => 'rina.deli@gmail.com',
                'deskripsi' => 'Pengolahan sampah organik pasar tradisional dan bank sampah anorganik pemukiman.',
                'alamat' => 'Jl. Sisingamangaraja No. 55',
                'desa' => 'Teladan Barat',
                'kecamatan' => 'Medan Kota',
                'kabupaten' => 'Kota Medan',
                'provinsi' => 'Sumatera Utara',
                'kode_pos' => '20217',
                'latitude' => 3.5852,
                'longitude' => 98.6756,
                'radius_layanan' => 3500,
                'kas_unit' => 1200000,
                'status' => 'nonaktif',
                'status_verifikasi' => 'rejected',
            ],
            [
                'kode_bank' => 'BS-BTN-010',
                'nomor_registrasi' => 'REG-2026-0801',
                'nama' => 'Bank Sampah Mutiara Banten',
                'slug' => 'bank-sampah-mutiara-banten',
                'penanggung_jawab' => 'Ahmad Fauzi',
                'telepon_pj' => '081234567895',
                'email_pj' => 'ahmad.fauzi@banten.id',
                'deskripsi' => 'Pengumpulan kardus, minyak jelantah, dan plastik residu lingkungan pesisir.',
                'alamat' => 'Jl. Raya Serang Km 14',
                'desa' => 'Cikupa',
                'kecamatan' => 'Cikupa',
                'kabupaten' => 'Kab. Tangerang',
                'provinsi' => 'Banten',
                'kode_pos' => '15710',
                'latitude' => -6.2389,
                'longitude' => 106.5167,
                'radius_layanan' => 4500,
                'kas_unit' => 1800000,
                'status' => 'nonaktif',
                'status_verifikasi' => 'document_revision',
            ],
        ];

        foreach ($newUnits as $unitData) {
            $bs = BankSampah::updateOrCreate(
                ['kode_bank' => $unitData['kode_bank']],
                $unitData
            );

            // 3. Buat dokumen legalitas untuk setiap unit
            $docTypes = [
                ['tipe' => 'sk_pendirian', 'nomor' => 'SK/01/2026', 'status' => 'approved'],
                ['tipe' => 'ktp_pj', 'nomor' => '3273012345670001', 'status' => 'approved'],
                ['tipe' => 'foto_lokasi', 'nomor' => 'DOK-FOTO-01', 'status' => 'approved'],
                ['tipe' => 'surat_izin_dlh', 'nomor' => 'DLH/660/88/2026', 'status' => $unitData['status_verifikasi'] === 'document_revision' ? 'revision_requested' : 'approved'],
            ];

            foreach ($docTypes as $doc) {
                BankSampahDocument::updateOrCreate(
                    [
                        'bank_sampah_id' => $bs->id,
                        'jenis_dokumen' => $doc['tipe'],
                    ],
                    [
                        'nomor_dokumen' => $doc['nomor'],
                        'file_path' => "documents/bank-sampah/{$doc['tipe']}_{$bs->id}.pdf",
                        'status_review' => $doc['status'],
                        'catatan' => $doc['status'] === 'revision_requested' ? 'Resolusi scan kurang jelas, mohon upload ulang berkas bertanda tangan asli.' : null,
                        'reviewed_by' => $superAdmin?->id,
                    ]
                );
            }

            // 4. Tambah riwayat verifikasi
            BankSampahVerification::updateOrCreate(
                [
                    'bank_sampah_id' => $bs->id,
                    'method' => 'online',
                ],
                [
                    'verified_by' => $superAdmin?->id,
                    'result' => $unitData['status_verifikasi'] === 'verified' ? 'approved' : ($unitData['status_verifikasi'] === 'rejected' ? 'rejected' : 'pending'),
                    'notes' => "Evaluasi berkas pendaftaran unit {$bs->nama}.",
                    'scheduled_at' => now()->addDays(2),
                    'completed_at' => $unitData['status_verifikasi'] === 'verified' ? now() : null,
                ]
            );
        }

        // 5. Buat sample Audit Logs sistem jika belum ada
        if (AuditLog::count() < 5) {
            $auditSamples = [
                [
                    'action' => 'BANK_SAMPAH_APPROVED',
                    'entity_type' => 'BankSampah',
                    'entity_id' => 1,
                    'actor_id' => $superAdmin?->id,
                    'old_values' => ['status_verifikasi' => 'meeting_scheduled', 'status' => 'nonaktif'],
                    'new_values' => ['status_verifikasi' => 'verified', 'status' => 'aktif'],
                    'reason' => 'Unit Bank Sampah Melati Bersih dinyatakan memenuhi seluruh berkas legalitas dan uji kelayakan fisik.',
                    'ip_address' => '182.253.14.2',
                    'created_at' => now()->subMinutes(15),
                ],
                [
                    'action' => 'WITHDRAWAL_APPROVED',
                    'entity_type' => 'Withdrawal',
                    'entity_id' => 1,
                    'actor_id' => $superAdmin?->id,
                    'old_values' => ['status' => 'pending', 'saldo_akhir' => 150000],
                    'new_values' => ['status' => 'approved', 'saldo_akhir' => 50000],
                    'reason' => 'Pencairan saldo tabungan nasabah sebesar Rp 100.000 via Transfer Bank BCA sukses.',
                    'ip_address' => '114.124.88.9',
                    'created_at' => now()->subHours(2),
                ],
                [
                    'action' => 'TRASH_PRICE_UPDATED',
                    'entity_type' => 'TrashCategory',
                    'entity_id' => 1,
                    'actor_id' => $superAdmin?->id,
                    'old_values' => ['nama' => 'Plastik PET Bening', 'harga_per_kg' => 4000],
                    'new_values' => ['nama' => 'Plastik PET Bening', 'harga_per_kg' => 4500],
                    'reason' => 'Penyesuaian kenaikan harga pasar komoditas plastik daur ulang per Agustus 2026.',
                    'ip_address' => '114.124.88.9',
                    'created_at' => now()->subDay(),
                ],
                [
                    'action' => 'GENERAL_SETTINGS_UPDATED',
                    'entity_type' => 'SystemSetting',
                    'entity_id' => 1,
                    'actor_id' => $superAdmin?->id,
                    'old_values' => ['default_radius_m' => 2000, 'min_pickup_weight_kg' => 3],
                    'new_values' => ['default_radius_m' => 3000, 'min_pickup_weight_kg' => 5],
                    'reason' => 'Standarisasi jangkauan radius layanan jemput armada nasional menjadi 3.000 meter.',
                    'ip_address' => '182.253.14.2',
                    'created_at' => now()->subDays(2),
                ],
                [
                    'action' => 'VIOLATION_RESOLVED',
                    'entity_type' => 'Violation',
                    'entity_id' => 1,
                    'actor_id' => $superAdmin?->id,
                    'old_values' => ['status' => 'pending'],
                    'new_values' => ['status' => 'resolved'],
                    'reason' => 'Kasus pembatalan sepihak telah dimediasi dan selesai secara kekeluargaan.',
                    'ip_address' => '182.253.14.2',
                    'created_at' => now()->subDays(3),
                ],
            ];

            foreach ($auditSamples as $log) {
                AuditLog::create($log);
            }
        }
    }
}
