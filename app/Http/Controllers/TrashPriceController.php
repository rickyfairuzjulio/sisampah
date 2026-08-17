<?php

namespace App\Http\Controllers;

use App\Core\Services\PricePredictionService;
use App\Core\Services\TrashPriceService;
use App\Http\Requests\StoreTrashPriceRequest;
use App\Http\Requests\UpdateTrashPriceRequest;
use App\Models\PriceHistory;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashPriceController extends Controller
{
    protected TrashPriceService $priceService;

    protected PricePredictionService $predictionService;

    public function __construct(TrashPriceService $priceService, PricePredictionService $predictionService)
    {
        $this->priceService = $priceService;
        $this->predictionService = $predictionService;
    }

    // ==========================================
    // ADMIN ACTIONS
    // ==========================================

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'status_harga', 'kualitas', 'min_price', 'max_price', 'sort', 'is_archived', 'bank_sampah_id']);

        if (Auth::user()?->bank_sampah_id) {
            $filters['bank_sampah_id'] = Auth::user()->bank_sampah_id;
        }

        $prices = $this->priceService->getFilteredPrices($filters, 10);
        $statistics = $this->priceService->getStatistics();
        $bankSampahs = \App\Models\BankSampah::all();

        return view('admin.trash-price.index', compact('prices', 'filters', 'statistics', 'bankSampahs'));
    }

    public function show($id)
    {
        $category = TrashCategory::with(['bankSampah', 'priceHistories.admin'])->findOrFail($id);
        $prediction = $this->predictionService->predictPrice($id, 7); // Predict 7 days ahead
        $trend = $this->predictionService->getTrendAnalysis($id);

        $histories = PriceHistory::where('trash_category_id', $id)
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $chartHistories = PriceHistory::where('trash_category_id', $id)
            ->orderBy('created_at', 'asc')
            ->take(30)
            ->get();

        return view('admin.trash-price.show', compact('category', 'prediction', 'trend', 'histories', 'chartHistories'));
    }

    public function store(StoreTrashPriceRequest $request)
    {
        $validated = $request->validated();

        if (Auth::user()?->bank_sampah_id) {
            $validated['bank_sampah_id'] = Auth::user()->bank_sampah_id;
        }

        $this->priceService->createPrice($validated, Auth::user());

        return redirect()->route('admin.trash_price.index')->with('success', 'Harga sampah berhasil ditambahkan.');
    }

    public function update(UpdateTrashPriceRequest $request, $id)
    {
        $data = $request->validated();
        $alasan = $request->input('alasan');

        $this->priceService->updatePrice($id, $data, Auth::user(), $alasan);

        return redirect()->route('admin.trash_price.index')->with('success', 'Harga sampah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $deleted = $this->priceService->deleteOrArchivePrice($id);
        $message = $deleted
            ? 'Harga sampah berhasil dihapus.'
            : 'Kategori ini memiliki transaksi, sehingga telah diarsipkan (soft delete).';

        return redirect()->route('admin.trash_price.index')->with('success', $message);
    }

    public function archive($id)
    {
        $this->priceService->deleteOrArchivePrice($id, false);

        return redirect()->route('admin.trash_price.index')->with('success', 'Harga sampah berhasil diarsipkan.');
    }

    public function restore($id)
    {
        $this->priceService->restorePrice($id);

        return redirect()->route('admin.trash_price.index')->with('success', 'Harga sampah berhasil dikembalikan dari arsip.');
    }

    public function duplicate($id)
    {
        $this->priceService->duplicatePrice($id, Auth::user());

        return redirect()->route('admin.trash_price.index')->with('success', 'Data harga berhasil digandakan.');
    }

    public function history(Request $request)
    {
        $query = PriceHistory::with(['trashCategory', 'admin'])->orderBy('created_at', 'desc');

        if ($request->filled('kategori_id')) {
            $query->where('trash_category_id', $request->kategori_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $histories = $query->paginate(15);
        $categories = TrashCategory::all();

        return view('admin.trash-price.history', compact('histories', 'categories'));
    }

    // ==========================================
    // NASABAH / PUBLIC ACTIONS
    // ==========================================

    public function publicIndex(Request $request)
    {
        $user = Auth::user();
        $userLat = $request->filled('lat') ? (float)$request->lat : -6.200000;
        $userLng = $request->filled('lng') ? (float)$request->lng : 106.816666;
        $radiusKm = $request->filled('radius') ? (float)$request->radius : 5.0;

        // Determine target Bank Sampah (default to user's followed unit or requested unit)
        $selectedBsId = $request->filled('bank_sampah_id') 
            ? $request->bank_sampah_id 
            : ($user?->bank_sampah_id ?: \App\Models\BankSampah::active()->first()?->id);

        $selectedBankSampah = \App\Models\BankSampah::find($selectedBsId);

        // Fetch active Bank Sampahs within dynamic radius
        $allActiveBankSampahs = \App\Models\BankSampah::active()->get();
        $nearbyBankSampahs = $allActiveBankSampahs->filter(function ($bs) use ($userLat, $userLng, $radiusKm) {
            if ($radiusKm >= 999) return true; // 'semua' filter
            $dist = $bs->calculateDistance($userLat, $userLng);
            return $dist <= $radiusKm || $dist == 0;
        })->values();

        $filters = $request->only(['search', 'kategori']);
        $filters['is_archived'] = 'false';
        $filters['bank_sampah_id'] = $selectedBsId;

        $prices = $this->priceService->getFilteredPrices($filters, 12);
        $favorites = $user ? $user->priceFavorites()->pluck('trash_category_id')->toArray() : [];

        return view('nasabah.prices.index', compact(
            'prices', 'filters', 'favorites', 'selectedBankSampah',
            'nearbyBankSampahs', 'radiusKm', 'selectedBsId'
        ));
    }

    public function publicShow($id)
    {
        $category = TrashCategory::active()->findOrFail($id);

        // Data for chart
        $histories = PriceHistory::where('trash_category_id', $id)
            ->orderBy('created_at', 'asc')
            ->take(30)
            ->get();

        $user = Auth::user();
        $isFavorite = $user ? $user->priceFavorites()->where('trash_category_id', $id)->exists() : false;

        return view('nasabah.prices.show', compact('category', 'histories', 'isFavorite'));
    }

    public function toggleFavorite($id)
    {
        $user = Auth::user();
        $exists = $user->priceFavorites()->where('trash_category_id', $id)->exists();

        if ($exists) {
            $user->priceFavorites()->where('trash_category_id', $id)->delete();

            return response()->json(['status' => 'removed', 'message' => 'Dihapus dari favorit']);
        } else {
            $user->priceFavorites()->create(['trash_category_id' => $id]);

            return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke favorit']);
        }
    }

    public function favorites()
    {
        $user = Auth::user();
        $favorites = $user->priceFavorites()->with('trashCategory')->get();

        return view('nasabah.prices.favorites', compact('favorites'));
    }
}
