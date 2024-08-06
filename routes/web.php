<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FlashReportController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestApiController;
use App\Livewire\Web\Home;
use Illuminate\Support\Facades\Route;


Route::get('/', Home::class)->name('home');
// Route::get('/', function () {
//     return view('web.home');
// })->name('home');
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/gioi-thieu', [AboutController::class, 'index'])->name('about');
Route::get('/thong-tin-ngay', [FlashReportController::class, 'indexDay'])->name('day-report');
Route::get('/thong-tin-gio', [FlashReportController::class, 'indexRecord'])->name('record-report');
Route::get('/bando-gis', [MapController::class, 'index'])->name('map');
Route::get('/bieudo', [ChartController::class, 'index'])->name('chart');
Route::get('/xuat-excel', [ChartController::class, 'xuatExcel'])->name('xuat.excel');
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');

//map
Route::get('/ban-do', [MapController::class, 'index'])->name('map');
Route::get('/ban-do/{layer}.geojson', [MapController::class, 'layer']);

Route::get('/map/landslide/info/{id}', [MapController::class, 'getLandslides'])->name('map.landslide.info');


///test post data api
Route::get('binhdinh/du_bao_5_ngay_sample_value', [TestApiController::class, 'duBao5Ngay']);
Route::get('/binhdinh/canh_bao_gio_sample_value', [TestApiController::class, 'canhBaoGio']);
require __DIR__.'/admin.php';
