<div
  x-show="sidebarOpen"
  class="fixed inset-0 z-40 bg-slate-900 bg-opacity-30 transition-opacity duration-200 lg:z-auto lg:hidden"
  @click="sidebarOpen = false"
  aria-hidden="true"
  x-cloak></div>
<aside
  id="sidebar"
  class="no-scrollbar absolute left-0 top-0 z-40 flex h-screen w-64 shrink-0 -translate-x-full transform flex-col overflow-y-auto border-r border-gray-800 bg-[#11101d] p-4 shadow-2xl transition-all duration-300 ease-in-out lg:static lg:left-auto lg:top-auto lg:translate-x-0"
  :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
  {{-- Logo Sidebar --}}
  <div class="mb-8 flex justify-center pr-3 sm:px-2">
    <a class="group flex items-center" href="{{ route('admin.dashboard') }}">
      <img
        src="{{ asset('img/Logo Kulakan/1x/Artboard 1 copy 3.png') }}"
        alt="Logo Kulakan"
        class="h-auto w-20 transition-transform duration-300 group-hover:scale-110" />
      <span class="ml-3 text-xl font-bold text-white lg:hidden xl:inline">Admin Kulakan</span>
    </a>
  </div>

  {{-- Menu Navigasi --}}
  <div class="space-y-2">
    @php
      $activeClass = 'bg-[#1d1b2e] text-white shadow-md';
      $inactiveClass = 'text-gray-300 hover:bg-[#1d1b2e] hover:text-white';
    @endphp

    {{-- Dashboard --}}
    <a
      href="{{ route('admin.dashboard') }}"
      class="{{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }} group flex items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
      <div
        class="{{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : 'group-hover:bg-white/10' }} rounded-lg p-2 transition-all duration-300">
        <svg
          class="h-5 w-5 shrink-0"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
      </div>
      <span class="ml-3 lg:hidden xl:inline">Dashboard</span>
    </a>

    {{-- Manajemen Pesanan --}}
    <a
      href="{{ route('admin.orders.index') }}"
      class="{{ request()->routeIs('admin.orders.*') ? $activeClass : $inactiveClass }} group flex items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
      <div
        class="{{ request()->routeIs('admin.orders.*') ? 'bg-white/10' : 'group-hover:bg-white/10' }} rounded-lg p-2 transition-all duration-300">
        <svg
          class="h-5 w-5 shrink-0"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
      </div>
      <span class="ml-3 lg:hidden xl:inline">Manajemen Pesanan</span>
    </a>

    {{-- Manajemen Produk --}}
    <a
      href="{{ route('admin.products.index') }}"
      class="{{ request()->routeIs('admin.products.*') ? $activeClass : $inactiveClass }} group flex items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
      <div
        class="{{ request()->routeIs('admin.products.*') ? 'bg-white/10' : 'group-hover:bg-white/10' }} rounded-lg p-2 transition-all duration-300">
        <svg
          class="h-5 w-5 shrink-0"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
      </div>
      <span class="ml-3 lg:hidden xl:inline">Manajemen Produk</span>
    </a>

    {{-- Manajemen Pelanggan --}}
    <a
      href="{{ route('admin.customers.index') }}"
      class="{{ request()->routeIs('admin.customers.*') ? $activeClass : $inactiveClass }} group flex items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
      <div
        class="{{ request()->routeIs('admin.customers.*') ? 'bg-white/10' : 'group-hover:bg-white/10' }} rounded-lg p-2 transition-all duration-300">
        <svg
          class="h-5 w-5 shrink-0"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      </div>
      <span class="ml-3 lg:hidden xl:inline">Manajemen Pelanggan</span>
    </a>

    {{-- Manajemen Tier Pelanggan --}}
    <a
      href="{{ route('admin.customer-tiers.index') }}"
      class="{{ request()->routeIs('admin.customer-tiers.*') ? $activeClass : $inactiveClass }} group flex items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
      <div
        class="{{ request()->routeIs('admin.customer-tiers.*') ? 'bg-white/10' : 'group-hover:bg-white/10' }} rounded-lg p-2 transition-all duration-300">
        <svg
          class="h-5 w-5 shrink-0"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
        </svg>
      </div>
      <span class="ml-3 lg:hidden xl:inline">Manajemen Tier</span>
    </a>

    {{-- Manajemen Sales --}}
    <a
      href="{{ route('admin.sales.index') }}"
      class="{{ request()->routeIs('admin.sales.*') ? $activeClass : $inactiveClass }} group flex items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
      <div
        class="{{ request()->routeIs('admin.sales.*') ? 'bg-white/10' : 'group-hover:bg-white/10' }} rounded-lg p-2 transition-all duration-300">
        <svg
          class="h-5 w-5 shrink-0"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </div>
      <span class="ml-3 lg:hidden xl:inline">Manajemen Sales</span>
    </a>

    {{-- Laporan & Analitik --}}
    <a
      href="{{ route('admin.reports.index') }}"
      class="{{ request()->routeIs('admin.reports.*') ? $activeClass : $inactiveClass }} group flex items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
      <div
        class="{{ request()->routeIs('admin.reports.*') ? 'bg-white/10' : 'group-hover:bg-white/10' }} rounded-lg p-2 transition-all duration-300">
        <svg
          class="h-5 w-5 shrink-0"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
      </div>
      <span class="ml-3 lg:hidden xl:inline">Laporan & Analitik</span>
    </a>
  </div>

  {{-- Menu di Bagian Bawah Sidebar (Pengaturan & Logout) --}}
  <div class="mt-auto space-y-2 border-t border-slate-800 pt-4">
    <a
      href="{{ route('admin.settings.index') }}"
      class="{{ request()->routeIs('admin.settings.*') ? $activeClass : $inactiveClass }} group flex items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
      <div
        class="{{ request()->routeIs('admin.settings.*') ? 'bg-white/10' : 'group-hover:bg-white/10' }} rounded-lg p-2 transition-all duration-300">
        <svg
          class="h-5 w-5 shrink-0"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </div>
      <span class="ml-3 lg:hidden xl:inline">Pengaturan Sistem</span>
    </a>
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button
        type="submit"
        class="{{ $inactiveClass }} group flex w-full items-center rounded-xl px-3 py-3 text-sm font-medium transition-all duration-300">
        <div class="rounded-lg p-2 transition-all duration-300 group-hover:bg-white/10">
          <svg
            class="h-5 w-5 shrink-0"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
        </div>
        <span class="ml-3 lg:hidden xl:inline">Logout</span>
      </button>
    </form>
  </div>
</aside>
