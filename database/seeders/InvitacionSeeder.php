<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('invitaciones')->insert([
            ['token' => 'helloda', 'idRole' => 3, 'is_used' => false, 'expired_at' => '2025-04-23'],
        ]);
    }
}
