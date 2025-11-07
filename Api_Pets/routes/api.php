<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

// Registro y login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Endpoints públicos
Route::get('mascotas', [MascotaController::class, 'index']);
Route::get('mascotas/{id}', [MascotaController::class, 'show']);

// Endpoints protegidos
Route::middleware('auth:sanctum')->group(function () {
    Route::post('mascotas/{id}/solicitudes', [SolicitudController::class, 'store']);
    Route::get('solicitudes', [SolicitudController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
});