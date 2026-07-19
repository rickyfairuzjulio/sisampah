@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-on-surface">Edit Artikel</h1>
            <p class="text-sm text-on-surface-variant mt-1">Perbarui data artikel edukasi nasabah.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-xl font-bold border border-outline-variant transition-colors text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <x-alert type="error" class="mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <div class="bg-surface-container-lowest rounded-3xl shadow-xl border border-outline-variant p-6 sm:p-8">
        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Judul Artikel --}}
            <div>
                <label for="judul" class="block text-sm font-semibold text-on-surface mb-2">Judul Artikel</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $article->judul) }}" required
                       class="w-full px-4 py-3 border border-outline-variant bg-surface rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-shadow shadow-sm hover:border-primary/50"
                       placeholder="Masukkan judul artikel">
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori" class="block text-sm font-semibold text-on-surface mb-2">Kategori</label>
                <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $article->kategori) }}" required
                       class="w-full px-4 py-3 border border-outline-variant bg-surface rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-shadow shadow-sm hover:border-primary/50"
                       placeholder="Contoh: Edukasi Daur Ulang">
            </div>

            {{-- Konten --}}
            <div>
                <label for="konten" class="block text-sm font-semibold text-on-surface mb-2">Konten Artikel</label>
                <textarea id="konten" name="konten" rows="8" required
                          class="w-full px-4 py-3 border border-outline-variant bg-surface rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-shadow shadow-sm hover:border-primary/50"
                          placeholder="Tulis isi konten artikel di sini...">{{ old('konten', $article->konten) }}</textarea>
            </div>

            {{-- Gambar Sampul & Live Preview --}}
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-2">Gambar Sampul</label>

                <div class="mb-4 p-4 border border-outline-variant bg-surface-container/50 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    @if($article->image_url)
                        <img id="image-preview" src="{{ $article->image_url }}" alt="{{ $article->judul }}" class="w-40 h-28 object-cover rounded-xl border border-outline-variant shadow-sm bg-surface">
                    @else
                        <div id="image-preview-container" class="w-40 h-28 rounded-xl border border-outline-variant bg-surface flex items-center justify-center overflow-hidden">
                            <img id="image-preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            <span id="no-image-text" class="text-xs text-on-surface-variant font-medium text-center p-2">Belum ada gambar</span>
                        </div>
                    @endif
                    <div class="flex-1">
                        <p class="text-sm font-bold text-on-surface" id="preview-label">
                            {{ ($article->image || $article->gambar) ? 'Gambar Saat Ini' : 'Belum Ada Gambar Sampul' }}
                        </p>
                        <p class="text-xs text-on-surface-variant mt-1" id="preview-desc">
                            Pilih gambar baru di bawah untuk mengganti gambar lama secara langsung.
                        </p>
                        @if($article->image || $article->gambar)
                            <p class="text-xs text-primary font-mono mt-1 break-all">{{ $article->image_url }}</p>
                        @endif
                    </div>
                </div>

                <label for="image" class="block text-xs font-semibold text-on-surface-variant mb-1">Upload Gambar Baru (Opsional)</label>
                <input type="file" id="image" name="image" accept="image/*" onchange="previewSelectedImage(this)"
                       class="w-full px-4 py-2 border border-outline-variant bg-surface rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors">
                <p class="text-xs text-on-surface-variant mt-1">Format gambar: JPG, PNG, GIF, WEBP (maksimal 2MB).</p>
            </div>

            {{-- Status Publikasi --}}
            <div class="pt-2">
                <label for="is_published" class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary bg-surface-container">
                    <span class="font-bold text-on-surface">Publikasikan artikel ini</span>
                </label>
                <p class="text-xs text-on-surface-variant ml-8 mt-1">Jika tidak dicentang, artikel akan disimpan sebagai draft.</p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-4 pt-6 border-t border-outline-variant">
                <a href="{{ route('admin.articles.index') }}" class="flex-1 px-6 py-3 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-xl font-bold border border-outline-variant transition-colors text-center">
                    Batal
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-primary to-forest-emerald hover:from-primary-container hover:to-primary text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 text-center">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('image-preview');
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                const noImgText = document.getElementById('no-image-text');
                if (noImgText) {
                    noImgText.classList.add('hidden');
                }
                document.getElementById('preview-label').textContent = 'Preview Gambar Baru (Belum Disimpan)';
                document.getElementById('preview-desc').textContent = 'Gambar ini akan disimpan setelah Anda mengklik tombol "Simpan Perubahan".';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
