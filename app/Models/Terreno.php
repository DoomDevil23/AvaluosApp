<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terreno extends Model
{
    protected $table = 'terreno';

    protected $fillable = [
        'fechaInscripcion', 'tituloFinca', 'areaTerreno', 'valorTerreno', 'valorMejora', 'idTipoMejora', 'idComunidad', 'zona', 'lote', 'planoLote'
    ];

    protected $casts = [
        'fechaInscripcion' => 'date'
    ];

    public function comunidad(){
        return $this->belongsTo(Comunidad::class, 'idComunidad');
    }

    public function tipoMejora(){
        return $this->belongsTo(TipoMejora::class, 'idTipoMejora');
    }
}
