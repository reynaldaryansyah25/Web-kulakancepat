<?php

namespace Database\Seeders;

use App\Models\Delivery;
use App\Models\DeliveryLocationHistory;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionsForDelivery = Transaction::whereIn('status', ['PROCESS', 'SEND'])->inRandomOrder()->limit(10)->get();

        if ($transactionsForDelivery->isEmpty()) {
            $this->command->warn('Tidak ada transaksi dengan status PROCESS atau SEND untuk dibuatkan data pengiriman.');
            return;
        }

        $this->command->info("Membuat data pengiriman untuk {$transactionsForDelivery->count()} transaksi...");

        foreach ($transactionsForDelivery as $transaction) {
            // Buat satu record pengiriman untuk setiap transaksi
            $delivery = Delivery::factory()->create([
                'transaction_id' => $transaction->id_transaction,
                // Anda bisa menambahkan logika untuk memilih sales/kurir yang lebih spesifik
            ]);

            // Buat beberapa histori lokasi untuk setiap pengiriman untuk simulasi perjalanan
            $historyCount = rand(5, 15);
            DeliveryLocationHistory::factory()->count($historyCount)->create([
                'delivery_id' => $delivery->id,
            ]);
        }

        $this->command->info('DeliverySeeder selesai dijalankan.');
    }
}
