<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Kulakan',
                'password' => 'password123',
                'created' => now(),
                'updated' => now(),
            ]
        );

        // Membuat beberapa admin contoh lainnya
        Admin::factory()->count(2)->create();
    }
}
