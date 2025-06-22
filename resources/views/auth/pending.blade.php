<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan - KulakanCepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#B8182D] to-[#520B14] min-h-screen flex items-center justify-center p-4">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md text-center">
        <div class="text-yellow-500 mb-4">
            <svg class="mx-auto h-16 w-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Terima Kasih Telah Mendaftar!</h1>
        <p class="text-gray-600 mb-6">
            Akun Anda telah berhasil dibuat dan saat ini sedang menunggu persetujuan dari Admin. Anda akan menerima notifikasi jika akun Anda sudah diaktifkan.
        </p>
        <a href="{{ route('landing') }}" class="w-full bg-[#B8182D] hover:bg-[#520B14] text-white py-2 rounded-md text-base font-medium transition block">
            Kembali ke Halaman Awal
        </a>
    </div>
</body>
</html>