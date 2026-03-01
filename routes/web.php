<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\ConsentimientoController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\CalendarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta pública (redirige a login)
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (requiere autenticación)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// ===== MÓDULO DE PACIENTES =====
Route::middleware(['auth'])->group(function () {
    
    // CRUD de pacientes
    Route::resource('pacientes', PacienteController::class);
    
    // Rutas adicionales para pacientes
    Route::get('/pacientes/buscar', [PacienteController::class, 'buscar'])
        ->name('pacientes.buscar');
    
    Route::delete('/pacientes/{paciente}', [PacienteController::class, 'destroy'])
        ->name('pacientes.destroy');
    
    Route::get('/pacientes/{paciente}/detalle', [PacienteController::class, 'detalle'])
        ->name('pacientes.detalle');
});

// ===== MÓDULO DE HISTORIAS CLÍNICAS =====
Route::middleware(['auth'])->prefix('historias')->name('historias.')->group(function () {
    
    // Listado de historias de un paciente
    Route::get('/paciente/{paciente}', [HistoriaController::class, 'index'])
        ->name('index');
    
    // Historias generales
    Route::get('/general/crear/{paciente}', [HistoriaController::class, 'createGeneral'])
        ->name('general.create');
    
    Route::post('/general', [HistoriaController::class, 'storeGeneral'])
        ->name('general.store');
    
    Route::get('/general/{historia}', [HistoriaController::class, 'showGeneral'])
        ->name('general.show');
    
    Route::get('/general/{historia}/editar', [HistoriaController::class, 'editGeneral'])
        ->name('general.edit');
    
    Route::put('/general/{historia}', [HistoriaController::class, 'updateGeneral'])
        ->name('general.update');
    
    Route::delete('/general/{historia}', [HistoriaController::class, 'destroyGeneral'])
        ->name('general.destroy');
    
    // Historias pediátricas
    Route::get('/pediatrica/crear/{paciente}', [HistoriaController::class, 'createPediatrica'])
        ->name('pediatrica.create');
    
    Route::post('/pediatrica', [HistoriaController::class, 'storePediatrica'])
        ->name('pediatrica.store');
    
    Route::get('/pediatrica/{historia}', [HistoriaController::class, 'showPediatrica'])
        ->name('pediatrica.show');
    
    Route::get('/pediatrica/{historia}/editar', [HistoriaController::class, 'editPediatrica'])
        ->name('pediatrica.edit');
    
    Route::put('/pediatrica/{historia}', [HistoriaController::class, 'updatePediatrica'])
        ->name('pediatrica.update');
    
    Route::delete('/pediatrica/{historia}', [HistoriaController::class, 'destroyPediatrica'])
        ->name('pediatrica.destroy');
});

// ===== MÓDULO DE RECETAS =====
Route::middleware(['auth'])->prefix('recetas')->name('recetas.')->group(function () {
    
    Route::get('/', [RecetaController::class, 'index'])->name('index');
    
    Route::get('/crear/{paciente}', [RecetaController::class, 'create'])
        ->name('create');
    
    Route::post('/', [RecetaController::class, 'store'])->name('store');
    
    Route::get('/{receta}', [RecetaController::class, 'show'])->name('show');
    
    Route::get('/{receta}/pdf', [RecetaController::class, 'pdf'])->name('pdf');
    
    Route::delete('/{receta}', [RecetaController::class, 'destroy'])->name('destroy');
});

// ===== MÓDULO DE LABORATORIO =====
Route::middleware(['auth'])->prefix('laboratorio')->name('laboratorio.')->group(function () {
    
    Route::get('/', [LaboratorioController::class, 'index'])->name('index');
    
    Route::get('/orden/crear/{paciente}', [LaboratorioController::class, 'createOrden'])
        ->name('create');
    
    Route::post('/orden', [LaboratorioController::class, 'storeOrden'])
        ->name('store');
    
    Route::get('/orden/{orden}', [LaboratorioController::class, 'showOrden'])
        ->name('show');
    
    Route::get('/orden/{orden}/upload', [LaboratorioController::class, 'uploadResultados'])
        ->name('upload');
    
    Route::post('/orden/{orden}/upload', [LaboratorioController::class, 'storeResultados'])
        ->name('storeResultados');
    
    Route::get('/orden/{orden}/download', [LaboratorioController::class, 'downloadResultados'])
        ->name('download');
    
    Route::delete('/orden/{orden}', [LaboratorioController::class, 'destroy'])
        ->name('destroy');
});

// ===== MÓDULO DE CONSENTIMIENTOS =====
Route::middleware(['auth'])->prefix('consentimientos')->name('consentimientos.')->group(function () {
    
    Route::get('/', [ConsentimientoController::class, 'index'])->name('index');
    
    Route::get('/crear/{paciente}', [ConsentimientoController::class, 'create'])
        ->name('create');
    
    Route::post('/', [ConsentimientoController::class, 'store'])->name('store');
    
    Route::get('/{consentimiento}', [ConsentimientoController::class, 'show'])
        ->name('show');
    
    Route::get('/{consentimiento}/pdf', [ConsentimientoController::class, 'pdf'])
        ->name('pdf');
});

// ===== MÓDULO DE BOLETAS =====
Route::middleware(['auth'])->prefix('boletas')->name('boletas.')->group(function () {
    
    Route::get('/', [BoletaController::class, 'index'])->name('index');
    
    Route::get('/crear/{paciente}', [BoletaController::class, 'create'])
        ->name('create');
    
    Route::post('/', [BoletaController::class, 'store'])->name('store');
    
    Route::get('/{boleta}', [BoletaController::class, 'show'])->name('show');
    
    Route::get('/{boleta}/pdf', [BoletaController::class, 'pdf'])->name('pdf');
});

// ===== MÓDULO DE CALENDARIO =====
Route::middleware(['auth'])->prefix('calendario')->name('calendario.')->group(function () {
    
    Route::get('/', [CalendarioController::class, 'index'])->name('index');
    
    Route::get('/eventos', [CalendarioController::class, 'eventos'])
        ->name('eventos');
    
    Route::post('/eventos', [CalendarioController::class, 'store'])
        ->name('eventos.store');
    
    Route::put('/eventos/{evento}', [CalendarioController::class, 'update'])
        ->name('eventos.update');
    
    Route::delete('/eventos/{evento}', [CalendarioController::class, 'destroy'])
        ->name('eventos.destroy');
});

// ===== PERFIL DE USUARIO (Breeze) =====
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== RUTAS DE AUTENTICACIÓN (Breeze) =====
require __DIR__.'/auth.php';