<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('distritos')->insert([
            //Bocas del Toro
            ['name' => 'Almirante', 'idProvincia' => 1],
            ['name' => 'Bocas del Toro', 'idProvincia' => 1],
            ['name' => 'Changuiola', 'idProvincia' => 1],
            ['name' => 'Chiriquí Grande', 'idProvincia' => 1],
            //Cocle
            ['name' => 'Aguadulce', 'idProvincia' => 2],
            ['name' => 'Antón', 'idProvincia' => 2],
            ['name' => 'La pintada', 'idProvincia' => 2],
            ['name' => 'Natá', 'idProvincia' => 2],
            ['name' => 'Olá', 'idProvincia' => 2],
            ['name' => 'Penonomé', 'idProvincia' => 2],
            //Colon
            ['name' => 'Chagres', 'idProvincia' => 3],
            ['name' => 'Colón', 'idProvincia' => 3],
            ['name' => 'Donoso', 'idProvincia' => 3],
            ['name' => 'Omar Torrijos Herrera', 'idProvincia' => 3],
            ['name' => 'Portobelo', 'idProvincia' => 3],
            ['name' => 'Santa Isabel', 'idProvincia' => 3],
            //Chiriqui
            ['name' => 'Alanje', 'idProvincia' => 4],
            ['name' => 'Barú', 'idProvincia' => 4],
            ['name' => 'Boquerón', 'idProvincia' => 4],
            ['name' => 'Boquete', 'idProvincia' => 4],
            ['name' => 'Bugaba', 'idProvincia' => 4],
            ['name' => 'David', 'idProvincia' => 4],
            ['name' => 'Dolega', 'idProvincia' => 4],
            ['name' => 'Gualaca', 'idProvincia' => 4],
            ['name' => 'Remedios', 'idProvincia' => 4],
            ['name' => 'Renacimiento', 'idProvincia' => 4],
            ['name' => 'San Félix', 'idProvincia' => 4],
            ['name' => 'San Lorenzo', 'idProvincia' => 4],
            ['name' => 'Tierras Altas', 'idProvincia' => 4],
            ['name' => 'Tolé', 'idProvincia' => 4],
            //Darien
            ['name' => 'Chepigana', 'idProvincia' => 5],
            ['name' => 'Pinogana', 'idProvincia' => 5],
            ['name' => 'Santa Fe', 'idProvincia' => 5],
            //Herrera
            ['name' => 'Chitré', 'idProvincia' => 6],
            ['name' => 'Las Minas', 'idProvincia' => 6],
            ['name' => 'Los Pozos', 'idProvincia' => 6],
            ['name' => 'Ocú', 'idProvincia' => 6],
            ['name' => 'Parita', 'idProvincia' => 6],
            ['name' => 'Pesé', 'idProvincia' => 6],
            ['name' => 'Santa María', 'idProvincia' => 6],
            //Los Santos
            ['name' => 'Guararé', 'idProvincia' => 7],
            ['name' => 'Las Tablas', 'idProvincia' => 7],
            ['name' => 'Los Santos', 'idProvincia' => 7],
            ['name' => 'Macaracas', 'idProvincia' => 7],
            ['name' => 'Pedasí', 'idProvincia' => 7],
            ['name' => 'Pocrí', 'idProvincia' => 7],
            ['name' => 'Tonosí', 'idProvincia' => 7],
            //Panama
            ['name' => 'Balboa', 'idProvincia' => 8],
            ['name' => 'Chepo', 'idProvincia' => 8],
            ['name' => 'Chimán', 'idProvincia' => 8],
            ['name' => 'Panamá', 'idProvincia' => 8],
            ['name' => 'San Miguelito', 'idProvincia' => 8],
            ['name' => 'Taboga', 'idProvincia' => 8],
            //Veraguas
            ['name' => 'Atalaya', 'idProvincia' => 9],
            ['name' => 'Calobre', 'idProvincia' => 9],
            ['name' => 'Cañazas', 'idProvincia' => 9],
            ['name' => 'La Mesa', 'idProvincia' => 9],
            ['name' => 'Las Palmas', 'idProvincia' => 9],
            ['name' => 'Mariato', 'idProvincia' => 9],
            ['name' => 'Montijo', 'idProvincia' => 9],
            ['name' => 'Río de Jesús', 'idProvincia' => 9],
            ['name' => 'San Francisco', 'idProvincia' => 9],
            ['name' => 'Santa Fé', 'idProvincia' => 9],
            ['name' => 'Santiago', 'idProvincia' => 9],
            ['name' => 'Soná', 'idProvincia' => 9],
            //Panama Oeste
            ['name' => 'Arraiján', 'idProvincia' => 10],
            ['name' => 'Capira', 'idProvincia' => 10],
            ['name' => 'Chame', 'idProvincia' => 10],
            ['name' => 'La Chorrera', 'idProvincia' => 10],
            ['name' => 'San Carlos', 'idProvincia' => 10],
            //Embera Wounaan
            ['name' => 'Cémaco', 'idProvincia' => 11],
            ['name' => 'Sambú', 'idProvincia' => 11],
            //Guna Yala
            ['name' => 'Guna Yala', 'idProvincia' => 12],
            //Ngabe'Bugle
            ['name' => 'Besiko', 'idProvincia' => 13],
            ['name' => 'Jirondai', 'idProvincia' => 13],
            ['name' => 'Kankintú', 'idProvincia' => 13],
            ['name' => 'Kusapín', 'idProvincia' => 13],
            ['name' => 'Mironó', 'idProvincia' => 13],
            ['name' => 'Müna', 'idProvincia' => 13],
            ['name' => 'Nole Duima', 'idProvincia' => 13],
            ['name' => 'Ñürüm', 'idProvincia' => 13],
            ['name' => 'Santa Catalina', 'idProvincia' => 13],
            //Naso Tjer Di
            ['name' => 'Naso Tjër Di', 'idProvincia' => 14],
        ]);
    }
}
