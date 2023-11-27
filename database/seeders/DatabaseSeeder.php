<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Travolta',
            'email' => 'user@email.com',
            'password' => Hash::make('password'),
        ]);
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Agokoy',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
            'role' => 1
        ]);
    }
}
