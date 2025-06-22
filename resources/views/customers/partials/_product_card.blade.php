{{--
  File ini adalah template untuk satu kartu produk.
  Mengharapkan variabel $product untuk dilewatkan.
--}}
<div class="card-hover product-card flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg">
  {{-- Tautan ke halaman detail produk --}}
  <a href="{{ route('product.show', $product) }}" class="block">
    <div class="flex h-48 items-center justify-center overflow-hidden bg-gray-100">
      <img
        src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://placehold.co/300x200/e2e8f0/94a3b8?text=Gambar' }}"
        alt="{{ $product->name_product }}"
        class="h-full w-full object-cover transition-transform duration-300 hover:scale-110" />
    </div>
  </a>
  <div class="flex flex-grow flex-col p-5">
    {{-- Kategori Produk --}}
    @if ($product->category)
      <a
        href="{{ route('catalog.index', ['category' => $product->id_product_category]) }}"
        class="mb-2 text-xs font-semibold text-red-600 hover:underline">
        {{ $product->category->name }}
      </a>
    @endif

    {{-- Nama Produk --}}
    <a href="{{ route('product.show', $product) }}" class="block">
      <h4 class="mb-2 h-12 text-base font-bold text-gray-800 transition-colors hover:text-red-700">
        {{ $product->name_product }}
      </h4>
    </a>

    {{-- Info Stok --}}
    <div class="mb-4">
      @if ($product->total_stock > 0)
        <span
          class="inline-block rounded-full bg-green-200 px-2 py-1 text-xs font-semibold uppercase text-green-600">
          Stok Tersedia: {{ $product->total_stock }}
        </span>
      @else
        <span
          class="inline-block rounded-full bg-red-200 px-2 py-1 text-xs font-semibold uppercase text-red-600">
          Stok Habis
        </span>
      @endif
    </div>

    {{-- Harga --}}
    <div class="mb-5 mt-auto">
      <p class="text-sm text-gray-500">Harga per Kardus</p>
      <p class="text-2xl font-bold text-red-600">
        Rp{{ number_format($product->price, 0, ',', '.') }}
      </p>
    </div>

    {{-- Tombol Aksi --}}
    <form action="{{ route('cart.add', $product) }}" method="POST">
      @csrf
      <input type="hidden" name="quantity" value="1" />
      <button
        type="submit"
        class="flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-red-500 to-red-600 py-3 font-semibold text-white transition-all hover:from-red-600 hover:to-red-700 disabled:cursor-not-allowed disabled:opacity-50"
        {{ $product->total_stock <= 0 ? 'disabled' : '' }}>
        <i class="fas fa-cart-plus mr-2"></i>
        <span>Tambah</span>
      </button>
    </form>
  </div>
</div>
