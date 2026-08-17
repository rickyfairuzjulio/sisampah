<x-app-layout title="Input Setoran Mandiri">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">



        <!-- Main Form Grid -->
        <form action="{{ route('petugas.self_deposit.store') }}" method="POST" enctype="multipart/form-data" 
              x-data="selfDepositForm()">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                <!-- Main Form Content -->
                <x-card class="space-y-6 lg:col-span-2 max-w-3xl mx-auto w-full">
                    @if ($errors->any())
                        <x-alert type="error" title="Ada Kesalahan" class="mb-6" dismissible>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-xs">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    @endif

                <!-- Form Section 1: Nasabah -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-primary/20">
                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="text-sm font-bold text-primary">1</span>
                        </div>
                        <h3 class="font-semibold text-on-surface">Data Nasabah</h3>
                    </div>

                    <x-input-field 
                        label="Email Nasabah"
                        name="user_email"
                        type="email"
                        placeholder="nasabah@email.com"
                        required
                        :value="old('user_email')"
                        :error="$errors->has('user_email') ? $errors->first('user_email') : false"
                    />
                    <p class="text-xs text-on-surface-variant flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        Cari nasabah berdasarkan email terdaftar
                    </p>
                </div>

                <!-- Form Section 2: Daftar Sampah -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-primary/20">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="text-sm font-bold text-primary">2</span>
                            </div>
                            <h3 class="font-semibold text-on-surface">Daftar Sampah</h3>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="space-y-4">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="flex flex-col sm:flex-row gap-4 p-4 border border-outline-variant rounded-xl bg-surface relative group">
                                <!-- Kategori -->
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-on-surface mb-1">Kategori Sampah <span class="text-error">*</span></label>
                                    <select x-model="item.trash_category_id" :name="'items['+index+'][trash_category_id]'" required class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary text-sm appearance-none transition-shadow shadow-sm hover:border-primary/50">
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        @foreach($trashCategories as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama }} (Rp {{ number_format($k->harga_per_kg, 0, ',', '.') }}/Kg)</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Berat -->
                                <div class="sm:w-40">
                                    <label class="block text-sm font-medium text-on-surface mb-1">Berat (Kg) <span class="text-error">*</span></label>
                                    <input type="number" x-model="item.berat_kg" :name="'items['+index+'][berat_kg]'" required min="0.1" step="0.1" placeholder="Contoh: 5.5" class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-shadow shadow-sm hover:border-primary/50">
                                </div>
                                
                                <!-- Hapus Button -->
                                <div class="flex sm:self-end sm:mb-0.5">
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="w-full sm:w-12 h-[3.25rem] bg-error/10 text-error hover:bg-error hover:text-white rounded-xl flex items-center justify-center transition-colors shadow-sm mt-2 sm:mt-0" title="Hapus Sampah">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sm:hidden ml-2 font-medium">Hapus</span>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Tambah Button -->
                    <button type="button" @click="addItem()" class="mt-2 py-2 px-4 border-2 border-dashed border-primary text-primary hover:bg-primary/5 font-bold rounded-xl transition-colors flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Sampah Lain
                    </button>
                </div>

                <!-- Form Section 3: Foto Bukti Timbangan (Live Camera & File Choice) -->
                <div class="space-y-4" x-data="{ 
                    isCameraOpen: false, 
                    photoPreview: null, 
                    cameraStream: null,
                    openCamera() {
                        this.isCameraOpen = true;
                        this.$nextTick(() => {
                            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                                .then(stream => {
                                    this.cameraStream = stream;
                                    this.$refs.videoFeed.srcObject = stream;
                                })
                                .catch(err => {
                                    alert('Tidak dapat mengaktifkan kamera live. Membuka kamera/galeri bawaan.');
                                    this.isCameraOpen = false;
                                    this.triggerFileInput();
                                });
                        });
                    },
                    closeCamera() {
                        if (this.cameraStream) {
                            this.cameraStream.getTracks().forEach(track => track.stop());
                            this.cameraStream = null;
                        }
                        this.isCameraOpen = false;
                    },
                    takePhoto() {
                        const video = this.$refs.videoFeed;
                        const canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth || 640;
                        canvas.height = video.videoHeight || 480;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        
                        const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
                        this.photoPreview = dataUrl;

                        canvas.toBlob(blob => {
                            const file = new File([blob], 'setoran_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            document.getElementById('foto_bukti').files = dataTransfer.files;
                        }, 'image/jpeg', 0.85);

                        this.closeCamera();
                    },
                    triggerFileInput() {
                        document.getElementById('foto_bukti').click();
                    },
                    handleFileSelect(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.photoPreview = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },
                    clearPhoto() {
                        this.photoPreview = null;
                        document.getElementById('foto_bukti').value = '';
                    }
                }">
                    <div class="flex items-center gap-2 pb-3 border-b border-primary/20">
                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="text-sm font-bold text-primary">3</span>
                        </div>
                        <h3 class="font-semibold text-on-surface">Foto Bukti Setoran (Opsional)</h3>
                    </div>

                    <!-- Hidden native file input with camera capture support -->
                    <input type="file" id="foto_bukti" name="foto_bukti" accept="image/*" capture="environment" class="hidden" @change="handleFileSelect($event)">

                    <!-- Options Grid (When no photo preview yet) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" x-show="!photoPreview">
                        <!-- Direct Live Camera Button -->
                        <button type="button" @click="openCamera()" 
                                class="p-4 rounded-2xl border-2 border-emerald-500/40 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 font-bold transition-all flex items-center justify-center gap-3 shadow-md hover:scale-[1.02] active:scale-95 group">
                            <div class="w-12 h-12 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center text-xl font-bold shadow group-hover:scale-110 transition-transform">
                                <i class="bi bi-camera-fill"></i>
                            </div>
                            <div class="text-left">
                                <span class="block text-sm font-extrabold text-on-surface">Buka Kamera Langsung</span>
                                <span class="block text-[11px] text-emerald-600 dark:text-emerald-300 font-normal">Ambil foto via kamera HP / WebCam</span>
                            </div>
                        </button>

                        <!-- Upload File / Gallery Button -->
                        <button type="button" @click="triggerFileInput()" 
                                class="p-4 rounded-2xl border-2 border-slate-300 dark:border-slate-700 bg-surface hover:bg-surface-container text-on-surface font-bold transition-all flex items-center justify-center gap-3 shadow-md hover:scale-[1.02] active:scale-95 group">
                            <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center text-xl font-bold shadow group-hover:scale-110 transition-transform">
                                <i class="bi bi-folder-fill"></i>
                            </div>
                            <div class="text-left">
                                <span class="block text-sm font-extrabold text-on-surface">Pilih dari Galeri</span>
                                <span class="block text-[11px] text-on-surface-variant font-normal">Pilih file foto di memori</span>
                            </div>
                        </button>
                    </div>

                    <!-- Photo Preview Box -->
                    <div x-show="photoPreview" class="relative rounded-2xl overflow-hidden border-2 border-emerald-500/50 bg-slate-900 p-3 text-center shadow-lg space-y-3" x-cloak>
                        <div class="flex items-center justify-between px-2 text-xs text-emerald-400 font-bold border-b border-slate-800 pb-2">
                            <span class="flex items-center gap-1.5"><i class="bi bi-check-circle-fill text-emerald-400"></i> Foto Bukti Berhasil Diambil</span>
                        </div>
                        <img :src="photoPreview" class="max-h-56 rounded-xl mx-auto object-contain border border-slate-800 shadow">
                        <div class="flex items-center justify-center gap-2 pt-1">
                            <button type="button" @click="openCamera()" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs flex items-center gap-1.5 shadow">
                                <i class="bi bi-camera-fill"></i> Foto Ulang Kamera
                            </button>
                            <button type="button" @click="triggerFileInput()" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold rounded-xl text-xs flex items-center gap-1.5 shadow">
                                <i class="bi bi-image"></i> Ganti File
                            </button>
                            <button type="button" @click="clearPhoto()" class="px-3 py-2 bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 font-bold rounded-xl text-xs flex items-center gap-1">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Live Camera Modal -->
                    <div x-show="isCameraOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-md p-4" x-cloak>
                        <div class="bg-slate-900 border border-emerald-500/40 rounded-3xl overflow-hidden max-w-md w-full shadow-2xl p-5 space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-800 pb-3 text-white">
                                <h3 class="font-bold text-base flex items-center gap-2">
                                    <i class="bi bi-camera-reels-fill text-emerald-400"></i> Kamera Timbangan Petugas
                                </h3>
                                <button type="button" @click="closeCamera()" class="text-slate-400 hover:text-white"><i class="bi bi-x-lg"></i></button>
                            </div>

                            <!-- Video Feed -->
                            <div class="relative bg-black rounded-2xl overflow-hidden aspect-video flex items-center justify-center border border-emerald-500/30">
                                <video x-ref="videoFeed" autoplay playsinline class="w-full h-full object-cover"></video>
                                <div class="absolute inset-0 border-2 border-emerald-500/30 pointer-events-none rounded-2xl"></div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <button type="button" @click="closeCamera()" class="flex-1 py-3 bg-slate-800 text-slate-300 font-bold rounded-xl text-xs hover:bg-slate-700">
                                    Batal
                                </button>
                                <button type="button" @click="takePhoto()" class="flex-1 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-extrabold rounded-xl text-xs shadow-lg flex items-center justify-center gap-2">
                                    <i class="bi bi-camera-fill text-sm"></i> Ambil Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Alert -->
                <x-alert type="info">
                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                    Setoran mandiri akan <strong>langsung menambah saldo</strong> nasabah dan mencatat poin lingkungan mereka.
                </x-alert>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-outline-variant">
                    <a href="{{ route('petugas.dashboard') }}" class="flex-1 py-3 px-6 bg-surface-container-high hover:bg-surface-container-high/80 text-on-surface font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-3 px-6 bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg text-white font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Setoran
                    </button>
                </div>
                </x-card>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('selfDepositForm', () => ({
                items: [
                    { id: Date.now(), trash_category_id: '', berat_kg: '' }
                ],
                addItem() {
                    this.items.push({ id: Date.now(), trash_category_id: '', berat_kg: '' });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }));
        });
    </script>
</x-app-layout>
