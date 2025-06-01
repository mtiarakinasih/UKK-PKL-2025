<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PklController;
use App\Http\Controllers\APIGuruController;
use App\Http\Controllers\APISiswaController;
use App\Http\Controllers\APIIndustriController;
use App\Http\Controllers\APIPKLController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pkls', [PklController::class, 'index']);

Route::apiResource('guru', APIGuruController::class);
Route::apiResource('siswa', APISiswaController::class);
Route::apiResource('industri', APIIndustriController::class);
Route::apiResource('pkl', APIPKLController::class);