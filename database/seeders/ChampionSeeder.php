<?php

namespace Database\Seeders;

use Database\Factories\ChampionFactory;
use Illuminate\Database\Seeder;

class ChampionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChampionFactory::new()->count(10)->create();
    }
}
