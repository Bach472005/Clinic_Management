<?php

namespace Database\Seeders;

use App\Models\Role;
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

        Role::insert([
            [
                'name' => 'guest',
                'created_at' => now()
            ],
            [
                'name' => 'admin', 
                'created_at' => now()
            ],
            [
                'name' => 'patient',
                'created_at' => now()
            ],
            [
                'name' => 'psychologist',
                'created_at' => now()
            ],
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'phone' => '1234567890',
            'role_id' => 2
        ]);
    }
}
