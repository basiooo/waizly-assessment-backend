<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->count(1)
            ->has(\App\Models\Note::factory()->count(10))
            ->create([
                'email' => 'test@test.com',
            ]);
        \App\Models\User::factory()->count(5)
            ->has(\App\Models\Note::factory()->count(10))
            ->create();
    }
}
