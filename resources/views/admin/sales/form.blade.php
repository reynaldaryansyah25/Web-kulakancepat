@extends('admin.layouts.app')

@php
    // Logika untuk menentukan mode form: create atau edit
    $isEditMode = isset($sale);
    // Tentukan URL action form berdasarkan mode
    $formAction = $isEditMode ? route('admin.sales.update', $sale->id_sales) : route('admin.sales.store');
    // Tentukan judul halaman
    $pageTitle = $isEditMode ? 'Edit Anggota Sales: ' . Str::limit($sale->name, 30) : 'Tambah Anggota Sales Baru';
@endphp

@section('title', $pageTitle)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ $isEditMode ? 'Edit Anggota Sales' : 'Tambah Anggota Sales Baru' }}</h1>
            @if ($isEditMode)
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 truncate max-w-xl">{{ $sale->name }}</p>
            @else
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Isi formulir di bawah untuk menambahkan anggota tim sales baru.</p>
            @endif
        </div>
        <div>
            <a href="{{ route('admin.sales.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                <span>Kembali ke Daftar Sales</span>
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-red-500/20 dark:text-red-400" role="alert">
            <span class="font-medium">Oops!</span> Terjadi beberapa kesalahan dengan input Anda. Silakan periksa di bawah.
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl p-6 sm:p-8">
        <form action="{{ $formAction }}" method="POST">
            @csrf
            @if($isEditMode)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                {{-- Nama Sales --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap Sales <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $sale->name ?? '') }}" required
                           class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('name') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                    @error('name') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $sale->email ?? '') }}" required
                           class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('email') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                    @error('email') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label for="no_phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="tel" name="no_phone" id="no_phone" value="{{ old('no_phone', $sale->no_phone ?? '') }}" required
                           class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('no_phone') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                    @error('no_phone') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                {{-- Target Sales --}}
                <div>
                    <label for="target_sales" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target Sales (Rp)</label>
                    <input type="number" name="target_sales" id="target_sales" value="{{ old('target_sales', $sale->target_sales ?? 0) }}" min="0" step="100000"
                           class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('target_sales') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                    @error('target_sales') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('status') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                        <option value="Aktif" {{ old('status', $sale->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Cuti" {{ old('status', $sale->status ?? '') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Nonaktif" {{ old('status', $sale->status ?? '') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password @if(!$isEditMode)<span class="text-red-500">*</span>@else (Kosongkan jika tidak ingin mengubah) @endif</label>
                        <input type="password" name="password" id="password" {{ !$isEditMode ? 'required' : '' }}
                               class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('password') ? 'border-red-500 dark:border-red-600 focus:ring-red-500/50 focus:border-red-500' : 'border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50' }}">
                        @error('password') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Konfirmasi Password @if(!$isEditMode)<span class="text-red-500">*</span>@endif</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" {{ !$isEditMode ? 'required' : '' }}
                               class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm border-slate-300 dark:border-slate-700 focus:ring-primary/50 focus:border-primary/50">
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.sales.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">Batal</a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg shadow-sm hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary/50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        <span>{{ $isEditMode ? 'Simpan Perubahan' : 'Simpan Anggota Sales' }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
