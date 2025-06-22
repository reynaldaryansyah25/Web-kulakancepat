@extends('admin.layouts.app')

@section('title', 'Tambah Pelanggan Baru')

@section('content')
  <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
          Tambah Pelanggan Baru
        </h1>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
          Isi formulir di bawah untuk menambahkan pelanggan baru ke sistem.
        </p>
      </div>
      <div class="mt-4 sm:mt-0">
        <a
          href="{{ route('admin.customers.index') }}"
          class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            viewBox="0 0 20 20"
            fill="currentColor">
            <path
              fill-rule="evenodd"
              d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
              clip-rule="evenodd" />
          </svg>
          <span>Kembali ke Daftar</span>
        </a>
      </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
      <div
        class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-500/20 dark:text-red-400"
        role="alert">
        <div class="flex items-center">
          <svg
            class="mr-3 inline h-4 w-4 flex-shrink-0"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20">
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
          </svg>
          <span class="font-medium">Perhatian!</span>
          Terdapat kesalahan dalam pengisian form.
        </div>
        <ul class="ml-7 mt-1.5 list-inside list-disc">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Form Container -->
    <div
      class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
      <!-- Form Header -->
      <div
        class="border-b border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-700 dark:bg-slate-700/30">
        <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
          Formulir Pelanggan Baru
        </h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
          Lengkapi semua field yang diperlukan (
          <span class="text-red-500">*</span>
          )
        </p>
      </div>

      <!-- Form Content -->
      <div class="p-6 sm:p-8">
        <form action="{{ route('admin.customers.store') }}" method="POST">
          @csrf

          <div class="space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <!-- Nama Toko -->
              <div>
                <label
                  for="name_store"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Nama Toko
                  <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  name="name_store"
                  id="name_store"
                  value="{{ old('name_store') }}"
                  required
                  class="{{
                    $errors->has('name_store')
                      ? 'border-red-500 focus:border-red-500 focus:ring-red-500/50 dark:border-red-600'
                      : 'focus:ring-primary/50 focus:border-primary/50 border-slate-300 dark:border-slate-700'
                  }} w-full rounded-lg border px-3 py-2.5 text-sm dark:bg-slate-800 dark:text-slate-300" />
                @error('name_store')
                  <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <!-- Nama Pemilik -->
              <div>
                <label
                  for="name_owner"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Nama Pemilik
                  <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  name="name_owner"
                  id="name_owner"
                  value="{{ old('name_owner') }}"
                  required
                  class="{{
                    $errors->has('name_owner')
                      ? 'border-red-500 focus:border-red-500 focus:ring-red-500/50 dark:border-red-600'
                      : 'focus:ring-primary/50 focus:border-primary/50 border-slate-300 dark:border-slate-700'
                  }} w-full rounded-lg border px-3 py-2.5 text-sm dark:bg-slate-800 dark:text-slate-300" />
                @error('name_owner')
                  <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <!-- Email -->
              <div class="md:col-span-2">
                <label
                  for="email"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Email
                  <span class="text-red-500">*</span>
                </label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  value="{{ old('email') }}"
                  required
                  class="{{
                    $errors->has('email')
                      ? 'border-red-500 focus:border-red-500 focus:ring-red-500/50 dark:border-red-600'
                      : 'focus:ring-primary/50 focus:border-primary/50 border-slate-300 dark:border-slate-700'
                  }} w-full rounded-lg border px-3 py-2.5 text-sm dark:bg-slate-800 dark:text-slate-300" />
                @error('email')
                  <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <!-- Nomor Telepon -->
              <div>
                <label
                  for="no_phone"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Nomor Telepon
                  <span class="text-red-500">*</span>
                </label>
                <input
                  type="tel"
                  name="no_phone"
                  id="no_phone"
                  value="{{ old('no_phone') }}"
                  required
                  class="{{
                    $errors->has('no_phone')
                      ? 'border-red-500 focus:border-red-500 focus:ring-red-500/50 dark:border-red-600'
                      : 'focus:ring-primary/50 focus:border-primary/50 border-slate-300 dark:border-slate-700'
                  }} w-full rounded-lg border px-3 py-2.5 text-sm dark:bg-slate-800 dark:text-slate-300" />
                @error('no_phone')
                  <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <!-- Sales Penanggung Jawab -->
              <div>
                <label
                  for="id_sales"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Sales Penanggung Jawab
                </label>
                <select
                  name="id_sales"
                  id="id_sales"
                  class="{{
                    $errors->has('id_sales')
                      ? 'border-red-500 focus:border-red-500 focus:ring-red-500/50 dark:border-red-600'
                      : 'focus:ring-primary/50 focus:border-primary/50 border-slate-300 dark:border-slate-700'
                  }} w-full rounded-lg border px-3 py-2.5 text-sm dark:bg-slate-800 dark:text-slate-300">
                  <option value="">Pilih Sales</option>
                  @foreach ($salesPeople ?? [] as $sales)
                    <option
                      value="{{ $sales->id_sales }}"
                      {{ old('id_sales') == $sales->id_sales ? 'selected' : '' }}>
                      {{ $sales->name }}
                    </option>
                  @endforeach
                </select>
                @error('id_sales')
                  <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <!-- Alamat -->
              <div class="md:col-span-2">
                <label
                  for="address"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Alamat Lengkap
                  <span class="text-red-500">*</span>
                </label>
                <textarea
                  name="address"
                  id="address"
                  rows="3"
                  required
                  class="{{
                    $errors->has('address')
                      ? 'border-red-500 focus:border-red-500 focus:ring-red-500/50 dark:border-red-600'
                      : 'focus:ring-primary/50 focus:border-primary/50 border-slate-300 dark:border-slate-700'
                  }} w-full rounded-lg border px-3 py-2.5 text-sm dark:bg-slate-800 dark:text-slate-300">
{{ old('address') }}</textarea
                >
                @error('address')
                  <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <!-- Status -->
              <div>
                <label
                  for="status"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Status Akun
                  <span class="text-red-500">*</span>
                </label>
                <select
                  name="status"
                  id="status"
                  required
                  class="{{
                    $errors->has('status')
                      ? 'border-red-500 focus:border-red-500 focus:ring-red-500/50 dark:border-red-600'
                      : 'focus:ring-primary/50 focus:border-primary/50 border-slate-300 dark:border-slate-700'
                  }} w-full rounded-lg border px-3 py-2.5 text-sm dark:bg-slate-800 dark:text-slate-300">
                  <option
                    value="PENDING_APPROVE"
                    {{ old('status', 'PENDING_APPROVE') == 'PENDING_APPROVE' ? 'selected' : '' }}>
                    Menunggu Persetujuan
                  </option>
                  <option value="ACTIVE" {{ old('status') == 'ACTIVE' ? 'selected' : '' }}>
                    Aktif
                  </option>
                  <option value="INACTIVE" {{ old('status') == 'INACTIVE' ? 'selected' : '' }}>
                    Nonaktif
                  </option>
                </select>
                @error('status')
                  <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- Password Section -->
            <div
              class="grid grid-cols-1 gap-6 border-t border-slate-200 pt-4 sm:grid-cols-2 dark:border-slate-700">
              <!-- Password -->
              <div>
                <label
                  for="password"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Password
                  <span class="text-red-500">*</span>
                </label>
                <input
                  type="password"
                  name="password"
                  id="password"
                  required
                  class="{{
                    $errors->has('password')
                      ? 'border-red-500 focus:border-red-500 focus:ring-red-500/50 dark:border-red-600'
                      : 'focus:ring-primary/50 focus:border-primary/50 border-slate-300 dark:border-slate-700'
                  }} w-full rounded-lg border px-3 py-2.5 text-sm dark:bg-slate-800 dark:text-slate-300" />
                @error('password')
                  <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <!-- Konfirmasi Password -->
              <div>
                <label
                  for="password_confirmation"
                  class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Konfirmasi Password
                  <span class="text-red-500">*</span>
                </label>
                <input
                  type="password"
                  name="password_confirmation"
                  id="password_confirmation"
                  required
                  class="focus:ring-primary/50 focus:border-primary/50 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300" />
              </div>
            </div>
          </div>

          <!-- Form Footer -->
          <div class="mt-8 border-t border-slate-200 pt-6 dark:border-slate-700">
            <div class="flex justify-end gap-3">
              <a
                href="{{ route('admin.customers.index') }}"
                class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
                Batal
              </a>
              <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-5 py-3 text-sm font-medium text-white shadow-lg transition duration-300 hover:bg-red-700">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  viewBox="0 0 20 20"
                  fill="currentColor">
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
                </svg>
                <span>Simpan Pelanggan</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
