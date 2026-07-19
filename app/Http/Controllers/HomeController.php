<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Transaction;
use App\Models\TrashCategory;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        $stats = \Illuminate\Support\Facades\Cache::remember('home.stats', 600, function () {
            return [
                'nasabah' => User::role('nasabah')->count(),
                'petugas' => User::role('petugas')->count(),
                'sampah_kg' => (float) Transaction::where('status', 'selesai')->sum('berat_kg'),
                'transaksi' => Transaction::where('status', 'selesai')->count(),
            ];
        });

        $categories = TrashCategory::active()->select('id', 'nama', 'harga_per_kg', 'satuan')->get();

        return view('home', compact('articles', 'stats', 'categories'));
    }
}
