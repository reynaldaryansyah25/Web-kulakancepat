<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class HalamanUtamaController extends Controller
{
  /**
   * Menampilkan halaman utama setelah user login.
   * Mengambil data kategori, produk terlaris, dan produk terbaru.
   */
  public function index()
  {
  
    $categories = ProductCategory::all();
    $bestSellingProducts = Product::inRandomOrder()->take(8)->get();

    
    $latestProducts = Product::latest()->take(8)->get();

    return view('customers.HalamanUtama', [
      'categories' => $categories,
      'bestSellingProducts' => $bestSellingProducts,
      'latestProducts' => $latestProducts,
    ]);
  }
}
