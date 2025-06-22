<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KulakanCepat - Grosir Digital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { scroll-behavior: smooth; }
        .gradient-bg { background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); }
        .mobile-menu { display: none; }
        .mobile-menu.active { display: block; }
        @media (max-width: 768px) { .hero-title { font-size: 2.5rem; } }
    </style>
</head>
<body class="bg-white text-gray-800 font-sans">

    <!-- Header -->
    <header class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-20 h-20 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('img/logo/Artboard 1 copy.png') }}" alt="Logo KulakanCepat">
                    </div>
                    <span class="text-2xl font-extrabold text-red-700">KulakanCepat</span>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#merchant" class="text-gray-700 hover:text-red-700 font-medium transition-colors">Merchant</a>
                    <a href="#blog" class="text-gray-700 hover:text-red-700 font-medium transition-colors">Blog</a>
                    <a href="#berita" class="text-gray-700 hover:text-red-700 font-medium transition-colors">Berita</a>

                    {{-- DIUBAH: Logika dinamis berdasarkan status login --}}
                    @guest
                        {{-- Jika user adalah tamu (belum login) --}}
                        <a href="{{ route('login') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-semibold hover:bg-red-800 transition-colors shadow-md">Masuk</a>
                    @else
                        {{-- Jika user sudah login --}}
                        <span class="text-gray-700 font-medium">Hi, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="bg-gray-700 text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-800 transition-colors shadow-md">
                           Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </nav>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="mobile-menu md:hidden mt-4 pb-4 border-t border-gray-200">
                <div class="flex flex-col space-y-4 pt-4">
                    <a href="#merchant" class="text-gray-700 hover:text-red-700 font-medium">Merchant</a>
                    <a href="#blog" class="text-gray-700 hover:text-red-700 font-medium">Blog</a>
                    <a href="#berita" class="text-gray-700 hover:text-red-700 font-medium">Berita</a>
                    @guest
                        <a href="{{ route('login') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-semibold text-center">Masuk</a>
                        <a href="{{ route('register') }}" class="border border-red-700 text-red-700 px-6 py-2 rounded-full font-semibold text-center mt-2">Daftar</a>
                    @else
                        <span class="text-gray-700 font-medium px-4 py-2">Hi, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                           class="bg-gray-700 text-white px-6 py-2 rounded-full font-semibold text-center">
                           Logout
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-red-800 to-red-600 text-white py-24 px-6 relative overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center justify-between gap-10">
            <img src="{{ asset('img/logo/Truk.png') }}" alt="Truk" class="w-full max-w-2xl md:w-[400px] lg:w-[500px] drop-shadow-xl rounded-2xl transition-transform duration-300 hover:scale-105" />
            <div class="text-center md:text-left max-w-xl">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 hero-title">Belanja Grosir Kini Lebih Mudah</h1>
                <p class="text-lg md:text-xl mb-8">KulakanCepat hadir untuk bantu toko dan UMKM se-Indonesia berkembang.</p>
                @guest
                    {{-- Tombol "Daftar" hanya tampil jika belum login --}}
                    <a href="{{ route('register') }}" class="bg-white text-red-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-red-800 hover:text-white transition shadow-lg">Daftar Sekarang</a>
                @else
                    {{-- Jika sudah login, bisa arahkan ke katalog --}}
                    <a href="{{ route('catalog.index') }}" class="bg-white text-red-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-red-800 hover:text-white transition shadow-lg">Mulai Belanja</a>
                @endguest
            </div>
        </div>
    </section>

     <!-- Stats Section -->
  <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
        <div class="card-hover">
          <div class="text-3xl lg:text-4xl font-bold text-red-700 mb-2">1000+</div>
          <div class="text-gray-600 font-medium">Merchant Terdaftar</div>
        </div>
        <div class="card-hover">
          <div class="text-3xl lg:text-4xl font-bold text-red-700 mb-2">50K+</div>
          <div class="text-gray-600 font-medium">Toko Partner</div>
        </div>
        <div class="card-hover">
          <div class="text-3xl lg:text-4xl font-bold text-red-700 mb-2">100+</div>
          <div class="text-gray-600 font-medium">Kota Jangkauan</div>
        </div>
        <div class="card-hover">
          <div class="text-3xl lg:text-4xl font-bold text-red-700 mb-2">24/7</div>
          <div class="text-gray-600 font-medium">Customer Support</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Merchant Section -->
  <section id="merchant" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="text-center mb-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-red-700 mb-4">#1 GROSIR MERCHANT</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Bergabunglah dengan ekosistem grosir digital terdepan di Indonesia
        </p>
      </div>
      
      <div class="grid lg:grid-cols-2 gap-8">
        <!-- Prinsipal Card -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 p-8 lg:p-12 rounded-3xl shadow-lg card-hover">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-red-700 rounded-full flex items-center justify-center mr-4">
              <i class="fas fa-industry text-white"></i>
            </div>
            <h3 class="text-red-700 font-bold text-2xl">#UntukPrinsipal</h3>
          </div>
          <p class="text-gray-700 text-lg mb-6">
            Peluang besar bersama KulakanCepat untuk menjangkau pasar UMKM yang lebih luas dan meningkatkan distribusi produk Anda.
          </p>
          <ul class="text-gray-600 space-y-2 mb-8">
            <li class="flex items-center"><i class="fas fa-check text-red-700 mr-2"></i> Akses ke ribuan toko retail</li>
            <li class="flex items-center"><i class="fas fa-check text-red-700 mr-2"></i> Sistem distribusi terotomatisasi</li>
            <li class="flex items-center"><i class="fas fa-check text-red-700 mr-2"></i> Analytics penjualan real-time</li>
          </ul>
          <a href="#" class="inline-flex items-center text-red-700 font-bold hover:text-red-800 transition-colors">
            Lihat Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
        
        <!-- Toko Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 lg:p-12 rounded-3xl shadow-lg card-hover">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-blue-700 rounded-full flex items-center justify-center mr-4">
              <i class="fas fa-store text-white"></i>
            </div>
            <h3 class="text-blue-700 font-bold text-2xl">#UntukToko</h3>
          </div>
          <p class="text-gray-700 text-lg mb-6">
            Membuat usaha menjadi mudah dengan produk grosir terkurasi dan terpercaya langsung dari distributor resmi.
          </p>
          <ul class="text-gray-600 space-y-2 mb-8">
            <li class="flex items-center"><i class="fas fa-check text-blue-700 mr-2"></i> Harga grosir kompetitif</li>
            <li class="flex items-center"><i class="fas fa-check text-blue-700 mr-2"></i> Pengiriman cepat & aman</li>
            <li class="flex items-center"><i class="fas fa-check text-blue-700 mr-2"></i> Credit limit untuk member</li>
          </ul>
          <a href="#" class="inline-flex items-center text-blue-700 font-bold hover:text-blue-800 transition-colors">
            Lihat Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Blog Section -->
  <section id="blog" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="text-center mb-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-red-700 mb-4">Blog & Aktivitas</h2>
        <p class="text-xl text-gray-600">Update terbaru dan tips bisnis untuk kesuksesan UMKM Anda</p>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Blog Card 1 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
          <div class="aspect-video bg-gradient-to-r from-red-400 to-red-600 flex items-center justify-center">
            <i class="fas fa-play-circle text-white text-6xl cursor-pointer hover:scale-110 transition-transform"></i>
          </div>
          <div class="p-6">
            <h3 class="font-bold text-xl text-gray-800 mb-3">Mudahnya Berjualan di KulakanCepat</h3>
            <p class="text-gray-600 mb-4">Pelajari langkah mudah untuk memulai bisnis grosir digital bersama kami.</p>
            <div class="flex items-center text-sm text-gray-500">
              <i class="fas fa-calendar mr-2"></i>
              <span>15 Maret 2024</span>
            </div>
          </div>
        </div>
        
        <!-- Blog Card 2 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
          <div class="aspect-video bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
            <i class="fas fa-play-circle text-white text-6xl cursor-pointer hover:scale-110 transition-transform"></i>
          </div>
          <div class="p-6">
            <h3 class="font-bold text-xl text-gray-800 mb-3">Tips Mengelola Stok dengan Efektif</h3>
            <p class="text-gray-600 mb-4">Strategi jitu untuk mengoptimalkan inventory dan meningkatkan profit.</p>
            <div class="flex items-center text-sm text-gray-500">
              <i class="fas fa-calendar mr-2"></i>
              <span>10 Maret 2024</span>
            </div>
          </div>
        </div>
        
        <!-- Blog Card 3 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
          <div class="aspect-video bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
            <i class="fas fa-play-circle text-white text-6xl cursor-pointer hover:scale-110 transition-transform"></i>
          </div>
          <div class="p-6">
            <h3 class="font-bold text-xl text-gray-800 mb-3">Peluang UMKM di Era Digital</h3>
            <p class="text-gray-600 mb-4">Maksimalkan potensi bisnis Anda dengan memanfaatkan teknologi digital.</p>
            <div class="flex items-center text-sm text-gray-500">
              <i class="fas fa-calendar mr-2"></i>
              <span>5 Maret 2024</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- News Section -->
  <section id="berita" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="text-center mb-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-red-700 mb-4">Berita & Update</h2>
        <p class="text-xl text-gray-600">Informasi terkini seputar program dan kegiatan KulakanCepat</p>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- News Card 1 -->
        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 p-8 rounded-2xl shadow-lg card-hover border border-yellow-200">
          <div class="w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-gift text-white text-2xl"></i>
          </div>
          <h3 class="font-bold text-2xl text-gray-800 mb-4">GIVEAWAY</h3>
          <p class="text-gray-600 mb-6">
            Ikuti dan menangkan hadiah menarik dengan mengikuti campaign giveaway kami. Total hadiah puluhan juta rupiah!
          </p>
          <a href="#" class="inline-flex items-center text-yellow-700 font-bold hover:text-yellow-800 transition-colors">
            Ikuti Sekarang <i class="fas fa-external-link-alt ml-2"></i>
          </a>
        </div>
        
        <!-- News Card 2 -->
        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-8 rounded-2xl shadow-lg card-hover border border-purple-200">
          <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-graduation-cap text-white text-2xl"></i>
          </div>
          <h3 class="font-bold text-2xl text-gray-800 mb-4">Kelas UMKM</h3>
          <p class="text-gray-600 mb-6">
            Webinar bisnis gratis untuk meningkatkan wawasan dan pengetahuan para pelaku usaha kecil menengah.
          </p>
          <a href="#" class="inline-flex items-center text-purple-700 font-bold hover:text-purple-800 transition-colors">
            Daftar Kelas <i class="fas fa-external-link-alt ml-2"></i>
          </a>
        </div>
        
        <!-- News Card 3 -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-2xl shadow-lg card-hover border border-green-200">
          <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-newspaper text-white text-2xl"></i>
          </div>
          <h3 class="font-bold text-2xl text-gray-800 mb-4">Artikel Terkini</h3>
          <p class="text-gray-600 mb-6">
            Update terbaru seputar UMKM, tips bisnis, dan kebijakan grosir terbaru di Indonesia.
          </p>
          <a href="#" class="inline-flex items-center text-green-700 font-bold hover:text-green-800 transition-colors">
            Baca Artikel <i class="fas fa-external-link-alt ml-2"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Partner Section -->
  <section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
      <h2 class="text-3xl lg:text-4xl font-bold text-red-700 mb-4">Partner Bisnis</h2>
      <p class="text-xl text-gray-600 mb-12">Dipercaya oleh brand-brand ternama Indonesia</p>
      
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center">
        <!-- Partner logos placeholder -->
        <div class="bg-white p-6 rounded-2xl shadow-md card-hover">
          <div class="w-16 h-16 bg-gray-200 rounded-lg mx-auto flex items-center justify-center">
            <i class="fas fa-building text-gray-400 text-2xl"></i>
          </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md card-hover">
          <div class="w-16 h-16 bg-gray-200 rounded-lg mx-auto flex items-center justify-center">
            <i class="fas fa-store text-gray-400 text-2xl"></i>
          </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md card-hover">
          <div class="w-16 h-16 bg-gray-200 rounded-lg mx-auto flex items-center justify-center">
            <i class="fas fa-industry text-gray-400 text-2xl"></i>
          </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md card-hover">
          <div class="w-16 h-16 bg-gray-200 rounded-lg mx-auto flex items-center justify-center">
            <i class="fas fa-warehouse text-gray-400 text-2xl"></i>
          </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md card-hover">
          <div class="w-16 h-16 bg-gray-200 rounded-lg mx-auto flex items-center justify-center">
            <i class="fas fa-truck-loading text-gray-400 text-2xl"></i>
          </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md card-hover">
          <div class="w-16 h-16 bg-gray-200 rounded-lg mx-auto flex items-center justify-center">
            <i class="fas fa-boxes text-gray-400 text-2xl"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="gradient-bg text-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
      <h2 class="text-3xl lg:text-5xl font-bold mb-6">
        Siap Bergabung dengan KulakanCepat?
      </h2>
      <p class="text-xl lg:text-2xl mb-8 text-red-100">
        Mulai journey bisnis grosir digital Anda bersama ribuan merchant dan toko lainnya
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#" class="bg-white text-red-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-red-50 transition-colors shadow-lg inline-flex items-center justify-center">
          <i class="fas fa-rocket mr-2"></i>
          Mulai Sekarang
        </a>
        <a href="#" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-red-700 transition-colors inline-flex items-center justify-center">
          <i class="fas fa-phone mr-2"></i>
          Hubungi Kami
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
        <!-- Company Info -->
        <div>
          <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center">
              <img src="{{ asset('images/logo/Artboard 1 copy 3.png') }}" alt="">
            </div>
            <span class="text-xl font-bold">KulakanCepat</span>
          </div>
          <p class="text-gray-400 mb-4">
            Platform grosir digital terdepan yang menghubungkan merchant dengan toko retail di seluruh Indonesia.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors">
              <i class="fab fa-facebook"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors">
              <i class="fab fa-youtube"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors">
              <i class="fab fa-linkedin"></i>
            </a>
          </div>
        </div>
        
        <!-- Products -->
        <div>
          <h3 class="text-lg font-bold mb-4">Produk</h3>
          <ul class="space-y-2 text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">Untuk Merchant</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Untuk Toko</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Sistem Pembayaran</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Logistik</a></li>
          </ul>
        </div>
        
        <!-- Company -->
        <div>
          <h3 class="text-lg font-bold mb-4">Perusahaan</h3>
          <ul class="space-y-2 text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Karir</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Press Release</a></li>
          </ul>
        </div>
        
        <!-- Support -->
        <div>
          <h3 class="text-lg font-bold mb-4">Dukungan</h3>
          <ul class="space-y-2 text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">Pusat Bantuan</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
          </ul>
        </div>
      </div>
      
      <!-- Bottom Footer -->
      <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
        <p>&copy; 2024 KulakanCepat. All rights reserved. | Designed with ❤️ for Indonesian UMKM</p>
      </div>
    </div>
  </footer>

  <script>
    function toggleMobileMenu() {
      const menu = document.getElementById('mobileMenu');
      menu.classList.toggle('active');
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
    
    // Close mobile menu when clicking on links
    document.querySelectorAll('#mobileMenu a').forEach(link => {
      link.addEventListener('click', () => {
        document.getElementById('mobileMenu').classList.remove('active');
      });
    });
  </script>
</body>
</html>

