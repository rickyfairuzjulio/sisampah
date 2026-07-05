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
    Route::get('/harga-sampah', [AdminController::class, 'indexTrashPrice'])->name('trash_price.index');
    Route::post('/harga-sampah', [AdminController::class, 'storeTrashPrice'])->name('trash_price.store');
    Route::put('/harga-sampah/{id}', [AdminController::class, 'updateTrashPrice'])->name('trash_price.update');
    Route::delete('/harga-sampah/{id}', [AdminController::class, 'destroyTrashPrice'])->name('trash_price.destroy');
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
