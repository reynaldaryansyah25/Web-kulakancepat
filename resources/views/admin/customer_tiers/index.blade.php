@extends('admin.layouts.app')

@section('title', 'Manajemen Tier Pelanggan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tier Pelanggan</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola level dan benefit untuk pelanggan</p>
        </div>
        <div>
            <a href="{{ route('admin.customer-tiers.create') }}" class="inline-flex items-center px-4 py-2 bg-red-700 text-white text-sm font-medium rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Tier
            </a>
        </div>
    </div>

    <!-- Notifications -->
    @if (session('success'))
    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg text-sm">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg text-sm">
        {{ session('error') }}
    </div>
    @endif

    <!-- Tier Cards - Uniform Size -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($tiers as $tier)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm h-full flex flex-col">
            <div class="p-6 flex-grow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $tier->name }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($tier->description, 60) }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                        {{ $tier->customers_count }} pelanggan
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Min. Pembelian</p>
                        <p class="mt-1 font-medium text-gray-900 dark:text-white">Rp{{ number_format($tier->min_monthly_purchase, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Termin</p>
                        <p class="mt-1 font-medium text-gray-900 dark:text-white">{{ $tier->payment_term_days }} hari</p>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-2">
                <a href="{{ route('admin.customer-tiers.edit', $tier->id_customer_tier) }}" class="p-2 text-gray-500 dark:text-gray-400 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                    </svg>
                </a>
                <form action="{{ route('admin.customer-tiers.destroy', $tier->id_customer_tier) }}" method="POST" onsubmit="return confirm('Hapus tier ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-gray-500 dark:text-gray-400 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="md:col-span-3 py-12 text-center">
            <div class="mx-auto w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-700 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada tier pelanggan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Mulai dengan membuat tier pertama Anda</p>
            <a href="{{ route('admin.customer-tiers.create') }}" class="inline-flex items-center px-4 py-2 bg-red-700 text-white text-sm font-medium rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Tier
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if (isset($tiers) && $tiers->hasPages())
    <div class="mt-8">
        {{ $tiers->links('vendor.pagination.simple-tailwind') }}
    </div>
    @endif
</div>
@endsection