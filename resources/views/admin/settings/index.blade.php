@extends('admin.layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
  <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8" x-data="{ activeTab: 'umum' }">
    <form
      action="{{ route('admin.settings.update') }}"
      method="POST"
      id="settingsForm"
      enctype="multipart/form-data">
      @csrf
      <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Pengaturan Sistem</h1>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Kelola konfigurasi sistem dan preferensi aplikasi
          </p>
        </div>
        <div class="mt-4 sm:mt-0">
          <button
            type="submit"
            class="bg-primary hover:bg-primary/90 focus:ring-primary/50 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">
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
            <span>Simpan Semua Perubahan</span>
          </button>
        </div>
      </div>

      @if (session('success'))
        <div
          class="mb-6 rounded-lg bg-green-100 px-4 py-3 leading-normal text-green-700 dark:bg-green-700/30 dark:text-green-100"
          role="alert">
          <p>{{ session('success') }}</p>
        </div>
      @endif

      @if ($errors->any())
        <div
          class="mb-6 rounded-lg bg-red-100 p-4 text-sm text-red-800 dark:bg-red-500/20 dark:text-red-400"
          role="alert">
          <span class="font-medium">Oops!</span>
          Terjadi beberapa kesalahan dengan input Anda.
        </div>
      @endif

      {{-- Navigasi Tab --}}
      <div class="mb-6 border-b border-slate-200 dark:border-slate-700">
        <nav class="-mb-px flex space-x-6" aria-label="Tabs">
          <button
            type="button"
            @click="activeTab = 'umum'"
            :class="activeTab === 'umum' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
            Pengaturan Umum
          </button>
          <button
            type="button"
            @click="activeTab = 'transaksi'"
            :class="activeTab === 'transaksi' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
            Transaksi & Keuangan
          </button>
          <button
            type="button"
            @click="activeTab = 'pengguna'"
            :class="activeTab === 'pengguna' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
            Pengguna & Akses
          </button>
          <button
            type="button"
            @click="activeTab = 'inovatif'"
            :class="activeTab === 'inovatif' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700'"
            class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium">
            Fitur Inovatif
          </button>
        </nav>
      </div>

      {{-- Konten Tab --}}
      <div class="space-y-8">
        <div x-show="activeTab === 'umum'" x-cloak>
          @include('admin.settings._tab_umum')
        </div>
        <div x-show="activeTab === 'transaksi'" x-cloak>
          @include('admin.settings._tab_transaksi')
        </div>
        <div x-show="activeTab === 'pengguna'" x-cloak>
          @include('admin.settings._tab_pengguna')
        </div>
        <div x-show="activeTab === 'inovatif'" x-cloak>
          @include('admin.settings._tab_inovatif')
        </div>
      </div>
    </form>
  </div>
  <style>
    .input-field { @apply px-3 py-2 text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition; }
    input[type=checkbox]:checked + div + .dot { transform: translateX(100%); }
    input[type=checkbox]:checked + div { background-color: #B6172C; }
  </style>
@endsection
