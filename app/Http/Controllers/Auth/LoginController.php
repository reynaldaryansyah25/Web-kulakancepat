<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function showLoginForm()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
      $customer = Auth::guard('customer')->user();

      if ($customer->status !== 'ACTIVE') {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors([
          'email' => 'Akun Anda belum aktif. Harap tunggu persetujuan dari admin.',
        ])->onlyInput('email');
      }

      $request->session()->regenerate();

      // Debugging - Hapus setelah testing
      // dd(Auth::guard('customer')->check(), session()->all());

      return redirect()->route('home')->with('success', 'Selamat datang, ' . $customer->name_store . '!');
    }

    return back()->withErrors([
      'email' => 'Email atau password yang Anda masukkan salah.',
    ])->onlyInput('email');
  }
  /**
   * Menangani permintaan logout.
   */
  public function logout(Request $request)
  {
    Auth::guard('customer')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  }
}
