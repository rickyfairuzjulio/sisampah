<x-modal name="create-modal" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-5 border-b border-outline-variant pb-4">
            <h2 class="text-xl font-bold text-on-surface">Tambah Harga Sampah</h2>
            <button @click="$dispatch('close-modal', 'create-modal')" class="text-on-surface-variant hover:text-on-surface">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.trash_price.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input-field label="Nama Kategori" name="nama" required placeholder="Misal: Botol Plastik PET" />
                
                <x-select-field label="Grup Kategori" name="kategori" required :items="[
                    ['value' => 'organik', 'label' => 'Organik'],
                    ['value' => 'anorganik', 'label' => 'Anorganik'],
                    ['value' => 'b3', 'label' => 'B3']
                ]" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <x-input-field label="Sub-Jenis / Varian" name="jenis" placeholder="Misal: Botol air mineral bening" />
                </div>
                <x-select-field label="Kualitas Standar" name="kualitas" required :items="[
                    ['value' => 'premium', 'label' => 'Premium'],
                    ['value' => 'standar', 'label' => 'Standar'],
                    ['value' => 'rendah', 'label' => 'Rendah']
                ]" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <label class="block text-sm font-medium text-on-surface mb-2">Harga <span class="text-red-500">*</span></label>
                    <div class="absolute inset-y-0 left-0 pt-7 pl-3 flex items-center pointer-events-none text-on-surface-variant">Rp</div>
                    <input type="number" name="harga_per_kg" required min="0" step="100" class="w-full pl-10 pr-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary focus:border-primary transition-all">
                </div>
                <x-select-field label="Satuan" name="satuan" required :items="[
                    ['value' => 'kg', 'label' => 'Kilogram (Kg)'],
                    ['value' => 'gram', 'label' => 'Gram (g)'],
                    ['value' => 'unit', 'label' => 'Per Unit/Pcs']
                ]" />
                <x-input-field label="Target Stok (Opsional)" name="stok_dibutuhkan" type="number" placeholder="Dalam satuan yg dipilih" />
            </div>

            <div x-data="{ photoName: null, photoPreview: null }">
                <label class="block text-sm font-medium text-on-surface mb-2">Upload Gambar (Opsional)</label>
                
                <div class="flex items-center gap-4">
                    <!-- Preview Image -->
                    <div class="w-24 h-24 rounded-lg bg-surface-container-high border border-outline-variant flex items-center justify-center overflow-hidden shrink-0">
                        <template x-if="!photoPreview">
                            <svg class="w-8 h-8 text-on-surface-variant/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </template>
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                    </div>
                    
                    <!-- File Input -->
                    <div class="flex-1">
                        <input type="file" name="gambar_file" accept="image/jpeg,image/png,image/webp" class="hidden"
                            @change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => { photoPreview = e.target.result; };
                                reader.readAsDataURL($refs.photo.files[0]);
                            "
                            x-ref="photo">
                        
                        <button type="button" @click="$refs.photo.click()" class="px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-sm font-semibold rounded-lg transition-colors border border-outline-variant">
                            Pilih Foto
                        </button>
                        <p class="text-[10px] text-on-surface-variant mt-2">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full border border-outline-variant rounded-lg p-3 text-sm focus:ring-primary bg-surface-container-lowest"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Manfaat Daur Ulang</label>
                    <textarea name="manfaat" rows="3" class="w-full border border-outline-variant rounded-lg p-3 text-sm focus:ring-primary bg-surface-container-lowest"></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Tips Penyimpanan</label>
                    <textarea name="tips_penyimpanan" rows="2" class="w-full border border-outline-variant rounded-lg p-3 text-sm focus:ring-primary bg-surface-container-lowest"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Tips Menjual</label>
                    <textarea name="tips_menjual" rows="2" class="w-full border border-outline-variant rounded-lg p-3 text-sm focus:ring-primary bg-surface-container-lowest"></textarea>
                </div>
            </div>
            
            <x-input-field label="Nilai Daur Ulang Ekonomi (Opsional)" name="nilai_daur_ulang" placeholder="Sangat Tinggi / Tinggi / Sedang / Rendah" />

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-outline-variant">
                <button type="button" @click="$dispatch('close-modal', 'create-modal')" class="px-5 py-2.5 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold rounded-xl transition-colors text-sm">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-container text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2 min-w-[120px] text-sm" :class="{ 'opacity-75 cursor-not-allowed': loading }">
                    <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="loading ? 'Menyimpan...' : 'Simpan Data'"></span>
                </button>
            </div>
        </form>
    </div>
</x-modal>
