<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan model Product di-import

class ProductController extends Controller
{
  /**
   * Menampilkan halaman detail untuk satu produk.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\View\View
   */
  public function show(Product $product)
  {
    // Berkat Route Model Binding, kita tidak perlu mencari produk lagi.
    // Laravel sudah menyediakannya di variabel $product.

    // Kita hanya perlu mengirimkan data produk tersebut ke view.
    return view('customers.DetailProduk', compact('product'));
  }
}
