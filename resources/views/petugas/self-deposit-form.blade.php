<x-app-layout title="Input Setoran Mandiri">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <x-role-nav role="petugas" />

        <!-- Main Form Grid -->
        <form action="{{ route('petugas.self_deposit.store') }}" method="POST" enctype="multipart/form-data" 
              x-data="selfDepositForm()" 
              @detected="handleAI($event.detail)"
              @snapshot-taken="handleSnapshot($event.detail)">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                <!-- Left Side: Camera Scanner -->
                <x-card class="sticky top-6">


                    <x-camera-scanner />
                </x-card>

                <!-- Right Side: Form Content -->
                <x-card class="space-y-6">
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

                <!-- Form Section 2: Kategori & Berat -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-primary/20">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="text-sm font-bold text-primary">2</span>
                            </div>
                            <h3 class="font-semibold text-on-surface">Detail Sampah</h3>
                        </div>
                        
                        <!-- AI Status Badge -->
                        <div x-show="aiDetectedCategory" x-cloak class="px-3 py-1 bg-forest-emerald/20 text-forest-emerald rounded-full text-xs font-bold flex items-center gap-1 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Dipilih Otomatis
                        </div>
                    </div>

                    <x-select-field 
                        label="Kategori Sampah"
                        name="trash_category_id"
                        x-model="selectedCategoryId"
                        required
                        :items="$trashCategories->map(fn($k) => [
                            'value' => $k->id,
                            'label' => $k->nama . ' (Rp ' . number_format($k->harga_per_kg, 0, ',', '.') . '/Kg)'
                        ])->toArray()"
                        :error="$errors->has('trash_category_id') ? $errors->first('trash_category_id') : false"
                    />

                    <x-input-field 
                        label="Berat Sampah (Kg)"
                        name="berat_kg"
                        type="number"
                        placeholder="Contoh: 5.5"
                        step="0.1"
                        min="0.1"
                        required
                        :value="old('berat_kg')"
                        :error="$errors->has('berat_kg') ? $errors->first('berat_kg') : false"
                    />
                </div>

                <!-- Form Section 3: Foto Bukti -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-primary/20">
                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="text-sm font-bold text-primary">3</span>
                        </div>
                        <h3 class="font-semibold text-on-surface">Foto Bukti (Opsional)</h3>
                    </div>

                    <div>
                        <label for="foto_bukti" class="block text-sm font-medium text-on-surface mb-2">Upload Foto</label>
                        <div class="relative border-2 border-dashed border-primary/30 rounded-lg p-6 hover:border-primary/50 transition-colors">
                            <input type="file" id="foto_bukti" name="foto_bukti" accept="image/*"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="text-center pointer-events-none">
                                <svg class="w-12 h-12 text-primary/60 dark:text-primary mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-semibold text-on-surface">Klik atau tarik foto di sini</p>
                                <p class="text-xs text-on-surface-variant">JPEG, PNG, JPG (Maks 2MB)</p>
                            </div>
                        </div>
                        <div id="preview" class="mt-4 hidden">
                            <img id="previewImg" src="" alt="Preview" class="max-h-40 rounded-lg mx-auto">
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
                selectedCategoryId: '{{ old('trash_category_id') }}',
                aiDetectedCategory: null,
                categories: @json($trashCategories->map(fn($k) => ['id' => $k->id, 'nama' => $k->nama])),

                handleAI(detail) {
                    const matchedCategory = this.categories.find(c => 
                        detail.category.toLowerCase().includes(c.nama.toLowerCase()) || 
                        c.nama.toLowerCase().includes(detail.category.toLowerCase())
                    );
                    
                    if (matchedCategory && this.selectedCategoryId != matchedCategory.id) {
                        this.selectedCategoryId = matchedCategory.id;
                        this.aiDetectedCategory = detail.category;
                    }
                },
                
                handleSnapshot(detail) {
                    // Convert Data URL to Blob, then to File
                    fetch(detail.photoUrl)
                        .then(res => res.blob())
                        .then(blob => {
                            const file = new File([blob], "snapshot.jpg", { type: "image/jpeg" });
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            
                            const fileInput = document.getElementById('foto_bukti');
                            fileInput.files = dataTransfer.files;
                            
                            // Trigger change event for preview
                            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                            
                            // Also select category if not selected
                            this.handleAI({category: detail.category});
                        });
                }
            }));
        });

        const fileInput = document.getElementById('foto_bukti');
        const preview = document.getElementById('preview');
        const previewImg = document.getElementById('previewImg');

        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Drag and drop
        fileInput.parentElement.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileInput.parentElement.classList.add('border-primary', 'bg-primary/5');
        });

        fileInput.parentElement.addEventListener('dragleave', () => {
            fileInput.parentElement.classList.remove('border-primary', 'bg-primary/5');
        });

        fileInput.parentElement.addEventListener('drop', (e) => {
            e.preventDefault();
            fileInput.parentElement.classList.remove('border-primary', 'bg-primary/5');
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        });
    </script>
</x-app-layout>
