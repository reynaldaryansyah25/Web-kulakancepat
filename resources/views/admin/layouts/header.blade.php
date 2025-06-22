<header
  class="sticky top-0 z-30 border-b border-gray-200 bg-white/90 shadow-lg backdrop-blur-xl dark:border-gray-700 dark:bg-gray-900/90">
  <div class="relative px-4 sm:px-6 lg:px-8">
    <div class="flex h-20 items-center justify-between">
      <div class="flex items-center space-x-4">
        <button
          @click.stop="sidebarOpen = !sidebarOpen"
          class="rounded-xl bg-red-800 p-3 text-white shadow-lg transition-all duration-300 hover:scale-105 hover:bg-red-700 hover:shadow-xl active:scale-95 lg:hidden"
          :aria-expanded="sidebarOpen">
          <span class="sr-only">Buka sidebar</span>
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z" />
          </svg>
        </button>

        <div class="group flex items-center">
          <div class="ml-5 hidden sm:block"></div>
        </div>
      </div>

      {{-- Bagian kanan header --}}
      <div class="flex items-center space-x-3">
        {{-- Status & Jam (terlihat di layar medium ke atas) --}}
        <div class="hidden items-center space-x-6 md:flex">
          <div
            class="flex items-center space-x-2 rounded-full border border-green-200 bg-green-50 px-4 py-2 dark:border-green-800 dark:bg-green-900/20">
            <div class="h-2 w-2 animate-pulse rounded-full bg-green-500"></div>
            <span class="text-sm font-medium text-green-700 dark:text-green-400">Online</span>
          </div>
          <div
            class="rounded-full border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-600 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-400">
            <span id="current-time">--:--:--</span>
          </div>
        </div>

        {{-- Dropdown Notifikasi --}}
        <div class="relative" x-data="{ open: false }">
          <button
            @click="open = !open"
            @keydown.escape.window="open = false"
            class="group relative rounded-xl bg-gray-50 p-3 text-gray-600 shadow-md transition-all duration-300 hover:scale-105 hover:bg-red-100 hover:text-red-600 hover:shadow-lg active:scale-95 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-red-900/30 dark:hover:text-red-400">
            <span class="sr-only">Lihat notifikasi</span>
            <svg id="notification-bell" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
            </svg>
            <div
              class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full border-2 border-white bg-red-500 dark:border-gray-900">
              <span class="text-xs font-bold text-white">3</span>
            </div>
          </button>

          <div
            x-show="open"
            @click.away="open = false"
            x-cloak
            class="absolute right-0 z-20 mt-3 w-80 origin-top-right overflow-hidden rounded-2xl border border-gray-200/50 bg-white/95 shadow-2xl backdrop-blur-xl dark:border-gray-700/50 dark:bg-gray-800/95"
            x-transition:enter="transition duration-200 ease-out"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition duration-150 ease-in"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0">
            <div
              class="border-b border-gray-200 bg-gradient-to-r from-red-50 to-red-100 px-6 py-4 dark:border-gray-700 dark:from-red-900/50 dark:to-red-800/50">
              <span class="text-lg font-bold text-gray-800 dark:text-gray-200">Notifikasi</span>
              <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">3 notifikasi baru</p>
            </div>
            <ul class="max-h-80 divide-y divide-gray-200 overflow-y-auto dark:divide-gray-700">
              <li
                class="cursor-pointer p-4 transition-colors duration-200 hover:bg-red-50 dark:hover:bg-red-900/20">
                <div class="flex items-start space-x-3">
                  <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-500">
                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                      Pesanan baru #12345 telah diterima.
                    </p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">5 menit lalu</p>
                  </div>
                </div>
              </li>
              <li
                class="cursor-pointer p-4 transition-colors duration-200 hover:bg-red-50 dark:hover:bg-red-900/20">
                <div class="flex items-start space-x-3">
                  <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-500">
                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                      Stok produk hampir habis: Teh Botol Sosro.
                    </p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">1 jam lalu</p>
                  </div>
                </div>
              </li>
            </ul>
            <div
              class="border-t border-gray-200 bg-gray-50 px-6 py-3 text-center dark:border-gray-700 dark:bg-gray-700/50">
              <a
                href="#"
                class="text-sm font-medium text-red-600 hover:underline dark:text-red-400">
                Lihat semua notifikasi
              </a>
            </div>
          </div>
        </div>

        {{-- Dropdown Profil Pengguna --}}
        <div class="relative" x-data="{ open: false }">
          <button
            @click="open = !open"
            @keydown.escape.window="open = false"
            class="group flex items-center space-x-2 rounded-xl p-2 transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-700">
            <div class="relative">
              <img
                class="h-10 w-10 rounded-full border-2 border-white shadow-md transition-colors duration-300 group-hover:border-red-800 dark:border-red-900"
                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name ?? 'A') }}&background=B91C1C&color=FFFFFF&bold=true"
                alt="User profile" />
              <div
                class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500 dark:border-red-900"></div>
            </div>
            <div class="hidden text-left md:block">
              <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400">Super Admin</p>
            </div>
          </button>

          <div
            x-show="open"
            @click.away="open = false"
            x-cloak
            class="absolute right-0 z-20 mt-3 w-56 origin-top-right overflow-hidden rounded-2xl border border-gray-200/50 bg-white/95 shadow-2xl backdrop-blur-xl dark:border-gray-700/50 dark:bg-gray-800/95">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
              <div class="flex items-center space-x-4">
                <img
                  class="h-12 w-12 rounded-full border-2 border-white shadow-md dark:border-red-900"
                  src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name ?? 'A') }}&background=B91C1C&color=FFFFFF&bold=true"
                  alt="User profile" />
                <div>
                  <p class="font-medium text-gray-900 dark:text-gray-100">
                    {{ Auth::guard('admin')->user()->name ?? 'Admin Kulakan' }}
                  </p>
                  <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ Auth::guard('admin')->user()->email ?? 'admin@kulakancepat.com' }}
                  </p>
                </div>
              </div>
            </div>
            <ul class="py-2">
              <li>
                <a
                  href="{{ route('admin.settings.index') }}"
                  class="block px-6 py-3 text-sm text-gray-700 transition-colors duration-200 hover:bg-red-50 dark:text-gray-300 dark:hover:bg-red-900/20">
                  <div class="flex items-center space-x-3">
                    <svg
                      class="h-5 w-5 text-gray-500 dark:text-gray-400"
                      fill="currentColor"
                      viewBox="0 0 20 20">
                      <path
                        fill-rule="evenodd"
                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                        clip-rule="evenodd" />
                    </svg>
                    <span>Pengaturan</span>
                  </div>
                </a>
              </li>
              <li class="border-t border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('admin.logout') }}">
                  @csrf
                  <button
                    type="submit"
                    class="block w-full px-6 py-3 text-left text-sm text-red-600 transition-colors duration-200 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">
                    <div class="flex items-center space-x-3">
                      <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                          fill-rule="evenodd"
                          d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                          clip-rule="evenodd" />
                      </svg>
                      <span>Keluar</span>
                    </div>
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<script>
  // Script untuk jam. Bisa juga dipindahkan ke resources/js/app.js untuk kerapian.
  function updateTime() {
    const timeEl = document.getElementById('current-time')
    if (timeEl) {
      timeEl.textContent = new Date().toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
      })
    }
  }
  setInterval(updateTime, 1000)
  updateTime()
</script>
