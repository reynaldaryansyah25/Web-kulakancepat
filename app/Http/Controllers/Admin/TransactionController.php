<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  /**
   * Menampilkan daftar semua transaksi (pesanan).
   */
  public function index(Request $request)
  {
    $search = $request->input('search_order');
    $statusFilter = $request->input('order_status');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Memulai query dengan eager loading relasi customer
    $query = Transaction::query()->with('customer');

    // Filter berdasarkan pencarian ID Transaksi atau Nama Toko Pelanggan
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('id_transaction', 'like', "%{$search}%")
          ->orWhereHas('customer', function ($subQ) use ($search) {
            $subQ->where('name_store', 'like', "%{$search}%");
          });
      });
    }

    // Filter berdasarkan status
    if ($statusFilter) {
      $query->where('status', $statusFilter);
    }

    // Filter berdasarkan rentang tanggal
    if ($startDate && $endDate) {
      $query->whereBetween('date_transaction', [$startDate, $endDate]);
    }

    $transactions = $query->orderBy('date_transaction', 'desc')->paginate(15);

    return view('admin.orders.index', compact('transactions'));
  }

  /**
   * Menampilkan detail satu transaksi.
   */
  public function show(Transaction $transaction) // Menggunakan Route Model Binding
  {
    // Eager load relasi detail beserta produknya, dan juga relasi customer
    $transaction->load(['details.product', 'customer.salesPerson']);

    return view('admin.orders.show', compact('transaction'));
  }

  /**
   * Memperbarui status transaksi.
   */
  public function updateStatus(Request $request, Transaction $transaction)
  {
    $validated = $request->validate([
      'status' => ['required', \Illuminate\Validation\Rule::in(['WAITING_CONFIRMATION', 'PROCESS', 'SEND', 'FINISH', 'CANCEL'])],
    ]);

    $transaction->status = $validated['status'];
    $transaction->save();

    // Di sini Anda bisa menambahkan logika untuk mengirim notifikasi ke pelanggan
    // tentang perubahan status pesanan.

    return redirect()->route('admin.orders.show', $transaction->id_transaction)
      ->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $validated['status'] . '.');
  }
}
