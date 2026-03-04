<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PacienteController;

Route::middleware('auth:sanctum')->group(function () {
    // Pacientes
    Route::apiResource('pacientes', PacienteController::class);
    Route::get('pacientes/buscar/{term}', [PacienteController::class, 'buscar']);
    
    // Aquí puedes agregar más recursos API
    // Route::apiResource('historias', HistoriaController::class);
    // Route::apiResource('recetas', RecetaController::class);
    // Route::apiResource('citas', CitaController::class);
});