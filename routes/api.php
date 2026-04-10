<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OngkirController;

// Bawaan Laravel (Biarkan saja)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// --- ROUTE RAJAONGKIR (KOMERCE) ---
Route::get('/provinces', [OngkirController::class, 'getProvinces']);
Route::get('/cities/{provinceId}', [OngkirController::class, 'getCities']);
Route::get('/districts/{cityId}', [OngkirController::class, 'getDistricts']);
Route::get('/villages/{district}', [OngkirController::class, 'getVillages']);

