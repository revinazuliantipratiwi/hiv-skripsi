<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PetaControlleruser;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HivController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Ini adalah file route utama aplikasi Anda.
*/

/** 🌐 Halaman Utama (Untuk Pengguna Umum) **/
Route::get('/', fn() => view('index'))->name('index');

Route::get('/peta', [PetaControlleruser::class, 'index'])->name('peta');
Route::view('/informasi', 'informasi')->name('informasi');
Route::view('/panduan', 'panduan')->name('panduan');
Route::view('/faqs', 'faqs')->name('faqs');
Route::view('/kontak', 'kontak')->name('kontak');

/** 🔐 Login & Auth **/
Auth::routes();

/** 🔒 Dashboard & Admin (Login Diperlukan) **/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard utama user/admin
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    /** 🛠️ CRUD Data Kasus HIV **/
    Route::prefix('hiv')->group(function () {
        Route::get('/', [HivController::class, 'index'])->name('hiv');
        Route::get('/create', [HivController::class, 'create'])->name('create');
        Route::post('/', [HivController::class, 'store'])->name('store');
        Route::get('/{hiv}/edit', [HivController::class, 'edit'])->name('edit');
        Route::put('/{hiv}', [HivController::class, 'update'])->name('update');
        Route::delete('/{hiv}', [HivController::class, 'destroy'])->name('destroy');
        Route::get('/map', [HivController::class, 'map'])->name('map'); // 🌍 Peta Data HIV
    });

    /** 🏥 CRUD dan Map Rumah Sakit **/
    Route::prefix('rumahsakit')->group(function () {
        Route::get('/', [RumahSakitController::class, 'index'])->name('rumahsakit');
        Route::get('/create', [RumahSakitController::class, 'create'])->name('rumahsakitcreate');
        Route::post('/', [RumahSakitController::class, 'store'])->name('rumahsakitstore');
        Route::get('/{id}/edit', [RumahSakitController::class, 'edit'])->name('rumahsakitedit');
        Route::put('/{id}', [RumahSakitController::class, 'update'])->name('rumahsakitupdate');
        Route::delete('/{id}', [RumahSakitController::class, 'destroy'])->name('rumahsakitdestroy');
        Route::get('/map', [RumahSakitController::class, 'map'])->name('rumahsakit.map');
    });

    /** 📊 Rekapitulasi (Controller) **/
    Route::get('/rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekapitulasi');

    // Tambahkan jika kamu punya export PDF/Excel
    Route::get('/rekap/export', [RekapitulasiController::class, 'export'])->name('rekap.export');
});
