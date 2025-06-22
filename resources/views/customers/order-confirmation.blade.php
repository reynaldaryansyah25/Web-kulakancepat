@extends('layouts.app')

@section('title', 'Pesanan Berhasil Dibuat')

@section('content')
  <main class="container mx-auto my-10 px-4">
    <div class="mx-auto max-w-2xl rounded-lg bg-white p-8 text-center shadow-md">
      <div
        class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
        <i class="fas fa-check-circle text-4xl text-green-500"></i>
      </div>
      <h2 class="text-2xl font-bold text-gray-800">Pesanan Anda Berhasil Dibuat!</h2>
      <p class="mt-2 text-gray-600">Terima kasih telah berbelanja di KulakanCepat.</p>

      <div class="mt-6 rounded-lg border bg-gray-50 p-4 text-left">
        <p class="text-sm text-gray-500">Nomor Invoice</p>
        <p class="text-lg font-bold text-red-700">
          #{{ $transaction->invoice_number ?? $transaction->id_transaction }}
        </p>
        <hr class="my-3" />
        <p class="text-sm text-gray-500">Total Pembayaran</p>
        <p class="text-lg font-bold">
          Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
        </p>
      </div>

      <div class="mt-6">
        <p class="text-sm text-gray-600">
          @if ($transaction->method_payment === 'cod')
            Silakan siapkan pembayaran saat kurir kami tiba.
          @else
              Silakan lakukan pembayaran sesuai dengan metode yang Anda pilih.
          @endif
        </p>
        <div class="mt-6 flex flex-col justify-center gap-4 sm:flex-row">
          {{-- Tombol untuk melihat detail pesanan --}}
          <a
            href="{{ route('order.show', $transaction->id_transaction) }}"
            class="w-full rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition-colors hover:bg-red-700 sm:w-auto">
            Lihat Detail Pesanan
          </a>
          <a
            href="{{ route('home') }}"
            class="w-full rounded-lg bg-gray-200 px-6 py-3 font-semibold text-gray-800 transition-colors hover:bg-gray-300 sm:w-auto">
            Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>
  </main>
@endsection
