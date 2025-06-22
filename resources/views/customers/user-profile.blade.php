@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@push('styles')
  {{-- Menambahkan CSS untuk Leaflet Map --}}
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="" />
  <style>
    /* Style untuk menimpa beberapa style default Leaflet */
    #map {
      height: 300px;
      width: 100%;
      z-index: 1;
      position: relative;
    }
    .leaflet-pane,
    .leaflet-control,
    .leaflet-top,
    .leaflet-bottom {
      z-index: 10 !important;
    }
    .leaflet-control-zoom {
      z-index: 1000 !important;
    }
  </style>
@endpush

@section('content')
  <main
    class="container mx-auto my-10 px-4"
    x-data="{
      showAddressModal: false,
      isEditMode: false,
      addressData: {
        latitude: null,
        longitude: null,
        label: '',
        address: '',
        notes: '',
        recipient_name: '',
        phone: '',
      },
      activeTab: window.location.hash.substring(1) || 'biodata',
    }">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
      <aside class="md:col-span-1">
        <div class="sticky top-24 rounded-lg bg-white p-4 text-center shadow-sm">
          <img
            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://i.pravatar.cc/150?u=' . $user->id_customer }}"
            class="mx-auto mb-4 h-24 w-24 rounded-full border-4 border-white object-cover shadow-lg" />
          <h6 class="truncate text-lg font-bold">{{ $user->name_owner }}</h6>
          <p class="text-sm text-gray-500">{{ $user->name_store ?? 'Toko Retail' }}</p>
        </div>
        <div class="mt-6 rounded-lg bg-white p-4 text-left shadow-sm">
          <h4 class="mb-3 text-base font-bold text-gray-700">Info Kredit</h4>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-500">Tingkat Tier</span>

              @if ($user->tier)
                <span class="font-semibold text-red-600">{{ $user->tier->name }}</span>
              @else
                <span class="font-semibold text-gray-600">-</span>
              @endif
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Plafon Kredit</span>
              <span class="font-semibold text-gray-800">
                Rp {{ number_format($user->credit_limit ?? 0, 0, ',', '.') }}
              </span>
            </div>
          </div>
        </div>
      </aside>

      <div class="md:col-span-3">
        <div class="rounded-lg bg-white shadow-sm">
          <div class="border-b">
            <nav class="flex space-x-6 px-6" id="tab-nav">
              <button
                @click="activeTab = 'biodata'"
                :class="{'border-red-600 text-red-600': activeTab === 'biodata', 'border-transparent text-gray-500': activeTab !== 'biodata'}"
                class="tab-button border-b-2 px-1 py-4 font-semibold hover:text-red-600">
                Biodata Diri
              </button>
              <button
                @click="activeTab = 'alamat'"
                :class="{'border-red-600 text-red-600': activeTab === 'alamat', 'border-transparent text-gray-500': activeTab !== 'alamat'}"
                class="tab-button border-b-2 px-1 py-4 font-semibold hover:text-red-600">
                Daftar Alamat
              </button>
              <button
                @click="activeTab = 'pesanan'"
                :class="{'border-red-600 text-red-600': activeTab === 'pesanan', 'border-transparent text-gray-500': activeTab !== 'pesanan'}"
                class="tab-button border-b-2 px-1 py-4 font-semibold hover:text-red-600">
                Daftar Pesanan
              </button>
            </nav>
          </div>

          <div class="p-6">
            @if (session('success'))
              <div
                class="mb-6 rounded-r-lg border-l-4 border-green-500 bg-green-100 p-4 text-green-700"
                role="alert">
                <p>{{ session('success') }}</p>
              </div>
            @endif

            @if ($errors->any())
              <div
                class="mb-6 rounded-r-lg border-l-4 border-red-500 bg-red-100 p-4 text-red-700"
                role="alert">
                <p class="font-bold">Oops! Terjadi kesalahan:</p>
                <ul class="mt-2 list-inside list-disc">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div id="biodata" x-show="activeTab === 'biodata'">
              <h3 class="mb-6 text-lg font-bold text-gray-800">Ubah Biodata Diri</h3>
              <form
                action="{{ route('profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')
                <div class="flex items-center border-b pb-4">
                  <label class="w-1/4 font-medium text-gray-500">Nama</label>
                  <input
                    type="text"
                    name="name_owner"
                    class="w-2/4 border-0 focus:ring-0"
                    value="{{ old('name_owner', $user->name_owner) }}" />
                </div>
                <div class="flex items-center border-b pb-4">
                  <label class="w-1/4 font-medium text-gray-500">Nama Toko</label>
                  <input
                    type="text"
                    name="name_store"
                    class="w-2/4 border-0 focus:ring-0"
                    value="{{ old('name_store', $user->name_store) }}" />
                </div>
                <div class="flex items-center border-b pb-4">
                  <label class="w-1/4 font-medium text-gray-500">Email</label>
                  <span class="w-2/4 text-gray-700">{{ $user->email }}</span>
                </div>
                <div class="flex items-center border-b pb-4">
                  <label class="w-1/4 font-medium text-gray-500">Nomor HP</label>
                  <span class="w-2/4 text-gray-700">{{ $user->no_phone }}</span>
                  <span class="text-sm text-green-600">Terverifikasi</span>
                </div>
                <div class="flex items-start pb-4">
                  <label class="w-1/4 pt-2 font-medium text-gray-500">Foto Profil</label>
                  <input
                    type="file"
                    name="avatar"
                    class="text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-red-700 hover:file:bg-red-100" />
                </div>
                <div class="flex">
                  <div class="w-1/4"></div>
                  <button
                    type="submit"
                    class="rounded-lg bg-red-600 px-8 py-2 text-white transition-colors hover:bg-red-700">
                    Simpan
                  </button>
                </div>
              </form>
              <hr class="my-8" />

              <h3 class="mb-6 text-lg font-bold text-gray-800">Ubah Password</h3>
              <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="flex items-center">
                  <label for="current_password" class="w-1/4 font-medium text-gray-500">
                    Password Saat Ini
                  </label>
                  <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                    class="w-2/4 rounded-md border-gray-200 focus:border-red-500 focus:ring-red-500" />
                </div>
                <div class="flex items-center">
                  <label for="new_password" class="w-1/4 font-medium text-gray-500">
                    Password Baru
                  </label>
                  <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    required
                    class="w-2/4 rounded-md border-gray-200 focus:border-red-500 focus:ring-red-500" />
                </div>
                <div class="flex items-center">
                  <label for="new_password_confirmation" class="w-1/4 font-medium text-gray-500">
                    Konfirmasi Password
                  </label>
                  <input
                    type="password"
                    id="new_password_confirmation"
                    name="new_password_confirmation"
                    required
                    class="w-2/4 rounded-md border-gray-200 focus:border-red-500 focus:ring-red-500" />
                </div>
                <div class="flex">
                  <div class="w-1/4"></div>
                  <button
                    type="submit"
                    class="rounded-lg bg-red-600 px-8 py-2 text-white transition-colors hover:bg-red-700">
                    Ubah Password
                  </button>
                </div>
              </form>
            </div>

            <div id="alamat" x-show="activeTab === 'alamat'">
              <div class="mb-6 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Daftar Alamat</h3>
                <button
                  @click="isEditMode = false; addressData = {latitude: null, longitude: null, label: '', address: '', notes: '', recipient_name: '', phone: ''}; showAddressModal = true"
                  class="flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm text-white transition-colors hover:bg-red-700">
                  <i class="fas fa-plus-circle"></i>
                  <span>Tambah Alamat Baru</span>
                </button>
              </div>
              <div class="space-y-4">
                @if ($user->address)
                  <div class="rounded-lg border border-green-500 p-4 transition hover:shadow-md">
                    <div class="flex flex-col justify-between sm:flex-row sm:items-start">
                      <div>
                        <p class="font-bold">
                          Alamat Utama
                          <span
                            class="ml-2 rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">
                            Pendaftaran
                          </span>
                        </p>
                        <p class="mt-2 font-semibold">{{ $user->name_owner }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ $user->no_phone }}</p>
                        <p class="mt-2 text-sm text-gray-600">{{ $user->address }}</p>
                      </div>
                    </div>
                  </div>
                @endif

                @forelse ($addresses as $address)
                  <div
                    class="{{ session('selected_address_id') == $address->id_address ? 'border-2 border-red-500' : '' }} rounded-lg border p-4 transition hover:shadow-md">
                    <div class="flex flex-col justify-between sm:flex-row sm:items-start">
                      <div>
                        <p class="font-bold">
                          {{ $address->label }}
                          @if (session('selected_address_id') == $address->id_address)
                            <span
                              class="ml-2 rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">
                              Dipilih
                            </span>
                          @elseif ($address->is_primary)
                            <span
                              class="ml-2 rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">
                              Utama
                            </span>
                          @endif
                        </p>
                        <p class="mt-2 font-semibold">{{ $address->recipient_name }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ $address->phone }}</p>
                        <p class="mt-2 text-sm text-gray-600">{{ $address->address }}</p>
                      </div>
                      <div class="mt-4 flex space-x-4 sm:mt-0">
                        <button
                          @click="isEditMode = true; addressData = {{ json_encode($address) }}; showAddressModal = true"
                          class="text-sm font-semibold text-blue-600 hover:underline">
                          Ubah
                        </button>
                        <form
                          action="{{ route('address.destroy', $address->id_address) }}"
                          method="POST">
                          @csrf
                          @method('DELETE')
                          <button
                            type="submit"
                            onclick="return confirm('Anda yakin ingin menghapus alamat ini?')"
                            class="text-sm font-semibold text-red-600 hover:underline">
                            Hapus
                          </button>
                        </form>
                      </div>
                    </div>
                    @if (session('selected_address_id') != $address->id_address)
                      <div class="mt-4 border-t pt-4 text-right">
                        <form
                          action="{{ route('address.select', $address->id_address) }}"
                          method="POST">
                          @csrf
                          <button
                            type="submit"
                            class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                            Pilih Alamat Ini
                          </button>
                        </form>
                      </div>
                    @endif
                  </div>
                @empty
                  @if (! $user->address)
                    <div class="rounded-lg border-2 border-dashed py-10 text-center">
                      <i class="fas fa-map-marked-alt text-4xl text-gray-300"></i>
                      <p class="mt-4 text-gray-500">Anda belum menambahkan alamat.</p>
                    </div>
                  @endif
                @endforelse
              </div>
            </div>

            <div id="pesanan" x-show="activeTab === 'pesanan'">
              <h2 class="mb-4 text-xl font-bold">Riwayat Pesanan</h2>
              <div class="space-y-4">
                @forelse ($transactions as $transaction)
                  @php
                    $statusClass = match (strtolower($transaction->status)) {
                      'finish', 'selesai' => 'bg-green-500',
                      'shipping', 'dikirim' => 'bg-blue-500',
                      'pending', 'belum-bayar' => 'bg-yellow-500 text-gray-800',
                      default => 'bg-gray-500',
                    };
                  @endphp

                  <a
                    href="{{ route('order.show', $transaction->id_transaction) }}"
                    class="block rounded-lg border p-4 transition hover:border-red-500 hover:shadow-md">
                    <div class="flex items-start justify-between">
                      <div>
                        <p class="font-bold text-red-700">
                          Pesanan
                          #{{ $transaction->invoice_number ?? $transaction->id_transaction }}
                        </p>
                        <p class="text-sm text-gray-500">
                          {{ $transaction->date_transaction->format('d F Y, H:i') }}
                        </p>
                      </div>
                      <div class="text-right">
                        <p class="text-lg font-semibold">
                          Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </p>
                        <span
                          class="{{ $statusClass }} rounded-full px-2 py-1 text-xs font-semibold text-white">
                          {{ ucfirst(str_replace('_', ' ', strtolower($transaction->status))) }}
                        </span>
                      </div>
                    </div>
                  </a>
                @empty
                  <div class="py-10 text-center">
                    <i class="fas fa-box-open text-4xl text-gray-300"></i>
                    <p class="mt-4 text-gray-500">Anda belum memiliki riwayat pesanan.</p>
                  </div>
                @endforelse
              </div>
              <div class="mt-6">{{ $transactions->links() }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Tambah/Edit Alamat -->
    <div
      x-show="showAddressModal"
      x-cloak
      x-transition:enter="transition duration-300 ease-out"
      x-transition:enter-start="scale-90 opacity-0"
      x-transition:enter-end="scale-100 opacity-100"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
      @keydown.escape.window="showAddressModal = false">
      <div
        @click.away="showAddressModal = false"
        class="flex max-h-[90vh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-xl">
        <div class="flex items-center justify-between border-b p-4">
          <h3
            class="text-lg font-bold"
            x-text="isEditMode ? 'Ubah Alamat' : 'Tambah Alamat Baru'"></h3>
          <button
            @click="showAddressModal = false"
            class="text-2xl text-gray-400 hover:text-gray-600">
            &times;
          </button>
        </div>
        <div class="overflow-y-auto p-6">
          <form
            id="address-form"
            :action="isEditMode ? `/address/${addressData.id_address}` : '{{ route('address.store') }}'"
            method="POST"
            class="space-y-6">
            @csrf
            <template x-if="isEditMode">@method('PUT')</template>
            <div>
              <label class="mb-2 block font-semibold text-gray-700">Pinpoint Lokasi</label>
              <div id="map"></div>
              <input type="hidden" name="latitude" x-model="addressData.latitude" />
              <input type="hidden" name="longitude" x-model="addressData.longitude" />
              <p class="mt-2 text-xs text-gray-500">
                Klik pada peta atau geser marker untuk menentukan lokasi Anda.
              </p>
            </div>
            <div>
              <label for="address_label" class="mb-2 block font-semibold text-gray-700">
                Label Alamat
              </label>
              <input
                type="text"
                id="address_label"
                name="label"
                x-model="addressData.label"
                placeholder="Contoh: Rumah, Kantor, Toko"
                class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                required />
            </div>
            <div>
              <label for="address_full" class="mb-2 block font-semibold text-gray-700">
                Alamat Lengkap
              </label>
              <textarea
                id="address_full"
                name="address"
                x-model="addressData.address"
                rows="4"
                placeholder="Masukkan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                required></textarea>
            </div>
            <div>
              <label for="address_notes" class="mb-2 block font-semibold text-gray-700">
                Catatan untuk Kurir (Opsional)
              </label>
              <input
                type="text"
                id="address_notes"
                name="notes"
                x-model="addressData.notes"
                placeholder="Contoh: Warna rumah, patokan, dll."
                class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" />
            </div>
            <hr />
            <div>
              <label for="recipient_name" class="mb-2 block font-semibold text-gray-700">
                Nama Penerima
              </label>
              <input
                type="text"
                id="recipient_name"
                name="recipient_name"
                x-model="addressData.recipient_name"
                class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                required />
            </div>
            <div>
              <label for="phone" class="mb-2 block font-semibold text-gray-700">Nomor HP</label>
              <input
                type="tel"
                id="phone"
                name="phone"
                x-model="addressData.phone"
                class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                required />
            </div>
          </form>
        </div>
        <div class="flex justify-end border-t bg-gray-50 p-4">
          <button
            @click="showAddressModal = false"
            type="button"
            class="mr-2 rounded-lg border bg-white px-6 py-2 hover:bg-gray-100">
            Batal
          </button>
          <button
            type="submit"
            form="address-form"
            class="rounded-lg bg-red-600 px-8 py-2 text-white hover:bg-red-700">
            Simpan
          </button>
        </div>
      </div>
    </div>
  </main>
@endsection

@push('scripts')
  <script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
  <script>
    let map = null
    let marker = null
    const defaultLat = -7.7956 // Jakarta
    const defaultLng = 110.3695 // Jakarta

    // Fungsi untuk menginisialisasi peta
    function initializeMap() {
      // Destroy map yang ada jika ada
      if (map) {
        map.remove()
        map = null
        marker = null
      }

      // Tunggu sampai element map tersedia di DOM
      const mapElement = document.getElementById('map')
      if (!mapElement) return

      // Set koordinat default atau dari data yang ada
      const lat = window.Alpine.store
        ? window.Alpine.store.addressData?.latitude || defaultLat
        : defaultLat
      const lng = window.Alpine.store
        ? window.Alpine.store.addressData?.longitude || defaultLng
        : defaultLng

      // Buat peta baru
      map = L.map('map').setView([lat, lng], 15)

      // Tambahkan tile layer
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors',
      }).addTo(map)

      // Tambahkan marker yang bisa di-drag
      marker = L.marker([lat, lng], {
        draggable: true,
      }).addTo(map)

      // Event ketika marker di-drag
      marker.on('dragend', function (event) {
        const position = marker.getLatLng()
        updateCoordinates(position.lat, position.lng)
      })

      // Event ketika peta di-klik
      map.on('click', function (e) {
        const lat = e.latlng.lat
        const lng = e.latlng.lng
        marker.setLatLng([lat, lng])
        updateCoordinates(lat, lng)
      })

      // Invalidate size setelah peta dimuat
      setTimeout(() => {
        if (map) {
          map.invalidateSize()
        }
      }, 100)
    }

    // Fungsi untuk update koordinat
    function updateCoordinates(lat, lng) {
      // Update Alpine.js data
      const mainElement = document.querySelector('main')
      if (mainElement && mainElement._x_dataStack) {
        const alpineData = mainElement._x_dataStack[0]
        if (alpineData.addressData) {
          alpineData.addressData.latitude = lat
          alpineData.addressData.longitude = lng
        }
      }
    }

    // Event listener ketika DOM sudah siap
    document.addEventListener('DOMContentLoaded', function () {
      // Observer untuk memantau perubahan modal
      const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
          const target = mutation.target

          // Cek jika modal sedang ditampilkan
          if (target.style && target.style.display !== 'none' && target.querySelector('#map')) {
            setTimeout(() => {
              initializeMap()
            }, 100)
          }
        })
      })

      // Pantau element modal
      const modalElement = document.querySelector('[x-show="showAddressModal"]')
      if (modalElement) {
        observer.observe(modalElement, {
          attributes: true,
          attributeFilter: ['style'],
        })
      }
    })

    // Event listener untuk Alpine.js
    document.addEventListener('alpine:init', () => {
      // Event ketika modal address dibuka
      window.addEventListener('address-modal-opened', () => {
        setTimeout(() => {
          initializeMap()
        }, 200)
      })
    })
  </script>
@endpush
