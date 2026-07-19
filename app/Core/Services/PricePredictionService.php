<?php

namespace App\Core\Services;

use App\Models\PriceHistory;
use App\Models\TrashCategory;

class PricePredictionService
{
    /**
     * Predict future prices using Simple Moving Average (SMA).
     */
    public function predictPrice(int $categoryId, int $daysAhead = 1): array
    {
        $category = TrashCategory::find($categoryId);
        if (! $category) {
            return ['status' => 'error', 'message' => 'Kategori tidak ditemukan.'];
        }

        // Get last 30 days of history
        $histories = PriceHistory::where('trash_category_id', $categoryId)
            ->orderBy('created_at', 'desc')
            ->take(30)
            ->get();

        if ($histories->count() < 7) {
            // Not enough data for meaningful prediction
            return [
                'status' => 'success',
                'current_price' => $category->harga_per_kg,
                'predicted_price' => $category->harga_per_kg,
                'confidence' => 'Rendah',
                'trend' => 'stabil',
                'message' => 'Data historis belum cukup untuk prediksi akurat.',
            ];
        }

        // Simple algorithm: weighted moving average where recent prices have more weight
        $prices = $histories->pluck('harga_baru')->toArray();
        $prices = array_reverse($prices); // chronological order

        $totalWeight = 0;
        $weightedSum = 0;

        foreach ($prices as $index => $price) {
            $weight = $index + 1; // 1 to N
            $totalWeight += $weight;
            $weightedSum += ($price * $weight);
        }

        $predictedPrice = $weightedSum / $totalWeight;

        // Adjust based on current trend (momentum)
        $recentTrend = $prices[count($prices) - 1] - $prices[count($prices) - 4]; // change over last 3 updates
        $momentumAdjusted = $predictedPrice + ($recentTrend * 0.5 * $daysAhead);

        // Ensure price is not negative and reasonable
        $momentumAdjusted = max($category->harga_per_kg * 0.5, $momentumAdjusted);
        $momentumAdjusted = round($momentumAdjusted / 100) * 100; // Round to nearest 100

        $confidence = $this->getConfidenceLevel($prices);
        $trend = $momentumAdjusted > $category->harga_per_kg ? 'naik' : ($momentumAdjusted < $category->harga_per_kg ? 'turun' : 'stabil');

        return [
            'status' => 'success',
            'current_price' => $category->harga_per_kg,
            'predicted_price' => $momentumAdjusted,
            'confidence' => $confidence,
            'trend' => $trend,
            'days_ahead' => $daysAhead,
            'message' => 'Prediksi berhasil dibuat berdasarkan data historis.',
        ];
    }

    /**
     * Get prediction confidence based on price volatility.
     */
    private function getConfidenceLevel(array $prices): string
    {
        if (count($prices) < 10) {
            return 'Rendah';
        }

        // Calculate standard deviation (volatility)
        $mean = array_sum($prices) / count($prices);

        $carry = 0.0;
        foreach ($prices as $val) {
            $d = ((float) $val) - $mean;
            $carry += $d * $d;
        }

        $variance = $carry / count($prices);
        $stdDev = sqrt($variance);

        $volatilityPercent = ($stdDev / $mean) * 100;

        if ($volatilityPercent < 5) {
            return 'Tinggi';
        }
        if ($volatilityPercent < 15) {
            return 'Sedang';
        }

        return 'Rendah';
    }

    /**
     * Get trend analysis for a category.
     */
    public function getTrendAnalysis(int $categoryId): array
    {
        $histories = PriceHistory::where('trash_category_id', $categoryId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        if ($histories->isEmpty()) {
            return ['trend' => 'stabil', 'volatility' => 'rendah'];
        }

        $first = $histories->last()->harga_baru; // Oldest of the 10
        $last = $histories->first()->harga_baru; // Newest

        $trend = 'stabil';
        if ($last > $first * 1.05) {
            $trend = 'naik';
        }
        if ($last < $first * 0.95) {
            $trend = 'turun';
        }

        return [
            'trend' => $trend,
            'change_amount' => abs($last - $first),
            'change_percent' => $first > 0 ? abs(($last - $first) / $first) * 100 : 0,
        ];
    }
}
