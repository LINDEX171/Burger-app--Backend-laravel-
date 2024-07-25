<?php

namespace Database\Seeders;

use App\Models\Burger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BurgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Burger::factory(10)->create();
    }
}
