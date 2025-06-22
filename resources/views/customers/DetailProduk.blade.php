@extends('layouts.app')

@section('title', $product->name_product . ' | KulakanCepat')

@section('content')
  <main>
    <!-- Breadcrumb -->
    <div class="mx-auto mt-6 max-w-7xl px-4">
      <nav class="text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-red-700">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('catalog.index') }}" class="hover:text-red-700">Katalog</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-gray-800">{{ $product->name_product }}</span>
      </nav>
    </div>

    <!-- Detail Produk -->
    <section class="mx-auto max-w-7xl px-4 py-8">
      {{-- Menampilkan pesan sukses jika produk berhasil ditambahkan --}}
      @if (session('success'))
        <div
          class="mb-6 rounded-lg border-l-4 border-green-500 bg-green-100 p-4 text-green-800"
          role="alert">
          <p>
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <a href="{{ route('cart.index') }}" class="ml-2 font-bold underline">
              Lihat Keranjang
            </a>
          </p>
        </div>
      @endif

      <div class="flex flex-col items-start gap-8 rounded-xl bg-white p-8 shadow-md md:flex-row">
        <!-- Gambar Produk -->
        <div class="w-full md:w-1/2 lg:w-2/5">
          <div
            class="flex h-full w-full items-center justify-center rounded-lg border bg-gray-100 p-4">
            <img
              src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://placehold.co/400x400/e2e8f0/94a3b8?text=Gambar+Produk' }}"
              alt="{{ $product->name_product }}"
              class="max-h-[400px] w-full rounded-md object-contain" />
          </div>
        </div>

        <!-- Info Produk -->
        <div class="flex w-full flex-col justify-start md:w-1/2 lg:w-3/5">
          {{-- Kategori --}}
          @if ($product->category)
            <a
              href="{{ route('catalog.index', ['category' => $product->id_product_category]) }}"
              class="mb-2 text-sm font-semibold text-red-600 hover:underline">
              {{ $product->category->name }}
            </a>
          @endif

          <h2 class="mb-2 text-3xl font-bold text-gray-900">{{ $product->name_product }}</h2>

          <p class="mb-1 text-3xl font-bold text-red-700">
            Rp{{ number_format($product->price, 0, ',', '.') }}
          </p>
          <small class="mb-4 block text-gray-500">per Kardus</small>

          <div class="mb-6 border-t pt-4">
            <h3 class="mb-2 font-semibold">Deskripsi Produk</h3>
            <p class="text-base leading-relaxed text-gray-600">
              {{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
            </p>
          </div>

          <div class="mb-6">
            @if ($product->total_stock > 0)
              <span
                class="inline-block rounded-full bg-green-200 px-3 py-1 text-sm font-semibold uppercase text-green-600">
                Stok Tersedia: {{ $product->total_stock }}
              </span>
            @else
              <span
                class="inline-block rounded-full bg-red-200 px-3 py-1 text-sm font-semibold uppercase text-red-600">
                Stok Habis
              </span>
            @endif
          </div>

          {{-- Form Tambah ke Keranjang --}}
          <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto">
            @csrf
            <div class="flex items-center space-x-4">
              {{-- Input Kuantitas --}}
              <div class="flex items-center rounded-md border">
                <button
                  type="button"
                  onclick="this.nextElementSibling.stepDown()"
                  class="rounded-l-md px-4 py-3 text-lg text-gray-600 hover:bg-gray-100">
                  -
                </button>
                <input
                  type="number"
                  name="quantity"
                  value="1"
                  min="1"
                  max="{{ $product->total_stock }}"
                  class="w-16 border-y text-center text-lg focus:outline-none" />
                <button
                  type="button"
                  onclick="this.previousElementSibling.stepUp()"
                  class="rounded-r-md px-4 py-3 text-lg text-gray-600 hover:bg-gray-100">
                  +
                </button>
              </div>

              {{-- Tombol Submit --}}
              <button
                type="submit"
                class="flex w-full items-center justify-center rounded-md bg-red-600 px-6 py-3 font-semibold text-white transition-colors hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                {{ $product->total_stock <= 0 ? 'disabled' : '' }}>
                <i class="fas fa-cart-plus mr-2"></i>
                Tambahkan ke Keranjang
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
@endsection
