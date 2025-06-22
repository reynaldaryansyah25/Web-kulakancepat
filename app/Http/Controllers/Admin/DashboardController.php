<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  /**
   * Display the admin dashboard with data from the database.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    // --- Menghitung Data untuk Kartu KPI ---
    $totalRevenue = Transaction::where('status', 'FINISH')
      ->whereDate('date_transaction', now()->toDateString())
      ->sum('total_price');
    $newOrdersCount = Transaction::whereDate('date_transaction', today())->count();
    $newCustomersCount = Customer::whereDate('created', today())->count();
    $criticalStockCount = Product::where('total_stock', '<=', 10)->count();

    $kpi = (object) [
      'totalRevenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
      'newOrders' => $newOrdersCount,
      'newCustomers' => $newCustomersCount,
      'criticalStock' => $criticalStockCount,
    ];


    // --- Menyiapkan Data untuk Tabel ---
    $recentOrders = Transaction::with('customer')->orderBy('date_transaction', 'desc')->limit(5)->get();
    $pendingCustomers = Customer::where('status', 'PENDING_APPROVE')->orderBy('created', 'desc')->limit(5)->get();
    $salesPeriod = $request->input('sales_period', '7days');
    $startDate = now();
    $dateFormat = "DATE(date_transaction)";
    $labelFormat = 'D MMM';

    switch ($salesPeriod) {
      case '30days':
        $startDate = now()->subDays(29)->startOfDay();
        break;
      case '1year':
        $startDate = now()->startOfYear();
        $dateFormat = "DATE_FORMAT(date_transaction, '%Y-%m-01')";
        $labelFormat = 'MMMM';
        break;
      default:
        $startDate = now()->subDays(6)->startOfDay();
        break;
    }

    $salesDataQuery = Transaction::where('status', 'FINISH')
      ->where('date_transaction', '>=', $startDate)
      ->select(
        DB::raw("$dateFormat as date_group"),
        DB::raw('sum(total_price) as total')
      )
      ->groupBy('date_group')
      ->orderBy('date_group', 'asc')
      ->get();

    // Proses data untuk format Chart.js
    $salesChartData = [
      'labels' => $salesDataQuery->map(function ($item) use ($labelFormat) {
        // Gunakan Carbon untuk memformat tanggal/bulan dengan nama Indonesia
        return Carbon::parse($item->date_group)->isoFormat($labelFormat);
      }),
      'data' => $salesDataQuery->pluck('total'),
    ];


    // --- Menyiapkan Data untuk Grafik Produk Terlaris ---
    $topProducts = TransactionDetail::join('products', 'transaction_detail.id_product', '=', 'products.id_product')
      ->select('products.name_product', DB::raw('sum(transaction_detail.quantity) as total_sold'))
      ->groupBy('products.id_product', 'products.name_product')
      ->orderBy('total_sold', 'desc')
      ->limit(5)
      ->get();

    $topProductsChartData = [
      'labels' => $topProducts->pluck('name_product'),
      'data' => $topProducts->pluck('total_sold'),
    ];
    // Kirim semua data ke view, termasuk periode yang dipilih
    return view('admin.dashboard', compact(
      'kpi',
      'recentOrders',
      'pendingCustomers',
      'salesChartData',
      'topProductsChartData',
      'salesPeriod'
    ));
  }
}
