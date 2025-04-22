<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Viewer', 'description' => 'Solo puede ver las vistas y los datos que muestra. No puede modificar nada a excepcion de los datos de su cuenta.'],
            ['name' => 'Admin', 'description' => 'Puede agregar, actualizar y eliminar registros. No puede cambiar roles ni enviar invitaciones para crear cuentas.'],
            ['name' => 'Gerente', 'description' => 'Puede acceder a todas las funciones.']
        ]);
    }
}
