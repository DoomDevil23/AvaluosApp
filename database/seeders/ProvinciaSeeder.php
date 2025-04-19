<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provincias')->insert([
            ['name'=>'Bocas del Toro'],
            ['name'=>'Cocle'],
            ['name'=>'Colón'],
            ['name'=>'Chiriquí'],
            ['name'=>'Darien'],
            ['name'=>'Herrera'],
            ['name'=>'Los Santos'],
            ['name'=>'Panamá'],
            ['name'=>'Veraguas'],
            ['name'=>'Panamá Oeste'],
            ['name'=>'Emberá-Wounaan'],
            ['name'=>'Guna Yala'],
            ['name'=>'Ngäbe-Buglé'],
            ['name'=>'Naso Tjër Di']
        ]);
    }
}
