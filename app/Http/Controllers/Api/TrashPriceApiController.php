<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\Services\TrashPriceService;
use App\Core\Services\PricePredictionService;
use App\Http\Requests\StoreTrashPriceRequest;
use App\Http\Requests\UpdateTrashPriceRequest;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashPriceApiController extends Controller
{
    protected TrashPriceService $priceService;
    protected PricePredictionService $predictionService;

    public function __construct(TrashPriceService $priceService, PricePredictionService $predictionService)
    {
        $this->priceService = $priceService;
        $this->predictionService = $predictionService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'status_harga', 'kualitas', 'min_price', 'max_price', 'sort', 'is_archived']);
        $perPage = $request->input('per_page', 15);
        
        $prices = $this->priceService->getFilteredPrices($filters, $perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $prices
        ]);
    }

    public function show($id)
    {
        $category = TrashCategory::with('priceHistories')->findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    public function store(StoreTrashPriceRequest $request)
    {
        $category = $this->priceService->createPrice($request->validated(), Auth::user());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Harga berhasil dibuat',
            'data' => $category
        ], 201);
    }

    public function update(UpdateTrashPriceRequest $request, $id)
    {
        $category = $this->priceService->updatePrice(
            $id, 
            $request->validated(), 
            Auth::user(), 
            $request->input('alasan')
        );
        
        return response()->json([
            'status' => 'success',
            'message' => 'Harga berhasil diperbarui',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $deleted = $this->priceService->deleteOrArchivePrice($id);
        
        return response()->json([
            'status' => 'success',
            'message' => $deleted ? 'Dihapus sepenuhnya' : 'Diarsipkan karena memiliki transaksi'
        ]);
    }

    public function history(Request $request)
    {
        $categoryId = $request->input('category_id');
        $query = \App\Models\PriceHistory::with('admin')->orderBy('created_at', 'desc');
        
        if ($categoryId) {
            $query->where('trash_category_id', $categoryId);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $query->paginate(20)
        ]);
    }

    public function statistics()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->priceService->getStatistics()
        ]);
    }

    public function trend($id)
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->predictionService->getTrendAnalysis($id)
        ]);
    }

    public function prediction(Request $request, $id)
    {
        $days = $request->input('days_ahead', 7);
        return response()->json(
            $this->predictionService->predictPrice($id, $days)
        );
    }
}
