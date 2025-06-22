@extends('admin.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Manajemen Pesanan</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Lacak dan kelola semua pesanan yang masuk.</p>
        </div>
        {{-- Tombol aksi bisa ditambahkan di sini jika perlu, misal 'Buat Pesanan Manual' --}}
    </div>

    {{-- Filter --}}
    <div class="mb-6 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl p-5">
        <form action="{{ route('admin.orders.index') }}" method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search_order" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Cari Pesanan</label>
                    <input type="text" name="search_order" id="search_order" value="{{ request('search_order') }}" class="w-full px-3 py-2 text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-primary/50 focus:border-primary/50" placeholder="ID Pesanan atau Nama Toko...">
                </div>
                <div>
                    <label for="order_status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status Pesanan</label>
                    <select id="order_status" name="order_status" class="w-full px-3 py-2 text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-primary/50 focus:border-primary/50">
                        <option value="">Semua Status</option>
                        <option value="WAITING_CONFIRMATION" {{ request('order_status') == 'WAITING_CONFIRMATION' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="PROCESS" {{ request('order_status') == 'PROCESS' ? 'selected' : '' }}>Proses</option>
                        <option value="SEND" {{ request('order_status') == 'SEND' ? 'selected' : '' }}>Dikirim</option>
                        <option value="FINISH" {{ request('order_status') == 'FINISH' ? 'selected' : '' }}>Selesai</option>
                        <option value="CANCEL" {{ request('order_status') == 'CANCEL' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                 <div>
                    <label for="start_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-primary/50 focus:border-primary/50">
                </div>
                <div class="flex items-end gap-2">
                    <div class="flex-grow">
                        <label for="end_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-primary/50 focus:border-primary/50">
                    </div>
                    <button type="submit" class="h-9 w-12 flex-shrink-0 inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg shadow-sm hover:bg-primary/90" title="Filter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="h-9 w-12 flex-shrink-0 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600" title="Reset Filter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 00-15.357-2m15.357 2H15" /></svg>
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if (session('success'))<div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 dark:text-green-100 dark:bg-green-700/30 rounded-lg" role="alert"><p>{{ session('success') }}</p></div>@endif
    
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-800">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold">ID Pesanan</th>
                        <th class="px-5 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-5 py-3 text-left font-semibold">Pelanggan</th>
                        <th class="px-5 py-3 text-right font-semibold">Total</th>
                        <th class="px-5 py-3 text-left font-semibold">Pembayaran</th>
                        <th class="px-5 py-3 text-left font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($transactions as $transaction)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap font-mono text-xs text-slate-600 dark:text-slate-300">#{{ $transaction->id_transaction }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($transaction->date_transaction)->isoFormat('D MMM YYYY, HH:mm') }}</td>
                        <td class="px-5 py-4 whitespace-nowrap"><div class="font-medium text-slate-800 dark:text-slate-100">{{ $transaction->customer->name_store ?? 'N/A' }}</div><div class="text-xs text-slate-500">{{ $transaction->customer->name_owner ?? '' }}</div></td>
                        <td class="px-5 py-4 whitespace-nowrap text-right font-semibold text-slate-800 dark:text-slate-100">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">{{ $transaction->method_payment }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 inline-flex items-center gap-1 text-xs font-semibold rounded-full {{ [ 'FINISH' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400', 'PROCESS' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400', 'WAITING_CONFIRMATION' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400', 'SEND' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-400', 'CANCEL' => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400' ][$transaction->status] ?? 'bg-slate-100 text-slate-800' }}">
                                {{ str_replace('_', ' ', ucwords(strtolower($transaction->status))) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-right text-sm">
                            <a href="{{ route('admin.orders.show', $transaction->id_transaction) }}" class="font-medium text-primary hover:text-primary/80">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500 dark:text-slate-400">Tidak ada data pesanan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if (isset($transactions) && $transactions->hasPages())
            <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">{{ $transactions->appends(request()->query())->links('vendor.pagination.tailwind') }}</div>
        @endif
    </div>
</div>
@endsection
