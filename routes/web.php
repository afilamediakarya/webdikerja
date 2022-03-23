<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\SkpController;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\SatkerController;
/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class, 'index']);
Route::get('/login', [AuthController::class, 'index']);

// skp
Route::get('/skp', [SkpController::class, 'index'])->name('skp');
Route::get('/skp/tambah', [SkpController::class, 'create'])->name('tambah-skp');


Route::prefix('realisasi')->group(function () {
    Route::get('/', [RealisasiController::class, 'index'])->name('realisasi');
    Route::get('/tambah', [RealisasiController::class, 'create'])->name('tambah-realisasi');
});

Route::prefix('laporan')->group(function () {
    Route::get('/absen', [LaporanController::class, 'absen'])->name('laporan-absen');
    Route::get('/skp', [LaporanController::class, 'skp'])->name('laporan-skp');
    Route::get('/aktivitas', [LaporanController::class, 'aktivitas'])->name('laporan-aktivitas');
    
});


Route::get('/penilaian/{type}', [PenilaianController::class, 'index'])->name('penilaian');
Route::get('/penilaian/{type}/{id}', [PenilaianController::class, 'create'])->name('tambah-penilaian');

Route::get('/aktivitas', [AktivitasController::class, 'index']);


Route::prefix('akun')->group(function () {

    Route::get('/', [AkunController::class, 'index'])->name('akun');
    Route::get('/edit', [AkunController::class, 'edit'])->name('edit-profil');
    Route::get('/ganti-password', [AkunController::class, 'index'])->name('ganti-password');
});

Route::prefix('admin')->group(function() {
    Route::prefix('pegawai')->group(function(){
        Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
        Route::get('/tambah', [PegawaiController::class, 'add'])->name('tambah-pegawai');
    });

    Route::prefix('informasi')->group(function(){
        Route::get('/', [InformasiController::class, 'index'])->name('informasi');

    });

    Route::prefix('jadwal')->group(function(){
        Route::get('/', [JadwalController::class, 'index'])->name('jadwal');
    });

    Route::prefix('satker')->group(function(){
        Route::get('/', [SatkerController::class, 'index'])->name('satker');
    });

    Route::prefix('jabatan')->group(function(){
        Route::get('/', [JabatanController::class, 'index'])->name('jabatan');
        Route::get('/kelas-jabatan', [JabatanController::class, 'kelas'])->name('kelas-jabatan');
    });

    Route::prefix('master')->group(function(){
        Route::get('/faq', [MasterController::class, 'faq'])->name('faq');
        Route::get('/satuan', [MasterController::class, 'satuan'])->name('master-satuan');
        Route::get('/perilaku', [MasterController::class, 'perilaku'])->name('master-perilaku');
    });

    Route::prefix('admin')->group(function(){
        Route::get('/', [AdminController::class, 'index'])->name('admin');
    });
});






// Demo routes
Route::get('/datatables', [PagesController::class, 'datatables']);
Route::get('/ktdatatables', [PagesController::class, 'ktDatatables']);
Route::get('/select2', [PagesController::class, 'select2']);
Route::get('/jquerymask', [PagesController::class, 'jQueryMask']);
Route::get('/icons/custom-icons', [PagesController::class, 'customIcons']);
Route::get('/icons/flaticon', [PagesController::class, 'flaticon']);
Route::get('/icons/fontawesome', [PagesController::class, 'fontawesome']);
Route::get('/icons/lineawesome', [PagesController::class, 'lineawesome']);
Route::get('/icons/socicons', [PagesController::class, 'socicons']);
Route::get('/icons/svg', [PagesController::class, 'svg']);

// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', [PagesController::class, 'quickSearch'])->name('quick-search');