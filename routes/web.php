<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TerrenoController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\CorregimientoController;
use App\Http\Controllers\ComunidadController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('terrenos', TerrenoController::class)->except(['show', 'edit']);
Route::get('/distritos/{idProvincia}', [TerrenoController::class, 'getDistritos']);
Route::get('/corregimientos/{idDistrito}', [TerrenoController::class, 'getCorregimientos']);
Route::get('/comunidades/{idCorregimiento}', [TerrenoController::class, 'getComunidades']);
Route::get('/provincias', [ProvinciaController::class, 'index']);
Route::get('/comunidad-info/{id}', [TerrenoController::class, 'comunidadInfo']);
Route::put('/terrenos/{terreno}', [TerrenoController::class, 'update'])->name('terrenos.update');
//Route::post('/comunidades', [ComunidadController::class, 'store']);
Route::resource('comunidades', ComunidadController::class)->except(['show', 'edit']);
Route::put('/comunidades/{comunidad}', [ComunidadController::class, 'update'])->name('comunidades.update');
Route::put('/corregimientos/{id}/codigo-ubicacion', [CorregimientoController::class, 'updateCodigoUbicacion']);
Route::get('/test-comunidad/{comunidad}', function(App\Models\Comunidad $comunidad){
    dd($comunidad);
});