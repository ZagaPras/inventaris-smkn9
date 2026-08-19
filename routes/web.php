<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {

    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/isi-data-diri', [AuthController::class, 'showDataDiriForm'])->name('data_diri.form');
    Route::post('/submit-data-diri', [AuthController::class, 'submitDataDiri'])->name('data_diri.submit');
    Route::get('/submit-data-diri', function () {
        return redirect()->route('data_diri.form');
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/ruangan', [RuanganController::class, 'index']);
        Route::post('/admin/ruangan/store', [RuanganController::class, 'store']);
        Route::get('/admin/ruangan/edit/{id}', [RuanganController::class, 'edit']);
        Route::post('/admin/ruangan/update/{id}', [RuanganController::class, 'update']);
        Route::get('/admin/ruangan/hapus/{id}', [RuanganController::class, 'hapus']);
        Route::get('/admin/ruangan/detail/{id}', [RuanganController::class, 'detail']);
        Route::post('/admin/ruangan/{id}/tambah-barang', [RuanganController::class, 'tambahBarang']);
        Route::get('/admin/ruangan/detail/{id}/cetak', [RuanganController::class, 'cetakPDF'])->name('admin.ruangan.cetak');

        Route::get('/admin/barang', [BarangController::class, 'index']);
        Route::post('/admin/barang/tambah', [BarangController::class, 'store']);
        Route::get('/admin/barang/edit/{id}', [BarangController::class, 'edit']);
        Route::post('/admin/barang/update/{id}', [BarangController::class, 'update']);
        Route::get('/admin/barang/hapus/{id}', [BarangController::class, 'destroy']);
        Route::post('/admin/barang/hapus/{id}', [BarangController::class, 'destroy']);
        Route::delete('/admin/barang/hapus/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
        Route::post('/admin/barang/import', [BarangController::class, 'importExcel']);
        Route::get('/admin/barang/cetak-pdf', [BarangController::class, 'cetakPdf'])->name('barang.cetakPdf');
        
        Route::get('/admin/laporan/cetak-semua', [RuanganController::class, 'cetakSemuaLaporan'])->name('laporan.cetak_semua');
    });

    Route::get('/lapor-keluhan', [KeluhanController::class, 'formKeluhan']);
    Route::get('/get-barangs/{ruangan_id}', [KeluhanController::class, 'getBarangsByRuangan']);
    Route::post('/lapor-keluhan', [KeluhanController::class, 'submitKeluhan']); 
    
    Route::get('/riwayat-keluhan', [KeluhanController::class, 'riwayatKeluhan'])->name('keluhan.riwayat');

    Route::get('/admin/keluhan', [KeluhanController::class, 'halamanKeluhan'])->name('admin.keluhan');
    Route::post('/admin/keluhan/update-status/{id}', [KeluhanController::class, 'updateStatusKeluhan']);
    Route::delete('/admin/keluhan/{id}', [KeluhanController::class, 'destroy']);

    Route::get('/user/ruangan', [RuanganController::class, 'userRuangan'])->name('user.ruangan');
    Route::get('/user/ruangan/detail/{id}', [RuanganController::class, 'userDetail'])->name('user.ruangan.detail');
    Route::get('/user/barang', [BarangController::class, 'userBarang'])->name('user.barang');
});