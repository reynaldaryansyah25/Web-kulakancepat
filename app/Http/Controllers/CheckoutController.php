<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function show(Request $request) {
        /** @var \App\Models\Customer $user */
        $user = Auth::guard('customer')->user();
        $cartItems = $request->session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('info', 'Keranjang belanja Anda kosong. Silakan belanja dulu.');
        }

        $selectedAddressId = session('selected_address_id');
        $selectedAddress = null;

        if ($selectedAddressId) {
            $selectedAddress = Address::where('id_address', $selectedAddressId)
                                      ->where('id_customer', $user->id_customer)
                                      ->first();
        }

        if (!$selectedAddress) {
            $selectedAddress = $user->addresses()->where('is_primary', true)->first() 
                            ?? $user->addresses()->first();
        }
        
        if (!$selectedAddress) {
             return redirect()->route('profile.show', ['#alamat'])->with('info', 'Silakan tambahkan alamat pengiriman terlebih dahulu.');
        }

        $allAddresses = $user->addresses()->latest()->get();

        return view('customers.checkout', [
            'user' => $user,
            'cartItems' => $cartItems,
            'selectedAddress' => $selectedAddress,
            'allAddresses' => $allAddresses,
        ]);
    }

    public function process(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string|in:cod,kredit_toko',
            'address_id' => 'required|exists:addresses,id_address',
        ]);

        /** @var \App\Models\Customer $user */
        $user = Auth::guard('customer')->user();
        $cartItems = session('checkout_items', []);

        if (empty($cartItems)) {
            return redirect()->route('home')->with('error', 'Sesi checkout berakhir. Silakan ulangi dari keranjang.');
        }

        $address = Address::find($validatedData['address_id']);
        if ($address->id_customer !== $user->id_customer) {
            return back()->with('error', 'Alamat pengiriman tidak valid.');
        }

        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
        
        DB::beginTransaction();
        try {
            $paymentMethod = $validatedData['payment_method'];
            $transactionStatus = 'belum-bayar';

            if ($paymentMethod === 'kredit_toko') {
                if ($user->credit_limit < $totalPrice) {
                    return back()->with('error', 'Limit kredit Anda tidak mencukupi.');
                }
                $user->credit_limit -= $totalPrice;
                $user->save();
                $transactionStatus = 'diproses';
            }

            $transaction = Transaction::create([
                'id_customer' => $user->id_customer,
                'date_transaction' => now(),
                'total_price' => $totalPrice,
                'status' => $transactionStatus,
                'method_payment' => $paymentMethod,
                'shipping_address' => json_encode($address->toArray()),
            ]);

            foreach ($cartItems as $id => $item) {
                TransactionDetail::create([
                    'id_transaction' => $transaction->id_transaction,
                    'id_product' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                Product::find($item['product_id'])->decrement('total_stock', $item['quantity']);
                session()->pull('cart.' . $id);
            }
            
            session()->forget(['checkout_items', 'selected_address_id']);
            DB::commit();

            return redirect()->route('order.confirmation', $transaction->id_transaction);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Gagal: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }
}