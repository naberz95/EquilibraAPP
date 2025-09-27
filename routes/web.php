<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('usuarios', UsuarioController::class);
    Route::patch('usuarios/{usuario}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('usuarios.toggle-status');

    Route::resource('pacientes', \App\Http\Controllers\PacienteController::class);

    Route::resource('entidades', \App\Http\Controllers\EntidadController::class);

    Route::get('citas/events', [\App\Http\Controllers\CitaController::class, 'getCalendarEvents'])->name('citas.events');
    Route::resource('citas', \App\Http\Controllers\CitaController::class);

    Route::resource('historias', \App\Http\Controllers\HistoriaClinicaController::class);
    Route::patch('historias/{historia}/toggle-bloqueo', [\App\Http\Controllers\HistoriaClinicaController::class, 'toggleBloqueo'])->name('historias.toggle-bloqueo');

    Route::post('firmas/guardar-dibujada', [\App\Http\Controllers\FirmaController::class, 'guardarFirmaDibujada'])->name('firmas.guardar-dibujada');
    Route::post('firmas/guardar-subida', [\App\Http\Controllers\FirmaController::class, 'guardarFirmaSubida'])->name('firmas.guardar-subida');
    Route::delete('firmas/eliminar', [\App\Http\Controllers\FirmaController::class, 'eliminarFirma'])->name('firmas.eliminar');
    Route::get('firmas/obtener/{userId}', [\App\Http\Controllers\FirmaController::class, 'obtenerFirma'])->name('firmas.obtener');
});

Route::get('/app', function () {
    return view('app');
});
