<?php
// Home Page
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Lapangan Badminton - Mitra Terpercaya Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-emerald-600 text-white rounded-lg p-2">
                    <i class="fas fa-badminton text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">BadmintonBook</h1>
            </div>
            <ul class="hidden md:flex gap-6 items-center">
                <li><a href="#home" class="text-slate-600 hover:text-emerald-600">Home</a></li>
                <li><a href="#lapangan" class="text-slate-600 hover:text-emerald-600">Lapangan</a></li>
                <li><a href="#tentang" class="text-slate-600 hover:text-emerald-600">Tentang</a></li>
                <li><a href="#kontak" class="text-slate-600 hover:text-emerald-600">Kontak</a></li>
                <li><a href="../../admin/login.php" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">Admin</a></li>
            </ul>
            <div class="md:hidden">
                <button class="text-slate-900"><i class="fas fa-bars text-xl"></i></button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-5xl font-bold mb-4">Pesan Lapangan Badminton Favoritmu</h2>
            <p class="text-xl mb-8 text-emerald-100">Mudah, cepat, dan terpercaya. Nikmati pengalaman booking yang menyenangkan.</p>
            <a href="../../pages/booking/index.php" class="inline-block bg-yellow-400 text-slate-900 font-bold px-8 py-4 rounded-lg hover:bg-yellow-500 transition">
                <i class="fas fa-calendar-check mr-2"></i> Mulai Booking Sekarang
            </a>
        </div>
    </section>

    <!-- Featured Courts Section -->
    <section id="lapangan" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4">
            <h3 class="text-4xl font-bold text-center mb-12">Lapangan Unggulan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Court Card 1 -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-badminton text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-slate-900 mb-2">Lapangan Premium A</h4>
                        <p class="text-slate-600 text-sm mb-4">Lapangan indoor dengan pencahayaan LED terbaik</p>
                        <div class="mb-4 pb-4 border-b border-slate-200">
                            <p class="text-emerald-600 font-bold text-lg">Rp 50.000 / jam</p>
                        </div>
                        <a href="../../pages/booking/index.php" class="inline-block bg-yellow-400 text-slate-900 font-semibold px-4 py-2 rounded-lg hover:bg-yellow-500">
                            <i class="fas fa-calendar mr-1"></i> Booking
                        </a>
                    </div>
                </div>

                <!-- Court Card 2 -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-badminton text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-slate-900 mb-2">Lapangan Standar B</h4>
                        <p class="text-slate-600 text-sm mb-4">Lapangan dengan fasilitas lengkap dan nyaman</p>
                        <div class="mb-4 pb-4 border-b border-slate-200">
                            <p class="text-emerald-600 font-bold text-lg">Rp 40.000 / jam</p>
                        </div>
                        <a href="../../pages/booking/index.php" class="inline-block bg-yellow-400 text-slate-900 font-semibold px-4 py-2 rounded-lg hover:bg-yellow-500">
                            <i class="fas fa-calendar mr-1"></i> Booking
                        </a>
                    </div>
                </div>

                <!-- Court Card 3 -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-badminton text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-slate-900 mb-2">Lapangan Ekonomis C</h4>
                        <p class="text-slate-600 text-sm mb-4">Lapangan terjangkau dengan kualitas terjamin</p>
                        <div class="mb-4 pb-4 border-b border-slate-200">
                            <p class="text-emerald-600 font-bold text-lg">Rp 30.000 / jam</p>
                        </div>
                        <a href="../../pages/booking/index.php" class="inline-block bg-yellow-400 text-slate-900 font-semibold px-4 py-2 rounded-lg hover:bg-yellow-500">
                            <i class="fas fa-calendar mr-1"></i> Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="tentang" class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h3 class="text-4xl font-bold text-center mb-12">Mengapa Pilih Kami?</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-5xl text-emerald-600 mb-4"><i class="fas fa-clock"></i></div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Booking Cepat</h4>
                    <p class="text-slate-600">Proses booking yang mudah dan cepat hanya dalam beberapa klik</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl text-emerald-600 mb-4"><i class="fas fa-lock"></i></div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Aman & Terpercaya</h4>
                    <p class="text-slate-600">Sistem pembayaran aman dengan enkripsi tingkat tinggi</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl text-emerald-600 mb-4"><i class="fas fa-star"></i></div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Kualitas Terjamin</h4>
                    <p class="text-slate-600">Lapangan terawat dengan baik dan fasilitas modern</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl text-emerald-600 mb-4"><i class="fas fa-headset"></i></div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Support 24/7</h4>
                    <p class="text-slate-600">Tim support siap membantu kapan saja Anda membutuhkan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div>
                    <h4 class="text-lg font-bold mb-4">BadmintonBook</h4>
                    <p class="text-slate-400">Platform booking lapangan badminton terpercaya se-Indonesia</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Menu</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li><a href="#home" class="hover:text-emerald-400">Home</a></li>
                        <li><a href="#lapangan" class="hover:text-emerald-400">Lapangan</a></li>
                        <li><a href="#tentang" class="hover:text-emerald-400">Tentang</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li><i class="fas fa-phone mr-2"></i> +62 812-3456-7890</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@badmintonbook.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Ikuti Kami</h4>
                    <div class="flex gap-4">
                        <a href="#" class="text-slate-400 hover:text-emerald-400 text-xl"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-slate-400 hover:text-emerald-400 text-xl"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-slate-400 hover:text-emerald-400 text-xl"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-700 pt-8 text-center text-slate-400">
                <p>&copy; 2026 BadmintonBook. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="../../public/assets/js/main.js"></script>
</body>
</html>
