<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
  public function showRegistrationForm()
  {
    return view('auth.register');
  }

  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name_store' => ['required', 'string', 'max:255'],
      'name_owner' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:100', 'unique:customer,email'],
      'no_phone' => ['required', 'string', 'max:20'],
      'address' => ['required', 'string', 'max:255'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    if ($validator->fails()) {
      // Jika validasi gagal, ini akan ditampilkan di form berkat @error
      return redirect('register')->withErrors($validator)->withInput();
    }

    // --- BAGIAN DEBUGGING TRY...CATCH ---
    try {
      // Kita coba untuk membuat customer
      Customer::create([
        'name_store' => $request->name_store,
        'name_owner' => $request->name_owner,
        'email' => $request->email,
        'no_phone' => $request->no_phone,
        'address' => $request->address,
        'password' => $request->password,
        'status' => 'PENDING_APPROVE',
        'credit_limit' => 0,
        'id_sales' => null,
        'customer_tier_id' => null,
      ]);
    } catch (\Exception $e) {
      // JIKA ADA ERROR APAPUN saat create, hentikan semua dan tampilkan pesannya.
      // Pesan error ini adalah kunci masalah kita.
      dd($e->getMessage());
    }
    // --- AKHIR BAGIAN DEBUGGING ---

    return redirect()->route('auth.pending');
  }
}
