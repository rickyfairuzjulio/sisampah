<?php

namespace App\Providers;

use App\Core\Services\PriceNotificationService;
use App\Core\Services\PricePredictionService;
use App\Core\Services\TrashPriceService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PriceNotificationService::class);
        $this->app->singleton(PricePredictionService::class);
        $this->app->singleton(TrashPriceService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        RateLimiter::for('chatbot', function (Request $request) {
            return Limit::perMinutes(5, 10)->by($request->user()?->id ?: $request->ip())->response(function (Request $request, array $headers) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sepertinya anda bertanya terlalu cepat. Mari beristirahat sejenak, silahkan coba lagi dalam 10 menit',
                ], 429, $headers);
            });
        });
    }
}
