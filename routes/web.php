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
use App\Http\Controllers\bankomController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\lokasiController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\SatkerController;
use App\Http\Controllers\Admin\AbsenController;
use App\Http\Controllers\Admin\Master\FaqController;
use App\Http\Controllers\Admin\Master\SatuanController;
use App\Http\Controllers\Admin\Master\PerilakuController;
use App\Http\Controllers\Admin\Master\MasterController;

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
Route::get('/laporan/viewexport/rekapitulasi_pegawai/{params1}/{params2}/{params3}', [LaporanController::class, 'viewexportRekapAbsen'])->name('laporan-view-absen-pegawai');
Route::get('/maintanence', [AuthController::class, 'aborts'])->name('aborts');
Route::get('/', [AuthController::class, 'indexes'])->name('indexes');
Route::get('set-tahun-penganggaran', [Controller::class, 'setTahunAnggaran'])->name('set-tahun-penganggaran');

Route::middleware('Auth')->group(function(){

    Route::get('/dashboard/{type}', [PagesController::class, 'index'])->name('dashboard');
    
    // Route::get('/', [PagesController::class, 'index_'])->name('main');

    Route::get('atasan/update/{id}', [AkunController::class , 'update_atasan'])->name("update-atasan");

    Route::middleware('roles:pegawai|admin_opd|super_admin')->group(function(){
        Route::get('/skp/{type}', [SkpController::class, 'index'])->name('skp');
        Route::get('/skp/bulanan/create-target', [SkpController::class, 'create_target'])->name('skp.bulanan');
        Route::post('/skp/bulanan/store', [SkpController::class, 'store_target'])->name('skp.bulanan.store');
        Route::post('/skp/bulanan/update/{params}', [SkpController::class, 'update_target'])->name('skp.bulanan.update');
        Route::get('/skp-datatable', [SkpController::class, 'datatable_skp_tahunan'])->name('skp_tahunan_datatable');
        Route::get('/skp/tahunan/tambah', [SkpController::class, 'create'])->name('tambah-skp');
        Route::post('/skp/store', [SkpController::class, 'store'])->name('store-skp');
        // Route::post('/skp/store/kepala', [SkpController::class, 'store_kepala'])->name('store-skp-kepala');
        Route::get('/skp/edit/{params}', [SkpController::class, 'edit'])->name('edit-skp');
        Route::get('/skp/show/{params}', [SkpController::class, 'show'])->name('show-skp');
        Route::post('/skp/update/{params}', [SkpController::class, 'update'])->name('update-skp');
        // Route::post('/skp/update/kepala/{params}', [SkpController::class, 'update_kepala'])->name('update_kepala');
        Route::delete('/skp/delete/{params}', [SkpController::class, 'delete'])->name('delete-skp');
    });
    
    
    Route::prefix('realisasi')->group(function () {
        Route::get('/', [RealisasiController::class, 'index'])->name('realisasi');
        Route::get('/tambah/{params}/{rencana_kerja}/{bulan}', [RealisasiController::class, 'create'])->name('tambah-realisasi');
        Route::post('/store', [RealisasiController::class, 'store'])->name('store-realisasi');
    });
    
    Route::prefix('laporan')->group(function () {
        Route::get('/absen/{type}', [LaporanController::class, 'absen'])->name('laporan-absen');
        Route::get('/skp', [LaporanController::class, 'skp'])->name('laporan-skp');
        Route::get('/aktivitas', [LaporanController::class, 'aktivitas'])->name('laporan-aktivitas');
        Route::get('/export/rekapitulasi_pegawai/{params}', [LaporanController::class, 'exportRekapAbsen'])->name('laporan-absen-pegawai');
        Route::get('/export/laporanSkp/{jenis}/{type}/{bulan}', [LaporanController::class, 'exportLaporanSkp'])->name('laporan-skp-pegawai');
        Route::get('/bankom/{type}', [LaporanController::class, 'bankom'])->name('laporan-bankom');
        Route::get('/export/bankom/{tahun}/{type}/{id_pegawai}', [LaporanController::class, 'exportbankom'])->name('export-bankom');
    });
    
    Route::get('/penilaian/{type}', [PenilaianController::class, 'index'])->name('penilaian');
    Route::get('/penilaian/{type}/{id}', [PenilaianController::class, 'create'])->name('tambah-penilaian');
    Route::get('/penilaian/realisasi/{type}/{id}/{bulan}', [PenilaianController::class, 'createRealisasi'])->name('tambah-penilaian-realisasi');
    Route::get('/get_data/penilaian/{type}', [PenilaianController::class, 'getData'])->name('getdata_penilaian');
    // Route::get('/get_data/penilaian/{type}', [PenilaianController::class, 'getData'])->name('getdata_penilaian');
    Route::post('/review_skp', [PenilaianController::class, 'postReviewSkp'])->name('postReviewSkp');
    Route::post('/review_realisasi', [PenilaianController::class, 'postReviewRealisasiSkp'])->name('postReviewRealisasiSkp');

    Route::prefix('aktivitas')->group(function(){
        Route::get('/', [AktivitasController::class, 'index'])->name('aktivitas');
        Route::get('/show', [AktivitasController::class, 'aktivitas'])->name('get-aktivitas');
        Route::post('/store', [AktivitasController::class, 'store'])->name('store-aktivitas');
        Route::get('/detail/{params}', [AktivitasController::class, 'detail'])->name('detail-aktivitas');
        Route::post('/update/{params}', [AktivitasController::class, 'update'])->name('update-aktivitas');
    });

    Route::prefix('bankom')->group(function(){
        Route::get('/', [bankomController::class, 'index'])->name('bankom');
        Route::post('/', [bankomController::class, 'store'])->name('post-bankom');
        Route::get('/{id}', [bankomController::class, 'show'])->name('show-bankom');
        Route::post('/{id}', [bankomController::class, 'update'])->name('update-bankom');
        Route::delete('/{id}', [bankomController::class, 'delete'])->name('delete-bankom');
    });
    
    
    Route::prefix('akun')->group(function () {
    
        Route::get('/', [AkunController::class, 'index'])->name('akun');
        Route::get('/edit', [AkunController::class, 'edit'])->name('edit-profil');
        Route::post('/change_password', [AkunController::class, 'change_password'])->name('ganti-password');
        Route::post('/pegawai/{id}', [PegawaiController::class, 'update'])->name('update-profil');
        Route::get('/bantuan', [AkunController::class, 'bantuan'])->name('bantuan');
    });
    Route::middleware('roles:super_admin|admin_opd')->group(function (){
        Route::prefix('admin')->group(function() {
            // oke
            Route::prefix('pegawai')->group(function(){
                Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
                Route::post('/', [PegawaiController::class, 'store'])->name('store-pegawai');
                Route::get('/{id}', [PegawaiController::class, 'show'])->name('show-pegawai');
                Route::post('/update/{id}', [PegawaiController::class, 'update'])->name('update-pegawai');
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

                    Route::get('/lokasi', [lokasiController::class, 'index'])->name('lokasi');
                    Route::post('/lokasi', [lokasiController::class, 'store'])->name('post-lokasi');
                    Route::get('/lokasi/{id}', [lokasiController::class, 'show'])->name('show-lokasi');
                    Route::post('/lokasi/{id}', [lokasiController::class, 'update'])->name('update-lokasi');
                    Route::delete('/lokasi/{id}', [lokasiController::class, 'delete'])->name('delete-lokasi');
                    
                    Route::get('/data-satuan', [MasterController::class, 'get_satuan'])->name('data_master_satuan');
                    
                    Route::get('/perilaku', [MasterController::class, 'perilaku'])->name('master_perilaku');
                    Route::get('/hari-libur', [MasterController::class, 'harilibur'])->name('master_harilibur');
                    Route::post('/store/hari-libur', [MasterController::class, 'store_harilibur'])->name('store_master_harilibur');
                    Route::get('/show/hari-libur/{params}', [MasterController::class, 'show_harilibur'])->name('show_master_harilibur');
                    Route::post('/update/hari-libur/{params}', [MasterController::class, 'update_harilibur'])->name('update_master_harilibur');
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
                Route::get('/pegawaiBySatuankerja/{params}', [JabatanController::class, 'pegawaiBySatuankerja'])->name('pegawaiBySatuankerja');
                Route::get('/jabatan/{id}', [JabatanController::class, 'show'])->name('show-jabatan');
                Route::post('/jabatan/{id}', [JabatanController::class, 'update'])->name('update-jabatan');
                Route::delete('/jabatan/{id}', [JabatanController::class, 'delete'])->name('delete-jabatan');    
                Route::get('/kelas', [JabatanController::class, 'kelas'])->name('kelas')->middleware('roles:super_admin');
                Route::post('/kelas', [JabatanController::class, 'store_kelas'])->name('post-kelas');
                Route::get('/kelas/{id}', [JabatanController::class, 'show_kelas'])->name('show-kelas');
                Route::post('/kelas/{id}', [JabatanController::class, 'update_kelas'])->name('update-kelas');
                Route::delete('/kelas/{id}', [JabatanController::class, 'delete_kelas'])->name('delete-kelas');
                Route::get('/getParent/{params}', [JabatanController::class, 'getParent'])->name('getParent');
            });
    
        
            Route::prefix('satker')->group(function(){
                Route::get('/', [SatkerController::class, 'index'])->name('satker');
                Route::post('/', [SatkerController::class, 'store'])->name('post-satker');
                Route::get('/{id}', [SatkerController::class, 'show'])->name('show-satker');
                Route::post('/{id}', [SatkerController::class, 'update'])->name('update-satker');
                Route::delete('/{id}', [SatkerController::class, 'delete'])->name('delete-satker');
            });

            Route::prefix('absen')->group(function(){
                Route::get('/', [AbsenController::class, 'index'])->name('absen');
                Route::get('/datatable/{satuan_kerja}/{tanggal}/{valid}', [AbsenController::class, 'datatable_'])->name('absen.filter');
                Route::post('/', [AbsenController::class, 'store'])->name('post-absen');
                Route::get('/{pegawai}/{tanggal}/{valid}', [AbsenController::class, 'show'])->name('show-absen');
                Route::post('/{id_pegawai}', [AbsenController::class, 'update'])->name('update-absen');
                Route::post('/pegawai/change-validation', [AbsenController::class, 'change_validation'])->name('change-validation');
                Route::delete('/{id}', [AbsenController::class, 'delete'])->name('delete-absen');
            });
            
            Route::prefix('admin')->group(function(){
                Route::get('/', [AdminController::class, 'index'])->name('admin');
                Route::post('/{pegawai}', [AdminController::class, 'update'])->name('add-admin');
                Route::delete('/{pegawai}', [AdminController::class, 'delete'])->name('delete-admin');
            });

            Route::prefix('axios')->group(function(){
                Route::get('/atasan-jabatan/{id}/{satuan}', [AxiosController::class, 'atasan_jabatan']);
                Route::get('/pegawai/{satuan}', [AdminController::class, 'getPegawai']);
                Route::get('/jabatan/{id}', [AxiosController::class, 'jabatan']);
                Route::get('/atasan/{id}', [AxiosController::class, 'getAtasan']);
            });
        });
    });
});







// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', [PagesController::class, 'quickSearch'])->name('quick-search');