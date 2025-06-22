<?php

namespace Database\Seeders;

use App\Models\SystemRecommendationLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemRecommendationLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 200 log rekomendasi acak
        SystemRecommendationLog::factory()->count(200)->create();

        $this->command->info('SystemRecommendationLogSeeder selesai dijalankan.');
    }
}
