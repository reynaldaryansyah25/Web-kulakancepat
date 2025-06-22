{{-- File: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - KulakanCepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#B8182D] to-[#520B14] min-h-screen flex items-center justify-center">
    <div class="flex min-h-screen w-full">
        
        <!-- Left Panel -->
        <div class="w-1/2 flex-col justify-center pl-20 text-white hidden md:flex">
            <div class="flex items-center gap-4 mb-2">
                <img src="{{ asset('images/logo/Artboard 1 copy 3.png') }}" alt="Logo" class="w-40 h-40"/>
                <h1 class="text-5xl font-semibold">KulakanCepat</h1>
            </div>
            <p class="text-5xl font-bold leading-tight">Solusi mudah untuk <br />belanja grosir</p>
        </div>

        <!-- Right Panel (Form) -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 sm:p-20">
            <form method="POST" action="{{ route('login') }}" class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md text-center">
                @csrf

                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Login</h2>
                
                <button type="button" class="w-full border border-red-300 text-gray-800 font-medium py-2 rounded-md flex items-center justify-center gap-2 mb-3 hover:bg-[#520B14] hover:text-white transition">
                    <img src="https://img.icons8.com/color/16/google-logo.png" alt="Google" /> Login Google
                </button>

                <div class="flex items-center my-4 text-sm text-gray-500">
                    <hr class="flex-grow border-gray-300" />
                    <span class="px-2">atau</span>
                    <hr class="flex-grow border-gray-300" />
                </div>

                {{-- Blok untuk menampilkan SEMUA pesan error dari controller --}}
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 text-left text-sm" role="alert">
                        <strong>Oops! Terjadi kesalahan:</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Input Email --}}
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus 
                           class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400" />
                </div>

                {{-- Input Password --}}
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Password" required
                           class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400" />
                </div>

                <button type="submit" class="w-full bg-[#B8182D] hover:bg-[#520B14] text-white py-2 rounded-md text-base font-medium transition">Login</button>

                <p class="mt-4 text-sm">
                    <a href="#" class="text-blue-600 hover:underline font-medium">Lupa Kata sandi?</a>
                </p>
                <p class="mt-2 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-red-600 hover:underline font-bold">Daftar di sini</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
