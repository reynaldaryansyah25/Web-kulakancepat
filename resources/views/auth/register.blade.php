{{-- File: resources/views/auth/register.blade.php --}}
{{-- Menggunakan desain Anda dan diintegrasikan dengan Laravel --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register - KulakanCepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#B8182D] to-[#520B14] min-h-screen flex items-center justify-center py-8">

    <div class="flex min-h-screen w-full">
        <!-- Left Panel -->
        <div class="w-1/2 flex-col justify-center pl-20 text-white hidden md:flex">
            <div class="flex items-center gap-4 mb-2">
                {{-- Menggunakan path yang lebih standar untuk gambar --}}
                <img src="{{ asset('img/Logo Kulakan/1x/Artboard 1 copy 3.png') }}" alt="Logo" class="w-60 h-60" />
                <h1 class="text-5xl font-semibold">KulakanCepat</h1>
            </div>
            <p class="text-5xl font-bold leading-tight">Solusi mudah untuk <br />belanja grosir</p>
        </div>

        <!-- Form Panel -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 sm:p-20">
            <form method="POST" action="{{ route('register') }}" class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md text-center">
                @csrf 
                
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Registrasi</h2>

                {{-- Kolom Nama Toko --}}
                <div class="mb-4">
                    <input type="text" name="name_store" placeholder="Nama Toko Anda" value="{{ old('name_store') }}" required class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('name_store') border-red-500 @enderror" />
                    @error('name_store') <p class="text-red-500 text-xs text-left mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- DIUBAH: name="name" menjadi "name_owner" --}}
                <div class="mb-4">
                    <input type="text" name="name_owner" placeholder="Nama Anda" value="{{ old('name_owner') }}" required class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('name_owner') border-red-500 @enderror" />
                    @error('name_owner') <p class="text-red-500 text-xs text-left mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kolom Email --}}
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('email') border-red-500 @enderror" />
                    @error('email') <p class="text-red-500 text-xs text-left mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- DIUBAH: name="phone_number" menjadi "no_phone" --}}
                <div class="mb-4">
                    <input type="text" name="no_phone" placeholder="No telepon" value="{{ old('no_phone') }}" required class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('no_phone') border-red-500 @enderror" />
                    @error('no_phone') <p class="text-red-500 text-xs text-left mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- DIUBAH: name="store_address" menjadi "address" --}}
                <div class="mb-4">
                    <input type="text" name="address" placeholder="Alamat Toko" value="{{ old('address') }}" required class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('address') border-red-500 @enderror" />
                    @error('address') <p class="text-red-500 text-xs text-left mt-1">{{ $message }}</p> @enderror
                </div>
                
                {{-- Kolom Password --}}
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Password" required class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('password') border-red-500 @enderror" />
                    @error('password') <p class="text-red-500 text-xs text-left mt-1">{{ $message }}</p> @enderror
                </div>
                
                {{-- Kolom Konfirmasi Password --}}
                <div class="mb-4">
                    <input type="password" name="password_confirmation" placeholder="Ulangi Password" required class="w-full border border-red-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400" />
                </div>

                {{-- DIUBAH: Menggunakan <button type="submit"> yang benar --}}
                <button type="submit" class="w-full bg-[#B8182D] hover:bg-[#520B14] text-white py-2 rounded-md text-base font-medium transition">Register Now</button>

                <p class="mt-4 text-sm">
                    Sudah mempunyai akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Login Now</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>

