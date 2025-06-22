@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $transaction->id_transaction)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Detail Pesanan #{{ $transaction->id_transaction }}</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Tanggal: {{ \Carbon\Carbon::parse($transaction->date_transaction)->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                <span>Kembali ke Daftar Pesanan</span>
            </a>
        </div>
    </div>

    @if (session('success'))<div class="mb-6 px-4 py-3 leading-normal text-green-700 bg-green-100 dark:text-green-100 dark:bg-green-700/30 rounded-lg" role="alert"><p>{{ session('success') }}</p></div>@endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Item & Update Status --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Detail Item --}}
            <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Rincian Produk ({{ $transaction->details->count() }} item)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Produk</th>
                                <th class="px-6 py-3 text-center font-semibold">Jumlah</th>
                                <th class="px-6 py-3 text-right font-semibold">Harga Satuan</th>
                                <th class="px-6 py-3 text-right font-semibold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach ($transaction->details as $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><div class="flex items-center"><img src="{{ $detail->product->image_path ? Storage::url($detail->product->image_path) : 'https://placehold.co/40x40/E2E8F0/94A3B8?text=N/A' }}" alt="{{ $detail->product->name_product ?? '' }}" class="h-10 w-10 object-cover rounded-md mr-4"><div class="font-medium text-slate-800 dark:text-slate-100">{{ $detail->product->name_product ?? 'Produk Dihapus' }}</div></div></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-slate-600 dark:text-slate-300">{{ $detail->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-slate-600 dark:text-slate-300">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-medium text-slate-800 dark:text-slate-100">Rp {{ number_format($detail->quantity * $detail->unit_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                    <div class="text-right">
                        <p class="text-sm text-slate-600 dark:text-slate-300">Total Harga Barang: <span class="font-semibold text-slate-800 dark:text-slate-100">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span></p>
                        {{-- Tambahkan info ongkir, diskon, dll di sini jika ada --}}
                        <p class="text-lg font-bold text-slate-900 dark:text-white mt-1">Total Pembayaran: <span class="text-primary">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span></p>
                    </div>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl">
                 <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700"><h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Update Status Pesanan</h3></div>
                 <div class="p-6">
                     <form action="{{ route('admin.orders.updateStatus', $transaction->id_transaction) }}" method="POST">
                         @csrf
                         @method('PATCH')
                         <div class="flex items-end gap-4">
                             <div class="flex-grow">
                                <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pilih Status Baru</label>
                                <select name="status" id="status" class="w-full px-3 py-2 text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-primary/50 focus:border-primary/50">
                                    <option value="WAITING_CONFIRMATION" @if($transaction->status == 'WAITING_CONFIRMATION') selected @endif>Menunggu Konfirmasi</option>
                                    <option value="PROCESS" @if($transaction->status == 'PROCESS') selected @endif>Proses</option>
                                    <option value="SEND" @if($transaction->status == 'SEND') selected @endif>Dikirim</option>
                                    <option value="FINISH" @if($transaction->status == 'FINISH') selected @endif>Selesai</option>
                                    <option value="CANCEL" @if($transaction->status == 'CANCEL') selected @endif>Batal</option>
                                </select>
                             </div>
                             <button type="submit" class="inline-flex items-center justify-center h-9 gap-2 px-4 text-sm font-medium text-white bg-primary rounded-lg shadow-sm hover:bg-primary/90">Perbarui</button>
                         </div>
                     </form>
                 </div>
            </div>
        </div>
        
        {{-- Kolom Kanan: Info Pelanggan & Pengiriman --}}
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl p-6">
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-4">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Informasi Pelanggan</h3>
                </div>
                @if ($transaction->customer)
                    <dl class="text-sm">
                        <div class="flex justify-between py-1.5"><dt class="text-slate-500">Nama Toko:</dt><dd class="font-medium text-slate-800 dark:text-slate-100">{{ $transaction->customer->name_store }}</dd></div>
                        <div class="flex justify-between py-1.5"><dt class="text-slate-500">Nama Pemilik:</dt><dd class="font-medium text-slate-800 dark:text-slate-100">{{ $transaction->customer->name_owner }}</dd></div>
                        <div class="flex justify-between py-1.5"><dt class="text-slate-500">Email:</dt><dd class="font-medium text-slate-800 dark:text-slate-100">{{ $transaction->customer->email }}</dd></div>
                        <div class="flex justify-between py-1.5"><dt class="text-slate-500">Telepon:</dt><dd class="font-medium text-slate-800 dark:text-slate-100">{{ $transaction->customer->no_phone }}</dd></div>
                        <div class="flex justify-between py-1.5"><dt class="text-slate-500">Sales:</dt><dd class="font-medium text-slate-800 dark:text-slate-100">{{ $transaction->customer->salesPerson->name ?? '-' }}</dd></div>
                    </dl>
                @else
                    <p class="text-sm text-slate-500">Data pelanggan tidak tersedia atau telah dihapus.</p>
                @endif
            </div>

            <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl p-6">
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-4"><h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Alamat Pengiriman</h3></div>
                @if ($transaction->customer)
                    <address class="not-italic text-sm text-slate-600 dark:text-slate-300">
                        {{ $transaction->customer->name_owner }}<br>
                        {{ $transaction->customer->name_store }}<br>
                        {{ $transaction->customer->address }}
                    </address>
                @else
                    <p class="text-sm text-slate-500">Data alamat tidak tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
