<?php

use App\Http\Controllers\AboutController;
<<<<<<< HEAD
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FlashReportController;
use App\Http\Controllers\MapController;
=======
>>>>>>> 683bbfeddd004eb38bb596b7f24d4996019df57a
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
<<<<<<< HEAD
    return view('web.home');
});
=======
    return view('components.web.home');
})->name('home');

Route::get('/gioi-thieu', [AboutController::class, 'index'])->name('about');

>>>>>>> 683bbfeddd004eb38bb596b7f24d4996019df57a
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

<<<<<<< HEAD
=======


>>>>>>> 683bbfeddd004eb38bb596b7f24d4996019df57a
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

<<<<<<< HEAD
Route::get('/gioi-thieu', [AboutController::class, 'index'])->name('about');
Route::get('/thong-tin-tuot-lo', [FlashReportController::class, 'index'])->name('flash-report');
Route::get('/bando-gis', [MapController::class, 'index'])->name('map');
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');

require __DIR__.'/admin.php';
=======
// Route::get('/thong-tin-tuot-lo', FlashReport::class);
// Route::get('/bando-gis', Map::class);
// Route::get('/lien-he', Contact::class);

require __DIR__.'/auth.php';
>>>>>>> 683bbfeddd004eb38bb596b7f24d4996019df57a
