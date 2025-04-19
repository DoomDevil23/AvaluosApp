<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corregimiento extends Model
{
    protected $fillable = ['codigoUbicacion'];
    public function distrito(){
        return $this->belongsTo(Distrito::class, 'idDistrito');
    }
}
