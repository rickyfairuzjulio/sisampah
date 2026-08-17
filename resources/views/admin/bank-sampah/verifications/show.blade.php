@extends('layouts.dashboard')

@section('header', 'Workstation Audit & Verifikasi Bank Sampah')

@section('content')
<div class="space-y-6">

    {{-- Top Action Header --}}
    <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 text-white shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.verifikasi_bank_sampah.index') }}" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 flex items-center gap-1.5 mb-2 transition-colors">
                <i class="bi bi-arrow-left"></i> Kembali ke Antrean Verifikasi
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">{{ $bankSampah->nama }}</h1>
            <p class="text-xs text-slate-300 mt-0.5">
                Kode Reg: <strong class="text-emerald-400 font-mono">{{ $bankSampah->nomor_registrasi ?: $bankSampah->kode_bank }}</strong> • Diajukan oleh: <strong class="text-white">{{ $bankSampah->penanggung_jawab }}</strong>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-4 py-2 rounded-full text-xs font-black uppercase border tracking-wider {{ $bankSampah->verifikasi_badge_bg }}">
                Status: {{ str_replace('_', ' ', $bankSampah->status_verifikasi) }}
            </span>

            @if(!in_array($bankSampah->status_verifikasi, ['verified', 'active']))
                <form action="{{ route('admin.verifikasi_bank_sampah.approve', $bankSampah->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI dan MENGAKTIFKAN Bank Sampah ini?')">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold rounded-xl text-xs transition-all shadow-lg hover:shadow-emerald-500/20 flex items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i> Setujui & Aktifkan Unit
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Alert Banner & WA Button --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-400 text-xs font-semibold flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-lg text-emerald-400"></i>
                <span>{{ session('success') }}</span>
            </div>
            @if(session('wa_url'))
                <a href="{{ session('wa_url') }}" target="_blank"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold rounded-xl text-xs flex items-center gap-2 transition-all shadow-md shrink-0">
                    <i class="bi bi-whatsapp text-sm"></i>
                    Kirim Catatan Revisi via WA ke {{ session('wa_target') }}
                </a>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN: Details & Document Review Workbench (2 Columns) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Organisasi & Pengelola Card --}}
            <div class="card p-6 space-y-4">
                <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                    <i class="bi bi-info-circle text-primary"></i> Detail Organisasi & Penanggung Jawab
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-text-secondary block">Nama Penanggung Jawab:</span>
                        <strong class="text-text-primary text-sm">{{ $bankSampah->penanggung_jawab }}</strong>
                    </div>
                    <div>
                        <span class="text-text-secondary block">Kontak PJ:</span>
                        <strong class="text-text-primary">{{ $bankSampah->email_pj }} | {{ $bankSampah->telepon_pj }}</strong>
                    </div>
                    <div>
                        <span class="text-text-secondary block">Alamat Operasional:</span>
                        <span class="text-text-primary">{{ $bankSampah->alamat }}, {{ $bankSampah->kecamatan }}, {{ $bankSampah->kabupaten }}, {{ $bankSampah->provinsi }}</span>
                    </div>
                    <div>
                        <span class="text-text-secondary block">Radius Layanan Penjemputan:</span>
                        <strong class="text-emerald-500 text-sm">{{ number_format(($bankSampah->radius_layanan ?: 3000) / 1000, 1) }} km</strong>
                    </div>
                    <div>
                        <span class="text-text-secondary block">Koordinat GPS:</span>
                        <span class="font-mono text-text-primary">{{ $bankSampah->latitude }}, {{ $bankSampah->longitude }}</span>
                    </div>
                    <div>
                        <span class="text-text-secondary block">Jam Operasional:</span>
                        <span class="text-text-primary">{{ $bankSampah->hari_operasional }} ({{ $bankSampah->jam_buka }} - {{ $bankSampah->jam_tutup }})</span>
                    </div>
                </div>
            </div>

            {{-- Document Verification Workbench Card --}}
            <div class="card p-6 space-y-4">
                <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                    <i class="bi bi-file-earmark-check text-primary"></i> Peninjauan Dokumen Legalitas (Audit Workbench)
                </h3>

                <div class="space-y-4">
                    @forelse($bankSampah->documents as $doc)
                        <div class="p-4 bg-surface rounded-2xl border border-border space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <span class="text-xs font-bold text-text-primary uppercase tracking-wide">
                                        {{ str_replace('_', ' ', $doc->jenis_dokumen) }}
                                    </span>
                                    <span class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $doc->status_review === 'approved' ? 'bg-emerald-500/20 text-emerald-400' : ($doc->status_review === 'revision_requested' ? 'bg-amber-500/20 text-amber-400' : 'bg-sky-500/20 text-sky-400') }}">
                                        {{ $doc->status_review }}
                                    </span>
                                </div>

                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-secondary !py-1 !px-3 text-xs">
                                    <i class="bi bi-box-arrow-up-right"></i> Buka File
                                </a>
                            </div>

                            @if($doc->catatan)
                                <div class="text-xs text-amber-400 bg-amber-500/10 p-2 rounded-xl border border-amber-500/20">
                                    Catatan Review: {{ $doc->catatan }}
                                </div>
                            @endif

                            {{-- Form Update Review Dokumen --}}
                            <form action="{{ route('admin.verifikasi_bank_sampah.review_doc', [$bankSampah->id, $doc->id]) }}" method="POST" class="flex flex-col sm:flex-row gap-2 pt-2 border-t border-border/50">
                                @csrf
                                <input type="text" name="catatan" value="{{ $doc->catatan }}" placeholder="Catatan revisi / feedback..."
                                    class="form-input text-xs flex-1 rounded-xl border-border">
                                
                                <button type="submit" name="status_review" value="approved" class="btn bg-emerald-600 hover:bg-emerald-500 text-white !py-1 !px-3 text-xs">
                                    Disetujui
                                </button>
                                <button type="submit" name="status_review" value="revision_requested" class="btn bg-amber-600 hover:bg-amber-500 text-white !py-1 !px-3 text-xs">
                                    Minta Revisi
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-text-secondary italic">Belum ada berkas dokumen diunggah.</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: Meeting Scheduling & Rejection Panel (1 Column) --}}
        <div class="space-y-6">

            {{-- Schedule Meeting Card --}}
            <div class="card p-6 space-y-4">
                <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                    <i class="bi bi-calendar-event text-primary"></i> Jadwalkan Pertemuan Validasi
                </h3>

                <form action="{{ route('admin.verifikasi_bank_sampah.schedule_meeting', $bankSampah->id) }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="block text-text-secondary font-semibold mb-1">Metode Pertemuan</label>
                        <select name="method" class="form-select text-xs w-full rounded-xl border-border">
                            <option value="online">Online (Zoom / Meet)</option>
                            <option value="offline">Offline (Kunjungan Lapangan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-text-secondary font-semibold mb-1">Tanggal & Waktu Jadwal</label>
                        <input type="datetime-local" name="scheduled_at" required class="form-input text-xs w-full rounded-xl border-border">
                    </div>

                    <div>
                        <label class="block text-text-secondary font-semibold mb-1">Catatan / Link Meet</label>
                        <textarea name="notes" rows="2" placeholder="Link Zoom / instruksi kedatangan..." class="form-input text-xs w-full rounded-xl border-border"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full !py-2 text-xs font-bold">
                        Simpan Jadwal Pertemuan
                    </button>
                </form>

                {{-- Existing Verification History --}}
                @if($bankSampah->verifications->count() > 0)
                    <div class="pt-3 border-t border-border space-y-2 text-xs">
                        <span class="font-bold text-text-primary block">Riwayat Jadwal Verification:</span>
                        @foreach($bankSampah->verifications as $v)
                            <div class="p-2 bg-surface rounded-xl border border-border text-[11px]">
                                <div class="font-bold text-primary uppercase">{{ $v->method }} - {{ $v->result }}</div>
                                <div class="text-text-secondary">{{ $v->scheduled_at ? $v->scheduled_at->format('d M Y H:i') : '-' }}</div>
                                @if($v->notes)
                                    <div class="text-text-primary mt-1">{{ $v->notes }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Rejection Form Card --}}
            <div class="card p-6 space-y-4 border border-rose-500/20 bg-rose-500/5">
                <h3 class="text-sm font-bold text-rose-400 uppercase tracking-wider border-b border-rose-500/20 pb-3 flex items-center gap-2">
                    <i class="bi bi-x-circle text-rose-400"></i> Tolak Permohonan
                </h3>

                <form action="{{ route('admin.verifikasi_bank_sampah.reject', $bankSampah->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK permohonan ini?')" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="block text-text-secondary font-semibold mb-1">Alasan Penolakan</label>
                        <textarea name="reason" rows="3" required placeholder="Jelaskan alasan penolakan..." class="form-input text-xs w-full rounded-xl border-border"></textarea>
                    </div>

                    <button type="submit" class="btn bg-rose-600 hover:bg-rose-500 text-white w-full !py-2 text-xs font-bold">
                        Tolak Permohonan Pendaftaran
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
