<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitacion extends Model
{
    protected $table = 'invitaciones';

    protected $fillable = [
        'token',
        'idRole',
        'is_used',
        'expired_at',
    ];
}
