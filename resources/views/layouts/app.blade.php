<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'KulakanCepat')</title>

    {{-- Aset Global --}}
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Style kustom --}}
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
      body {
        font-family: 'Inter', sans-serif;
      }
      .gradient-bg {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
      }
      .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border-left-color: #fff;
        animation: spin 1s ease infinite;
      }
      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
    </style>

    @stack('styles')
  </head>
  <body class="bg-gray-100 text-gray-800">
    <!-- Header Terpadu -->
    <header class="sticky top-0 z-50 bg-white text-gray-800 shadow-lg">
      <!-- Top Bar -->
      <div class="gradient-bg text-xs text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-1 sm:px-6 lg:px-8">
          <div class="flex items-center space-x-4">
            <span>Ikuti kami di:</span>
            <a href="#" class="hover:text-red-200"><i class="fab fa-facebook"></i></a>
            <a href="#" class="hover:text-red-200"><i class="fab fa-instagram"></i></a>
          </div>
          <div class="flex items-center space-x-4">
            <a href="#" class="hover:text-red-200">
              <i class="fas fa-bell mr-1"></i>
              Notifikasi
            </a>
          </div>
        </div>
      </div>

      <!-- Main Header -->
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
          <!-- Logo -->
          <!-- Logo -->
          <div class="flex-shrink-0">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
              <div class="h-12 w-12 overflow-hidden rounded-xl">
                <img
                  src="{{ asset('img/logo/Artboard 1 copy.png') }}"
                  alt="Logo KulakanCepat"
                  class="h-full w-full object-cover" />
              </div>
              <div>
                <h1 class="text-xl font-bold text-red-700">KulakanCepat</h1>
                <p class="text-xs text-gray-500">Grosir Digital</p>
              </div>
            </a>
          </div>

          <!-- Search Bar -->
          <div class="mx-8 hidden max-w-lg flex-1 md:flex">
            <form action="{{ route('catalog.index') }}" method="GET" class="relative w-full">
              <input
                name="search"
                type="text"
                placeholder="Cari di KulakanCepat"
                value="{{ request('search') }}"
                class="w-full rounded-full border-2 border-gray-200 bg-gray-100 py-3 pl-12 pr-4 text-gray-800 placeholder-gray-400 transition-all focus:border-transparent focus:outline-none focus:ring-2 focus:ring-red-500" />
              <button
                type="submit"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-600">
                <i class="fas fa-search"></i>
              </button>
            </form>
          </div>

          <!-- Navigation Icons & Profile -->
          <nav class="flex items-center space-x-6">
            <a
              href="{{ route('cart.index') }}"
              class="relative text-gray-600 transition-colors hover:text-red-700">
              <i class="fas fa-shopping-cart text-2xl"></i>
              @if (session('cart') && count(session('cart')) > 0)
                <span
                  class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white">
                  {{ count(session('cart')) }}
                </span>
              @endif
            </a>

            @auth('customer')
              <div x-data="{ open: false }" class="relative">
                <button
                  @click="open = !open"
                  class="flex cursor-pointer items-center space-x-2 rounded-full bg-gray-100 py-1 pl-1 pr-4 transition-colors hover:bg-gray-200 focus:outline-none">
                  <img
                    src="{{ Auth::guard('customer')->user()->profile_photo_path ? asset('storage/' . Auth::guard('customer')->user()->profile_photo_path) : 'https://i.pravatar.cc/40?u=' . Auth::guard('customer')->user()->email }}"
                    class="h-9 w-9 rounded-full object-cover" />
                  <span class="hidden text-sm font-medium lg:block">
                    {{ Str::words(Auth::guard('customer')->user()->name_owner, 2, '') }}
                  </span>
                </button>
                <div
                  x-show="open"
                  @click.away="open = false"
                  x-transition
                  class="absolute right-0 z-20 mt-2 w-56 rounded-xl bg-white py-2 text-sm text-gray-800 shadow-lg">
                  <div class="border-b px-4 py-3">
                    <p class="font-semibold">
                      Hi, {{ Auth::guard('customer')->user()->name_owner }}
                    </p>
                    <p class="text-xs text-gray-500">
                      {{ Auth::guard('customer')->user()->email }}
                    </p>
                  </div>
                  <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">
                    Profil Saya
                  </a>
                  <a
                    href="{{ route('profile.show', ['status' => 'semua']) }}"
                    class="block px-4 py-2 hover:bg-gray-100">
                    Riwayat Pesanan
                  </a>
                  <a
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="block w-full px-4 py-2 text-left font-semibold text-red-600 hover:bg-red-50">
                    Logout
                  </a>
                  <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    class="hidden">
                    @csrf
                  </form>
                </div>
              </div>
            @else
              <a
                href="{{ route('login') }}"
                class="text-sm font-medium text-gray-600 transition-colors hover:text-red-700">
                Login
              </a>
              <a
                href="{{ route('register') }}"
                class="rounded-full bg-red-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700">
                Daftar
              </a>
            @endauth
          </nav>
        </div>
      </div>
    </header>

    {{-- Konten Utama dari Halaman Anak --}}
    <main>
      @yield('content')
    </main>

    <!-- Footer Konsisten -->
    <footer class="bg-gray-900 py-16 text-white">
      <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="mb-8 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
          <!-- Company Info -->
          <div>
            <div class="mb-6 flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-lg">
                <img src="{{ asset('images/logo/Artboard 1 copy 3.png') }}" alt="" />
              </div>
              <span class="text-xl font-bold">KulakanCepat</span>
            </div>
            <p class="mb-4 text-gray-400">
              Platform grosir digital terdepan yang menghubungkan merchant dengan toko retail di
              seluruh Indonesia.
            </p>
            <div class="flex space-x-4">
              <a
                href="#"
                class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 transition-colors hover:bg-red-700">
                <i class="fab fa-instagram"></i>
              </a>
              <a
                href="#"
                class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 transition-colors hover:bg-red-700">
                <i class="fab fa-facebook"></i>
              </a>
              <a
                href="#"
                class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 transition-colors hover:bg-red-700">
                <i class="fab fa-youtube"></i>
              </a>
              <a
                href="#"
                class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 transition-colors hover:bg-red-700">
                <i class="fab fa-linkedin"></i>
              </a>
            </div>
          </div>

          <!-- Products -->
          <div>
            <h3 class="mb-4 text-lg font-bold">Produk</h3>
            <ul class="space-y-2 text-gray-400">
              <li><a href="#" class="transition-colors hover:text-white">Untuk Merchant</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Untuk Toko</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Sistem Pembayaran</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Logistik</a></li>
            </ul>
          </div>

          <!-- Company -->
          <div>
            <h3 class="mb-4 text-lg font-bold">Perusahaan</h3>
            <ul class="space-y-2 text-gray-400">
              <li><a href="#" class="transition-colors hover:text-white">Tentang Kami</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Karir</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Blog</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Press Release</a></li>
            </ul>
          </div>

          <!-- Support -->
          <div>
            <h3 class="mb-4 text-lg font-bold">Dukungan</h3>
            <ul class="space-y-2 text-gray-400">
              <li><a href="#" class="transition-colors hover:text-white">Pusat Bantuan</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Syarat & Ketentuan</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Kebijakan Privasi</a></li>
              <li><a href="#" class="transition-colors hover:text-white">Kontak</a></li>
            </ul>
          </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
          <p>
            &copy; 2024 KulakanCepat. All rights reserved. | Designed with ❤️ for Indonesian UMKM
          </p>
        </div>
      </div>
    </footer>

    @stack('scripts')
  </body>
</html>
