<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/edukasi', [ArticleController::class, 'publicIndex'])->name('edukasi.index');
Route::get('/edukasi/{slug}', [ArticleController::class, 'publicShow'])->name('edukasi.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('petugas')) {
        return redirect()->route('petugas.dashboard');
    } elseif ($user->hasRole('nasabah')) {
        return redirect()->route('nasabah.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:nasabah'])->prefix('nasabah')->name('nasabah.')->group(function () {
    Route::get('/dashboard', [NasabahController::class, 'dashboard'])->name('dashboard');
    Route::get('/jemput-sampah', [NasabahController::class, 'showPickupForm'])->name('pickup.form');
    Route::post('/jemput-sampah', [NasabahController::class, 'storePickup'])->name('pickup.store');
    Route::get('/dompet', [NasabahController::class, 'wallet'])->name('wallet');
    Route::post('/withdrawal', [NasabahController::class, 'requestWithdrawal'])->name('withdrawal.request');
    Route::get('/edukasi', [ArticleController::class, 'nasabahIndex'])->name('edukasi');
    Route::get('/prices', [\App\Http\Controllers\TrashPriceController::class, 'publicIndex'])->name('prices.index');
    Route::get('/prices/favorites', [\App\Http\Controllers\TrashPriceController::class, 'favorites'])->name('prices.favorites');
    Route::get('/prices/{id}', [\App\Http\Controllers\TrashPriceController::class, 'publicShow'])->name('prices.show');
    Route::post('/prices/{id}/favorite', [\App\Http\Controllers\TrashPriceController::class, 'toggleFavorite'])->name('prices.favorite');
    Route::get('/sertifikat', [NasabahController::class, 'certificate'])->name('certificate');
    Route::post('/transaksi/{id}/rating', [NasabahController::class, 'submitRating'])->name('transaction.rating');
});

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard-manifes', [PetugasController::class, 'dashboardManifes'])->name('dashboard');
    Route::get('/input-timbangan/{user_id}', [PetugasController::class, 'showWeighingForm'])->name('weighing.form');
    Route::post('/input-timbangan', [PetugasController::class, 'storeWeighing'])->name('weighing.store');
    Route::get('/setor-mandiri', [PetugasController::class, 'showSelfDepositForm'])->name('self_deposit.form');
    Route::post('/setor-mandiri', [PetugasController::class, 'storeSelfDeposit'])->name('self_deposit.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Modul Harga Sampah (Admin)
    Route::prefix('trash-price')->name('trash_price.')->group(function () {
        Route::get('/', [\App\Http\Controllers\TrashPriceController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\TrashPriceController::class, 'store'])->name('store');
        Route::get('/history', [\App\Http\Controllers\TrashPriceController::class, 'history'])->name('history');
        Route::get('/{id}', [\App\Http\Controllers\TrashPriceController::class, 'show'])->name('show');
        Route::put('/{id}', [\App\Http\Controllers\TrashPriceController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\TrashPriceController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/archive', [\App\Http\Controllers\TrashPriceController::class, 'archive'])->name('archive');
        Route::post('/{id}/restore', [\App\Http\Controllers\TrashPriceController::class, 'restore'])->name('restore');
        Route::post('/{id}/duplicate', [\App\Http\Controllers\TrashPriceController::class, 'duplicate'])->name('duplicate');
    });
    Route::get('/validasi-keuangan', [AdminController::class, 'validateFinance'])->name('finance.validate');
    Route::post('/validasi-keuangan/{id}', [AdminController::class, 'approveWithdrawal'])->name('finance.approve');
    Route::post('/validasi-keuangan/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('finance.reject');
    Route::get('/konfigurasi-wilayah', [AdminController::class, 'configureRegion'])->name('region.configure');
    Route::get('/laporan', [AdminController::class, 'reports'])->name('reports');
    Route::get('/laporan/export', [AdminController::class, 'exportReports'])->name('reports.export');
    Route::get('/articles', [ArticleController::class, 'adminIndex'])->name('articles.index');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

require __DIR__.'/auth.php';
