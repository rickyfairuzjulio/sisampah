@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <x-role-nav role="admin" />

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Artikel Edukasi</h1>
        <button onclick="openCreateModal()" class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
            Buat Artikel Baru
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($article->gambar)
                        <img src="{{ Storage::url($article->gambar) }}" alt="{{ $article->judul }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold px-2 py-1 rounded-full
                                @if($article->is_published) bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $article->is_published ? 'Dipublikasikan' : 'Draft' }}
                            </span>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $article->judul }}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $article->konten }}</p>

                        <div class="text-xs text-gray-500 mb-4">
                            <p>{{ $article->kategori }}</p>
                            <p>{{ $article->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="flex gap-2">
                            <button onclick="editArticle({{ $article->id }}, '{{ addslashes($article->judul) }}', '{{ addslashes($article->konten) }}', '{{ $article->kategori }}', {{ $article->is_published ? 'true' : 'false' }})" class="flex-1 px-3 py-2 bg-blue-600 text-white rounded font-semibold hover:bg-blue-700 text-sm">
                                Edit
                            </button>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="w-full px-3 py-2 bg-red-600 text-white rounded font-semibold hover:bg-red-700 text-sm">
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
        <div class="text-center py-12 bg-white rounded-lg shadow-md">
            <p class="text-gray-600 text-lg mb-4">Belum ada artikel yang dibuat</p>
            <button onclick="openCreateModal()" class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                Buat Artikel Pertama
            </button>
        </div>
    @endif
</div>

<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center overflow-y-auto">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl w-full my-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Buat Artikel Baru</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="createForm" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="judul" class="block text-sm font-semibold text-gray-900 mb-2">Judul Artikel</label>
                <input type="text" id="judul" name="judul" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Judul artikel">
            </div>

            <div>
                <label for="kategori" class="block text-sm font-semibold text-gray-900 mb-2">Kategori</label>
                <input type="text" id="kategori" name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: Edukasi Daur Ulang">
            </div>

            <div>
                <label for="konten" class="block text-sm font-semibold text-gray-900 mb-2">Konten</label>
                <textarea id="konten" name="konten" rows="6" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Isi konten artikel..."></textarea>
            </div>

            <div>
                <label for="gambar" class="block text-sm font-semibold text-gray-900 mb-2">Gambar (Opsional)</label>
                <input type="file" id="gambar" name="gambar" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>

            <div>
                <label for="is_published" class="flex items-center gap-2">
                    <input type="checkbox" id="is_published" name="is_published" value="1" class="w-4 h-4">
                    <span class="text-sm font-semibold text-gray-900">Publikasikan artikel ini</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeCreateModal()" class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                    Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createForm').reset();
        document.getElementById('createForm').action = '{{ route("admin.articles.store") }}';
        document.getElementById('createModal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    function editArticle(id, judul, konten, kategori, isPublished) {
        document.getElementById('judul').value = judul;
        document.getElementById('konten').value = konten;
        document.getElementById('kategori').value = kategori;
        document.getElementById('is_published').checked = isPublished;
        document.getElementById('createForm').action = '/admin/articles/' + id;
        document.querySelector('h2').textContent = 'Edit Artikel';
        document.getElementById('createModal').classList.remove('hidden');
    }
</script>
@endsection
