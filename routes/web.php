<?php

use App\Http\Controllers\Admin\BankSampahController;
use App\Http\Controllers\Admin\BankSampahVerificationController;
use App\Http\Controllers\Admin\PelanggaranController;
use App\Http\Controllers\Admin\PetugasResignController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BankSampahRegistrationController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashPriceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/chat', [ChatbotController::class, 'chat'])->middleware('throttle:30,1')->name('chat');
Route::post('/chat/vision', [ChatbotController::class, 'analyzeVision'])->middleware('throttle:15,1')->name('chat.vision');
Route::get('/scan-history', [ChatbotController::class, 'history'])->name('scan.history');
Route::delete('/scan-history/{id}', [ChatbotController::class, 'deleteHistory'])->name('scan.history.delete');
Route::get('/api/bank-sampah/nearest', [BankSampahController::class, 'nearestApi'])->name('api.bank_sampah.nearest');
Route::get('/edukasi', [ArticleController::class, 'publicIndex'])->name('edukasi.index');
Route::get('/edukasi/{slug}', [ArticleController::class, 'publicShow'])->name('edukasi.show');

// Public Bank Sampah Registration & Status Tracking Routes
Route::get('/daftar-bank-sampah', [BankSampahRegistrationController::class, 'showForm'])->name('pendaftaran_bank_sampah.index');
Route::post('/daftar-bank-sampah', [BankSampahRegistrationController::class, 'store'])->middleware('throttle:5,1')->name('pendaftaran_bank_sampah.store');
Route::get('/lacak-pendaftaran', [BankSampahRegistrationController::class, 'trackingForm'])->name('pendaftaran_bank_sampah.tracking');
Route::post('/lacak-pendaftaran/reupload', [BankSampahRegistrationController::class, 'reuploadDocument'])->middleware('throttle:5,1')->name('pendaftaran_bank_sampah.reupload');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('petugas')) {
        return redirect()->route('petugas.dashboard');
    } elseif ($user->hasRole('nasabah')) {
        return redirect()->route('nasabah.dashboard');
    }

    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/api/notifications', [\App\Http\Controllers\NotificationController::class, 'getNotifications'])->name('api.notifications');
    Route::post('/api/notifications/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('api.notifications.read');
});

Route::middleware(['auth', 'role:nasabah'])->prefix('nasabah')->name('nasabah.')->group(function () {
    Route::get('/dashboard', [NasabahController::class, 'dashboard'])->name('dashboard');
    Route::get('/jemput-sampah', [NasabahController::class, 'showPickupForm'])->name('pickup.form');
    Route::post('/jemput-sampah', [NasabahController::class, 'storePickup'])->middleware('throttle:10,1')->name('pickup.store');
    Route::get('/dompet', [NasabahController::class, 'wallet'])->name('wallet');
    Route::post('/withdrawal', [NasabahController::class, 'requestWithdrawal'])->middleware('throttle:10,1')->name('withdrawal.request');
    Route::post('/withdrawal/{id}/confirm', [NasabahController::class, 'confirmWithdrawalReceipt'])->name('withdrawal.confirm');
    Route::get('/edukasi', [ArticleController::class, 'nasabahIndex'])->name('edukasi');
    Route::get('/prices', [TrashPriceController::class, 'publicIndex'])->name('prices.index');
    Route::get('/prices/favorites', [TrashPriceController::class, 'favorites'])->name('prices.favorites');
    Route::get('/prices/{id}', [TrashPriceController::class, 'publicShow'])->name('prices.show');
    Route::post('/prices/{id}/favorite', [TrashPriceController::class, 'toggleFavorite'])->name('prices.favorite');
    Route::get('/sertifikat', [NasabahController::class, 'certificate'])->name('certificate');
    Route::post('/transaksi/{id}/rating', [NasabahController::class, 'submitRating'])->name('transaction.rating');
    
    // Top Up Routes
    Route::get('/topup', [NasabahController::class, 'showTopUpForm'])->name('topup.form');
    Route::post('/topup', [NasabahController::class, 'storeTopUp'])->middleware('throttle:10,1')->name('topup.store');
    Route::get('/topup/{id}/status', [NasabahController::class, 'checkTopUpStatus'])->name('topup.status');
});

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard-manifes', [PetugasController::class, 'dashboardManifes'])->name('dashboard');
    Route::get('/input-timbangan/{user_id}', [PetugasController::class, 'showWeighingForm'])->name('weighing.form');
    Route::post('/input-timbangan', [PetugasController::class, 'storeWeighing'])->name('weighing.store');
    Route::get('/setor-mandiri', [PetugasController::class, 'showSelfDepositForm'])->name('self_deposit.form');
    Route::post('/setor-mandiri', [PetugasController::class, 'storeSelfDeposit'])->name('self_deposit.store');
});

