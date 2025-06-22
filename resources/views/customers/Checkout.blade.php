@extends('layouts.checkout')
{{-- Menggunakan layout checkout yang baru --}}

@section('title', 'Checkout')

@section('content')
  <main class="container mx-auto my-6 px-4" x-data="{ showAddressModal: false }">
    <form action="{{ route('checkout.process') }}" method="POST">
      @csrf
      <div class="flex flex-col gap-8 lg:flex-row">
        <!-- Kolom Kiri: Detail Pesanan -->
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
            <div class="flex items-start space-x-4">
              <i class="fas fa-map-marker-alt mt-1 text-red-700"></i>
              <div>
                <p class="font-bold">
                  {{ $selectedAddress->recipient_name }} ({{ $selectedAddress->label }})
                </p>
                <p class="text-sm text-gray-600">{{ $selectedAddress->phone }}</p>
                <p class="mt-1 text-sm text-gray-600">{{ $selectedAddress->address }}</p>
                @if ($selectedAddress->notes)
                  <p class="mt-1 text-xs text-gray-500">
                    <b>Catatan:</b>
                    {{ $selectedAddress->notes }}
                  </p>
                @endif

                <input
                  type="hidden"
                  name="address_id"
                  value="{{ $selectedAddress->id_address ?? '' }}" />
              </div>
            </div>
          </div>

          <!-- Daftar Produk Pesanan -->
          <div class="rounded-lg border bg-white p-6">
            <h4 class="mb-4 border-b pb-4 font-bold">PRODUK PESANAN</h4>
            @php
              $totalItemPrice = 0;
            @endphp

            @forelse ($cartItems as $item)
              <div class="mb-4 flex items-center">
                <img
                  src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://placehold.co/100x100/e2e8f0/94a3b8?text=Gambar' }}"
                  alt="{{ $item['name'] }}"
                  class="mr-4 h-16 w-16 rounded object-cover" />
                <div class="flex-1">
                  <p class="font-bold">{{ $item['name'] }}</p>
                  <p class="text-sm text-gray-600">{{ $item['description'] }}</p>
                </div>
                <div class="text-right">
                  <p class="font-bold">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                  <p class="text-sm text-gray-600">{{ $item['quantity'] }} barang</p>
                </div>
              </div>
              @php
                $totalItemPrice += $item['price'] * $item['quantity'];
              @endphp
            @empty
              <p class="text-gray-500">Keranjang belanja Anda kosong.</p>
            @endforelse
          </div>
        </div>

        <!-- Kolom Kanan: Ringkasan & Pembayaran -->
        <aside class="w-full space-y-6 lg:w-1/3">
          <div class="sticky top-24 rounded-lg border bg-white p-6">
            <h4 class="mb-4 border-b pb-4 font-bold">PILIH PEMBAYARAN</h4>
            <div class="space-y-3">
              {{-- Opsi 1: Bayar di Tempat (COD) --}}
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
                  class="accent-red-700" />
              </label>
              {{-- Opsi 2: Kredit Toko --}}
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
                  class="accent-red-700" />
              </label>
            </div>
            <hr class="my-6" />
            <h4 class="mb-4 font-bold">Ringkasan Belanja</h4>
            <div class="mb-2 flex justify-between text-gray-600">
              <span>Total Harga ({{ count($cartItems) }} Barang)</span>
              <span id="summary-item-price" data-price="{{ $totalItemPrice }}">
                Rp{{ number_format($totalItemPrice, 0, ',', '.') }}
              </span>
            </div>
            <hr class="my-2" />
            <div class="flex justify-between text-lg font-bold">
              <span>Total Tagihan</span>
              <span id="summary-total-price" data-total="{{ $totalItemPrice }}">
                Rp{{ number_format($totalItemPrice, 0, ',', '.') }}
              </span>
            </div>
            <button
              type="submit"
              class="mt-4 w-full rounded-lg bg-red-700 py-3 font-bold text-white transition-colors hover:bg-red-800">
              <i class="fas fa-shield-alt mr-2"></i>
              Konfirmasi Pesanan
            </button>
          </div>
        </aside>
      </div>
    </form>

    <!-- Modal Popup untuk Pilih Alamat -->
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
            <div
              class="{{ $selectedAddress->id_address == $address->id_address ? 'border-2 border-red-500' : '' }} rounded-lg border p-3 transition">
              <p class="font-bold">{{ $address->label }}</p>
              <p class="mt-1 font-semibold">{{ $address->recipient_name }}</p>
              <p class="text-sm text-gray-600">{{ $address->phone }}</p>
              <p class="mt-1 text-sm text-gray-600">{{ $address->address }}</p>
              <div class="mt-2 text-right">
                @if ($selectedAddress->id_address == $address->id_address)
                  <span class="text-sm font-semibold text-red-600">Alamat Dipilih</span>
                @else
                  <form action="{{ route('address.select', $address->id_address) }}" method="POST">
                    @csrf
                    <button
                      type="submit"
                      class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                      Pilih
                    </button>
                  </form>
                @endif
              </div>
            </div>
          @empty
            <p class="text-center text-gray-500">Tidak ada alamat tersimpan.</p>
          @endforelse
          <a
            href="{{ route('profile.show', ['#alamat']) }}"
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
    document.addEventListener('DOMContentLoaded', function () {
      const insuranceCheckbox = document.getElementById('shippingInsurance')
      const summaryTotalPriceEl = document.getElementById('summary-total-price')
      const summaryInsurancePriceEl = document.getElementById('summary-insurance-price')

      const baseItemPrice = parseFloat(document.getElementById('summary-item-price').dataset.price)
      const insuranceCost = 300

      function calculateTotal() {
        const insurancePrice = insuranceCheckbox.checked ? insuranceCost : 0
        const totalPrice = baseItemPrice + insurancePrice

        summaryInsurancePriceEl.textContent = 'Rp' + insurancePrice.toLocaleString('id-ID')
        summaryTotalPriceEl.textContent = 'Rp' + totalPrice.toLocaleString('id-ID')
      }

      insuranceCheckbox.addEventListener('change', calculateTotal)

      document.querySelectorAll('.payment-option').forEach((option) => {
        option.addEventListener('click', function () {
          document
            .querySelectorAll('.payment-option')
            .forEach((opt) => opt.classList.remove('bg-red-50', 'border-red-500'))
          this.classList.add('bg-red-50', 'border-red-500')
          this.querySelector('input[type="radio"]').checked = true
        })
      })

      const checkedRadio = document.querySelector('input[name="payment_method"]:checked')
      if (checkedRadio) {
        checkedRadio.closest('.payment-option').classList.add('bg-red-50', 'border-red-500')
      }

      calculateTotal()
    })
  </script>
@endpush
