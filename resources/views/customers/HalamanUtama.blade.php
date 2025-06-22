@extends('layouts.app')

@section('title', 'KulakanCepat.id - Platform Grosir Digital')

@section('content')
  <main>
    <!-- Promo Banner -->
    <div
      class="border-b border-red-100 bg-gradient-to-r from-pink-100 to-red-50 py-4 text-center text-red-700">
      <div class="flex items-center justify-center space-x-2">
        <i class="fas fa-fire text-orange-500"></i>
        <span class="font-semibold">
          🎉 Promo Merdeka! Diskon hingga
          <strong class="text-red-600">50%</strong>
          untuk semua produk UMKM!
        </span>
        <a
          href="{{ route('catalog.index') }}"
          class="ml-4 rounded-full bg-red-600 px-4 py-1 text-sm font-bold text-white transition-colors hover:bg-red-700">
          Belanja Sekarang
        </a>
      </div>
    </div>

    <!-- Hero Section -->
    <section class="relative mb-8 h-[400px]">
      <img
        src="{{ asset('img/logo/gambar1.jpg') }}"
        alt="Hero Background"
        class="absolute inset-0 z-0 h-full w-full object-cover" />
      <div class="absolute inset-0 z-10 flex items-center bg-black bg-opacity-50 px-6">
        <div class="text-white">
          <h2 class="mb-2 text-3xl font-bold md:text-4xl">
            Kemudahan Belanja
            <br />
            Untuk Usaha Anda
          </h2>
          <p class="mb-4 text-lg">Produk lengkap, harga murah, pengiriman cepat</p>
          <a
            href="{{ route('catalog.index') }}"
            class="rounded-full bg-red-700 px-6 py-3 font-semibold text-white hover:bg-red-900">
            Belanja Sekarang
          </a>
        </div>
      </div>
    </section>

    <!-- Categories -->
    <section class="bg-white py-16">
      <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
          <h3 class="mb-4 text-3xl font-bold text-gray-800">Kategori Pilihan</h3>
          <p class="text-lg text-gray-600">
            Temukan berbagai kategori produk untuk kebutuhan bisnis Anda
          </p>
        </div>
        <div class="grid grid-cols-2 gap-6 md:grid-cols-4 lg:grid-cols-6">
          @foreach ($categories as $category)
            <a
              href="{{ route('catalog.index', ['category' => $category->id_product_category]) }}"
              class="group cursor-pointer text-center">
              <div
                class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-red-50 to-red-100 transition-all group-hover:scale-110 group-hover:shadow-lg">
                <i class="{{ $category->icon ?? 'fas fa-box' }} text-2xl text-red-600"></i>
              </div>
              <p class="font-semibold text-gray-700">{{ $category->name }}</p>
            </a>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Best Selling Products -->
    <section class="bg-gradient-to-br from-gray-50 to-red-50 py-16">
      <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 flex items-center justify-between">
          <div>
            <h3 class="text-3xl font-bold text-gray-800">Produk Terlaris</h3>
            <p class="text-gray-600">Produk pilihan yang paling banyak dibeli</p>
          </div>
          <a
            href="{{ route('catalog.index', ['sort' => 'best_selling']) }}"
            class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition-colors hover:bg-red-700">
            Lihat Semua
            <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
          @forelse ($bestSellingProducts as $product)
            @include('customers.partials._product_card', ['product' => $product])
          @empty
            <p class="col-span-full text-center text-gray-500">Produk terlaris belum tersedia.</p>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Newest Products -->
    <section class="bg-white py-16">
      <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 flex flex-wrap items-center justify-between gap-4">
          <div>
            <h3 class="text-3xl font-bold text-gray-800">Produk Terbaru</h3>
            <p class="mt-1 text-gray-600">Lihat koleksi produk yang baru kami tambahkan</p>
          </div>
          <a
            href="{{ route('catalog.index', ['sort' => 'latest']) }}"
            class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition-colors hover:bg-red-700">
            Lihat Semua
            <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
          @forelse ($latestProducts as $product)
            @include('customers.partials._product_card', ['product' => $product])
          @empty
            <p class="col-span-full py-10 text-center text-gray-500">
              Produk terbaru belum tersedia.
            </p>
          @endforelse
        </div>
      </div>
    </section>
  </main>
@endsection
