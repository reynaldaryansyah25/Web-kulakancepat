<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $cartItems = session('cart', []);
        return view('customers.cart', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang belanja.
     */
    public function add(Request $request, Product $product)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:999'
            ], [
                'quantity.required' => 'Jumlah produk harus diisi.',
                'quantity.integer' => 'Jumlah produk harus berupa angka.',
                'quantity.min' => 'Jumlah produk minimal 1.',
                'quantity.max' => 'Jumlah produk maksimal 999.'
            ]);

            $cart = session('cart', []);
            $cartItemId = $product->id_product;
            $requestedQuantity = (int)$request->quantity;

            // Cek apakah produk sudah ada di keranjang
            if (isset($cart[$cartItemId])) {
                $newQuantity = $cart[$cartItemId]['quantity'] + $requestedQuantity;
                
                // Batasi maksimal quantity per item
                if ($newQuantity > 999) {
                    return redirect()->back()->with('error', 'Jumlah produk melebihi batas maksimal (999).');
                }
                
                $cart[$cartItemId]['quantity'] = $newQuantity;
                $message = 'Jumlah produk di keranjang berhasil ditambahkan!';
            } else {
                // Tambah produk baru ke keranjang
                $cart[$cartItemId] = [
                    "product_id" => $product->id_product,
                    "name" => $product->name_product,
                    "quantity" => $requestedQuantity,
                    "price" => $product->price,
                    "image" => $product->image_path,
                    "description" => $product->description,
                ];
                $message = 'Produk berhasil ditambahkan ke keranjang!';
            }

            session(['cart' => $cart]);

            return redirect()->route('cart.index')->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error adding product to cart: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan produk ke keranjang.');
        }
    }

    /**
     * Memperbarui jumlah item di keranjang.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|string',
                'quantity' => 'required|integer|min:1|max:999',
            ], [
                'id.required' => 'ID produk tidak valid.',
                'quantity.required' => 'Jumlah produk harus diisi.',
                'quantity.integer' => 'Jumlah produk harus berupa angka.',
                'quantity.min' => 'Jumlah produk minimal 1.',
                'quantity.max' => 'Jumlah produk maksimal 999.'
            ]);

            $cart = session('cart', []);
            $cartItemId = $request->id;
            $newQuantity = (int)$request->quantity;

            if (isset($cart[$cartItemId])) {
                // Update quantity
                $cart[$cartItemId]['quantity'] = $newQuantity;
                session(['cart' => $cart]);
                
                return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
            }

            return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan di keranjang.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('cart.index')->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error updating cart item: ' . $e->getMessage(), [
                'cart_item_id' => $request->id ?? 'unknown',
                'quantity' => $request->quantity ?? 'unknown'
            ]);
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memperbarui keranjang.');
        }
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function remove(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|string'
            ], [
                'id.required' => 'ID produk tidak valid.'
            ]);

            $cart = session('cart', []);
            $cartItemId = $request->id;

            if (isset($cart[$cartItemId])) {
                $productName = $cart[$cartItemId]['name'] ?? 'Produk';
                unset($cart[$cartItemId]);
                session(['cart' => $cart]);
                
                return redirect()->route('cart.index')->with('success', "Produk \"$productName\" berhasil dihapus dari keranjang.");
            }

            return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan di keranjang.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('cart.index')->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error removing cart item: ' . $e->getMessage(), [
                'cart_item_id' => $request->id ?? 'unknown'
            ]);
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat menghapus item dari keranjang.');
        }
    }

    /**
     * Mengosongkan seluruh keranjang belanja.
     */
    public function clear()
    {
        try {
            session()->forget('cart');
            return redirect()->route('cart.index')->with('success', 'Keranjang belanja berhasil dikosongkan.');
        } catch (\Exception $e) {
            Log::error('Error clearing cart: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat mengosongkan keranjang.');
        }
    }

    /**
     * Mendapatkan jumlah total item di keranjang (untuk badge/counter).
     */
    public function getCartCount()
    {
        try {
            $cart = session('cart', []);
            $totalItems = array_sum(array_column($cart, 'quantity'));
            
            return response()->json(['count' => $totalItems]);
        } catch (\Exception $e) {
            Log::error('Error getting cart count: ' . $e->getMessage());
            return response()->json(['count' => 0]);
        }
    }

    /**
     * Mendapatkan total harga keranjang.
     */
    public function getCartTotal()
    {
        try {
            $cart = session('cart', []);
            $totalPrice = 0;

            foreach ($cart as $item) {
                $totalPrice += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
            }

            return response()->json([
                'total' => $totalPrice,
                'formatted_total' => 'Rp' . number_format($totalPrice, 0, ',', '.')
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting cart total: ' . $e->getMessage());
            return response()->json([
                'total' => 0,
                'formatted_total' => 'Rp0'
            ]);
        }
    }
}