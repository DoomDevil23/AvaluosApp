<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comunidad extends Model
{
    protected $table = 'comunidades';
    //protected $primaryKey = 'id';

    protected $fillable = ['name', 'idCorregimiento'];

    public function terrenos(){
        return $this->hasMany(Terreno::class, 'idComunidad');
    }

    public function corregimiento(){
        return $this->belongsTo(Corregimiento::class, 'idCorregimiento');
    }
}
