<x-modal name="delete-modal" maxWidth="md">
    <div class="p-6 text-center">
        <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        
        <h3 class="text-xl font-bold text-on-surface mb-2">Konfirmasi Penghapusan</h3>
        <p class="text-on-surface-variant mb-6">
            Apakah Anda yakin ingin menghapus <strong class="text-on-surface" x-text="deleteName"></strong>?
            <br><span class="text-sm mt-2 block">Catatan: Jika kategori ini memiliki riwayat transaksi, data hanya akan diarsipkan (soft delete) untuk menjaga integritas data.</span>
        </p>

        <form x-bind:action="`/admin/trash-price/${deleteId}`" method="POST" class="flex justify-center gap-3" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            @method('DELETE')
            <button type="button" @click="$dispatch('close-modal', 'delete-modal')" class="px-5 py-2.5 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold rounded-xl transition-colors">
                Batal
            </button>
            <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center min-w-[120px]" :class="{ 'opacity-75 cursor-not-allowed': loading }">
                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span x-text="loading ? 'Menghapus...' : 'Ya, Hapus'"></span>
            </button>
        </form>
    </div>
</x-modal>
