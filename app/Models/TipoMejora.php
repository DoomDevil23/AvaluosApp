<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMejora extends Model
{
    protected $table = 'tipomejora';

    public function terrenos(){
        return $this->hasMany(Terreno::class, 'idTipoMejora');
    }
}
