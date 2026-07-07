@props(['onDetect' => 'console.log'])

<div x-data="cameraScanner()" x-init="init()" class="mb-6 relative rounded-2xl overflow-hidden border border-outline-variant bg-surface-container shadow-sm group">
    <!-- Overlay UI for Loading / Status -->
    <div x-show="isLoading" class="absolute inset-0 z-20 bg-surface-container/80 backdrop-blur-sm flex flex-col items-center justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary border-t-transparent mb-4"></div>
        <p class="text-sm font-semibold text-primary" x-text="statusText">Memuat Model AI...</p>
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
                <!-- Scanning line -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-primary/80 shadow-[0_0_15px_rgba(var(--color-primary),0.8)] animate-[scan_2s_ease-in-out_infinite]"></div>
                <!-- Bounding corners -->
                <div class="absolute top-1/4 left-1/4 right-1/4 bottom-1/4 border-2 border-primary/50 rounded-xl relative">
                    <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-primary"></div>
                    <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-primary"></div>
                    <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-primary"></div>
                    <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-primary"></div>
                </div>
            </div>
        </div>

        <!-- Start Camera Button (Fallback if autoplay fails) -->
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
                <p class="text-xs text-white/70 font-medium mb-1">Mendeteksi Otomatis...</p>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-primary text-white text-sm font-bold rounded-lg shadow-lg" x-text="currentPrediction || 'Arahkan ke sampah'"></span>
                    <span x-show="confidence > 0" class="text-white/90 text-sm font-mono" x-text="Math.round(confidence * 100) + '% Akurasi'"></span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <!-- Capture Button -->
                <button type="button" x-show="currentPrediction && confidence > 0.4" @click="captureAndUse()" class="px-4 py-2 bg-forest-emerald text-white text-sm font-bold rounded-lg hover:bg-forest-emerald/90 transition-colors shadow-lg flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Ambil Foto
                </button>
                <button type="button" @click="stopCamera()" class="p-2 rounded-full bg-white/20 text-white hover:bg-white/30 backdrop-blur-sm transition-colors" title="Tutup Kamera">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes scan {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(200px); }
}
</style>

<!-- Load TensorFlow.js -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<!-- Load MobileNet -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"></script>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cameraScanner', () => ({
        isLoading: false,
        statusText: 'Memuat Model AI...',
        isCameraActive: false,
        model: null,
        currentPrediction: '',
        confidence: 0,
        stream: null,
        animationFrameId: null,
        lastEmittedCategory: null,
        lastEmittedTime: 0,

        // Custom mapping for demo (MobileNet classes to our Categories)
        classMap: {
            'water bottle': 'Plastik',
            'bottle': 'Plastik',
            'cup': 'Plastik',
            'coffee mug': 'Kaca',
            'can': 'Logam',
            'pop bottle': 'Plastik',
            'paper towel': 'Kertas',
            'carton': 'Kertas',
            'envelope': 'Kertas',
            'packet': 'Plastik',
            'plastic bag': 'Plastik',
            'desktop computer': 'Elektronik',
            'monitor': 'Elektronik',
            'notebook': 'Kertas',
            'banana': 'Organik',
            'strawberry': 'Organik',
            'apple': 'Organik',
            'orange': 'Organik',
            'lemon': 'Organik',
            'book': 'Kertas',
            'magazine': 'Kertas',
            'toilet tissue': 'Kertas',
            'milk can': 'Logam',
            'bucket': 'Plastik',
            'flower pot': 'Kaca',
            'cellular telephone': 'Elektronik',
            'laptop': 'Elektronik'
        },

        async init() {
            this.isLoading = true;
            this.statusText = 'Mengunduh Model TF.js (Offline Cache)...';
            try {
                this.model = await mobilenet.load({version: 2, alpha: 0.5});
                this.isLoading = false;
                this.startCamera();
            } catch (error) {
                console.error("Error loading model:", error);
                this.statusText = 'Gagal memuat model. Periksa koneksi internet untuk download pertama kali.';
                setTimeout(() => this.isLoading = false, 3000);
            }
        },

        async startCamera() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { facingMode: 'environment' }
                    });
                    this.$refs.video.srcObject = this.stream;
                    this.isCameraActive = true;
                    
                    this.$refs.video.onloadeddata = () => {
                        this.detectFrame();
                    };
                } catch (error) {
                    console.error("Camera access denied or error:", error);
                    alert("Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin.");
                }
            }
        },

        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            if (this.animationFrameId) {
                cancelAnimationFrame(this.animationFrameId);
            }
            this.isCameraActive = false;
        },

        captureAndUse() {
            if (!this.$refs.video || !this.$refs.canvas) return;
            
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            
            // Set canvas size to video frame size
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw current video frame to canvas
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Get Data URL
            const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
            
            // Dispatch event with the photo data and category
            this.$dispatch('snapshot-taken', {
                photoUrl: dataUrl,
                category: this.lastEmittedCategory || this.currentPrediction
            });

            // Stop camera after taking photo
            this.stopCamera();
        },

        async detectFrame() {
            if (!this.isCameraActive || !this.model || !this.$refs.video) return;

            try {
                const predictions = await this.model.classify(this.$refs.video);
                
                if (predictions && predictions.length > 0) {
                    const topPrediction = predictions[0];
                    let detectedClass = topPrediction.className.split(',')[0].toLowerCase();
                    
                    let mappedCategory = null;
                    for (const [key, value] of Object.entries(this.classMap)) {
                        if (detectedClass.includes(key) || key.includes(detectedClass)) {
                            mappedCategory = value;
                            break;
                        }
                    }

                    this.currentPrediction = mappedCategory || detectedClass;
                    this.confidence = topPrediction.probability;

                    const now = Date.now();
                    if (this.confidence > 0.4 && mappedCategory) {
                        if (mappedCategory !== this.lastEmittedCategory || now - this.lastEmittedTime > 2000) {
                            this.$dispatch('detected', { 
                                category: mappedCategory,
                                raw: detectedClass,
                                confidence: this.confidence
                            });
                            this.lastEmittedCategory = mappedCategory;
                            this.lastEmittedTime = now;
                        }
                    }
                }
            } catch (e) {
                console.error("Detection error", e);
            }

            this.animationFrameId = requestAnimationFrame(() => this.detectFrame());
        }
    }));
});
</script>
