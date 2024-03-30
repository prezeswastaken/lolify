<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'normal_test_user',
            'email' => 'normal_tester@test.com',
            'password' => bcrypt('password'),
            'is_admin' => 'false',
        ]);
    }
}
