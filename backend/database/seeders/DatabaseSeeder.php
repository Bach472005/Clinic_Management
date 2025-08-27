<?php

namespace Database\Seeders;

use App\Models\Psychologist;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\SchedulePsychologistSeeder as SeedersSchedulePsychologistSeeder;
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
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'role_id' => 2
        ]);
        // Tạo user
        $user = User::factory()->create([
            'name' => 'Psychologist',
            'email' => 'psychologist@example.com',
            'password' => bcrypt('password'),
            'phone' => '0376177391',
            'role_id' => 4
        ]);

        Psychologist::create([
            'user_id' => $user->id,
            'specialization' => 'Cognitive Behavioral Therapy',
            'bio' => 'Experienced psychologist specializing in CBT and mental health counseling.',
            'experience' => 5,
            'education' => 'Master of Clinical Psychology - Stanford University',
            'method' => 'CBT, ACT, Mindfulness-Based Therapy',
            'focus_areas' => 'Anxiety, Depression, Workplace Stress, Relationship Issues',
            'image_url' => 'https://png.pngtree.com/png-clipart/20230914/original/pngtree-psychiatrist-clipart-cartoon-old-doctor-character-with-a-stethoscope-vector-png-image_12148388.png',
        ]);
        
        $this->call(SeedersSchedulePsychologistSeeder::class);
    }
}
