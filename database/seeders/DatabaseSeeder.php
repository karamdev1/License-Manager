<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin111',
            'role' => 'Owner',
        ]);
    }
}
