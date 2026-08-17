<x-modal name="edit-modal" maxWidth="3xl">
    <div x-data="{ activeTab: 'utama', loading: false }" class="flex flex-col h-full max-h-[calc(100vh-6rem)]">
        
        <!-- Header (Solid background & high contrast) -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex items-center justify-between bg-white dark:bg-[#071c15] shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-500">
                    <i class="bi bi-pencil-square text-lg font-bold"></i>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white leading-tight">Edit Kategori &amp; Harga Sampah</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="editData.nama ? `Memperbarui data: ${editData.nama}` : 'Perbarui tarif dan deskripsi sampah'"></p>
                </div>
            </div>
            <button @click="$dispatch('close-modal', 'edit-modal')" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-200 dark:hover:bg-white/10 hover:text-gray-700 dark:hover:text-white transition-colors">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>

        <!-- Navigation Tabs -->
        <div class="px-6 pt-3 bg-gray-50 dark:bg-white/[0.03] border-b border-gray-200 dark:border-white/10 flex gap-2 shrink-0">
            <button @click="activeTab = 'utama'" :class="activeTab === 'utama' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold bg-white dark:bg-[#0c271e]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 border-b-2 text-xs font-semibold rounded-t-lg transition-all flex items-center gap-2">
                <i class="bi bi-sliders"></i> 1. Informasi &amp; Perubahan Harga
            </button>
            <button @click="activeTab = 'detail'" :class="activeTab === 'detail' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold bg-white dark:bg-[#0c271e]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 border-b-2 text-xs font-semibold rounded-t-lg transition-all flex items-center gap-2">
                <i class="bi bi-journal-text"></i> 2. Deskripsi &amp; Tips Daur Ulang
            </button>
        </div>

        <!-- Form Content Body (Scrollable) -->
        <form x-bind:action="`/admin/trash-price/${editData.id}`" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar" @submit="loading = true">
            @csrf
            @method('PUT')
            
            <!-- Tab 1: Utama -->
            <div x-show="activeTab === 'utama'" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" x-model="editData.nama" required class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Grup Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" x-model="editData.kategori" required class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-[#071c15] text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                            <option value="organik">Organik</option>
                            <option value="anorganik">Anorganik</option>
                            <option value="b3">B3</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Sub-Jenis / Varian</label>
                        <input type="text" name="jenis" x-model="editData.jenis" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Kualitas Standar <span class="text-red-500">*</span></label>
                        <select name="kualitas" x-model="editData.kualitas" required class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-[#071c15] text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                            <option value="premium">Premium</option>
                            <option value="standar">Standar</option>
                            <option value="rendah">Rendah</option>
                        </select>
                    </div>
                </div>

                <!-- Price Highlight & Reason Box -->
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="relative">
                            <label class="block text-xs font-black text-emerald-800 dark:text-emerald-300 uppercase tracking-wider mb-1.5">Harga Per Kg <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-600 dark:text-emerald-400 font-bold text-sm">Rp</div>
                                <input type="number" name="harga_per_kg" x-model="editData.harga_per_kg" required min="0" step="100" class="w-full pl-9 pr-3 py-2 text-base font-extrabold border border-emerald-500/40 rounded-xl bg-white dark:bg-[#071c15] text-emerald-600 dark:text-emerald-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Satuan <span class="text-red-500">*</span></label>
                            <select name="satuan" x-model="editData.satuan" required class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-[#071c15] text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                <option value="kg">Kilogram (Kg)</option>
                                <option value="gram">Gram (g)</option>
                                <option value="unit">Per Unit/Pcs</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Target Stok (Kg)</label>
                            <input type="number" name="stok_dibutuhkan" x-model="editData.stok_dibutuhkan" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-emerald-800 dark:text-emerald-300 uppercase tracking-wider mb-1.5">Alasan Perubahan Harga (Catatan Histori)</label>
                        <input type="text" name="alasan" placeholder="Misal: Penyesuaian harga pasar daur ulang" class="w-full px-3.5 py-2 text-xs border border-emerald-500/30 rounded-xl bg-white dark:bg-[#071c15] text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    </div>
                </div>

                <!-- Photo Upload Box -->
                <div x-data="{ photoName: null, photoPreview: null }" class="p-4 border border-gray-200 dark:border-white/10 rounded-2xl bg-gray-50/50 dark:bg-white/[0.02]">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-2">Foto / Gambar Sampah</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-xl bg-white dark:bg-white/5 border border-gray-300 dark:border-white/10 flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                            <template x-if="!photoPreview && !editData.image_url">
                                <i class="bi bi-image text-2xl text-gray-400"></i>
                            </template>
                            <template x-if="!photoPreview && editData.image_url">
                                <img :src="editData.image_url" class="w-full h-full object-cover">
                            </template>
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="gambar_file" accept="image/jpeg,image/png,image/webp" class="hidden"
                                @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                "
                                x-ref="photo">
                            <button type="button" @click="$refs.photo.click()" class="px-4 py-2 bg-white dark:bg-white/10 border border-gray-300 dark:border-white/10 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-xl hover:bg-gray-100 dark:hover:bg-white/20 transition-all inline-flex items-center gap-2">
                                <i class="bi bi-upload"></i> Pilih Foto Baru
                            </button>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1.5">Kosongkan jika tidak ingin mengganti foto.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Deskripsi & Tips -->
            <div x-show="activeTab === 'detail'" class="space-y-5" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                        <textarea name="deskripsi" x-model="editData.deskripsi" rows="3" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Manfaat Daur Ulang</label>
                        <textarea name="manfaat" x-model="editData.manfaat" rows="3" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Tips Penyimpanan</label>
                        <textarea name="tips_penyimpanan" x-model="editData.tips_penyimpanan" rows="3" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Tips Menjual Agar Harga Maksimal</label>
                        <textarea name="tips_menjual" x-model="editData.tips_menjual" rows="3" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"></textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider mb-1.5">Nilai Daur Ulang Ekonomi (Opsional)</label>
                    <input type="text" name="nilai_daur_ulang" x-model="editData.nilai_daur_ulang" placeholder="Sangat Tinggi / Tinggi / Sedang / Rendah" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="pt-4 border-t border-gray-200 dark:border-white/10 flex items-center justify-between bg-white dark:bg-[#0c271e]">
                <button type="button" @click="activeTab = (activeTab === 'utama' ? 'detail' : 'utama')" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                    <span x-text="activeTab === 'utama' ? 'Lanjut ke Tips &amp; Deskripsi &rarr;' : '&larr; Kembali ke Informasi Utama'"></span>
                </button>
                <div class="flex items-center gap-3">
                    <button type="button" @click="$dispatch('close-modal', 'edit-modal')" class="px-5 py-2.5 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/15 text-gray-700 dark:text-gray-200 font-semibold rounded-xl transition-all text-xs">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2 text-xs" :class="{ 'opacity-75 cursor-not-allowed': loading }">
                        <i x-show="!loading" class="bi bi-check-lg text-sm"></i>
                        <span x-text="loading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-modal>
