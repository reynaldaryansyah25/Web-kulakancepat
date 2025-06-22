<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk memeriksa status login

class HomeController extends Controller
{
  /**
   * Menampilkan halaman landing utama.
   *
   * Halaman ini akan secara dinamis menampilkan konten yang berbeda
   * tergantung pada apakah pengguna sudah login atau belum,
   * berkat logika @guest dan @auth di dalam file blade.
   *
   * @return \Illuminate\View\View
   */
  public function landing()
  {
    // Fungsi ini hanya perlu mengembalikan view.
    // Logika untuk menampilkan/menyembunyikan tombol
    // sudah ditangani langsung di dalam file blade.
    return view('customers.landing');
  }
}
