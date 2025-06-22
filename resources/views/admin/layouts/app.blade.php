<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Dashboard Admin') - KulakanCepat</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
      href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap"
      rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
      /* Menyembunyikan elemen yang belum diinisialisasi oleh Alpine.js untuk mencegah 'flickering' */
      [x-cloak] {
        display: none !important;
      }
    </style>
  </head>
  <body
    class="bg-slate-100 font-sans antialiased dark:bg-slate-900"
    x-data="{ sidebarOpen: false }"
    @keydown.escape.window="sidebarOpen = false">
    <div class="flex h-screen overflow-hidden">
      @include('admin.layouts.sidebar')
      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        @include('admin.layouts.header')

        <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
          @if (session('success'))
            <div
              class="mb-4 rounded-lg border border-green-200 bg-green-100 px-4 py-3 leading-normal text-green-800 dark:border-green-700 dark:bg-green-900/50 dark:text-green-100"
              role="alert">
              <div class="flex items-center gap-2">
                <svg
                  class="h-4 w-4 text-green-600 dark:text-green-400"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
              </div>
            </div>
          @endif

          @if (session('error'))
            <div
              class="mb-4 rounded-lg border border-red-200 bg-red-100 px-4 py-3 leading-normal text-red-800 dark:border-red-700 dark:bg-red-900/50 dark:text-red-100"
              role="alert">
              <div class="flex items-center gap-2">
                <svg
                  class="h-4 w-4 text-red-600 dark:text-red-400"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
              </div>
            </div>
          @endif

          @yield('content')
        </main>
      </div>
    </div>
    @stack('scripts')
  </body>
</html>
