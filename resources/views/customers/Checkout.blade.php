@extends('layouts.checkout')
{{-- Pastikan layout ini ada dan sudah memuat Tailwind CSS, Alpine.js, dan Font Awesome --}}

@section('title', 'Checkout')

@section('content')
  <main
    class="container mx-auto my-6 px-4"
    x-data="{
      showAddressModal: false,
      selectedPayment: '{{ old('payment_method', 'cod') }}',
    }">
    {{-- ====================================================== --}}
    {{-- == BAGIAN UNTUK MENAMPILKAN ERROR ATAU NOTIFIKASI == --}}
    {{-- ====================================================== --}}
    @if (session('error'))
      <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700" role="alert">
        <span class="font-bold">Terjadi Kesalahan!</span>
        {{ session('error') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700">
        <span class="font-bold">Harap perbaiki kesalahan berikut:</span>
        <ul class="mt-1 list-inside list-disc">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Form utama yang akan di-submit --}}
    <form action="{{ route('checkout.store') }}" method="POST">
      @csrf
      <div class="flex flex-col gap-8 lg:flex-row">
        <!-- =================================================== -->
        <!-- == KOLOM KIRI: Alamat & Daftar Produk           == -->
        <!-- =================================================== -->
        <div class="w-full space-y-6 lg:w-2/3">
          <!-- Alamat Pengiriman -->
          <div class="rounded-lg border bg-white p-6">
            <div class="mb-4 flex items-center justify-between border-b pb-4">
              <h4 class="font-bold text-gray-800">ALAMAT PENGIRIMAN</h4>
              <button
                type="button"
                @click="showAddressModal = true"
                class="text-sm font-semibold text-red-600 hover:underline">
                Pilih Alamat Lain
              </button>
            </div>

            {{-- PERBAIKAN: Input 'address_id' dipindah ke luar @if agar selalu ada --}}
            <input
              type="hidden"
              name="address_id"
              value="{{ $selectedAddress->id_address ?? '' }}" />

            @if ($selectedAddress)
              <div class="flex items-start space-x-4">
                <i class="fas fa-map-marker-alt mt-1 text-red-700"></i>
                <div>
                  <p class="font-bold">
                    {{ $selectedAddress->recipient_name }} ({{ $selectedAddress->label }})
                  </p>
                  <p class="text-sm text-gray-600">{{ $selectedAddress->phone }}</p>
                  <p class="mt-1 text-sm text-gray-600">
                    {{ $selectedAddress->full_address ?? $selectedAddress->address }}
                  </p>
                  @if ($selectedAddress->notes)
                    <p class="mt-1 text-xs text-gray-500">
                      <b>Catatan:</b>
                      {{ $selectedAddress->notes }}
                    </p>
                  @endif
                </div>
              </div>
            @else
              <div class="text-center text-red-500">
                <p>Alamat belum dipilih atau tidak valid.</p>
                <p class="text-sm">Silakan pilih dari modal atau tambah alamat baru.</p>
              </div>
            @endif
          </div>

          <!-- Daftar Produk Pesanan -->
          <div class="rounded-lg border bg-white p-6">
            <h4 class="mb-4 border-b pb-4 font-bold">PRODUK PESANAN</h4>
            @php
              $totalItemPrice = 0;
            @endphp

            @forelse ($cartItems as $item)
              <div class="mb-4 flex items-center last:mb-0">
                <img
                  src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://placehold.co/100x100/e2e8f0/94a3b8?text=Gambar' }}"
                  alt="{{ $item['name'] }}"
                  class="mr-4 h-16 w-16 rounded object-cover" />
                <div class="flex-1">
                  <p class="font-bold">{{ $item['name'] }}</p>
                  <p class="text-sm text-gray-600">{{ $item['description'] }}</p>
                </div>
                <div class="text-right">
                  <p class="font-bold">
                    Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                  </p>
                  <p class="text-sm text-gray-600">
                    {{ $item['quantity'] }} barang x
                    Rp{{ number_format($item['price'], 0, ',', '.') }}
                  </p>
                </div>
              </div>
              @php
                $totalItemPrice += $item['price'] * $item['quantity'];
              @endphp
            @empty
              <p class="text-center text-gray-500">Keranjang belanja Anda kosong.</p>
            @endforelse
          </div>
        </div>

        <!-- =================================================== -->
        <!-- == KOLOM KANAN: Pembayaran & Ringkasan          == -->
        <!-- =================================================== -->
        <aside class="w-full space-y-6 lg:w-1/3">
          <div class="sticky top-24 rounded-lg border bg-white p-6">
            <h4 class="mb-4 border-b pb-4 font-bold">PILIH PEMBAYARAN</h4>
            <div class="space-y-3">
              <label
                @click="selectedPayment = 'cod'"
                class="payment-option flex cursor-pointer items-center rounded-lg border p-3"
                :class="{'bg-red-50 border-red-500': selectedPayment === 'cod'}">
                <i class="fas fa-handshake w-10 text-center text-xl text-red-600"></i>
                <div class="flex-1"><p class="font-bold">Bayar di Tempat (COD)</p></div>
                <input
                  type="radio"
                  name="payment_method"
                  value="cod"
                  x-model="selectedPayment"
                  class="h-4 w-4 accent-red-600" />
              </label>
              <label
                @click="selectedPayment = 'kredit_toko'"
                class="payment-option flex cursor-pointer items-center rounded-lg border p-3"
                :class="{'bg-red-50 border-red-500': selectedPayment === 'kredit_toko'}">
                <i class="fas fa-wallet w-10 text-center text-xl text-red-600"></i>
                <div class="flex-1">
                  <p class="font-bold">Gunakan Kredit Toko</p>
                  <p class="text-xs text-gray-500">
                    Sisa Limit:
                    Rp{{ number_format(Auth::guard('customer')->user()->credit_limit, 0, ',', '.') }}
                  </p>
                </div>
                <input
                  type="radio"
                  name="payment_method"
                  value="kredit_toko"
                  x-model="selectedPayment"
                  class="h-4 w-4 accent-red-600" />
              </label>
            </div>
            <hr class="my-6" />
            <h4 class="mb-4 font-bold">Ringkasan Belanja</h4>
            <div class="mb-2 flex justify-between text-gray-600">
              <span>Total Harga ({{ count($cartItems) }} Barang)</span>
              <span>Rp{{ number_format($totalItemPrice, 0, ',', '.') }}</span>
            </div>
            <div class="mb-2 flex justify-between text-gray-600">
              <span>Biaya Pengiriman</span>
              <span>Rp{{ number_format(0, 0, ',', '.') }}</span>
            </div>
            <hr class="my-2" />
            <div class="flex justify-between text-lg font-bold">
              <span>Total Tagihan</span>
              <span>Rp{{ number_format($totalItemPrice, 0, ',', '.') }}</span>
            </div>
            <button
              type="submit"
              class="mt-4 w-full rounded-lg bg-red-700 py-3 font-bold text-white transition-colors hover:bg-red-800 disabled:cursor-not-allowed disabled:opacity-50"
              :disabled="!{{ $selectedAddress ? 'true' : 'false' }} || {{ empty($cartItems) ? 'true' : 'false' }}">
              <i class="fas fa-shield-alt mr-2"></i>
              Konfirmasi Pesanan
            </button>
          </div>
        </aside>
      </div>
    </form>

    <!-- =================================================== -->
    <!-- == MODAL POPUP UNTUK PILIH ALAMAT                 == -->
    <!-- =================================================== -->
    <div
      x-show="showAddressModal"
      style="display: none"
      x-transition
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
      @keydown.escape.window="showAddressModal = false">
      <div
        @click.away="showAddressModal = false"
        class="flex max-h-[90vh] w-full max-w-lg flex-col rounded-lg bg-white shadow-xl">
        <div class="flex items-center justify-between border-b p-4">
          <h3 class="text-lg font-bold">Pilih Alamat Pengiriman</h3>
          <button
            @click="showAddressModal = false"
            class="text-2xl text-gray-400 hover:text-gray-600">
            &times;
          </button>
        </div>
        <div class="space-y-4 overflow-y-auto p-6">
          @forelse ($allAddresses as $address)
            {{-- PERBAIKAN: Menggunakan id_address untuk perbandingan --}}
            <div
              class="{{ $selectedAddress && $selectedAddress->id_address == $address->id_address ? 'border-2 border-red-500 bg-red-50' : 'border' }} rounded-lg p-3 transition">
              <p class="font-bold">{{ $address->label }}</p>
              <p class="mt-1 font-semibold">{{ $address->recipient_name }}</p>
              <p class="text-sm text-gray-600">{{ $address->phone }}</p>
              <p class="mt-1 text-sm text-gray-600">
                {{ $address->full_address ?? $address->address }}
              </p>
              <div class="mt-2 text-right">
                @if ($selectedAddress && $selectedAddress->id_address == $address->id_address)
                  <span class="rounded-md bg-red-100 px-3 py-1 text-sm font-semibold text-red-600">
                    Alamat Dipilih
                  </span>
                @else
                  {{-- PERBAIKAN: Mengirim id_address pada route --}}
                  <form
                    action="{{ route('address.select', ['address' => $address->id_address]) }}"
                    method="POST">
                    @csrf
                    <button
                      type="submit"
                      class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                      Pilih Alamat Ini
                    </button>
                  </form>
                @endif
              </div>
            </div>
          @empty
            <p class="text-center text-gray-500">Tidak ada alamat tersimpan.</p>
          @endforelse
          <a
            href="{{ route('profile.show') }}#address-section"
            class="mt-4 block w-full rounded-lg border-2 border-dashed py-3 text-center font-semibold text-red-600 hover:bg-red-50">
            + Tambah Alamat Baru
          </a>
        </div>
      </div>
    </div>
  </main>
@endsection

@push('scripts')
  <script>
    // PERBAIKAN: Script JS yang tidak perlu dan menyebabkan error sudah dihapus.
    // Kode ini hanya untuk menangani highlight pada metode pembayaran.
    document.addEventListener('DOMContentLoaded', function () {
      // Fungsi ini dijalankan saat halaman sudah siap
      function highlightPayment() {
        const checkedRadio = document.querySelector('input[name="payment_method"]:checked')
        if (checkedRadio) {
          // Hapus highlight dari semua pilihan dulu
          document.querySelectorAll('.payment-option').forEach((opt) => {
            opt.classList.remove('bg-red-50', 'border-red-500')
          })
          // Tambahkan highlight ke pilihan yang aktif
          checkedRadio.closest('.payment-option').classList.add('bg-red-50', 'border-red-500')
        }
      }

      // Jalankan saat pertama kali load
      highlightPayment()

      // Tambahkan listener ke semua pilihan pembayaran
      document.querySelectorAll('.payment-option').forEach((option) => {
        option.addEventListener('click', function () {
          this.querySelector('input[type="radio"]').checked = true
          highlightPayment()
        })
      })
    })
  </script>
@endpush
