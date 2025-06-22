<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login - KulakanCepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      body {
        font-family: 'Inter', sans-serif, system-ui;
      }
    </style>
  </head>
  <body
    class="flex min-h-screen items-center justify-center bg-gradient-to-b from-[#B8182D] to-[#520B14] p-4">
    <div class="flex w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl">
      <div
        class="hidden w-1/2 flex-col justify-center p-12 text-white md:flex"
        style="background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%)">
        <div class="mb-4 flex items-center gap-4">
          <img
            src="{{ asset('img/Logo Kulakan/1x/Artboard 1 copy 3.png') }}"
            alt="Logo"
            class="h-20 w-20 rounded-xl" />
          <div>
            <h1 class="text-4xl font-bold">KulakanCepat</h1>
            <p class="text-white/80">Admin Panel</p>
          </div>
        </div>
        <p class="mt-4 text-xl font-light leading-relaxed">
          Selamat datang di pusat kendali. Silakan login untuk mengelola operasional bisnis.
        </p>
      </div>

      <div class="flex w-full items-center justify-center p-8 sm:p-12 md:w-1/2">
        <div class="w-full">
          <h2 class="mb-2 text-3xl font-bold text-gray-800">Admin Login</h2>
          <p class="mb-8 text-sm text-gray-600">Masukkan kredensial Anda untuk melanjutkan.</p>

          {{-- Blok untuk menampilkan pesan error login --}}
          @if ($errors->any())
            <div
              class="mb-6 border-l-4 border-red-500 bg-red-100 p-4 text-left text-sm text-red-700"
              role="alert">
              <p>{{ $errors->first() }}</p>
            </div>
          @endif

          <form method="POST" action="{{ route('admin.login.submit') }}" class="w-full">
            @csrf

            {{-- Input Email --}}
            <div class="mb-4">
              <label for="email" class="sr-only">Email</label>
              <input
                type="email"
                name="email"
                id="email"
                placeholder="Email"
                value="{{ old('email') }}"
                required
                autofocus
                class="w-full rounded-md border border-gray-300 p-3 text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-400" />
            </div>

            {{-- Input Password --}}
            <div class="mb-6">
              <label for="password" class="sr-only">Password</label>
              <input
                type="password"
                name="password"
                id="password"
                placeholder="Password"
                required
                class="w-full rounded-md border border-gray-300 p-3 text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-400" />
            </div>

            <div class="mb-6 flex items-center justify-between">
              <div class="flex items-center">
                <input
                  id="remember"
                  name="remember"
                  type="checkbox"
                  class="text-primary focus:ring-primary/50 h-4 w-4 rounded border-slate-300" />
                <label for="remember" class="ml-2 block text-sm text-slate-700">Remember me</label>
              </div>
              {{-- Link lupa password bisa diaktifkan jika fiturnya sudah dibuat --}}
              {{-- <a href="#" class="text-sm text-red-600 hover:underline font-medium">Lupa password?</a> --}}
            </div>

            <button
              type="submit"
              class="w-full transform rounded-md bg-[#B8182D] py-3 text-base font-medium text-white transition-transform hover:scale-105 hover:bg-[#991B1B]">
              Login
            </button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
