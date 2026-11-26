<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\Admin\ServiceRequestController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// ============================================================
// Health Check Endpoint (untuk Docker & monitoring)
// ============================================================
Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status'   => 'ok',
            'database' => 'connected',
            'app'      => config('app.name'),
            'env'      => config('app.env'),
            'timestamp'=> now()->toISOString(),
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status'   => 'error',
            'database' => 'disconnected',
            'message'  => $e->getMessage(),
            'timestamp'=> now()->toISOString(),
        ], 500);
    }
})->name('health');

// ============================================================
// Halaman Publik
// ============================================================
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/profil-desa', [PublicController::class, 'profile'])->name('profile');

// Berita
Route::get('/berita', [PublicController::class, 'newsList'])->name('news.index');
Route::get('/berita/{slug}', [PublicController::class, 'newsShow'])->name('news.show');

// Agenda
Route::get('/agenda', [PublicController::class, 'eventsList'])->name('events.index');

// Layanan
Route::get('/layanan', [PublicController::class, 'servicesList'])->name('services.index');
Route::post('/layanan/ajukan', [PublicController::class, 'serviceSubmit'])->name('services.submit');
Route::get('/layanan/cek-status', [PublicController::class, 'serviceTrack'])->name('services.track');

// ============================================================
// Autentikasi
// ============================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================
// Halaman Admin (dilindungi middleware)
// ============================================================
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profil & Statistik Desa
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/perangkat', [ProfileController::class, 'storeOfficial'])->name('profile.official.store');
    Route::delete('/profil/perangkat/{official}', [ProfileController::class, 'destroyOfficial'])->name('profile.official.destroy');

    // Manajemen Berita
    Route::resource('news', NewsController::class)->except(['show']);

    // Manajemen Agenda Kegiatan
    Route::resource('events', EventController::class)->except(['show']);

    // Manajemen Jenis Layanan
    Route::resource('service-types', ServiceTypeController::class)->except(['show']);

    // Manajemen Pengajuan Warga
    Route::get('/service-requests', [ServiceRequestController::class, 'index'])->name('service-requests.index');
    Route::get('/service-requests/{serviceRequest}', [ServiceRequestController::class, 'show'])->name('service-requests.show');
    Route::put('/service-requests/{serviceRequest}', [ServiceRequestController::class, 'update'])->name('service-requests.update');
    Route::delete('/service-requests/{serviceRequest}', [ServiceRequestController::class, 'destroy'])->name('service-requests.destroy');
});
