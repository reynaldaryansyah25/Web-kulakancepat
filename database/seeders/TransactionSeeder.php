<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan customer dan produk sudah ada
        Transaction::factory()->count(100) // Membuat 100 transaksi contoh
            ->create()
            ->each(function ($transaction) {
                // Untuk setiap transaksi, buat 1 sampai 5 detail transaksi (item produk)
                $numberOfDetails = rand(1, 5);
                $products = Product::inRandomOrder()->limit($numberOfDetails)->get();

                if ($products->isEmpty()) return; // Lewati jika tidak ada produk

                $totalTransactionPrice = 0;

                foreach ($products as $product) {
                    if ($product->total_stock > 0) { // Hanya jika produk ada stok
                        $quantity = rand(1, min(5, $product->total_stock)); // Jumlah acak, maks 5 atau stok tersedia
                        $unitPrice = $product->price;
                        $totalPriceForItem = $quantity * $unitPrice;
                        $totalTransactionPrice += $totalPriceForItem;

                        TransactionDetail::factory()->create([
                            'id_transaction' => $transaction->id_transaction,
                            'id_product' => $product->id_product,
                            'quantity' => $quantity,
                            'unit_price' => $unitPrice,
                        ]);

                        // Kurangi stok produk (opsional, tergantung logika bisnis Anda)
                        // $product->decrement('total_stock', $quantity);
                    }
                }
                // Update total_price di transaksi berdasarkan detailnya
                if ($totalTransactionPrice > 0) {
                    $transaction->total_price = $totalTransactionPrice;
                    $transaction->save();
                } else {
                    // Jika tidak ada item yang bisa ditambahkan (misal semua produk habis),
                    // mungkin transaksi ini sebaiknya dihapus atau statusnya diubah jadi cancel.
                    // Untuk seeder, kita bisa biarkan atau hapus.
                    // $transaction->delete();
                }
            });
    }
}
