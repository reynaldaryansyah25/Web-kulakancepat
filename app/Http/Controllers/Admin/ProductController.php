<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
  public function index(Request $request)
  {
    $search = $request->input('search_product');
    $categoryFilter = $request->input('id_product_category');

    $query = Product::query()->with('category');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('name_product', 'like', "%{$search}%")
          ->orWhere('SKU', 'like', "%{$search}%");
      });
    }

    if ($categoryFilter) {
      $query->where('id_product_category', $categoryFilter);
    }

    $products = $query->orderBy('created', 'desc')->paginate(10);
    $categories = ProductCategory::orderBy('name')->get();

    return view('admin.products.index', compact('products', 'categories'));
  }

  public function create()
  {
    $categories = ProductCategory::orderBy('name')->get();
    return view('admin.products.form', compact('categories'));
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name_product' => 'required|string|max:255',
      'SKU' => 'required|string|max:255|unique:products,SKU',
      'description' => 'nullable|string',
      'price' => 'required|numeric|min:0',
      'total_stock' => 'required|integer|min:0',
      'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
      'id_product_category' => 'nullable|exists:products_category,id_product_category',
    ]);

    if ($request->hasFile('image_file')) {
      $path = $request->file('image_file')->store('products', 'public');
      $validatedData['image_path'] = $path;
    }
    unset($validatedData['image_file']);

    Product::create($validatedData);

    return redirect()->route('admin.products.index')->with('success', 'Produk baru berhasil ditambahkan.');
  }

  public function edit(Product $product)
  {
    $categories = ProductCategory::orderBy('name')->get();
    return view('admin.products.form', compact('product', 'categories'));
  }

  public function update(Request $request, Product $product)
  {
    $validatedData = $request->validate([
      'name_product' => 'required|string|max:255',
      'SKU' => ['required', 'string', 'max:255', Rule::unique('products', 'SKU')->ignore($product->id_product, 'id_product')],
      'description' => 'nullable|string',
      'price' => 'required|numeric|min:0',
      'total_stock' => 'required|integer|min:0',
      'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
      'id_product_category' => 'nullable|exists:products_category,id_product_category',
    ]);

    if ($request->hasFile('image_file')) {
      if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
        Storage::disk('public')->delete($product->image_path);
      }
      $path = $request->file('image_file')->store('products', 'public');
      $validatedData['image_path'] = $path;
    }
    unset($validatedData['image_file']);

    $product->update($validatedData);

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
  }

  public function destroy(Product $product)
  {
    if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
      Storage::disk('public')->delete($product->image_path);
    }
    $product->delete();
    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
  }
}
