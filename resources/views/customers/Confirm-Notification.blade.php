<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transaksi Berhasil!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
    <!-- Top Navbar -->
    <nav class="bg-red-700 text-white text-sm py-2">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:underline">Home</a>
                <span>Ikuti kami di</span>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="relative">
                    <i class="fas fa-bell"></i> Notifikasi
                    <span class="bg-white text-red-600 rounded-full text-xs px-2 ml-1">5</span>
                </a>
                <a href="#"><i class="fas fa-globe"></i> Bahasa Indonesia <i
                        class="fas fa-chevron-down text-xs"></i></a>
                <a href="#" class="flex items-center space-x-2">
                    <img src="https://i.pravatar.cc/40?u=nistelroy" class="rounded-full h-6 w-6" />
                    <span>Ruud Van Nistelroy</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Header -->
    <header class="bg-white shadow py-4 border-b border-gray-200">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a href="#" class="flex items-center space-x-2 text-red-700 text-2xl font-bold">
                <img src="Artboard 1.png" alt="Logo Kulakan" class="h-20" />
                <span>KulakanCepat</span>
            </a>
            <div class="relative">
                <i class="fas fa-shopping-cart text-red-700 text-2xl"></i>
                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-2">2</span>
            </div>
        </div>
    </header>

    <!-- Success Card -->
    <div class="container mx-auto px-4 mt-12">
        <div class="bg-white rounded-lg shadow-lg p-10 text-center max-w-xl mx-auto">
            <div class="w-20 h-20 rounded-full bg-green-600 flex items-center justify-center mx-auto mb-6">
                <svg class="text-white w-10 h-10" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">PESANAN ANDA BERHASIL!</h1>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                Terima kasih telah berbelanja di KulakanCepat Id.<br />
                Nomor pesanan Anda adalah: <span class="font-bold text-red-700">198887</span><br />
                Anda bisa mengecek status pesanan melalui detail pemesanan.<br />
                Pesanan Anda akan segera diproses.
            </p>
            <a href="#"
                class="inline-block bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-6 rounded">PERIKSA PESANAN
                SAYA</a>
            <p class="text-sm text-gray-500 mt-6">
                Jika Anda memiliki pertanyaan, silakan menghubungi pusat
                <a href="#" class="text-red-700 font-medium hover:underline">Bantuan KulakanCepat</a>.
            </p>
        </div>
    </div>
</body>

</html>
