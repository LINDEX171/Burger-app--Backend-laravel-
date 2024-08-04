<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Insérer les rôles dans la table "roles"
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'customer'],
            ['name' => 'manager'],
        ]);
    }


    
}
