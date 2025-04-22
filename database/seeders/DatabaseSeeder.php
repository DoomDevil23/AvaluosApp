<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $this->call([ProvinciaSeeder::class]);
        $this->call([DistritoSeeder::class]);
        $this->call([CorregimientoSeeder::class]);
        $this->call([TipoMejoraSeeder::class]);
        $this->call([RoleSeeder::class]);
        $this->call([InvitacionSeeder::class]);
    }
}
