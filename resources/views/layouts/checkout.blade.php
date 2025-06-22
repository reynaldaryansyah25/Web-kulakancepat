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

    @stack('styles')
  </head>
  <body class="bg-gray-100 font-sans text-gray-800">
    <!-- Header Minimalis untuk Checkout -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
          <!-- Logo -->
          <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-600">
              <i class="fas fa-store text-xl text-white"></i>
            </div>
            <div>
              <h1 class="text-xl font-bold text-red-700">KulakanCepat</h1>
            </div>
          </a>
          <a href="{{ route('cart.index') }}" class="text-sm text-red-600 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali ke Keranjang
          </a>
        </div>
      </div>
    </header>

    {{-- Konten Utama dari Halaman Checkout --}}
    <main>
      @yield('content')
    </main>

    {{-- Footer Sederhana --}}
    <footer class="py-6 text-center text-sm text-gray-500">
      &copy; {{ date('Y') }} KulakanCepat.
    </footer>

    @stack('scripts')
  </body>
</html>
