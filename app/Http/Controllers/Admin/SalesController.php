<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
  /**
   * Menampilkan daftar sales beserta statistik kinerja.
   */
  public function index(Request $request)
  {
    // === Menghitung Statistik KPI di Atas ===
    $totalSales = Sales::count();
    $activeSales = Sales::where('status', 'Aktif')->count();
    $totalTargetThisMonth = Sales::where('status', 'Aktif')->sum('target_sales');
    $totalAchievementThisMonth = Transaction::where('status', 'FINISH')
      ->whereMonth('date_transaction', now()->month)
      ->whereYear('date_transaction', now()->year)
      ->sum('total_price');
    $overallAchievementPercentage = ($totalTargetThisMonth > 0)
      ? ($totalAchievementThisMonth / $totalTargetThisMonth) * 100
      : 0;

    $stats = (object) [
      'total' => $totalSales,
      'active' => $activeSales,
      'totalTarget' => $totalTargetThisMonth,
      'totalAchievement' => $overallAchievementPercentage,
    ];

    // === Logika untuk Filter dan Daftar Sales ===
    $search = $request->input('search_sales');
    $statusFilter = $request->input('sales_status');

    $query = Sales::query()
      ->withCount('customers')
      ->withSum(['transactions as achievement_this_month' => function ($query) {
        $query->where('transaction.status', 'FINISH')
          ->whereMonth('date_transaction', now()->month)
          ->whereYear('date_transaction', now()->year);
      }], 'total_price');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%"); 
      });
    }

    if ($statusFilter) {
      $query->where('sales.status', $statusFilter);
    }

    $salesTeam = $query->orderBy('name', 'asc')->paginate(10);

    return view('admin.sales.index', compact('salesTeam', 'stats'));
  }

  /**
   * Menyimpan sales baru ke database.
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:100|unique:sales,email',
      'no_phone' => 'required|string|max:20',
      'password' => 'required|string|min:8|confirmed',
      'target_sales' => 'nullable|numeric|min:0',
      'status' => ['required', Rule::in(['Aktif', 'Cuti', 'Nonaktif'])],
    ]);
    Sales::create($validatedData);
    return redirect()->route('admin.sales.index')->with('success', 'Anggota sales baru berhasil ditambahkan.');
  }

  /**
   * Memperbarui data sales di database.
   */
  public function update(Request $request, Sales $sale)
  {
    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'email' => ['required', 'string', 'email', 'max:100', Rule::unique('sales', 'email')->ignore($sale->id_sales, 'id_sales')],
      'no_phone' => 'required|string|max:20',
      'target_sales' => 'nullable|numeric|min:0',
      'status' => ['required', Rule::in(['Aktif', 'Cuti', 'Nonaktif'])],
      'password' => 'nullable|string|min:8|confirmed',
    ]);
    if (!empty($request->input('password'))) {
      $sale->password = $request->input('password');
    }
    $updateData = $request->except('password', 'password_confirmation', '_token', '_method');
    if (empty($request->input('password'))) {
      unset($updateData['password_confirmation']);
    }
    $sale->fill($updateData);
    $sale->save();
    return redirect()->route('admin.sales.index')->with('success', 'Data anggota sales berhasil diperbarui.');
  }

  // Method lainnya tidak perlu diubah
  public function create()
  {
    return view('admin.sales.form');
  }
  public function edit(Sales $sale)
  {
    return view('admin.sales.form', compact('sale'));
  }
  public function destroy(Sales $sale)
  {
    if ($sale->customers()->count() > 0) {
      return redirect()->route('admin.sales.index')->with('error', 'Tidak dapat menghapus sales ini karena masih memiliki pelanggan terkait.');
    }
    $sale->delete();
    return redirect()->route('admin.sales.index')->with('success', 'Anggota sales berhasil dihapus.');
  }
}
