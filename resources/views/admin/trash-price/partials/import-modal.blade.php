<x-modal name="import-modal" maxWidth="md">
    <div class="p-6">
        <div class="flex items-center justify-between mb-5 border-b border-outline-variant pb-4">
            <h2 class="text-xl font-bold text-on-surface">Import Data Harga</h2>
            <button @click="$dispatch('close-modal', 'import-modal')" class="text-on-surface-variant hover:text-on-surface">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="mb-4">
            <p class="text-sm text-on-surface-variant mb-2">Gunakan fitur ini untuk memperbarui harga secara massal atau menambahkan kategori baru dari file Excel/CSV.</p>
            <a href="#" class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download Template Excel
            </a>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="border-2 border-dashed border-outline-variant rounded-xl p-6 text-center hover:bg-surface-container-lowest transition-colors cursor-pointer relative" id="dropzone">
                <input type="file" name="file" accept=".xlsx,.csv" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="document.getElementById('filename').textContent = this.files[0].name">
                <svg class="w-10 h-10 text-on-surface-variant mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-sm font-semibold text-on-surface">Klik atau Drag & Drop file disini</p>
                <p class="text-xs text-on-surface-variant mt-1" id="filename">Format didukung: .xlsx, .csv</p>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-outline-variant">
                <button type="button" @click="$dispatch('close-modal', 'import-modal')" class="px-5 py-2.5 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold rounded-xl transition-colors">
                    Batal
                </button>
                <button type="button" class="px-6 py-2.5 bg-primary opacity-50 cursor-not-allowed text-white font-bold rounded-xl shadow-sm transition-colors">
                    Import Data (Coming Soon)
                </button>
            </div>
        </form>
    </div>
</x-modal>
