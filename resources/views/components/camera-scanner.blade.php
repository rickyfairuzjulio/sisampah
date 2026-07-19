@props(['onDetect' => 'console.log'])

<div x-data="cameraScanner()" class="mb-6 relative rounded-2xl overflow-hidden border border-outline-variant bg-surface-container shadow-sm group">
    <!-- Overlay UI for Loading / Status -->
    <div x-show="isLoading" class="absolute inset-0 z-30 bg-surface-container/90 backdrop-blur-md flex flex-col items-center justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary border-t-transparent mb-4"></div>
        <p class="text-sm font-semibold text-primary" x-text="statusText">Menganalisis dengan AI...</p>
    </div>

    <!-- Video Element -->
    <div class="relative w-full aspect-video bg-black flex items-center justify-center overflow-hidden">
        <video x-ref="video" autoplay playsinline class="absolute inset-0 w-full h-full object-cover z-0" 
               x-bind:class="{'opacity-100': !isLoading && isCameraActive, 'opacity-0': isLoading || !isCameraActive}"></video>
        
        <!-- Hidden Canvas for Snapshot -->
        <canvas x-ref="canvas" class="hidden"></canvas>

        <!-- Scanner Overlay Animation -->
        <div x-show="isCameraActive && !isLoading" class="absolute inset-0 z-10 pointer-events-none">
            <div class="w-full h-full relative">
                <!-- Grid pattern -->
                <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.1)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.1)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
                <!-- Bounding corners -->
                <div class="absolute top-1/4 left-1/4 right-1/4 bottom-1/4 border-2 border-primary/50 rounded-xl relative">
                    <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-primary"></div>
                    <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-primary"></div>
                    <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-primary"></div>
                    <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-primary"></div>
                </div>
            </div>
        </div>

        <!-- Start Camera Button -->
        <div x-show="!isCameraActive && !isLoading" class="absolute z-20">
            <button type="button" @click="startCamera()" class="px-6 py-3 bg-primary text-white rounded-xl font-bold shadow-lg flex items-center gap-2 hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Aktifkan Kamera AI
            </button>
        </div>
    </div>

    <!-- Prediction Results Bar -->
    <div x-show="isCameraActive && !isLoading" class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent z-20">
        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs text-white/70 font-medium mb-1">Arahkan kamera ke sampah</p>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur text-white text-sm font-bold rounded-lg shadow-lg">Gemini Flash Vision</span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <!-- Capture Button -->
                <button type="button" @click="captureAndAnalyze()" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-lg flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Ambil Foto & Analisis
                </button>
                <button type="button" @click="stopCamera()" class="p-2 rounded-full bg-white/20 text-white hover:bg-white/30 backdrop-blur-sm transition-colors" title="Tutup Kamera">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cameraScanner', () => ({
        isLoading: false,
        statusText: 'Menghubungkan ke Kamera...',
        isCameraActive: false,
        stream: null,

        async startCamera() {
            this.isLoading = true;
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { facingMode: 'environment' }
                    });
                    this.$refs.video.srcObject = this.stream;
                    this.isCameraActive = true;
                } catch (error) {
                    console.error("Camera access denied or error:", error);
                    alert("Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin.");
                }
            }
            this.isLoading = false;
        },

        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            this.isCameraActive = false;
        },

        async captureAndAnalyze() {
            if (!this.$refs.video || !this.$refs.canvas) return;
            
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert to blob
            canvas.toBlob(async (blob) => {
                if (!blob) return;
                
                this.isLoading = true;
                this.statusText = 'Gemini AI sedang menganalisis gambar...';

                const formData = new FormData();
                formData.append('foto', blob, 'scan.jpg');
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    const response = await fetch('{{ route("petugas.scan.process") }}', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (data.matched) {
                        // Dispatch successful event
                        this.$dispatch('ai-detected', data);
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: 'Sampah diidentifikasi: ' + data.nama }}));
                    } else {
                        // Not matched
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'warning', message: data.message || 'Gagal identifikasi, silakan pilih manual.' }}));
                        this.$dispatch('ai-detected', { matched: false });
                    }
                } catch (e) {
                    console.error(e);
                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: 'Terjadi kesalahan jaringan atau server.' }}));
                } finally {
                    this.isLoading = false;
                }
                
            }, 'image/jpeg', 0.8);
        }
    }));
});
</script>
