<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SkpController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\AktivitasController;
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

Route::get('/realisasi', [RealisasiController::class, 'index'])->name('realisasi');
Route::get('/realisasi/tambah', [RealisasiController::class, 'create'])->name('tambah-realisasi');


Route::get('/penilaian/{type}', [PenilaianController::class, 'index'])->name('penilaian');
Route::get('/penilaian/{type}/{id}', [PenilaianController::class, 'create'])->name('tambah-penilaian');

Route::get('/aktivitas', [AktivitasController::class, 'index']);




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