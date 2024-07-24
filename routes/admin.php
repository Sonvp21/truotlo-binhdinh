<?php

use App\Http\Controllers\Admin\Album\CooperationController;
use App\Http\Controllers\Admin\Album\PhotoController;
use App\Http\Controllers\Admin\Album\VideoController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ApplyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RichTextAttachmentController;
use App\Http\Controllers\Admin\ScienceInformationController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\Support\TinymceController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ForecastSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        // Route::resource('categories', CategoryController::class);
    });
});


// API

Route::get('/sessions', [ForecastSessionController::class, 'indexView'])->name('admin.sessions.index');


require __DIR__.'/auth.php';
