<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangLelangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengajuanUserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PantauLelangController;


Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/barang', [BarangLelangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangLelangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangLelangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangLelangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangLelangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangLelangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/pengajuan-user', [PengajuanUserController::class, 'index']) ->name('pending.index');
    Route::get('/pengajuan-aktif', [PengajuanUserController::class, 'aktif'])->name('pengajuan.aktif');
    Route::get('/pengajuan-selesai', [PengajuanUserController::class, 'selesai'])->name('pengajuan.selesai');


    Route::get('/pantau-lelang', [PantauLelangController::class, 'index'])->name('pantau.lelang.index');
    Route::get('/pantau-lelang/{id}', [PantauLelangController::class, 'show'])->name('pantau.show');





    Route::resource('kategori', KategoriController::class);
});




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
