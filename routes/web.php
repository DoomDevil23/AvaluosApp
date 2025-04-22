<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TerrenoController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\CorregimientoController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\TipoMejoraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvitacionController;
//use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

//RUTAS CON AUTH
Route::middleware('auth')->group(function(){
    //VISTAS PRINCIPALES
    Route::get('/terrenos', [TerrenoController::class, 'index'])->name('terrenos.index');
    Route::get('/comunidades', [ComunidadController::class, 'index'])->name('comunidades.index');

    //SELECT DINAMICOS
    Route::get('/distritos/{idProvincia}', [TerrenoController::class, 'getDistritos']);
    Route::get('corregimientos/{idDistrito}', [TerrenoController::class, 'getCorregimientos']);
    Route::get('/comunidades/{idCorregimiento}', [TerrenoController::class, 'getComunidades']);
    Route::get('/provincias', [ProvinciaController::class, 'index']);
    Route::get('comunidad-info/{id}', [TerrenoController::class, 'comunidadInfo']);
    Route::get('/tipomejoras', [TipoMejoraController::class, 'index']);
});

//RUTAS POR ROL DE ADMIN Y GERENTE
Route::middleware(['auth', 'role:2,3'])->group(function(){
    //TERRENOS
    Route::post('/terrenos', [TerrenoController::class, 'store'])->name('terrenos.store');
    Route::put('/terrenos/{terreno}', [TerrenoController::class, 'update'])->name('terrenos.update');
    Route::delete('terrenos/{terreno}', [TerrenoController::class, 'destroy'])->name('terrenos.destroy');

    //COMUNIDADES
    Route::post('/comunidades', [ComunidadController::class, 'store'])->name('comunidades.store');
    Route::put('comunidades/{comunidad}', [comunidadController::class, 'update'])->name('comunidades.update');
    Route::delete('comunidades/{comunidad}', [ComunidadController::class, 'destroy'])->name('comunidades.destroy');

    //CORREGIMIENTOS
    Route::put('/corregimientos/{id}/codigo-ubicacion', [CorregimientoController::class, 'updateCodigoUbicacion']);
});

//RUTAS SOLO PARA EL GERENTE
Route::middleware(['auth', 'role:3'])->group(function(){
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/invitaciones', [InvitacionController::class, 'store'])->name('invitaciones.store');
});
//Route::get('/users', [UserController::class, 'index'])->name('users.index');
//Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/test-middleware', fn() => 'Ok')->middleware('invitacion');

//Route::get('/test', dd(Auth::user()->idRole));