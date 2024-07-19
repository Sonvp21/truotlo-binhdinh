<?php

use App\Http\Controllers\API\BorderLayerController;
use App\Http\Controllers\API\CommuneLayerController;
use App\Http\Controllers\API\DistrictLayerController;
use App\Http\Controllers\API\LandslideLayerController;
use App\Http\Controllers\ForecastRecordController;
use App\Http\Controllers\ForecastSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/map/layers/communes', CommuneLayerController::class);
Route::get('/map/layers/districts', DistrictLayerController::class);
Route::get('/map/layers/borders', BorderLayerController::class);
Route::get('/map/layers/landslides', LandslideLayerController::class);

Route::apiResource('binhdinh/du_bao_5_ngay', ForecastSessionController::class);
Route::apiResource('binhdinh/canh_bao_gio', ForecastRecordController::class);
