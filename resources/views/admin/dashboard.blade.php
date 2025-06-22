@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Dashboard</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Selamat datang kembali, AdminKulakanCepat!</p>
        </div>
        <div>
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd" />
                </svg>
                <span>Buat Laporan</span>
            </a>
        </div>
    </div>

    {{-- Kartu KPI (Key Performance Indicator) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        {{-- Total Pendapatan --}}
        <div class="group relative overflow-hidden">
            <div class="relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-xl rounded-xl p-5 transform transition-all duration-300 group-hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Pendapatan</p>
                        <p class="mt-1 text-lg font-black text-slate-800 dark:text-slate-100">{{ $kpi->totalRevenue ?? 'Rp 0' }}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-500/20 dark:to-blue-600/20 text-blue-600 dark:text-blue-400 shadow-lg">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <h3 class="text-xs font-bold text-slate-700 dark:text-slate-200">Performa Keuangan</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Total pendapatan bersih hari ini</p>
            </div>
        </div>

        {{-- Pesanan Baru --}}
        <div class="group relative overflow-hidden">
            <div class="relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-xl rounded-xl p-5 transform transition-all duration-300 group-hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pesanan Baru</p>
                        <p class="mt-1 text-lg font-black text-slate-800 dark:text-slate-100">{{ $kpi->newOrders ?? 0 }}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-gradient-to-br from-green-100 to-green-200 dark:from-green-500/20 dark:to-green-600/20 text-green-600 dark:text-green-400 shadow-lg">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    </div>
                </div>
                <h3 class="text-xs font-bold text-slate-700 dark:text-slate-200">Aktivitas Harian</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Jumlah pesanan baru hari ini</p>
            </div>
        </div>

        {{-- Pelanggan Baru --}}
        <div class="group relative overflow-hidden">
            <div class="relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-xl rounded-xl p-5 transform transition-all duration-300 group-hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pelanggan Baru (Hari Ini)</p>
                        <p class="mt-1 text-lg font-black text-slate-800 dark:text-slate-100">{{ $kpi->newCustomers ?? 0 }}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-500/20 dark:to-yellow-600/20 text-yellow-600 dark:text-yellow-400 shadow-lg">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3M16 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                </div>
                <h3 class="text-xs font-bold text-slate-700 dark:text-slate-200">Akuisisi Pengguna</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Jumlah pelanggan baru yang terdaftar</p>
            </div>
        </div>

        {{-- Stok Kritis --}}
        <div class="group relative overflow-hidden">
            <div class="relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-xl rounded-xl p-5 transform transition-all duration-300 group-hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Stok Kritis</p>
                        <p class="mt-1 text-lg font-black text-slate-800 dark:text-slate-100">{{ $kpi->criticalStock ?? 0 }} <span class="text-xs font-bold">Produk</span></p>
                    </div>
                    <div class="p-2 rounded-lg bg-gradient-to-br from-red-100 to-red-200 dark:from-red-500/20 dark:to-red-600/20 text-red-600 dark:text-red-400 shadow-lg">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                </div>
                <h3 class="text-xs font-bold text-slate-700 dark:text-slate-200">Manajemen Inventaris</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Produk dengan stok di bawah batas aman</p>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
     <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
        {{-- Grafik Analitik Penjualan --}}
        <div class="lg:col-span-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Analitik Penjualan</h2>
                <form action="{{ route('admin.dashboard') }}" method="GET" id="salesPeriodForm">
                    <select name="sales_period" onchange="document.getElementById('salesPeriodForm').submit();" class="text-sm border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-primary/50 focus:border-primary/50">
                        <option value="30days" {{ $salesPeriod == '30days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    </select>
                </form>
            </div>
            <div class="h-80">
                <canvas id="salesChartDashboard"></canvas>
            </div>
        </div>
        {{-- Grafik Produk Terlaris --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-xl p-6">
            <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4">Produk Terlaris</h2>
            <div class="h-80 flex items-center justify-center">
                <canvas id="topProductsChartDashboard"></canvas>
            </div>
        </div>
    </div>

    {{-- Tabel Aktivitas (dengan Tab) --}}
    <div x-data="{ activeTab: 'orders' }" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-xl">
        {{-- Header Tab --}}
        <div class="px-6 border-b border-slate-200 dark:border-slate-700">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:hover:text-slate-200 dark:hover:border-slate-500'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Aktivitas Pesanan Terbaru
                </button>
                <button @click="activeTab = 'customers'" :class="activeTab === 'customers' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:hover:text-slate-200 dark:hover:border-slate-500'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Pelanggan Menunggu Persetujuan
                    @if(isset($pendingCustomers) && !empty($pendingCustomers) && count($pendingCustomers) > 0)
                        <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ count($pendingCustomers) }}</span>
                    @endif
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="p-2 sm:p-4">
            {{-- Panel Tabel Aktivitas Pesanan Terbaru --}}
            <div x-show="activeTab === 'orders'" class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-800">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">ID Pesanan</th>
                            <th class="px-4 py-2 text-left font-semibold">Pelanggan</th>
                            <th class="px-4 py-2 text-left font-semibold">Tanggal</th>
                            <th class="px-4 py-2 text-left font-semibold">Status</th>
                            <th class="px-4 py-2 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse ($recentOrders ?? [] as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50">
                            <td class="px-4 py-3 whitespace-nowrap font-medium text-slate-800 dark:text-slate-100">#{{ $order->id_transaction }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300">{{ $order->customer->name_store ?? 'Pelanggan Dihapus' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($order->date_transaction)->isoFormat('D MMM, HH:mm') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2.5 py-1 inline-flex items-center gap-1 text-xs font-semibold rounded-full
                                    {{ [
                                        'FINISH' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400',
                                        'PROCESS' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400',
                                        'WAITING_CONFIRMATION' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400',
                                        'SEND' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-400',
                                        'CANCEL' => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400',
                                    ][$order->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-500/20 dark:text-slate-300' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ [
                                        'FINISH' => 'bg-green-500',
                                        'PROCESS' => 'bg-blue-500',
                                        'WAITING_CONFIRMATION' => 'bg-yellow-500',
                                        'SEND' => 'bg-indigo-500',
                                        'CANCEL' => 'bg-red-500',
                                    ][$order->status] ?? 'bg-slate-500' }}"></span>
                                    {{ str_replace('_', ' ', ucwords(strtolower($order->status))) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                                <a href="#" class="font-medium text-primary hover:text-primary/80">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                                Tidak ada aktivitas pesanan terbaru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Panel Tabel Pelanggan Menunggu Persetujuan --}}
            <div x-show="activeTab === 'customers'" style="display: none;" class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-800">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">Nama Toko</th>
                            <th class="px-4 py-2 text-left font-semibold">Pemilik</th>
                            <th class="px-4 py-2 text-left font-semibold">Tanggal Daftar</th>
                            <th class="px-4 py-2 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
                         @forelse ($pendingCustomers ?? [] as $customer)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50">
                            <td class="px-4 py-3 whitespace-nowrap font-medium text-slate-800 dark:text-slate-100">{{ $customer->name_store }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300">{{ $customer->name_owner }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($customer->created)->isoFormat('D MMM YY') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                                <form action="{{ route('admin.customers.approve', $customer->id_customer) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="font-medium text-green-600 hover:text-green-500">Setujui</button>
                                </form>
                                <a href="{{ route('admin.customers.edit', $customer->id_customer) }}" class="ml-4 font-medium text-yellow-600 hover:text-yellow-500">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                                Tidak ada pelanggan menunggu persetujuan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const salesCtxDashboard = document.getElementById('salesChartDashboard');
        const salesChartData = {
            labels: @json($salesChartData['labels'] ?? []),
            data: @json($salesChartData['data'] ?? [])
        };

        if (salesCtxDashboard) {
            new Chart(salesCtxDashboard, {
                type: 'line',
                data: {
                    labels: salesChartData.labels,
                    datasets: [{
                        label: 'Penjualan',
                        data: salesChartData.data,
                        borderColor: '#B6172C',
                        backgroundColor: 'rgba(182, 23, 44, 0.1)',
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }
                            }
                        } 
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // Top Products Chart
        const topProductsCtxDashboard = document.getElementById('topProductsChartDashboard');
        const topProductsChartData = {
            labels: @json($topProductsChartData['labels'] ?? []),
            data: @json($topProductsChartData['data'] ?? [])
        };

        if (topProductsCtxDashboard) {
            new Chart(topProductsCtxDashboard, {
                type: 'doughnut',
                data: {
                    labels: topProductsChartData.labels,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: topProductsChartData.data,
                        backgroundColor: [
                            '#B6172C', '#d32f2f', '#f44336', '#ef5350', '#e57373'
                        ],
                        borderColor: document.documentElement.classList.contains('dark') ? '#1e293b' : '#fff',
                        borderWidth: 4,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    });
</script>
@endpush
