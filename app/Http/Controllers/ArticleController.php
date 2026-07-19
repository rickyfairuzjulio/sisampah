<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function publicIndex()
    {
        $articles = Article::where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('articles.public-index', compact('articles'));
    }

    public function publicShow($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedArticles = Article::where('kategori', $article->kategori)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->limit(3)
            ->get();

        return view('articles.public-show', compact('article', 'relatedArticles'));
    }

    public function nasabahIndex()
    {
        $articles = Article::where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('articles.nasabah-index', compact('articles'));
    }

    public function adminIndex()
    {
        $articles = Article::latest()->paginate(15);

        return view('articles.admin-index', compact('articles'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'boolean',
        ]);

        $file = $request->file('image') ?? $request->file('gambar');
        if ($file) {
            $path = $file->store('articles', 'public');
            $validated['image'] = $path;
            $validated['gambar'] = $path;
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['created_by'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published', false);

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'boolean',
        ]);

        // Cek apakah user mengupload gambar baru
        $file = $request->file('image') ?? $request->file('gambar');

        if ($file) {
            // Hapus gambar lama dari storage public jika ada
            $oldImage = $article->image ?? $article->gambar;
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            // Simpan gambar baru ke storage/public/articles
            $path = $file->store('articles', 'public');
            $validated['image'] = $path;
            $validated['gambar'] = $path;
        } else {
            // Jika user tidak upload gambar baru, gambar lama jangan terhapus / ter-overwrite
            unset($validated['image'], $validated['gambar']);
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['is_published'] = $request->boolean('is_published', false);

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $imagePath = $article->image ?? $article->gambar;
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
