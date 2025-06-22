<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class OrderDetailController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan (order history).
     */
    public function index()
    {
        $customerId = Auth::guard('customer')->id();
        $transactions = Transaction::where('id_customer', $customerId)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        
        return view('customers.order-history', compact('transactions'));
    }

    /**
     * Menampilkan halaman Checkout dengan data dari Session dan Alamat.
     */
    public function checkout()
    {
        $customerId = Auth::guard('customer')->id();
        $cart = Session::get('cart', []);   
        
        $cart = array_filter($cart, function($key) {
            return !empty($key);
        }, ARRAY_FILTER_USE_KEY);

        if (empty($cart)) {
            Session::put('cart', []);
            return redirect()->route('catalog.index')->with('error', 'Keranjang Anda kosong atau berisi item tidak valid!');
        }
        $selectedAddressId = Session::get('selected_address_id');
        $allAddresses = Address::where('id_customer', $customerId)->get();

        if ($allAddresses->isEmpty()) {
            return redirect()->route('profile.show')->with('error', 'Silakan tambahkan alamat pengiriman terlebih dahulu.');
        }

        $selectedAddress = $selectedAddressId
            ? $allAddresses->firstWhere('id_address', $selectedAddressId)
            : $allAddresses->firstWhere('is_primary', true) ?? $allAddresses->first();

        // --- Logika Keranjang (Sekarang Aman) ---
        $productIds = array_keys($cart);
        $products = Product::whereIn('id_product', $productIds)->get();
        $cartItems = [];

        foreach ($products as $product) {
            if (isset($cart[$product->id_product])) {
                $cartItems[] = [  
                    'id'          => $product->id_product,
                    'name'        => $product->name,
                    'description' => $product->short_description ?? '',
                    'image'       => $product->image ?? '',
                    'price'       => $product->price,
                    'quantity'    => $cart[$product->id_product]['quantity'],
                ];
            }
        }

        return view('customers.Checkout', compact('cartItems', 'selectedAddress', 'allAddresses'));
    }

    /**
     * Memproses data dari form checkout untuk membuat transaksi baru.
     */
   public function store(Request $request)
    {
        $request->validate([
            'address_id'     => 'required|exists:addresses,id_address',
            'payment_method' => 'required|in:COD,kredit_toko',
        ]);

        $customerId = Auth::guard('customer')->id();
        $cart = Session::get('cart', []);
        $cart = array_filter($cart, fn($key) => !empty($key), ARRAY_FILTER_USE_KEY);
        
        if (empty($cart)) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        DB::beginTransaction();
        try {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id_product', $productIds)->get()->keyBy('id_product');

            $totalPrice = 0;
            foreach ($cart as $id => $details) {
                if(isset($products[$id])) {
                    $totalPrice += $products[$id]->price * $details['quantity'];
                } else {
                    throw new \Exception("Produk dengan ID {$id} tidak dapat diproses.");
                }
            }

            if ($request->payment_method === 'kredit_toko') {
                $customer = Auth::guard('customer')->user();
                if ($customer->credit_limit < $totalPrice) {
                    throw new \Exception('Limit kredit Anda tidak mencukupi.');
                }
            }
            $transaction = Transaction::create([
                'id_customer'      => $customerId,
                'date_transaction' => Carbon::now(), 
                'total_price'      => $totalPrice, 
                'status'           => 'WAITING_CONFIRMATION', 
                'method_payment'   => $request->payment_method, 
                'payment_due_date' => Carbon::now()->addDay(),  
                'paid_at'          => null,
            ]);
            

            foreach ($cart as $id => $details) {
                TransactionDetail::create([
                    'id_transaction' => $transaction->id_transaction,
                    'id_product'     => $id,
                    'quantity'       => $details['quantity'],
                    'unit_price'     => $products[$id]->price,
                ]);
            }

            Session::forget('cart');
            DB::commit();

            return redirect()->route('order.confirmation', ['transaction' => $transaction->id_transaction])
                             ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.show')->with('error', $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman konfirmasi setelah checkout berhasil.
     */
    public function confirmation(Transaction $transaction)
    {
        if ($transaction->id_customer !== Auth::guard('customer')->id()) {
            abort(403, 'Akses Ditolak');
        }
        return view('customers.order-confirmation', compact('transaction'));
    }

    /**
     * Menampilkan detail lengkap dari satu transaksi.
     */
    public function show(Transaction $transaction)
    {
        if ($transaction->id_customer !== Auth::guard('customer')->id()) {
            abort(403, 'Akses Ditolak');
        }
        $transaction->load('details.product');
        return view('customers.order-detail', compact('transaction'));
    }
}