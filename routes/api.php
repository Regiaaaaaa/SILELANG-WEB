<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BarangLelangController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PenawaranController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// PUBLIC ROUTES (tidak perlu auth)
Route::group(['prefix' => 'public'], function () {
    // Get penawaran untuk barang tertentu (untuk user yang belum login)
    Route::get('/penawaran/{barangLelangId}', [PenawaranController::class, 'getPublicBids']);

    // Get penawaran tertinggi untuk barang tertentu
    Route::get('/penawaran/{barangLelangId}/highest', [PenawaranController::class, 'getHighestBid']);

    // Get history penawaran untuk barang tertentu (real-time)
    Route::get('/penawaran/{barangLelangId}/history', [PenawaranController::class, 'getBidHistory']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'adminLogin']); 

// USER AUTH (untuk mobile)
Route::prefix('user')->group(function () {
    Route::post('/register', [AuthController::class, 'userRegister']);
    Route::post('/login', [AuthController::class, 'userLogin']);
});

// USER - hanya role 'user'
Route::prefix('user')->middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::post('/barang-lelang', [BarangLelangController::class, 'userStore']);
    Route::put('/barang-lelang/{id}', [BarangLelangController::class, 'userUpdate']);
    Route::delete('/barang-lelang/{id}', [BarangLelangController::class, 'userDestroy']);
    // Penawaran User
    Route::post('/penawaran', [PenawaranController::class, 'userStore']);
    // Lihat penawaran user sendiri
    Route::get('/penawaran', [PenawaranController::class, 'userIndex']);
    // Lihat barang-barang yang pernah user bid (dashboard user)
    Route::get('/penawaran/my-bidded-items', [PenawaranController::class, 'getUserBiddedItems']);

    // Lihat semua penawaran pada barang yang user sudah bid
    Route::get('/penawaran/{id}/all-bids', [PenawaranController::class, 'getUserBidsOnItem']);
});

// ADMIN - hanya role 'admin'
Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/barang-lelang', [BarangLelangController::class, 'adminStore']);
    Route::put('/barang-lelang/{id}', [BarangLelangController::class, 'adminUpdate']);
    Route::delete('/barang-lelang/{id}', [BarangLelangController::class, 'adminDestroy']);
    
    // TAMBAHAN: Get detail barang untuk admin (untuk modal detail)
    Route::get('/barang-lelang/{id}', [BarangLelangController::class, 'show']);

    // Get semua penawaran (dengan filter & search)
    Route::get('/penawaran', [PenawaranController::class, 'getAllBids']);

    // Get penawaran untuk barang tertentu (detail admin)
    Route::get('/penawaran/{id}', [PenawaranController::class, 'adminIndex']);

    // Get statistik penawaran (untuk dashboard)
    Route::get('/penawaran/statistics/summary', [PenawaranController::class, 'getBidStatistics']);
    
    // Tambahan untuk verifikasi
    Route::post('/barang-lelang/{id}/verifikasi', [BarangLelangController::class, 'verify']);
    Route::post('/barang-lelang/{id}/tolak', [BarangLelangController::class, 'reject']);
});

// Get penawaran tertinggi untuk barang tertentu
Route::get('/penawaran/{id}/highest', [PenawaranController::class, 'getHighestBid']);

// Get history penawaran untuk barang tertentu
Route::get('/penawaran/{id}/history', [PenawaranController::class, 'getBidHistory']);

// UMUM
Route::get('/barang-lelang', [BarangLelangController::class, 'index']);
Route::get('/barang-lelang/{id}', [BarangLelangController::class, 'show']);