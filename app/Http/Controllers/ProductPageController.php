<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    /**
     * Menampilkan halaman detail untuk produk yang spesifik.
     * Menggunakan Route-Model Binding untuk secara otomatis menemukan produk.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Mengirim data produk yang ditemukan ke view 'DetailProduk'
        return view('customers.DetailProduk', compact('product'));
    }
}
