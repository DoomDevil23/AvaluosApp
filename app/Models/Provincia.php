<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provincia extends Model
{
    use HasFactory;

    // Define the table if it's not following the Laravel convention (provincias)
    protected $table = 'provincias';

    // Define the fillable attributes (columns that are mass assignable)
    protected $fillable = [
        'name', // Add other attributes here if needed
    ];
}
