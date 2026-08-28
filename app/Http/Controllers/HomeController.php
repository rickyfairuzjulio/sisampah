<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Transaction;
use App\Models\TrashCategory;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $rawArticles = Article::where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        $articles = $rawArticles->map(function ($a) {
            return [
                'id' => $a->id,
                'judul' => $a->judul,
                'slug' => $a->slug,
                'kategori' => $a->kategori ?? 'Edukasi',
                'excerpt' => $a->excerpt,
                'image_url' => $a->image_url,
                'tanggal' => $a->created_at ? $a->created_at->translatedFormat('d M Y') : 'Terbaru',
                'url' => route('edukasi.show', $a->slug),
            ];
        });

        $stats = \Illuminate\Support\Facades\Cache::remember('home.stats', 600, function () {
            $sampahKg = (float) Transaction::where('status', 'selesai')->sum('berat_kg');
            return [
                'nasabah' => User::role('nasabah')->count(),
                'petugas' => User::role('petugas')->count(),
                'sampah_kg' => $sampahKg,
                'sampah_formatted' => $sampahKg >= 1000 
                    ? number_format($sampahKg / 1000, 1) . ' Ton' 
                    : number_format($sampahKg, 1) . ' Kg',
                'transaksi' => Transaction::where('status', 'selesai')->count(),
            ];
        });

        $categories = TrashCategory::active()
            ->select('id', 'nama', 'harga_per_kg', 'satuan', 'kategori')
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'nama' => $c->nama,
                    'harga_per_kg' => (int) $c->harga_per_kg,
                    'satuan' => $c->satuan ?? 'kg',
                    'kategori' => $c->kategori ?? 'Anorganik',
                ];
            });

        $authUser = auth()->user();
        $authData = [
            'is_authenticated' => auth()->check(),
            'user' => $authUser ? [
                'name' => $authUser->name,
                'email' => $authUser->email,
                'avatar_url' => $authUser->avatar_url,
                'role' => $authUser->getRoleNames()->first() ?? 'nasabah',
                'dashboard_url' => route(
                    $authUser->hasRole('super_admin')
                        ? 'super_admin.dashboard'
                        : ($authUser->hasRole('admin')
                            ? 'admin.dashboard'
                            : ($authUser->hasRole('petugas') ? 'petugas.dashboard' : 'nasabah.dashboard'))
                ),
            ] : null,
        ];

        return Inertia::render('landing/LandingPage', compact('articles', 'stats', 'categories', 'authData'));
    }
}
