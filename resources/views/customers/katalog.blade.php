@extends('layouts.app')

@section('title', 'Katalog Produk | KulakanCepat')

@section('content')
  <main>
    <!-- Banner -->
    <section class="gradient-bg py-8 text-center text-white shadow-inner">
      <h2 class="mb-1 text-3xl font-bold">Katalog Produk</h2>
      <p class="text-sm opacity-90">
        Cari dan temukan produk grosir terbaik untuk kebutuhan bisnismu
      </p>
    </section>

    <!-- Filter & Search -->
    <div class="mx-auto mb-6 mt-8 max-w-7xl px-4">
      <form action="{{ route('catalog.index') }}" method="GET">
        <div class="flex flex-wrap items-center gap-4 rounded-xl bg-white p-4 shadow-md">
          <span class="font-semibold text-gray-600">Filter:</span>
          <select
            name="category"
            onchange="this.form.submit()"
            class="w-full flex-grow rounded-lg border border-gray-300 p-2 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 sm:w-auto sm:flex-grow-0">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
              <option
                value="{{ $category->id_product_category }}"
                {{ request('category') == $category->id_product_category ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
          <select
            name="sort"
            onchange="this.form.submit()"
            class="w-full flex-grow rounded-lg border border-gray-300 p-2 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 sm:w-auto sm:flex-grow-0">
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
              Urutkan: Terbaru
            </option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
              Harga Terendah
            </option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
              Harga Tertinggi
            </option>
          </select>
        </div>
      </form>
    </div>

    <!-- Daftar Produk -->
    <section class="mx-auto max-w-7xl px-4 pb-16">
      <div
        id="product-grid"
        class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @include('customers.partials._product_list', ['products' => $products])
      </div>

      @if ($products->isEmpty())
        <div class="col-span-full rounded-lg bg-white p-12 text-center shadow-md">
          <i class="fas fa-box-open mb-6 text-6xl text-gray-300"></i>
          <h3 class="text-2xl font-semibold text-gray-700">Produk tidak ditemukan</h3>
          <p class="mx-auto mt-2 max-w-md text-gray-500">
            Coba ganti kata kunci pencarian atau filter Anda.
          </p>
          <a
            href="{{ route('catalog.index') }}"
            class="mt-6 inline-block rounded-lg bg-red-600 px-6 py-3 font-bold text-white transition-colors hover:bg-red-700">
            Lihat Semua Produk
          </a>
        </div>
      @endif

      <div id="pagination-wrapper" class="mt-12 text-center">
        @if ($products->hasMorePages())
          <button
            id="load-more-btn"
            data-next-page="{{ $products->nextPageUrl() }}"
            class="inline-flex transform items-center justify-center rounded-lg bg-red-700 px-8 py-3 font-bold text-white shadow-lg transition-all hover:-translate-y-1 hover:bg-red-800 hover:shadow-xl disabled:cursor-wait disabled:opacity-50">
            <span class="btn-text">Lihat Lebih Banyak</span>
            <div class="spinner ml-2 hidden"></div>
          </button>
        @elseif (count($products) > 0)
          <p class="mt-8 text-gray-500">Anda telah melihat semua produk.</p>
        @endif
      </div>
    </section>
  </main>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const paginationWrapper = document.getElementById('pagination-wrapper')
      if (!paginationWrapper) return

      paginationWrapper.addEventListener('click', function (e) {
        const loadMoreBtn = e.target.closest('#load-more-btn')
        if (!loadMoreBtn) return

        const productGrid = document.getElementById('product-grid')
        let nextPageUrl = loadMoreBtn.dataset.nextPage

        const buttonText = loadMoreBtn.querySelector('.btn-text')
        const spinner = loadMoreBtn.querySelector('.spinner')

        if (!nextPageUrl) return

        buttonText.classList.add('hidden')
        spinner.classList.remove('hidden')
        loadMoreBtn.disabled = true

        fetch(nextPageUrl, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error('Network response was not ok.')
            }
            return response.text()
          })
          .then((html) => {
            // Jika response kosong, berarti tidak ada produk lagi
            if (html.trim().length === 0) {
              paginationWrapper.innerHTML =
                '<p class="text-gray-500">Anda telah melihat semua produk.</p>'
              return
            }

            productGrid.insertAdjacentHTML('beforeend', html)

            let currentUrl = new URL(nextPageUrl)
            let currentPage = parseInt(currentUrl.searchParams.get('page'))
            currentUrl.searchParams.set('page', currentPage + 1)
            loadMoreBtn.dataset.nextPage = currentUrl.toString()

            buttonText.classList.remove('hidden')
            spinner.classList.add('hidden')
            loadMoreBtn.disabled = false
          })
          .catch((error) => {
            console.error('Error fetching more products:', error)
            paginationWrapper.innerHTML =
              '<p class="text-red-500 font-semibold">Gagal memuat produk. Silakan refresh halaman.</p>'
          })
      })
    })
  </script>
@endpush
