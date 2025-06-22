@extends('admin.layouts.app')

@section('title', 'Manajemen Pelanggan')

@section('content')
  <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
    {{-- Header Halaman --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Manajemen Pelanggan</h1>
        <p class="mt-1 text-base text-slate-600 dark:text-slate-300">
          Kelola dan pantau semua pelanggan terdaftar
        </p>
      </div>
      <div class="mt-4 sm:mt-0">
        <a
          href="{{ route('admin.customers.create') }}"
          class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-800/50 focus:ring-offset-2">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            viewBox="0 0 20 20"
            fill="currentColor">
            <path
              fill-rule="evenodd"
              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
              clip-rule="evenodd" />
          </svg>
          <span>Tambah Pelanggan</span>
        </a>
      </div>
    </div>

    {{-- Kartu Statistik --}}
    <div class="mb-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
      {{-- Total Pelanggan --}}
      <div class="group relative overflow-hidden">
        <div
          class="relative transform rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 group-hover:-translate-y-1 dark:border-slate-700 dark:bg-slate-800">
          <div class="mb-3 flex items-center justify-between">
            <div
              class="rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 p-2 dark:from-blue-500/20 dark:to-blue-600/20">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-blue-600 dark:text-blue-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <div class="text-right">
              <p
                class="text-[11px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                Total
              </p>
              <p class="text-2xl font-black text-slate-800 dark:text-slate-100">
                {{ $customerStats->total ?? 0 }}
              </p>
            </div>
          </div>
          <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Total Pelanggan</h3>
          <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Pelanggan terdaftar</p>
        </div>
      </div>
      {{-- Pelanggan Aktif --}}
      <div class="group relative overflow-hidden">
        <div
          class="relative transform rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 group-hover:-translate-y-1 dark:border-slate-700 dark:bg-slate-800">
          <div class="mb-3 flex items-center justify-between">
            <div
              class="rounded-lg bg-gradient-to-br from-green-100 to-green-200 p-2 dark:from-green-500/20 dark:to-green-600/20">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-green-600 dark:text-green-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="text-right">
              <p
                class="text-[11px] font-bold uppercase tracking-wider text-green-600 dark:text-green-400">
                Aktif
              </p>
              <p class="text-2xl font-black text-slate-800 dark:text-slate-100">
                {{ $customerStats->active ?? 0 }}
              </p>
            </div>
          </div>
          <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Pelanggan Aktif</h3>
          <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Sedang bertransaksi</p>
        </div>
      </div>
      {{-- Menunggu Approval --}}
      <div class="group relative overflow-hidden">
        <div
          class="relative transform rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 group-hover:-translate-y-1 dark:border-slate-700 dark:bg-slate-800">
          <div class="mb-3 flex items-center justify-between">
            <div
              class="rounded-lg bg-gradient-to-br from-amber-100 to-amber-200 p-2 dark:from-amber-500/20 dark:to-amber-600/20">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-amber-600 dark:text-amber-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="text-right">
              <p
                class="text-[11px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">
                Pending
              </p>
              <p class="text-2xl font-black text-slate-800 dark:text-slate-100">
                {{ $customerStats->pending ?? 0 }}
              </p>
            </div>
          </div>
          <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Menunggu Approval</h3>
          <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Perlu persetujuan</p>
        </div>
      </div>
      {{-- Registrasi Bulan Ini --}}
      <div class="group relative overflow-hidden">
        <div
          class="relative transform rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 group-hover:-translate-y-1 dark:border-slate-700 dark:bg-slate-800">
          <div class="mb-3 flex items-center justify-between">
            <div
              class="rounded-lg bg-gradient-to-br from-purple-100 to-purple-200 p-2 dark:from-purple-500/20 dark:to-purple-600/20">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-purple-600 dark:text-purple-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <div class="text-right">
              <p
                class="text-[11px] font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">
                Baru
              </p>
              <p class="text-2xl font-black text-slate-800 dark:text-slate-100">
                {{ $customerStats->registeredThisMonth ?? 0 }}
              </p>
            </div>
          </div>
          <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Registrasi Bulan Ini</h3>
          <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Pelanggan baru</p>
        </div>
      </div>
    </div>

    {{-- Filter --}}
    <div class="mb-6">
      <form action="{{ route('admin.customers.index') }}" method="GET" id="customerFilterForm">
        <div class="flex flex-col items-center gap-4 sm:flex-row">
          <div class="relative w-full sm:flex-grow">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
              <svg
                class="h-4 w-4 text-slate-400"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor">
                <path
                  fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <input
              type="text"
              name="search_customer"
              id="search_customer"
              value="{{ request('search_customer') }}"
              class="w-full rounded-lg border border-slate-300 py-3 pl-10 pr-4 text-sm shadow-sm transition-all duration-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100"
              placeholder="Cari pelanggan, email, atau toko..." />
          </div>
          <div class="w-full sm:w-auto">
            <select
              id="customer_status"
              name="customer_status"
              onchange="document.getElementById('customerFilterForm').submit();"
              class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm transition-all duration-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:w-56 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
              <option value="" {{ request('customer_status') == '' ? 'selected' : '' }}>
                Semua Status
              </option>
              <option
                value="PENDING_APPROVE"
                {{ request('customer_status') == 'PENDING_APPROVE' ? 'selected' : '' }}>
                Menunggu Persetujuan
              </option>
              <option
                value="ACTIVE"
                {{ request('customer_status') == 'ACTIVE' ? 'selected' : '' }}>
                Aktif
              </option>
              <option
                value="INACTIVE"
                {{ request('customer_status') == 'INACTIVE' ? 'selected' : '' }}>
                Nonaktif
              </option>
            </select>
          </div>
        </div>
        <button type="submit" class="hidden">Submit</button>
      </form>
    </div>

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

    {{-- Tabel Pelanggan --}}
    <div
      class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg dark:border-slate-700 dark:bg-slate-800">
      <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
          Daftar Pelanggan ({{ $customers->total() }})
        </h3>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead
            class="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-slate-700/50 dark:text-slate-400">
            <tr>
              <th class="px-5 py-3 text-left font-semibold">Pelanggan</th>
              <th class="px-5 py-3 text-left font-semibold">Kontak</th>
              <th class="px-5 py-3 text-left font-semibold">Toko</th>
              <th class="px-5 py-3 text-left font-semibold">Tier & Plafon</th>
              <th class="px-5 py-3 text-center font-semibold">Total Pesanan</th>
              <th class="px-5 py-3 text-left font-semibold">Total Pembelian</th>
              <th class="px-5 py-3 text-left font-semibold">Sales</th>
              <th class="px-5 py-3 text-left font-semibold">Status</th>
              <th class="px-5 py-3 text-right font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @forelse ($customers as $customer)
              <tr
                class="transition-colors duration-200 hover:bg-slate-50 dark:hover:bg-slate-700/50">
                <td class="whitespace-nowrap px-5 py-4">
                  <div class="flex items-center">
                    <div class="ml-1">
                      <div class="font-medium text-slate-800 dark:text-slate-100">
                        {{ $customer->name_owner }}
                      </div>
                      <div class="text-xs text-slate-500 dark:text-slate-400">
                        Daftar:
                        {{ \Carbon\Carbon::parse($customer->created)->isoFormat('D MMM YY') }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="whitespace-nowrap px-5 py-4">
                  <div class="mb-1 flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-3.5 w-3.5 text-blue-500"
                      viewBox="0 0 20 20"
                      fill="currentColor">
                      <path
                        d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                      <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    <span class="text-xs font-medium">{{ $customer->email }}</span>
                  </div>
                  <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-3.5 w-3.5 text-green-500"
                      viewBox="0 0 20 20"
                      fill="currentColor">
                      <path
                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    <span class="text-xs font-medium">{{ $customer->no_phone ?? '-' }}</span>
                  </div>
                </td>
                <td class="whitespace-nowrap px-5 py-4">
                  <div class="font-medium text-slate-800 dark:text-slate-100">
                    {{ $customer->name_store }}
                  </div>
                  <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    {{ Str::limit($customer->address, 25) }}
                  </div>
                </td>
                <td class="whitespace-nowrap px-5 py-4">
                  <div class="font-semibold text-slate-700 dark:text-slate-200">
                    {{ $customer->tier->name ?? 'N/A' }}
                  </div>
                  <div class="text-[11px] text-slate-500 dark:text-slate-400">
                    Plafon: Rp {{ number_format($customer->credit_limit, 0, ',', '.') }}
                  </div>
                </td>
                <td class="whitespace-nowrap px-5 py-4 text-center">
                  <div class="font-semibold text-slate-700 dark:text-slate-200">
                    {{ $customer->transactions_count }}
                  </div>
                  <div class="text-[11px] text-slate-500 dark:text-slate-400">pesanan</div>
                </td>
                <td class="whitespace-nowrap px-5 py-4">
                  <div class="font-semibold text-slate-700 dark:text-slate-200">
                    Rp {{ number_format($customer->total_pembelian ?? 0, 0, ',', '.') }}
                  </div>
                  <div class="text-[11px] text-slate-500 dark:text-slate-400">total</div>
                </td>
                <td class="whitespace-nowrap px-5 py-4">
                  <div class="text-slate-700 dark:text-slate-300">
                    {{ $customer->salesPerson->name ?? '-' }}
                  </div>
                </td>
                <td class="whitespace-nowrap px-5 py-4">
                  <span
                    class="{{ ['ACTIVE' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400', 'INACTIVE' => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400', 'PENDING_APPROVE' => 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400'][$customer->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-600/20 dark:text-slate-300' }} inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-bold">
                    <span
                      class="{{ ['ACTIVE' => 'bg-green-500', 'INACTIVE' => 'bg-red-500', 'PENDING_APPROVE' => 'bg-amber-500'][$customer->status] ?? 'bg-slate-500' }} h-1.5 w-1.5 rounded-full"></span>
                    {{ str_replace('_', ' ', ucwords(strtolower($customer->status))) }}
                  </span>
                </td>
                <td class="whitespace-nowrap px-5 py-4 text-right text-xs font-medium">
                  <div class="flex items-center justify-end gap-2">
                    <a
                      href="{{ route('admin.customers.edit', $customer->id_customer) }}"
                      class="inline-flex items-center rounded-md bg-blue-100 px-2.5 py-1 text-[11px] font-medium text-blue-700 transition-colors duration-200 hover:bg-blue-200 dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500/30">
                      Edit
                    </a>
                    @if ($customer->status == 'PENDING_APPROVE')
                      <form
                        action="{{ route('admin.customers.approve', $customer->id_customer) }}"
                        method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <button
                          type="submit"
                          class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-1 text-[11px] font-medium text-green-700 transition-colors duration-200 hover:bg-green-200 dark:bg-green-500/20 dark:text-green-400 dark:hover:bg-green-500/30">
                          Setujui
                        </button>
                      </form>
                    @endif

                    <form
                      action="{{ route('admin.customers.destroy', $customer->id_customer) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Anda yakin ingin menghapus pelanggan ini?');">
                      @csrf
                      @method('DELETE')
                      <button
                        type="submit"
                        class="inline-flex items-center rounded-md bg-red-100 px-2.5 py-1 text-[11px] font-medium text-red-700 transition-colors duration-200 hover:bg-red-200 dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-500/30">
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center">
                    <svg
                      class="mb-3 h-12 w-12 text-slate-300 dark:text-slate-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mb-1 text-base font-semibold text-slate-600 dark:text-slate-300">
                      @if (request()->has('search_customer') || request()->has('customer_status'))
                        Tidak ada pelanggan ditemukan
                      @else
                          Belum ada data pelanggan
                      @endif
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                      @if (request()->has('search_customer') || request()->has('customer_status'))
                        Coba ubah filter pencarian Anda
                      @else
                          Mulai tambahkan pelanggan pertama Anda
                      @endif
                    </p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if (isset($customers) && $customers->hasPages())
        <div
          class="border-t border-slate-200 bg-slate-50 px-5 py-3 dark:border-slate-700 dark:bg-slate-800/50">
          {{ $customers->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
      @endif
    </div>
  </div>
@endsection