Route::middleware(['auth', 'role:admin|super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::post('/users/{id}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle_status');

    // Super Admin Bank Sampah Verification Pipeline
    Route::prefix('verifikasi-bank-sampah')->name('verifikasi_bank_sampah.')->group(function () {
        Route::get('/', [BankSampahVerificationController::class, 'index'])->name('index');
        Route::get('/{id}', [BankSampahVerificationController::class, 'show'])->name('show');
        Route::post('/{id}/review-doc/{docId}', [BankSampahVerificationController::class, 'reviewDocument'])->name('review_doc');
        Route::post('/{id}/schedule-meeting', [BankSampahVerificationController::class, 'scheduleMeeting'])->name('schedule_meeting');
        Route::post('/{id}/meeting-result', [BankSampahVerificationController::class, 'recordMeetingResult'])->name('meeting_result');
        Route::post('/{id}/approve', [BankSampahVerificationController::class, 'approveAndActivate'])->name('approve');
        Route::post('/{id}/reject', [BankSampahVerificationController::class, 'reject'])->name('reject');
    });

    // Master Bank Sampah & Peta Sebaran (Super Admin)
    Route::get('/peta-sebaran', [BankSampahController::class, 'sebaranMap'])->name('peta_sebaran');
    Route::prefix('master-bank-sampah')->name('master_bank_sampah.')->group(function () {
        Route::get('/', [BankSampahController::class, 'index'])->name('index');
        Route::get('/create', [BankSampahController::class, 'create'])->name('create');
        Route::post('/', [BankSampahController::class, 'store'])->name('store');
        Route::get('/{id}', [BankSampahController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BankSampahController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BankSampahController::class, 'update'])->name('update');
        Route::delete('/{id}', [BankSampahController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [BankSampahController::class, 'toggleStatus'])->name('toggle_status');
    });
    // Modul Harga Sampah (Admin)
    Route::prefix('trash-price')->name('trash_price.')->group(function () {
        Route::get('/', [TrashPriceController::class, 'index'])->name('index');
        Route::post('/', [TrashPriceController::class, 'store'])->name('store');
        Route::get('/history', [TrashPriceController::class, 'history'])->name('history');
        Route::get('/{id}', [TrashPriceController::class, 'show'])->name('show');
        Route::put('/{id}', [TrashPriceController::class, 'update'])->name('update');
        Route::delete('/{id}', [TrashPriceController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/archive', [TrashPriceController::class, 'archive'])->name('archive');
        Route::post('/{id}/restore', [TrashPriceController::class, 'restore'])->name('restore');
    });

    // Modul Catatan Pelanggaran & Audit Trail
    Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
        Route::get('/', [PelanggaranController::class, 'index'])->name('index');
    });

    Route::get('/validasi-keuangan', [AdminController::class, 'validateFinance'])->name('finance.validate');
    Route::post('/validasi-keuangan/topup-kas', [AdminController::class, 'topupKas'])->name('finance.topup_kas');
    Route::post('/validasi-keuangan/{id}', [AdminController::class, 'approveWithdrawal'])->name('finance.approve');
    Route::post('/validasi-keuangan/{id}/approve-gateway', [AdminController::class, 'approveWithdrawalWithGateway'])->name('finance.approve_gateway');
    Route::post('/validasi-keuangan/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('finance.reject');
    Route::get('/konfigurasi-wilayah', [AdminController::class, 'configureRegion'])->name('region.configure');
    Route::post('/konfigurasi-wilayah', [AdminController::class, 'updateSettings'])->name('region.update');
    Route::get('/laporan', [AdminController::class, 'reports'])->name('reports');
    Route::get('/laporan/export', [AdminController::class, 'exportReports'])->name('reports.export');
    Route::get('/articles', [ArticleController::class, 'adminIndex'])->name('articles.index');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::match(['PUT', 'POST'], '/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// Fallback route untuk menyajikan file dari storage/app/public jika symlink belum dibuat
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (! file_exists($filePath)) {
        abort(404);
    }

    $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';

    return response()->file($filePath, ['Content-Type' => $mimeType]);
})->where('path', '.*');

// Helper Route untuk Pembersihan Cache & Compiled Views
Route::get('/clear-app-cache', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    } catch (\Throwable $e) {}

    \Illuminate\Support\Facades\Cache::forget('nasabah_rt_list');
    \Illuminate\Support\Facades\Cache::forget('nasabah_rw_list');

    $files = glob(storage_path('framework/views/*.php'));
    if ($files) {
        foreach ($files as $file) {
            if (is_file($file)) @unlink($file);
        }
    }

    return redirect()->route('admin.region.configure')->with('success', 'Cache dan Tampilan Kompilasi berhasil dibersihkan!');
})->name('clear_app_cache');

// Automated Web Database Reset & Seeder Pipeline
Route::get('/setup-db-now', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        \App\Models\User::where('email', 'admin@sisampah.local')->delete();

        $usersCount = \App\Models\User::count();
        $adminCount = \App\Models\User::role('admin')->count();
        $superAdminCount = \App\Models\User::role('super_admin')->count();
        $bankCount = \App\Models\BankSampah::count();

        return response()->json([
            'status' => 'success',
            'message' => 'Database berhasil di-reset & di-seed otomatis!',
            'bank_sampah_terbuat' => $bankCount,
            'total_pengguna' => $usersCount,
            'admin_unit' => $adminCount,
            'super_admin' => $superAdminCount,
            'akun_siap_login' => [
                'Super Admin' => 'superadmin@sisampah.id (pass: password)',
                'Admin Melati' => 'admin@sisampah.id (pass: password)',
                'Admin Tampingan' => 'admin.tampingan@sisampah.id (pass: password)',
                'Admin Kenanga' => 'admin.kenanga@sisampah.id (pass: password)',
                'Admin Surabaya' => 'admin.surabaya@sisampah.id (pass: password)',
                'Admin Bali' => 'admin.bali@sisampah.id (pass: password)',
            ]
        ], 200, [], JSON_PRETTY_PRINT);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'error_message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500, [], JSON_PRETTY_PRINT);
    }
})->name('setup_db_now');

require __DIR__.'/auth.php';
