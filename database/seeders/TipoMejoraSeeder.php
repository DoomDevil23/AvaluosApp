<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoMejoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipoMejora')->insert([
            ['name' => 'Comercial', 'description' => 'Proyectos destinados a comercios privados.'],
            ['name' => 'Gubernamental', 'description' => 'Proyectos impulsados por el gobierno.'],
            ['name' => 'Industrial', 'description' => 'Proyectos destinados a la produccion industrial.'],
            ['name' => 'Residencial', 'description' => 'Desarrollo de barriadas y proyectos con fines de vivienda personal/familiar.']
        ]);
    }
}
