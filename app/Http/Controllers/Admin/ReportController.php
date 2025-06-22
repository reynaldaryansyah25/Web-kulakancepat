<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class ReportController extends Controller
{
  /**
   * Menampilkan halaman laporan utama.
   */
  public function exportExcel(Request $request)
  {
    $period = $request->input('period', '30days');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $dateRange = $this->determineDateRange($period, $startDate, $endDate);

    return Excel::download(new ReportExport($dateRange), 'laporan-' . $period . '.xlsx');
  }


  public function index(Request $request)
  {
    // === PENGATURAN PERIODE ===
    $period = $request->input('period', '30days');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $dateRange = $this->determineDateRange($period, $startDate, $endDate);
    $previousDateRange = $this->getPreviousDateRange($dateRange['start'], $dateRange['end']);

    // === AMBIL SEMUA DATA YANG DIPERLUKAN ===
    $stats = $this->getKpiStats($dateRange, $previousDateRange);
    $revenueTrend = $this->getRevenueTrend($dateRange);
    $categoryDistribution = $this->getCategoryDistribution($dateRange);
    $revenueComparison = $this->getRevenueComparison();
    $topProducts = $this->getTopProducts($dateRange);
    $topCustomers = $this->getTopCustomers($dateRange);

    return view('admin.reports.index', compact(
      'stats',
      'revenueTrend',
      'categoryDistribution',
      'revenueComparison',
      'topProducts',
      'topCustomers',
      'period',
      'dateRange'
    ));
  }

  private function determineDateRange($period, $start, $end): array
  {
    if ($period === 'custom' && $start && $end) {
      return ['start' => Carbon::parse($start)->startOfDay(), 'end' => Carbon::parse($end)->endOfDay()];
    }

    switch ($period) {
      case '7days':
        return ['start' => now()->subDays(6)->startOfDay(), 'end' => now()->endOfDay()];
      case '1year':
        return ['start' => now()->startOfYear(), 'end' => now()->endOfDay()];
      case '30days':
      default:
        return ['start' => now()->subDays(29)->startOfDay(), 'end' => now()->endOfDay()];
    }
  }

  private function getPreviousDateRange(Carbon $start, Carbon $end): array
  {
    $duration = $end->diffInDays($start);
    $prevEnd = $start->copy()->subDay();
    $prevStart = $prevEnd->copy()->subDays($duration);
    return ['start' => $prevStart, 'end' => $prevEnd];
  }

  private function getKpiStats(array $currentRange, array $previousRange): object
  {
    $currentRevenue = Transaction::where('status', 'FINISH')->whereBetween('date_transaction', [$currentRange['start'], $currentRange['end']])->sum('total_price');
    $previousRevenue = Transaction::where('status', 'FINISH')->whereBetween('date_transaction', [$previousRange['start'], $previousRange['end']])->sum('total_price');

    $currentOrders = Transaction::whereBetween('date_transaction', [$currentRange['start'], $currentRange['end']])->count();
    $previousOrders = Transaction::whereBetween('date_transaction', [$previousRange['start'], $previousRange['end']])->count();

    $currentActiveCustomers = Transaction::whereBetween('date_transaction', [$currentRange['start'], $currentRange['end']])->distinct('id_customer')->count('id_customer');
    $previousActiveCustomers = Transaction::whereBetween('date_transaction', [$previousRange['start'], $previousRange['end']])->distinct('id_customer')->count('id_customer');

    $currentAvgOrderValue = $currentOrders > 0 ? $currentRevenue / $currentOrders : 0;
    $previousAvgOrderValue = $previousOrders > 0 ? $previousRevenue / $previousOrders : 0;

    $revenueChange = $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : ($currentRevenue > 0 ? 100 : 0);
    $ordersChange = $previousOrders > 0 ? (($currentOrders - $previousOrders) / $previousOrders) * 100 : ($currentOrders > 0 ? 100 : 0);
    $customersChange = $previousActiveCustomers > 0 ? (($currentActiveCustomers - $previousActiveCustomers) / $previousActiveCustomers) * 100 : ($currentActiveCustomers > 0 ? 100 : 0);
    $avgOrderChange = $previousAvgOrderValue > 0 ? (($currentAvgOrderValue - $previousAvgOrderValue) / $previousAvgOrderValue) * 100 : ($currentAvgOrderValue > 0 ? 100 : 0);

    return (object) [
      'totalRevenue' => 'Rp ' . number_format($currentRevenue / 1000000, 1, ',', '.') . 'M',
      'revenueChange' => $revenueChange,
      'totalOrders' => number_format($currentOrders, 0, ',', '.'),
      'ordersChange' => $ordersChange,
      'activeCustomers' => number_format($currentActiveCustomers, 0, ',', '.'),
      'customersChange' => $customersChange,
      'avgOrderValue' => 'Rp ' . number_format($currentAvgOrderValue / 1000, 0, ',', '.') . 'K',
      'avgOrderChange' => $avgOrderChange,
    ];
  }

  private function getRevenueTrend(array $dateRange): array
  {
    $durationInDays = $dateRange['end']->diffInDays($dateRange['start']);

    if ($durationInDays > 60) {
      $dateFormat = "DATE_FORMAT(date_transaction, '%Y-%m-01')";
      $labelFormat = 'MMM yy';
    } else {
      $dateFormat = "DATE(date_transaction)";
      $labelFormat = 'D MMM';
    }

    $data = Transaction::where('status', 'FINISH')
      ->whereBetween('date_transaction', [$dateRange['start'], $dateRange['end']])
      ->select(DB::raw("$dateFormat as date_group"), DB::raw('sum(total_price) as total'))
      ->groupBy('date_group')->orderBy('date_group', 'asc')->get();

    $labels = [];
    $values = [];

    // Loop untuk memastikan semua tanggal/bulan ada di grafik, bahkan yang tidak ada penjualan
    $currentDate = $dateRange['start']->copy();
    while ($currentDate <= $dateRange['end']) {
      $dateKey = ($durationInDays > 60) ? $currentDate->format('Y-m-01') : $currentDate->format('Y-m-d');
      $labels[] = $currentDate->isoFormat($labelFormat);
      $values[] = $data->firstWhere('date_group', $dateKey)->total ?? 0;

      if ($durationInDays > 60) {
        $currentDate->addMonth()->startOfMonth();
      } else {
        $currentDate->addDay();
      }
    }

    return ['labels' => $labels, 'data' => $values];
  }

  private function getCategoryDistribution(array $dateRange): array
  {
    $data = TransactionDetail::join('products', 'transaction_detail.id_product', '=', 'products.id_product')
      ->join('products_category', 'products.id_product_category', '=', 'products_category.id_product_category')
      ->join('transaction', 'transaction_detail.id_transaction', '=', 'transaction.id_transaction')
      ->where('transaction.status', 'FINISH')
      ->whereBetween('transaction.date_transaction', [$dateRange['start'], $dateRange['end']])
      ->select('products_category.name', DB::raw('sum(transaction_detail.quantity * transaction_detail.unit_price) as total_revenue'))
      ->groupBy('products_category.name')->orderBy('total_revenue', 'desc')->limit(5)->get();

    return ['labels' => $data->pluck('name'), 'data' => $data->pluck('total_revenue')];
  }

  private function getRevenueComparison(): array
  {
    $currentYearData = Transaction::where('status', 'FINISH')->whereYear('date_transaction', now()->year)
      ->select(DB::raw("MONTH(date_transaction) as month"), DB::raw("SUM(total_price) as total"))
      ->groupBy('month')->pluck('total', 'month');

    $lastYearData = Transaction::where('status', 'FINISH')->whereYear('date_transaction', now()->subYear()->year)
      ->select(DB::raw("MONTH(date_transaction) as month"), DB::raw("SUM(total_price) as total"))
      ->groupBy('month')->pluck('total', 'month');

    $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    $currentYearValues = [];
    $lastYearValues = [];

    for ($i = 1; $i <= 12; $i++) {
      $currentYearValues[] = $currentYearData->get($i, 0);
      $lastYearValues[] = $lastYearData->get($i, 0);
    }

    return ['labels' => $labels, 'current' => $currentYearValues, 'previous' => $lastYearValues];
  }

  private function getTopProducts(array $dateRange)
  {
    return TransactionDetail::join('products', 'transaction_detail.id_product', '=', 'products.id_product')
      ->join('transaction', 'transaction_detail.id_transaction', '=', 'transaction.id_transaction')
      ->where('transaction.status', 'FINISH')
      ->whereBetween('transaction.date_transaction', [$dateRange['start'], $dateRange['end']])
      ->select(
        'products.name_product',
        DB::raw('sum(transaction_detail.quantity) as total_sold'),
        DB::raw('sum(transaction_detail.quantity * transaction_detail.unit_price) as total_revenue')
      )
      ->groupBy('products.id_product', 'products.name_product')
      ->orderBy('total_revenue', 'desc')->limit(5)->get();
  }

  private function getTopCustomers(array $dateRange)
  {
    return Transaction::join('customer', 'transaction.id_customer', '=', 'customer.id_customer')
      ->where('transaction.status', 'FINISH')
      ->whereBetween('transaction.date_transaction', [$dateRange['start'], $dateRange['end']])
      ->select(
        'customer.name_store',
        DB::raw('count(transaction.id_transaction) as total_orders'),
        DB::raw('sum(transaction.total_price) as total_spent')
      )
      ->groupBy('customer.id_customer', 'customer.name_store')
      ->orderBy('total_spent', 'desc')->limit(5)->get();
  }
}
