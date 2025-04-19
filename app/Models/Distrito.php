<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'distritos';

    protected $fillable = [
        'name',
        'idProvincia'
    ];

    public function provincia(){
        return $this->belongsTo(Provincia::class, 'idProvincia');
    }
}
