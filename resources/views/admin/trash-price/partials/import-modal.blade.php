<x-modal name="import-modal" maxWidth="md">
    <div class="p-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-200 dark:border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/15 flex items-center justify-center">
                    <i class="bi bi-cloud-upload text-emerald-500 text-lg"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Import Data Harga</h2>
            </div>
            <button @click="$dispatch('close-modal', 'import-modal')"
                class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 hover:text-gray-700 dark:hover:text-white transition-colors">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>

        {{-- Description --}}
        <div class="mb-5">
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 leading-relaxed">
                Gunakan fitur ini untuk memperbarui harga secara massal atau menambahkan kategori baru dari file Excel/CSV.
            </p>
            <a href="#" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                <i class="bi bi-download text-sm"></i>
                Download Template Excel
            </a>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Dropzone --}}
            <div class="border-2 border-dashed border-gray-300 dark:border-white/20 rounded-xl p-8 text-center hover:border-emerald-400 dark:hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-500/5 transition-all cursor-pointer relative" id="dropzone">
                <input type="file" name="file" accept=".xlsx,.csv" required
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                    onchange="document.getElementById('filename').textContent = this.files[0].name">
                <i class="bi bi-file-earmark-plus text-4xl text-gray-400 dark:text-gray-500 mb-3 block"></i>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">Klik atau Drag &amp; Drop file disini</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5" id="filename">Format didukung: .xlsx, .csv</p>
            </div>

            {{-- Footer Actions --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-white/10">
                <button type="button" @click="$dispatch('close-modal', 'import-modal')"
                    class="px-5 py-2.5 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/15 text-gray-700 dark:text-gray-200 font-semibold rounded-xl transition-colors text-sm">
                    Batal
                </button>
                <button type="button" disabled
                    class="px-6 py-2.5 bg-emerald-500 opacity-60 cursor-not-allowed text-white font-bold rounded-xl text-sm flex items-center gap-2">
                    <i class="bi bi-cloud-upload-fill"></i>
                    Import Data (Coming Soon)
                </button>
            </div>
        </form>
    </div>
</x-modal>
