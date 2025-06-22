<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk produk
        $productsQuery = Product::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $productsQuery->where('name_product', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $productsQuery->where('id_product_category', $request->category);
        }

        // Pengurutan
        if ($request->get('sort') == 'price_asc') {
            $productsQuery->orderBy('price', 'asc');
        } elseif ($request->get('sort') == 'price_desc') {
            $productsQuery->orderBy('price', 'desc');
        } else {
            $productsQuery->latest(); // Default: terbaru
        }

        // Ambil data produk dengan pagination
        $products = $productsQuery->paginate(10);

        if ($request->ajax()) {
            return view('customers.partials._product_list', compact('products'))->render();
        }

        // Jika bukan AJAX, muat halaman katalog lengkap
        $categories = ProductCategory::all();
        
        return view('customers.katalog', compact('products', 'categories'));
    }
}
