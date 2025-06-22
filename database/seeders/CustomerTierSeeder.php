<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerTier; // Import model CustomerTier

class CustomerTierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk memastikan kebersihan data
        // CustomerTier::truncate(); // Hati-hati jika sudah ada relasi

        $tiers = [
            [
                'name' => 'Bronze',
                'description' => 'Tier standar untuk pelanggan baru.',
                'min_monthly_purchase' => 0,
                'payment_term_days' => 7,
            ],
            [
                'name' => 'Silver',
                'description' => 'Pelanggan setia dengan pembelian reguler.',
                'min_monthly_purchase' => 5000000,
                'payment_term_days' => 14,
            ],
            [
                'name' => 'Gold',
                'description' => 'Pelanggan prioritas dengan volume pembelian tinggi.',
                'min_monthly_purchase' => 20000000,
                'payment_term_days' => 30,
            ],
            [
                'name' => 'Platinum',
                'description' => 'Pelanggan VVIP dengan kemitraan strategis.',
                'min_monthly_purchase' => 50000000,
                'payment_term_days' => 45,
            ],
        ];

        foreach ($tiers as $tierData) {
            CustomerTier::firstOrCreate(
                ['name' => $tierData['name']], // Cari berdasarkan nama untuk menghindari duplikasi
                $tierData                      // Buat dengan data ini jika belum ada
            );
        }

        $this->command->info('CustomerTierSeeder selesai dijalankan.');
    }
}
