<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Memulai proses seeding database...');

        $this->call([
            AdminSeeder::class,
            CustomerTierSeeder::class,
            ProductCategorySeeder::class,
            SalesSeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            TransactionSeeder::class,
            // Seeder untuk fitur inovatif
            SystemRecommendationLogSeeder::class,
            DeliverySeeder::class,
        ]);

        $this->command->info('Proses seeding database telah selesai.');
    }
}
