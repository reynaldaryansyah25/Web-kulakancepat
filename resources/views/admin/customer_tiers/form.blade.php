@extends('admin.layouts.app')

@php
    $isEditMode = isset($customerTier);
    $formAction = $isEditMode ? route('admin.customer-tiers.update', $customerTier->id_customer_tier) : route('admin.customer-tiers.store');
    $pageTitle = $isEditMode ? 'Edit Tier: ' . $customerTier->name : 'Tambah Tier Baru';
@endphp

@section('title', $pageTitle)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ $isEditMode ? 'Edit Tingkatan Pelanggan' : 'Tambah Tingkatan Pelanggan Baru' }}</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Atur nama, syarat, dan benefit untuk tingkatan ini.</p>
            </div>
            <div>
                <a href="{{ route('admin.customer-tiers.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                    <span>Batal</span>
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-red-500/20 dark:text-red-400" role="alert"><span class="font-medium">Oops!</span> Terjadi beberapa kesalahan dengan input Anda.</div>
        @endif

        <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl p-6 sm:p-8">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if($isEditMode)
                    @method('PUT')
                @endif
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Tier <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $customerTier->name ?? '') }}" required class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('name') ? 'border-red-500' : 'border-slate-300' }} focus:ring-primary/50 focus:border-primary/50" placeholder="Contoh: Gold">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('description') ? 'border-red-500' : 'border-slate-300' }} focus:ring-primary/50 focus:border-primary/50">{{ old('description', $customerTier->description ?? '') }}</textarea>
                        @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="min_monthly_purchase" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Minimum Pembelian Bulanan (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="min_monthly_purchase" id="min_monthly_purchase" value="{{ old('min_monthly_purchase', $customerTier->min_monthly_purchase ?? 0) }}" required min="0" step="1000" class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('min_monthly_purchase') ? 'border-red-500' : 'border-slate-300' }} focus:ring-primary/50 focus:border-primary/50">
                        @error('min_monthly_purchase') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="payment_term_days" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Termin Pembayaran (Hari) <span class="text-red-500">*</span></label>
                        <input type="number" name="payment_term_days" id="payment_term_days" value="{{ old('payment_term_days', $customerTier->payment_term_days ?? 7) }}" required min="0" class="w-full px-3 py-2 text-sm dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm {{ $errors->has('payment_term_days') ? 'border-red-500' : 'border-slate-300' }} focus:ring-primary/50 focus:border-primary/50">
                        @error('payment_term_days') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.customer-tiers.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600">Batal</a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg shadow-sm hover:bg-primary/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            <span>{{ $isEditMode ? 'Simpan Perubahan' : 'Simpan Tier' }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
