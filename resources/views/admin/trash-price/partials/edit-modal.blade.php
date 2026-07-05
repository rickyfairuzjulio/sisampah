<x-modal name="edit-modal" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-5 border-b border-outline-variant/30 pb-4">
            <h2 class="text-xl font-bold text-on-surface">Edit Harga Sampah</h2>
            <button @click="$dispatch('close-modal', 'edit-modal')" class="text-on-surface-variant hover:text-on-surface">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form x-bind:action="`/admin/trash-price/${editData.id}`" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" x-model="editData.nama" required class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Grup Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" x-model="editData.kategori" required class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary">
                        <option value="organik">Organik</option>
                        <option value="anorganik">Anorganik</option>
                        <option value="b3">B3</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-on-surface mb-2">Sub-Jenis / Varian</label>
                    <input type="text" name="jenis" x-model="editData.jenis" class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Kualitas Standar <span class="text-red-500">*</span></label>
                    <select name="kualitas" x-model="editData.kualitas" required class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary">
                        <option value="premium">Premium</option>
                        <option value="standar">Standar</option>
                        <option value="rendah">Rendah</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-surface-container-low rounded-xl border border-outline-variant/50">
                <div class="relative">
                    <label class="block text-sm font-medium text-on-surface mb-2">Harga Baru <span class="text-red-500">*</span></label>
                    <div class="absolute inset-y-0 left-0 pt-7 pl-3 flex items-center pointer-events-none text-on-surface-variant">Rp</div>
                    <input type="number" name="harga_per_kg" x-model="editData.harga_per_kg" required min="0" step="100" class="w-full pl-10 pr-4 py-2 border border-primary/50 rounded-lg bg-surface-container-lowest focus:ring-primary font-bold text-primary">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-on-surface mb-2">Alasan Perubahan Harga</label>
                    <input type="text" name="alasan" placeholder="Cth: Penyesuaian pasar, dll (wajib jika harga diubah)" class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Satuan <span class="text-red-500">*</span></label>
                    <select name="satuan" x-model="editData.satuan" required class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary">
                        <option value="kg">Kilogram (Kg)</option>
                        <option value="gram">Gram (g)</option>
                        <option value="unit">Per Unit/Pcs</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Target Stok</label>
                    <input type="number" name="stok_dibutuhkan" x-model="editData.stok_dibutuhkan" class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Update Gambar (Biarkan kosong jika tidak diubah)</label>
                <input type="file" name="gambar_file" accept="image/jpeg,image/png,image/webp" class="w-full border border-outline-variant rounded-lg py-2 px-3 text-sm focus:ring-primary bg-surface-container-lowest file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Deskripsi</label>
                    <textarea name="deskripsi" x-model="editData.deskripsi" rows="2" class="w-full border border-outline-variant rounded-lg p-3 text-sm focus:ring-primary bg-surface-container-lowest"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Manfaat</label>
                    <textarea name="manfaat" x-model="editData.manfaat" rows="2" class="w-full border border-outline-variant rounded-lg p-3 text-sm focus:ring-primary bg-surface-container-lowest"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-outline-variant/30">
                <button type="button" @click="$dispatch('close-modal', 'edit-modal')" class="px-5 py-2.5 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold rounded-xl transition-colors text-sm">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-container text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2 min-w-[120px] text-sm" :class="{ 'opacity-75 cursor-not-allowed': loading }">
                    <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="loading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                </button>
            </div>
        </form>
    </div>
</x-modal>
