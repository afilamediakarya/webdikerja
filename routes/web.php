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
use App\Http\Controllers\AxiosController;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\SatkerController;
use App\Http\Controllers\Admin\Master\FaqController;
use App\Http\Controllers\Admin\Master\SatuanController;
use App\Http\Controllers\Admin\Master\PerilakuController;
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

Route::post('/login', [AuthController::class, 'setLogin'])->name('do-Login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::middleware('Auth')->group(function(){

    Route::get('/', [PagesController::class, 'index'])->name('dashboard');

    Route::middleware('roles:pegawai|admin_opd|super_admin')->group(function(){
        Route::get('/skp', [SkpController::class, 'index'])->name('skp');
        Route::get('/skp/tambah', [SkpController::class, 'create'])->name('tambah-skp');
    });
    
    
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
    
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas');
    Route::get('/aktivitas/show', [AktivitasController::class, 'aktivitas'])->name('get-aktivitas');
    
    
    Route::prefix('akun')->group(function () {
    
        Route::get('/', [AkunController::class, 'index'])->name('akun');
        Route::get('/edit', [AkunController::class, 'edit'])->name('edit-profil');
        Route::get('/ganti-password', [AkunController::class, 'index'])->name('ganti-password');
    });
    Route::middleware('roles:super_admin|admin_opd')->group(function (){
        Route::prefix('admin')->group(function() {
            // oke
            Route::prefix('pegawai')->group(function(){
                Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
                Route::post('/', [PegawaiController::class, 'store'])->name('store-pegawai');
                Route::get('/{id}', [PegawaiController::class, 'show'])->name('show-pegawai');
                Route::post('/{id}', [PegawaiController::class, 'update'])->name('update-pegawai');
                Route::delete('/{id}', [PegawaiController::class, 'delete'])->name('delete-pegawai');
            });
    
            Route::prefix('informasi')->group(function(){
                Route::get('/', [InformasiController::class, 'index'])->name('informasi');
                Route::post('/', [InformasiController::class, 'store'])->name('post-informasi');
                Route::get('/{id}', [InformasiController::class, 'show'])->name('show-informasi');
                Route::post('/{id}', [InformasiController::class, 'update'])->name('update-informasi');
                Route::delete('/{id}', [InformasiController::class, 'delete'])->name('delete-informasi');
            });
    
            
            Route::middleware('roles:super_admin')->group(function(){
                Route::prefix('jadwal')->group(function(){
                    Route::get('/', [JadwalController::class, 'index'])->name('jadwal');
                    Route::post('/', [JadwalController::class, 'store'])->name('post-jadwal');
                    Route::get('/{id}', [JadwalController::class, 'show'])->name('show-jadwal');
                    Route::post('/{id}', [JadwalController::class, 'update'])->name('update-jadwal');
                    Route::delete('/{id}', [JadwalController::class, 'delete'])->name('delete-jadwal');
                });
                Route::prefix('master')->group(function(){
                    // Route::get('/faq', [MasterController::class, 'faq'])->name('master_faq');
                    Route::get('/faq', [FaqController::class, 'faq'])->name('faq');
                    Route::post('/faq', [FaqController::class, 'store_faq'])->name('post-faq');
                    Route::get('/faq/{id}', [FaqController::class, 'show_faq'])->name('show-faq');
                    Route::post('/faq/{id}', [FaqController::class, 'update_faq'])->name('update-faq');
                    Route::delete('/faq/{id}', [FaqController::class, 'delete_faq'])->name('delete-faq');
        
                    Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan');
                    Route::post('/satuan', [SatuanController::class, 'store'])->name('post-satuan');
                    Route::get('/satuan/{id}', [SatuanController::class, 'show'])->name('show-satuan');
                    Route::post('/satuan/{id}', [SatuanController::class, 'update'])->name('update-satuan');
                    Route::delete('/satuan/{id}', [SatuanController::class, 'delete'])->name('delete-satuan');
                    
                    Route::get('/data-satuan', [MasterController::class, 'get_satuan'])->name('data_master_satuan');
                    
                    Route::get('/perilaku', [MasterController::class, 'perilaku'])->name('master_perilaku');
                });
        
            });

            Route::middleware('roles:admin_opd')->group(function(){
                Route::prefix('kegiatan')->group(function(){
                    Route::get('/', [KegiatanController::class, 'index'])->name('kegiatan');
                    Route::post('/', [KegiatanController::class, 'store'])->name('post-kegiatan');
                    Route::get('/{id}', [KegiatanController::class, 'show'])->name('show-kegiatan');
                    Route::post('/{id}', [KegiatanController::class, 'update'])->name('update-kegiatan');
                    Route::delete('/{id}', [KegiatanController::class, 'delete'])->name('delete-kegiatan');
                });
            });
    
            
            Route::prefix('jabatan')->group(function(){
                Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
                Route::post('/jabatan', [JabatanController::class, 'store'])->name('post-jabatan');
                Route::get('/jabatan/{id}', [JabatanController::class, 'show'])->name('show-jabatan');
                Route::post('/jabatan/{id}', [JabatanController::class, 'update'])->name('update-jabatan');
                Route::delete('/jabatan/{id}', [JabatanController::class, 'delete'])->name('delete-jabatan');    
                Route::get('/kelas', [JabatanController::class, 'kelas'])->name('kelas')->middleware('roles:super_admin');
                Route::post('/kelas', [JabatanController::class, 'store_kelas'])->name('post-kelas');
                Route::get('/kelas/{id}', [JabatanController::class, 'show_kelas'])->name('show-kelas');
                Route::post('/kelas/{id}', [JabatanController::class, 'update_kelas'])->name('update-kelas');
                Route::delete('/kelas/{id}', [JabatanController::class, 'delete_kelas'])->name('delete-kelas');
    
            });
    
        
            Route::prefix('satker')->group(function(){
                Route::get('/', [SatkerController::class, 'index'])->name('satker');
                Route::post('/', [SatkerController::class, 'store'])->name('post-satker');
                Route::get('/{id}', [SatkerController::class, 'show'])->name('show-satker');
                Route::post('/{id}', [SatkerController::class, 'update'])->name('update-satker');
                Route::delete('/{id}', [SatkerController::class, 'delete'])->name('delete-satker');
            });
        
            
            
            
            Route::prefix('admin')->group(function(){
                Route::get('/', [AdminController::class, 'index'])->name('admin');
            });

            Route::prefix('axios')->group(function(){
                Route::get('/atasan-jabatan/{id}', [AxiosController::class, 'atasan_jabatan']);
                Route::get('/jabatan/{id}', [AxiosController::class, 'jabatan']);
                Route::get('/atasan/{id}', [AxiosController::class, 'getAtasan']);

            });
        });
    });
});







// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', [PagesController::class, 'quickSearch'])->name('quick-search');