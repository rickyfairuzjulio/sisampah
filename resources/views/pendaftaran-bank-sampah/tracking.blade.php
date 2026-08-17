@extends('layouts.landing')

@section('content')
<div class="relative min-h-screen pt-28 pb-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header Title --}}
        <div class="text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald/10 border border-emerald/30 text-emerald-400 text-xs sm:text-sm font-semibold mb-4">
                <svg class="w-4 h-4 text-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Pelacakan Permohonan
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                Lacak Status Pendaftaran Bank Sampah
            </h1>
            <p class="mt-2 text-sm sm:text-base text-slate-300">
                Masukkan Kode Registrasi (e.g. REG-BS-20260812-XXXX) atau Kode Bank Sampah Anda.
            </p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-300 text-sm font-medium flex items-center gap-3">
                <svg class="w-6 h-6 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Search Input Form --}}
        <div class="bg-[#0b221a]/90 backdrop-blur-xl border border-emerald-500/20 rounded-3xl p-6 sm:p-8 shadow-2xl">
            <form action="{{ route('pendaftaran_bank_sampah.tracking') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="text" name="reg" value="{{ request('reg', $regCode) }}" required placeholder="Contoh: REG-BS-20260812-XXXX"
                    class="flex-1 bg-black/40 border border-emerald-500/30 rounded-2xl px-5 py-4 text-white text-base placeholder-slate-500 focus:outline-none focus:border-emerald-400">
                <button type="submit" class="px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-white font-bold rounded-2xl shadow-lg transition-all">
                    Cari Status
                </button>
            </form>
        </div>

        {{-- Tracking Results Card --}}
        @if($bankSampah)
            <div class="bg-[#0b221a]/90 backdrop-blur-xl border border-emerald-500/20 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-emerald-500/20">
                    <div>
                        <span class="text-xs font-mono text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/30">
                            {{ $bankSampah->nomor_registrasi ?: $bankSampah->kode_bank }}
                        </span>
                        <h2 class="text-2xl font-bold text-white mt-2">{{ $bankSampah->nama }}</h2>
                        <p class="text-xs text-slate-400">Penanggung Jawab: {{ $bankSampah->penanggung_jawab }} ({{ $bankSampah->email_pj }})</p>
                    </div>
                    <div>
                        <span class="px-4 py-2 rounded-full text-xs font-extrabold uppercase border {{ $bankSampah->verifikasi_badge_bg }}">
                            Status Verifikasi: {{ str_replace('_', ' ', $bankSampah->status_verifikasi) }}
                        </span>
                    </div>
                </div>

                {{-- Status Progress Timeline --}}
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider">Tahapan Verifikasi</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div class="p-3 rounded-2xl border text-center text-xs font-bold {{ in_array($bankSampah->status_verifikasi, ['submitted', 'under_review', 'document_revision', 'meeting_scheduled', 'verified', 'active']) ? 'bg-emerald-500/20 border-emerald-500/40 text-emerald-300' : 'bg-black/20 border-white/5 text-slate-500' }}">
                            1. Diajukan
                        </div>
                        <div class="p-3 rounded-2xl border text-center text-xs font-bold {{ in_array($bankSampah->status_verifikasi, ['under_review', 'document_revision', 'meeting_scheduled', 'verified', 'active']) ? 'bg-emerald-500/20 border-emerald-500/40 text-emerald-300' : 'bg-black/20 border-white/5 text-slate-500' }}">
                            2. Peninjauan Dokumen
                        </div>
                        <div class="p-3 rounded-2xl border text-center text-xs font-bold {{ in_array($bankSampah->status_verifikasi, ['meeting_scheduled', 'verified', 'active']) ? 'bg-emerald-500/20 border-emerald-500/40 text-emerald-300' : 'bg-black/20 border-white/5 text-slate-500' }}">
                            3. Pertemuan / Fit
                        </div>
                        <div class="p-3 rounded-2xl border text-center text-xs font-bold {{ in_array($bankSampah->status_verifikasi, ['verified', 'active']) ? 'bg-emerald-500/20 border-emerald-500/40 text-emerald-300' : 'bg-black/20 border-white/5 text-slate-500' }}">
                            4. Terverifikasi & Aktif
                        </div>
                    </div>
                </div>

                {{-- Document Attachments & Status --}}
                <div class="space-y-4 pt-4 border-t border-emerald-500/20">
                    <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider">Status Dokumen Diserahkan & Catatan Revisi</h3>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($bankSampah->documents as $doc)
                            <div class="p-4 bg-black/40 border border-emerald-500/20 rounded-2xl space-y-3">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-white text-sm uppercase">{{ str_replace('_', ' ', $doc->jenis_dokumen) }}</span>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-emerald-400 hover:underline text-xs flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            Lihat File Saat Ini
                                        </a>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase {{ $doc->status_review === 'approved' ? 'bg-emerald-500/20 border border-emerald-500/40 text-emerald-300' : ($doc->status_review === 'revision_requested' ? 'bg-amber-500/20 border border-amber-500/40 text-amber-300 animate-pulse' : 'bg-sky-500/20 border border-sky-500/40 text-sky-300') }}">
                                        {{ $doc->status_review === 'approved' ? 'Disetujui' : ($doc->status_review === 'revision_requested' ? 'Perlu Revisi' : 'Sedang Ditinjau') }}
                                    </span>
                                </div>

                                @if($doc->catatan)
                                    <div class="p-3 bg-amber-500/10 border border-amber-500/30 rounded-xl text-xs text-amber-200 flex items-start gap-2">
                                        <svg class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <div>
                                            <span class="font-bold text-amber-400 block mb-0.5">Catatan Revisi dari Super Admin:</span>
                                            <p>{{ $doc->catatan }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($doc->status_review === 'revision_requested')
                                    <div class="p-3 bg-slate-900/80 border border-amber-500/30 rounded-xl space-y-2">
                                        <label class="block text-xs font-bold text-amber-300">Unggah File Perbaikan Baru (PDF/JPG/PNG max 10MB):</label>
                                        <form action="{{ route('pendaftaran_bank_sampah.reupload') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3">
                                            @csrf
                                            <input type="hidden" name="document_id" value="{{ $doc->id }}">
                                            <input type="hidden" name="reg_code" value="{{ $bankSampah->nomor_registrasi ?: $bankSampah->kode_bank }}">
                                            <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png"
                                                class="flex-1 text-xs text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-500/20 file:text-amber-300 hover:file:bg-amber-500/30 cursor-pointer">
                                            <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-xs rounded-xl transition-all shadow-md shrink-0">
                                                Kirim Perbaikan Dokumen
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Meeting Verification Schedule if available --}}
                @if($bankSampah->verifications->count() > 0)
                    <div class="p-4 bg-indigo-500/10 border border-indigo-500/30 rounded-2xl space-y-2 text-xs text-indigo-200">
                        <div class="font-bold text-sm text-indigo-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Jadwal Validasi Pertemuan
                        </div>
                        @foreach($bankSampah->verifications as $ver)
                            <p>Metode: <strong class="uppercase">{{ $ver->method }}</strong> | Tanggal: <strong>{{ $ver->scheduled_at ? $ver->scheduled_at->format('d M Y H:i') : 'Menunggu Konfirmasi' }}</strong></p>
                            @if($ver->notes)
                                <p class="text-slate-300">Catatan Petugas: {{ $ver->notes }}</p>
                            @endif
                        @endforeach
                    </div>
                @endif

            </div>
        @elseif(request('reg'))
            <div class="p-6 bg-rose-500/10 border border-rose-500/30 rounded-3xl text-center space-y-2">
                <p class="text-rose-300 font-bold">Data Pendaftaran Tidak Ditemukan</p>
                <p class="text-xs text-slate-400">Pastikan Kode Registrasi (e.g. REG-BS-20260812-XXXX) yang Anda masukkan sudah benar.</p>
            </div>
        @endif

    </div>
</div>
@endsection
