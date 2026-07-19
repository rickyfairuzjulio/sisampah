@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <x-role-nav role="admin" />

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-on-surface">Kelola Artikel Edukasi</h1>
            <p class="text-sm text-on-surface-variant mt-1">Buat dan kelola konten edukasi untuk nasabah.</p>
        </div>
        <button onclick="openCreateModal()" class="px-6 py-2.5 bg-primary text-white rounded-xl font-bold hover:bg-primary-container shadow-sm transition-all hover:shadow hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Artikel Baru
        </button>
    </div>

    @if (session('success'))
        <x-alert type="success" class="mb-6 animate-slide-in">{{ session('success') }}</x-alert>
    @endif

    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-slide-in">
            @foreach($articles as $article)
                <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden hover:shadow-md hover:border-primary/30 transition-all flex flex-col h-full group">
                    @if($article->image_url)
                        <img src="{{ $article->image_url }}" alt="{{ $article->judul }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-44 bg-gradient-to-br from-primary/20 to-forest-emerald/20 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg border
                                @if($article->is_published) bg-green-100 text-green-700 border-green-200
                                @else bg-surface-container text-on-surface-variant border-outline-variant
                                @endif">
                                {{ $article->is_published ? 'Dipublikasikan' : 'Draft' }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-on-surface mb-2 line-clamp-2 group-hover:text-primary transition-colors">{{ $article->judul }}</h3>
                        <p class="text-sm text-on-surface-variant mb-4 line-clamp-3 flex-1">{{ $article->konten }}</p>

                        <div class="flex items-center justify-between text-xs text-on-surface-variant font-medium mb-5 pt-4 border-t border-outline-variant">
                            <span class="bg-surface-container px-2 py-1 rounded-md">{{ $article->kategori }}</span>
                            <span>{{ $article->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.articles.edit', $article->id) }}" 
                               class="flex-1 px-4 py-2 bg-surface-container-high text-on-surface rounded-xl font-bold hover:bg-surface border border-outline-variant transition-colors text-sm text-center">
                                Edit
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus artikel ini?')" class="w-full px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-xl font-bold hover:bg-red-100 transition-colors text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-surface-container-lowest border border-dashed border-outline-variant rounded-2xl shadow-sm">
            <svg class="w-16 h-16 text-outline-variant mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            <p class="text-on-surface-variant text-lg font-semibold mb-6">Belum ada artikel edukasi</p>
            <button onclick="openCreateModal()" class="px-6 py-2.5 bg-primary text-white rounded-xl font-bold hover:bg-primary-container shadow-sm transition-all hover:shadow hover:-translate-y-0.5 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Artikel Pertama
            </button>
        </div>
    @endif
</div>

<div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto px-4 py-6" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeCreateModal()"></div>
    
    <div class="bg-surface-container-lowest rounded-3xl shadow-2xl border border-outline-variant p-6 sm:p-8 max-w-2xl w-full my-8 relative z-10 transform transition-all">
        <h2 class="text-2xl font-bold text-on-surface mb-6">Buat Artikel Baru</h2>

        @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form id="createForm" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <x-input-field label="Judul Artikel" name="judul" id="judul" required placeholder="Tulis judul yang menarik" />
            <x-input-field label="Kategori" name="kategori" id="kategori" required placeholder="Contoh: Edukasi Daur Ulang" />

            <div>
                <label for="konten" class="block text-sm font-semibold text-on-surface mb-2">Konten Artikel</label>
                <textarea id="konten" name="konten" rows="8" required class="w-full px-4 py-3 border border-outline-variant bg-surface rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-shadow shadow-sm hover:border-primary/50" placeholder="Tulis isi konten artikel di sini..."></textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-semibold text-on-surface mb-2">Gambar Sampul (Opsional)</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-2 border border-outline-variant bg-surface rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors">
            </div>

            <div class="pt-2">
                <label for="is_published" class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="is_published" name="is_published" value="1" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary bg-surface-container">
                    <span class="font-bold text-on-surface">Publikasikan artikel ini</span>
                </label>
                <p class="text-xs text-on-surface-variant ml-8 mt-1">Jika tidak dicentang, artikel akan disimpan sebagai draft.</p>
            </div>

            <div class="flex gap-3 pt-6 border-t border-outline-variant mt-2">
                <button type="button" onclick="closeCreateModal()" class="flex-1 px-6 py-3 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-xl font-bold border border-outline-variant transition-colors text-center">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-primary to-forest-emerald hover:from-primary-container hover:to-primary text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 text-center">
                    Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createForm').reset();
        document.getElementById('createModal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }
</script>
@endsection
