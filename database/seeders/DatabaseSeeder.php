<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pelatihan;
use App\Models\News;
use App\Models\Service;
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

         Pelatihan::updateOrCreate(
            ['title' => 'Example Training'],
            [
                'slug' => 'example-training',
                'description' => 'Description of the training course.',
                'image_path' => 'training-image.jpg',
                'duration' => '2 hours',
                'price' => 150.00,
                'status' => 'active',
            ]
        );
        News::updateOrCreate(
            ['title' => 'Example News Title'],
            [
                'slug' => 'example-news-title',
                'category' => 'General',
                'image_path' => 'example-image.jpg',
                'excerpt' => 'Short excerpt of the news.',
                'body' => 'Full body of the news article goes here.',
                'published_at' => now(),
                'is_active' => true,
            ]
        );
        Service::updateOrCreate(
            ['name' => 'Example Service'],
            [
                'description' => 'A brief description of the service.',
                'url_layanan' => 'http://example.com',
                'image_path' => 'service-image.jpg',
                'is_active' => true,
            ]
        );
    }
}
