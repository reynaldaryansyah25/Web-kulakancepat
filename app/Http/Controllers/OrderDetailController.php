<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDetailController extends Controller
{
   
    public function confirmation(Transaction $transaction)
    {
        if ($transaction->id_customer !== Auth::guard('customer')->id()) {
            abort(403, 'Akses Ditolak');
        }

        return view('customers.order-confirmation', compact('transaction'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->id_customer !== Auth::guard('customer')->id()) {
            abort(403, 'Akses Ditolak');
        }

        $transaction->load('details.product');

        return view('customers.order-detail', [
            'transaction' => $transaction,
        ]);
    }
}
