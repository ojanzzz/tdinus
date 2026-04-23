<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => 'admin12345',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'member@tdinus.com'],
            [
                'name' => 'Member',
                'password' => 'member12345',
                'role' => 'member',
            ]
        );
          User::updateOrCreate(
            ['email' => 'member@member.com'],
            [
                'name' => 'Member',
                'password' => 'member12345',
                'role' => 'member',
            ]
        );
    }
}
