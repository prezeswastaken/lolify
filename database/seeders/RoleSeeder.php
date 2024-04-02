<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'TOP']);
        Role::create(['name' => 'JUNGLE']);
        Role::create(['name' => 'MID']);
        Role::create(['name' => 'ADC']);
        Role::create(['name' => 'SUPPORT']);
    }
}
