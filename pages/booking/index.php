<?php
// Booking Page (User)
session_start();
require_once '../../config/database.php';

$page_title = 'Booking Lapangan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - BadmintonBook</title>
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
            <div class="flex gap-4">
                <a href="../../index.php" class="text-slate-600 hover:text-emerald-600"><i class="fas fa-home mr-1"></i> Home</a>
                <a href="../../admin/login.php" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-slate-50 border-b border-slate-200 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm text-slate-600">
                <a href="../../index.php" class="hover:text-emerald-600">Home</a>
                <span class="mx-2">/</span>
                <span class="text-emerald-600 font-semibold"><?php echo $page_title; ?></span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-4xl font-bold text-slate-900 mb-8">Pesan Lapangan Badminton</h2>

        <!-- Booking Steps -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-emerald-50 border-2 border-emerald-600 rounded-2xl p-6 text-center">
                <div class="text-4xl text-emerald-600 font-bold mb-2">1</div>
                <h3 class="text-xl font-bold text-slate-900">Pilih Lapangan</h3>
                <p class="text-slate-600 mt-2">Pilih lapangan yang sesuai dengan kebutuhan Anda</p>
            </div>
            <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-6 text-center">
                <div class="text-4xl text-slate-400 font-bold mb-2">2</div>
                <h3 class="text-xl font-bold text-slate-900">Tentukan Waktu</h3>
                <p class="text-slate-600 mt-2">Pilih tanggal dan waktu yang Anda inginkan</p>
            </div>
            <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-6 text-center">
                <div class="text-4xl text-slate-400 font-bold mb-2">3</div>
                <h3 class="text-xl font-bold text-slate-900">Bayar & Konfirmasi</h3>
                <p class="text-slate-600 mt-2">Lakukan pembayaran dan tunggu konfirmasi</p>
            </div>
        </div>

        <!-- Coming Soon Message -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-12 text-center">
            <i class="fas fa-tools text-6xl text-blue-600 mb-4"></i>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Fitur Booking Sedang Dikembangkan</h3>
            <p class="text-slate-600 text-lg mb-6">Halaman booking user sedang dalam tahap pengembangan. Fitur ini akan segera tersedia dengan antarmuka yang user-friendly.</p>
            <a href="../../index.php" class="inline-block bg-emerald-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-emerald-700">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Home
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-slate-400">
            <p>&copy; 2026 BadmintonBook. All rights reserved.</p>
        </div>
    </footer>

    <script src="../../public/assets/js/main.js"></script>
</body>
</html>
