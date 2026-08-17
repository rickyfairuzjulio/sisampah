@component('mail::message')
# Halo {{ $bankSampah->penanggung_jawab }},

Super Admin **SiSampah** telah meninjau dokumen pendaftaran untuk mitra Bank Sampah **{{ $bankSampah->nama }}**.

Terdapat dokumen yang memerlukan **perbaikan / unggah ulang**:

- **Jenis Dokumen**: {{ strtoupper(str_replace('_', ' ', $document->jenis_dokumen)) }}
- **Catatan Revisi dari Super Admin**:
> {{ $document->catatan ?: 'Mohon perbaiki dan unggah ulang dokumen yang sesuai.' }}

Silakan klik tombol di bawah ini untuk melihat detail catatan dan mengunggah ulang dokumen perbaikan Anda:

@component('mail::button', ['url' => route('pendaftaran_bank_sampah.tracking', ['reg' => $bankSampah->nomor_registrasi ?: $bankSampah->kode_bank])])
Perbaiki & Unggah Ulang Dokumen
@endcomponent

Atau buka halaman Pelacakan Pendaftaran dengan Nomor Registrasi Anda: **{{ $bankSampah->nomor_registrasi ?: $bankSampah->kode_bank }}**.

Terima kasih,<br>
Tim Admin {{ config('app.name') }}
@endcomponent
