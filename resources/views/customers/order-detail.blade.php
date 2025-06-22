@extends("layouts.app")

@section("title", "Detail Pesanan #" . ($transaction->invoice_number ?? $transaction->id_transaction))

@section("content")
  <main class="container mx-auto my-10 px-4">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
        <p class="text-sm text-gray-500">Lihat rincian lengkap dari transaksi Anda.</p>
      </div>
      <a
        href="{{ route("profile.show", ["#pesanan"]) }}"
        class="text-sm text-red-600 hover:underline">
        <i class="fas fa-arrow-left mr-1"></i>
        Kembali ke Riwayat Pesanan
      </a>
    </div>

    <div class="rounded-lg bg-white p-6 shadow-md">
      <!-- Header Detail Pesanan -->
      <div class="mb-6 flex flex-col justify-between border-b pb-4 sm:flex-row sm:items-center">
        <div>
          <p class="text-sm text-gray-500">Nomor Invoice</p>
          <p class="text-lg font-bold text-red-700">
            #{{ $transaction->invoice_number ?? $transaction->id_transaction }}
          </p>
        </div>
        <div class="mt-4 text-left sm:mt-0 sm:text-right">
          <p class="text-sm text-gray-500">Tanggal Pemesanan</p>
          <p class="font-semibold">{{ $transaction->date_transaction->format("d F Y, H:i") }}</p>
        </div>
        <div class="mt-4 text-left sm:mt-0 sm:text-right">
          <p class="text-sm text-gray-500">Status</p>
          <span
            class="@if ($transaction->status == "selesai" || $transaction->status == "FINISH")
                bg-green-500
            @elseif ($transaction->status == "dibatalkan")
                bg-red-500
            @elseif ($transaction->status == "dikirim" || $transaction->status == "SHIPPING")
                bg-blue-500
            @else
                bg-yellow-500
                text-gray-800
            @endif rounded-full px-3 py-1 text-sm font-semibold text-white">
            {{ ucfirst(str_replace("_", " ", strtolower($transaction->status))) }}
          </span>
        </div>
      </div>

      <!-- Detail Pengiriman & Produk -->
      <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <h3 class="mb-4 font-bold text-gray-800">Produk yang Dipesan</h3>
          <div class="space-y-4">
            @foreach ($transaction->details as $detail)
              <div class="flex items-center">
                <img
                  src="{{ $detail->product->image_path ? asset("storage/" . $detail->product->image_path) : "https://placehold.co/100x100/e2e8f0/94a3b8?text=Gambar" }}"
                  alt="{{ $detail->product->name_product }}"
                  class="mr-4 h-16 w-16 rounded-lg border object-cover" />
                <div class="flex-grow">
                  <p class="font-semibold text-gray-800">{{ $detail->product->name_product }}</p>
                  <p class="text-sm text-gray-500">
                    {{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ",", ".") }}
                  </p>
                </div>
                <p class="font-semibold text-gray-800">
                  Rp {{ number_format($detail->quantity * $detail->price, 0, ",", ".") }}
                </p>
              </div>
            @endforeach
          </div>
        </div>

        <div class="lg:col-span-1">
          <div class="rounded-lg border bg-gray-50 p-4">
            <h3 class="mb-4 font-bold text-gray-800">Info Pengiriman</h3>
            @php
              // Alamat disimpan sebagai JSON, jadi kita perlu decode
              $shippingAddress = json_decode($transaction->shipping_address);
            @endphp

            <p class="font-semibold">{{ $shippingAddress->recipient_name ?? "N/A" }}</p>
            <p class="text-sm text-gray-600">{{ $shippingAddress->phone ?? "N/A" }}</p>
            <p class="mt-2 text-sm text-gray-600">{{ $shippingAddress->address ?? "N/A" }}</p>
          </div>

          <div class="mt-6 border-t pt-6">
            <h3 class="mb-4 font-bold text-gray-800">Rincian Pembayaran</h3>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-600">Metode Pembayaran</span>
                <span class="font-semibold">
                  {{ strtoupper(str_replace("_", " ", $transaction->method_payment)) }}
                </span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600">Subtotal Produk</span>
                <span class="font-semibold">
                  Rp {{ number_format($transaction->total_price, 0, ",", ".") }}
                </span>
              </div>
              {{-- Anda bisa menambahkan rincian lain seperti ongkir atau asuransi jika ada --}}
              <div class="mt-2 flex justify-between border-t pt-2 text-lg font-bold">
                <span>Total</span>
                <span class="text-red-700">
                  Rp {{ number_format($transaction->total_price, 0, ",", ".") }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
