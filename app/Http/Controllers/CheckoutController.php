<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function show(Request $request)
    {
        /** @var \App\Models\Customer $user */
        $user = Auth::guard('customer')->user();
        
        // Mengambil item yang dipilih dari halaman keranjang (jika ada)
        $selectedItemIds = $request->query('items', []);
        $cart = session('cart', []);

        if (!empty($selectedItemIds)) {
            $cartItems = array_intersect_key($cart, array_flip($selectedItemIds));
            session(['checkout_items' => $cartItems]);
        } else {
            
            $cartItems = session('checkout_items', []);
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('info', 'Keranjang belanja Anda kosong atau belum ada produk yang dipilih.');
        }

        
        $selectedAddressId = session('selected_address_id');
        $selectedAddress = $selectedAddressId 
            ? Address::where('id_address', $selectedAddressId)->where('id_customer', $user->id_customer)->first()
            : ($user->addresses()->where('is_primary', true)->first() ?? $user->addresses()->first());
        
        if (!$selectedAddress) {
             return redirect()->route('profile.show', ['#alamat'])->with('info', 'Silakan tambahkan alamat pengiriman terlebih dahulu.');
        }

        $allAddresses = $user->addresses()->latest()->get();

        return view('customers.checkout', compact('user', 'cartItems', 'selectedAddress', 'allAddresses'));
    }

    /**
     * Memproses pesanan dari halaman checkout.
     */
    public function process(Request $request)
    {

        $validatedData = $request->validate([
            'payment_method' => 'required|string|in:cod,kredit_toko',
            'address_id' => 'required|exists:addresses,id_address',
        ]);

        /** @var \App\Models\Customer $user */
        $user = Auth::guard('customer')->user();
        $checkoutItems = session('checkout_items', []);

        if (empty($checkoutItems)) {
            return redirect()->route('home')->with('error', 'Sesi checkout berakhir. Silakan ulangi dari keranjang.');
        }

        $address = Address::find($validatedData['address_id']);
        if ($address->id_customer !== $user->id_customer) {
            return redirect()->back()->with('error', 'Alamat pengiriman tidak valid.');
        }

        DB::beginTransaction();
        try {
            $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $checkoutItems));

            $transaction = Transaction::create([
                'id_customer' => $user->id_customer,
                'date_transaction' => now(),
                'total_price' => $totalPrice,
                'status' => ($validatedData['payment_method'] === 'kredit_toko') ? 'diproses' : 'belum-bayar',
                'method_payment' => $validatedData['payment_method'],
                'shipping_address' => json_encode($address->toArray()),
            ]);

            foreach ($checkoutItems as $id => $item) {
                TransactionDetail::create([
                    'id_transaction' => $transaction->id_transaction,
                    'id_product' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                Product::find($item['product_id'])->decrement('total_stock', $item['quantity']);
                session()->pull('cart.' . $id);
            }
            
            if ($validatedData['payment_method'] === 'kredit_toko') {
                $user->credit_limit -= $totalPrice;
                $user->save();
            }

            session()->forget(['checkout_items', 'selected_address_id']);
            DB::commit();

            return redirect()->route('order.confirmation', $transaction)->with('success', 'Pesanan Anda berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Gagal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda.');
        }
    }
}
