@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="certificateExporter()">
    <!-- Header / Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <a href="{{ route('nasabah.dashboard') }}" class="inline-flex items-center gap-2 text-sm text-on-surface-variant hover:text-primary transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-bold text-on-surface">Rapor & Sertifikat Anda</h1>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="button" @click="generatePDF" :disabled="isExporting" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary-container text-white font-bold rounded-xl shadow-lg transition-all hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg x-show="!isExporting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <svg x-show="isExporting" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span x-text="isExporting ? 'Memproses PDF...' : 'Download PDF'"></span>
            </button>
        </div>
    </div>

    <!-- Wrapping div for shadow and proper scaling -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden overflow-x-auto">
        <!-- The actual element to be exported as PDF -->
        <!-- Fixed A4 size ratio for PDF generation (794x1123px is roughly A4 at 96dpi) -->
        <div id="pdf-content" class="relative bg-white text-gray-800 w-[794px] mx-auto p-12 min-h-[1123px] flex flex-col justify-between" style="font-family: 'Inter', sans-serif;">
            
            <!-- Watermark / Background Blob -->
            <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-emerald-100 rounded-full blur-[100px] opacity-60"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-green-100 rounded-full blur-[100px] opacity-60"></div>

            <div class="relative z-10 flex flex-col h-full">
                <!-- Header -->
                <div class="flex items-center justify-between border-b-2 border-emerald-500 pb-6 mb-10">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-black text-2xl">S</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-gray-800 tracking-tight">SiSampah</h2>
                            <p class="text-sm text-gray-500 font-medium tracking-widest uppercase">Bank Sampah Digital</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-500">LAPORAN TAHUNAN</p>
                        <p class="text-xl font-black text-emerald-600">2026</p>
                    </div>
                </div>

                <!-- Certificate Body -->
                <div class="text-center mb-12">
                    <p class="text-sm font-semibold tracking-[0.2em] text-gray-400 mb-4">PIAGAM PENGHARGAAN DIBERIKAN KEPADA</p>
                    <h1 class="text-5xl font-black text-gray-900 mb-6">{{ $user->name }}</h1>
                    <div class="inline-flex items-center gap-2 px-6 py-2 bg-emerald-50 border border-emerald-200 rounded-full mb-8">
                        <span class="text-emerald-700 font-bold">Nasabah Peringkat #{{ $rank }}</span>
                    </div>
                    <p class="max-w-xl mx-auto text-gray-600 leading-relaxed">
                        Atas dedikasi, komitmen, dan kontribusi aktif dalam upaya pengelolaan sampah dan pelestarian lingkungan desa selama tahun 2026. Anda telah diakui secara resmi dengan gelar kehormatan:
                    </p>
                    <div class="mt-6 text-3xl font-bold text-emerald-600">
                        {{ $badge }}
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-6 mb-12">
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 text-center shadow-sm">
                        <p class="text-gray-500 text-sm font-semibold mb-1">Total Sampah Terkelola</p>
                        <p class="text-3xl font-black text-gray-800">{{ number_format($totalBerat, 1) }} <span class="text-lg">Kg</span></p>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 text-center shadow-sm">
                        <p class="text-gray-500 text-sm font-semibold mb-1">Jumlah Transaksi</p>
                        <p class="text-3xl font-black text-gray-800">{{ $totalTransaksi }} <span class="text-lg">Kali</span></p>
                    </div>
                    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 text-center shadow-sm">
                        <p class="text-emerald-700 text-sm font-semibold mb-1">Total Poin Lingkungan</p>
                        <p class="text-3xl font-black text-emerald-600">{{ number_format($totalPoin, 0) }}</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 text-center shadow-sm">
                        <p class="text-gray-500 text-sm font-semibold mb-1">Total Pengurangan CO₂</p>
                        <p class="text-3xl font-black text-gray-800">{{ number_format($impact['co2'], 1) }} <span class="text-lg">Kg</span></p>
                    </div>
                </div>

                <!-- Footer Signatures -->
                <div class="mt-auto pt-10 flex items-end justify-between">
                    <!-- QR Code Mockup -->
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 bg-white border-2 border-gray-200 p-2 rounded-lg flex items-center justify-center">
                            <!-- SVG QR Code Dummy -->
                            <svg class="w-full h-full text-gray-800" viewBox="0 0 100 100" fill="currentColor">
                                <rect x="10" y="10" width="30" height="30" fill="none" stroke="currentColor" stroke-width="5"/>
                                <rect x="15" y="15" width="20" height="20"/>
                                <rect x="60" y="10" width="30" height="30" fill="none" stroke="currentColor" stroke-width="5"/>
                                <rect x="65" y="15" width="20" height="20"/>
                                <rect x="10" y="60" width="30" height="30" fill="none" stroke="currentColor" stroke-width="5"/>
                                <rect x="15" y="65" width="20" height="20"/>
                                <path d="M50 10h5v20h-5zM60 50h30v5H60zM10 50h40v5H10zM50 60h5v30h-5zM60 65h10v10H60zM80 80h10v10H80z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">VERIFIKASI DIGITAL</p>
                            <p class="text-sm font-bold text-gray-700">ID: SIS-{{ strtoupper(substr(md5($user->id . time()), 0, 8)) }}</p>
                        </div>
                    </div>

                    <!-- Signatures -->
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-12">Diterbitkan pada: {{ now()->translatedFormat('d F Y') }}</p>
                        <div class="relative inline-block">
                            <!-- Dummy Signature -->
                            <svg class="absolute top-[-30px] left-1/2 transform -translate-x-1/2 w-32 h-16 text-emerald-600/30" viewBox="0 0 200 100" fill="none" stroke="currentColor" stroke-width="3">
                                <path d="M20,60 Q40,10 60,70 T100,40 T140,80 T180,30" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M30,50 Q80,90 120,30" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="w-48 border-t-2 border-gray-800 mx-auto"></div>
                            <p class="text-sm font-bold text-gray-800 mt-2">Kepala Bank Sampah</p>
                            <p class="text-xs text-gray-500">SiSampah Digital</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Load html2pdf.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('certificateExporter', () => ({
            isExporting: false,
            
            generatePDF() {
                this.isExporting = true;
                const element = document.getElementById('pdf-content');
                
                const opt = {
                    margin:       0,
                    filename:     'Sertifikat-SiSampah-{{ Str::slug($user->name) }}-2026.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2, useCORS: true, logging: false },
                    jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };

                // New Promise-based usage:
                html2pdf().set(opt).from(element).save().then(() => {
                    this.isExporting = false;
                }).catch(err => {
                    console.error("Error generating PDF:", err);
                    this.isExporting = false;
                    alert("Gagal membuat PDF. Silakan coba lagi.");
                });
            }
        }));
    });
</script>
@endpush
@endsection
