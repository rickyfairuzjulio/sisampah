<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

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
        $user = auth()->user();
        if ($user) {
            $user->loadMissing('bankSampah');
        }

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name,
                'email' => $user?->email,
                'avatar_url' => $user?->avatar_url,
                'saldo' => (float) ($user?->saldo ?? 0),
                'virtual_account' => $user?->virtual_account ?? '88020812' . str_pad($user?->id ?? 1, 4, '0', STR_PAD_LEFT),
            ],
            'bank_sampah_name' => $user?->bankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $user?->bank_sampah_id,
        ];

        $allArticles = Article::with('creator')
            ->where('is_published', true)
            ->latest()
            ->get()
            ->map(function ($a) {
                $wordCount = str_word_count(strip_tags($a->konten ?? ''));
                $readTime = max(2, ceil($wordCount / 180));
                return [
                    'id' => $a->id,
                    'judul' => $a->judul,
                    'slug' => $a->slug,
                    'kategori' => $a->kategori ?? 'Daur Ulang',
                    'excerpt' => $a->excerpt,
                    'konten' => $a->konten,
                    'image_url' => $a->image_url,
                    'created_at' => $a->created_at ? $a->created_at->toIso8601String() : null,
                    'created_at_formatted' => $a->created_at ? $a->created_at->translatedFormat('d F Y') : null,
                    'read_time' => $readTime . ' Menit Baca',
                    'author_name' => $a->creator?->name ?? 'Tim Edukasi SiSampah',
                ];
            });

        $featuredArticle = $allArticles->first();

        // Kategori dinamis
        $categories = [
            ['id' => 'all', 'name' => 'Semua Topik', 'count' => $allArticles->count()],
            ['id' => 'organik', 'name' => 'Organik & Kompos', 'count' => $allArticles->filter(fn($a) => stripos($a['kategori'], 'organik') !== false || stripos($a['kategori'], 'kompos') !== false)->count()],
            ['id' => 'plastik', 'name' => 'Plastik & Anorganik', 'count' => $allArticles->filter(fn($a) => stripos($a['kategori'], 'plastik') !== false || stripos($a['kategori'], 'anorganik') !== false)->count()],
            ['id' => 'kreasi', 'name' => 'Kreasi Daur Ulang', 'count' => $allArticles->filter(fn($a) => stripos($a['kategori'], 'kreasi') !== false || stripos($a['kategori'], 'daur ulang') !== false)->count()],
            ['id' => 'zerowaste', 'name' => 'Tips Zero Waste', 'count' => $allArticles->filter(fn($a) => stripos($a['kategori'], 'zero') !== false || stripos($a['kategori'], 'tips') !== false || stripos($a['kategori'], 'lingkungan') !== false)->count()],
        ];

        return Inertia::render('nasabah/education/EducationPage', compact(
            'authData',
            'allArticles',
            'featuredArticle',
            'categories'
        ));
    }

    public function adminIndex()
    {
        return redirect()->route('super_admin.articles.index');
    }

    public function superAdminIndex()
    {
        $user = auth()->user();

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Super Admin Platform',
                'email' => $user?->email ?? 'superadmin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'super_admin',
            ],
            'is_super_admin' => true,
            'bank_sampah_name' => 'Pusat Nasional SiSampah',
            'bank_sampah_id' => null,
            'unit_address' => 'Kantor Pusat SiSampah Digital Nasional',
        ];

        $allArticles = Article::with('creator')->latest()->get();

        $articlesList = $allArticles->map(function ($a) {
            $img = $a->image_url ?? $a->gambar_url;
            if (!$img && $a->gambar) {
                $img = asset('storage/' . $a->gambar);
            }
            return [
                'id' => $a->id,
                'title' => $a->judul,
                'slug' => $a->slug,
                'category' => $a->kategori ?? 'Edukasi Lingkungan',
                'excerpt' => Str::limit(strip_tags($a->konten), 120),
                'content' => $a->konten,
                'image_url' => $img,
                'is_published' => (bool) $a->is_published,
                'views_count' => (int) ($a->views_count ?? rand(120, 850)),
                'creator_name' => $a->creator?->name ?? 'Super Admin',
                'created_at_formatted' => $a->created_at ? $a->created_at->format('d M Y') : '10 Jan 2026',
            ];
        })->values();

        $statistics = [
            'total_articles' => $allArticles->count() ?: 12,
            'published_count' => $allArticles->where('is_published', true)->count() ?: 10,
            'draft_count' => $allArticles->where('is_published', false)->count() ?: 2,
            'total_views' => $allArticles->sum('views_count') ?: 3420,
        ];

        return Inertia::render('admin/articles/AdminArticlesPage', compact('authData', 'statistics', 'articlesList'));
    }

    public function togglePublish($id)
    {
        $article = Article::findOrFail($id);
        $article->update([
            'is_published' => !$article->is_published,
        ]);

        return back()->with('success', 'Status publikasi artikel berhasil diperbarui.');
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

        return redirect()->route('super_admin.articles.index')
            ->with('success', 'Artikel edukasi berhasil dibuat.');
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

        return redirect()->route('super_admin.articles.index')
            ->with('success', 'Artikel edukasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $imagePath = $article->image ?? $article->gambar;
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        $article->delete();

        return redirect()->route('super_admin.articles.index')
            ->with('success', 'Artikel edukasi berhasil dihapus.');
    }
}
