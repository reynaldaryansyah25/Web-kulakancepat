@extends('admin.layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Tambah Produk Baru</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Isi formulir di bawah untuk menambahkan produk baru ke inventaris.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                <span>Kembali ke Daftar Produk</span>
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-red-500/20 dark:text-red-400" role="alert">
            <span class="font-medium">Oops!</span> Terjadi beberapa kesalahan dengan input Anda. Silakan periksa di bawah.
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl p-6 sm:p-8">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Tidak ada @method('PUT') karena ini form create --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                {{-- Nama Produk --}}
                <div class="md:col-span-2">
                    <label for="name_product" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name_product" id="name_product" value="{{ old('name_product') }}" required
                           class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('name_product') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                    @error('name_product') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- SKU --}}
                <div>
                    <label for="SKU" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">SKU (Kode Produk) <span class="text-red-500">*</span></label>
                    <input type="text" name="SKU" id="SKU" value="{{ old('SKU') }}" required
                           class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('SKU') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                    @error('SKU') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="1"
                           class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('price') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                    @error('price') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                {{-- Stok --}}
                <div>
                    <label for="total_stock" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="total_stock" id="total_stock" value="{{ old('total_stock', 0) }}" required min="0"
                           class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('total_stock') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                    @error('total_stock') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                {{-- Kategori --}}
                <div>
                    <label for="id_product_category" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                    <select name="id_product_category" id="id_product_category"
                            class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('id_product_category') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id_product_category }}" {{ old('id_product_category') == $category->id_product_category ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_product_category') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                {{-- Input File Gambar --}}
                <div class="md:col-span-2">
                    <label for="image_file" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Upload Gambar Produk</label>
                    <input type="file" name="image_file" id="image_file"
                           class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Max 2MB (JPG, PNG, WEBP).</p>
                    @error('image_file') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                
                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi Produk</label>
                    <textarea name="description" id="description" rows="5" class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('description') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600">Batal</a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg shadow-sm hover:bg-primary/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        <span>Simpan Produk</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
