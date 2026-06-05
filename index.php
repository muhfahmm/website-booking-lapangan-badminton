<?php
// Database connection
$host = 'localhost';
$db = 'db_booking_lapangan_badminton';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $pdo = null;
}

// Get current page from URL, default to home
$current_page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'home';
$allowed_pages = ['home', 'booking', 'history', 'about'];
if (!in_array($current_page, $allowed_pages)) {
    $current_page = 'home';
}

// Get page titles
$titles = [
    'home' => 'Beranda - Booking Lapangan Badminton',
    'booking' => 'Booking Lapangan - Booking Lapangan Badminton',
    'history' => 'Riwayat Booking - Booking Lapangan Badminton',
    'about' => 'Tentang Kami - Booking Lapangan Badminton'
];

$page_title = $titles[$current_page] ?? 'Booking Lapangan Badminton';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #059669;
            --accent-color: #FACC15;
            --dark-color: #0F172A;
            --light-color: #F8FAFC;
        }
        body {
            font-family: 'Inter', 'Roboto', sans-serif;
        }
        .nav-link {
            position: relative;
            padding-bottom: 0.5rem;
            transition: color 0.3s ease;
        }
        .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }
        .nav-link:hover:after,
        .nav-link.active:after {
            width: 100%;
        }
        .nav-link.active {
            color: var(--primary-color);
        }
        .cta-btn {
            background: var(--accent-color);
            color: var(--dark-color);
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }
        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="index.php" class="text-2xl font-bold" style="color: var(--primary-color);">
                        🏸 Booking Lapangan
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php?page=home" class="nav-link <?php echo ($current_page === 'home') ? 'active' : ''; ?>" style="color: <?php echo ($current_page === 'home') ? 'var(--primary-color)' : '#666'; ?>">
                        Beranda
                    </a>
                    <a href="index.php?page=booking" class="nav-link <?php echo ($current_page === 'booking') ? 'active' : ''; ?>" style="color: <?php echo ($current_page === 'booking') ? 'var(--primary-color)' : '#666'; ?>">
                        Booking
                    </a>
                    <a href="index.php?page=history" class="nav-link <?php echo ($current_page === 'history') ? 'active' : ''; ?>" style="color: <?php echo ($current_page === 'history') ? 'var(--primary-color)' : '#666'; ?>">
                        Riwayat
                    </a>
                    <a href="index.php?page=about" class="nav-link <?php echo ($current_page === 'about') ? 'active' : ''; ?>" style="color: <?php echo ($current_page === 'about') ? 'var(--primary-color)' : '#666'; ?>">
                        Tentang
                    </a>
                </div>

                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-emerald-600" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a href="index.php?page=home" class="block px-2 py-2 text-gray-700 hover:text-emerald-600">Beranda</a>
                <a href="index.php?page=booking" class="block px-2 py-2 text-gray-700 hover:text-emerald-600">Booking</a>
                <a href="index.php?page=history" class="block px-2 py-2 text-gray-700 hover:text-emerald-600">Riwayat</a>
                <a href="index.php?page=about" class="block px-2 py-2 text-gray-700 hover:text-emerald-600">Tentang</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="min-h-screen">

        <!-- ============================================================================ -->
        <!-- HOME PAGE -->
        <!-- ============================================================================ -->
        <?php if ($current_page === 'home'): ?>

            <!-- HERO SECTION -->
            <section class="bg-gradient-to-r from-slate-900 via-emerald-900 to-slate-900 text-white py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div>
                            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                                Booking Lapangan <span style="color: var(--accent-color);">Badminton</span> Mudah & Cepat
                            </h1>
                            <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                                Temukan dan pesan lapangan badminton favorit Anda dengan mudah. Sistem transparan, harga terjangkau, dan pelayanan terbaik.
                            </p>
                            <div class="flex gap-4">
                                <a href="index.php?page=booking" class="cta-btn">
                                    Mulai Booking Sekarang
                                </a>
                                <a href="index.php?page=about" class="cta-btn" style="background: transparent; border: 2px solid var(--accent-color); color: var(--accent-color);">
                                    Pelajari Lebih Lanjut
                                </a>
                            </div>

                            <div class="grid grid-cols-3 gap-6 mt-12">
                                <div class="text-center">
                                    <div class="text-4xl font-bold" style="color: var(--accent-color);">50+</div>
                                    <p class="text-gray-300 mt-2">Lapangan</p>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold" style="color: var(--accent-color);">1000+</div>
                                    <p class="text-gray-300 mt-2">Pengguna</p>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold" style="color: var(--accent-color);">5000+</div>
                                    <p class="text-gray-300 mt-2">Booking</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-emerald-400 rounded-lg blur-2xl opacity-20"></div>
                            <div class="relative bg-gradient-to-br from-emerald-400 to-yellow-300 rounded-lg p-1">
                                <img src="https://via.placeholder.com/600x400/059669/FACC15?text=Badminton+Court" alt="Lapangan Badminton" class="w-full h-auto rounded-lg object-cover" style="height: 400px;">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FITUR SECTION -->
            <section class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">Mengapa Memilih Kami?</h2>
                        <p class="text-xl text-gray-600">Kami menyediakan pengalaman booking terbaik untuk Anda</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-center">Mudah & Cepat</h3>
                            <p class="text-gray-600 text-center">Proses booking hanya membutuhkan beberapa klik. Sistem kami dirancang untuk kemudahan maksimal.</p>
                        </div>

                        <div class="bg-gradient-to-br from-slate-50 to-yellow-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto" style="background: var(--accent-color);">
                                <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-center">Harga Transparan</h3>
                            <p class="text-gray-600 text-center">Tidak ada biaya tersembunyi. Harga yang Anda lihat adalah harga yang Anda bayar.</p>
                        </div>

                        <div class="bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.172l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-center">Dukungan 24/7</h3>
                            <p class="text-gray-600 text-center">Tim support kami siap membantu Anda kapan saja. Chat, email, atau telepon.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- LAPANGAN SECTION -->
            <section class="py-20 bg-slate-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">Lapangan Populer</h2>
                        <p class="text-xl text-gray-600">Pilihan terbaik dari berbagai lokasi</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <?php
                        if ($pdo && $current_page === 'home') {
                            try {
                                $query = "SELECT id, name, location, price_weekday, price_weekend, image_url, status FROM tb_court WHERE status = 'tersedia' LIMIT 3";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();
                                $courts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (empty($courts)) {
                                    echo '<div class="col-span-3 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg text-center">';
                                    echo '<p class="text-blue-700 text-lg">📭 Belum ada lapangan yang tersedia saat ini</p>';
                                    echo '<p class="text-blue-600 text-sm mt-2">Silakan hubungi admin untuk menambahkan lapangan baru</p>';
                                    echo '</div>';
                                } else {
                                    foreach($courts as $court):
                                        $rating = round(4.5 + (rand(0, 5) / 10), 1);
                                        $image = !empty($court['image_url']) ? $court['image_url'] : 'https://via.placeholder.com/400x250/059669/FACC15?text=' . urlencode($court['name']);
                        ?>
                        <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300 transform hover:scale-105">
                            <div class="relative h-48 overflow-hidden bg-gray-200">
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($court['name']); ?>" class="w-full h-full object-cover">
                                <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-bold" style="background: var(--accent-color); color: var(--dark-color);">
                                    ⭐ <?php echo $rating; ?>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($court['name']); ?></h3>
                                <p class="text-gray-600 text-sm mb-4">📍 <?php echo htmlspecialchars($court['location']); ?></p>

                                <div class="bg-slate-50 rounded-lg p-4 mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-600 text-sm">Weekday:</span>
                                        <span class="font-bold text-emerald-600">Rp <?php echo number_format($court['price_weekday'], 0, ',', '.'); ?>/jam</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 text-sm">Weekend:</span>
                                        <span class="font-bold" style="color: var(--accent-color);">Rp <?php echo number_format($court['price_weekend'], 0, ',', '.'); ?>/jam</span>
                                    </div>
                                </div>

                                <a href="index.php?page=booking" class="w-full bg-emerald-600 text-white py-2 rounded-lg font-semibold hover:bg-emerald-700 transition text-center block">
                                    Booking Sekarang
                                </a>
                            </div>
                        </div>
                        <?php endforeach;
                                }
                            } catch (PDOException $e) {
                                echo '<div class="col-span-3 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">';
                                echo '<p class="text-red-700">⚠️ Database Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="col-span-3 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">';
                            echo '<p class="text-red-700">❌ Database tidak terhubung</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <div class="text-center mt-12">
                        <a href="index.php?page=booking" class="cta-btn" style="background: var(--primary-color); color: white;">
                            Lihat Semua Lapangan →
                        </a>
                    </div>
                </div>
            </section>

            <!-- TESTIMONIAL & REVIEW SECTION -->
            <section class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">Apa Kata Pelanggan Kami?</h2>
                        <p class="text-xl text-gray-600">Ribuan pelanggan puas telah merasakan kemudahan booking dengan kami</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Testimonial Card 1 -->
                        <div class="bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-xl">
                                    AH
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold">Ahmad Hidayat</h4>
                                    <p class="text-gray-600 text-sm">Pelanggan Setia</p>
                                </div>
                            </div>
                            <div class="flex mb-4">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                            <p class="text-gray-700 italic mb-4">
                                "Platform booking ini sangat memudahkan saya. Proses booking cepat dan harganya transparan. Saya sudah booking berkali-kali dan selalu puas dengan layanannya!"
                            </p>
                            <p class="text-gray-500 text-sm">Jakarta, 3 bulan lalu</p>
                        </div>

                        <!-- Testimonial Card 2 -->
                        <div class="bg-gradient-to-br from-slate-50 to-yellow-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold text-xl">
                                    SR
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold">Siti Rahmawati</h4>
                                    <p class="text-gray-600 text-sm">Pemain Aktif</p>
                                </div>
                            </div>
                            <div class="flex mb-4">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                            <p class="text-gray-700 italic mb-4">
                                "Lapangan yang ditawarkan berkualitas tinggi dengan harga yang kompetitif. Support teamnya juga sangat responsif jika ada pertanyaan. Highly recommended!"
                            </p>
                            <p class="text-gray-500 text-sm">Bandung, 2 bulan lalu</p>
                        </div>

                        <!-- Testimonial Card 3 -->
                        <div class="bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-xl">
                                    BW
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold">Budi Wijaya</h4>
                                    <p class="text-gray-600 text-sm">Pelatih Badminton</p>
                                </div>
                            </div>
                            <div class="flex mb-4">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                            <p class="text-gray-700 italic mb-4">
                                "Sebagai pelatih, saya sangat menghargai sistem booking yang fleksibel dan mudah digunakan. Klien saya juga sangat senang dengan kemudahannya!"
                            </p>
                            <p class="text-gray-500 text-sm">Surabaya, 1 bulan lalu</p>
                        </div>
                    </div>

                    <!-- Rating Summary -->
                    <div class="mt-16 bg-gradient-to-r from-slate-900 via-emerald-900 to-slate-900 text-white rounded-xl p-8">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                            <div>
                                <div class="text-5xl font-bold mb-2" style="color: var(--accent-color);">4.8</div>
                                <p class="text-lg">Rating Rata-rata</p>
                                <p class="text-gray-400 text-sm">dari 1000+ review</p>
                            </div>
                            <div>
                                <div class="text-5xl font-bold mb-2" style="color: var(--accent-color);">1000+</div>
                                <p class="text-lg">Pengguna Puas</p>
                                <p class="text-gray-400 text-sm">di seluruh Indonesia</p>
                            </div>
                            <div>
                                <div class="text-5xl font-bold mb-2" style="color: var(--accent-color);">5000+</div>
                                <p class="text-lg">Booking Berhasil</p>
                                <p class="text-gray-400 text-sm">tanpa masalah</p>
                            </div>
                            <div>
                                <div class="text-5xl font-bold mb-2" style="color: var(--accent-color);">24/7</div>
                                <p class="text-lg">Support Team</p>
                                <p class="text-gray-400 text-sm">siap membantu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Call to Action Review -->
                    <div class="mt-12 text-center">
                        <p class="text-gray-600 mb-4">Sudah booking dengan kami? Bagikan pengalaman Anda!</p>
                        <button class="bg-emerald-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                            Tulis Review Anda
                        </button>
                    </div>
                </div>
            </section>

            <!-- CTA SECTION -->
            <section class="py-20" style="background: linear-gradient(to right, #059669, #047857);">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                    <h2 class="text-4xl font-bold mb-6">Siap Booking Lapangan?</h2>
                    <p class="text-xl mb-8" style="color: #d1f9e4;">Jangan tunda lagi! Pesan lapangan favorit Anda sekarang.</p>
                    <a href="index.php?page=booking" class="cta-btn text-lg font-bold px-8 py-4">
                        Booking Sekarang →
                    </a>
                </div>
            </section>

        <!-- ============================================================================ -->
        <!-- BOOKING PAGE -->
        <!-- ============================================================================ -->
        <?php elseif ($current_page === 'booking'): ?>

            <div class="min-h-screen bg-slate-50 py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="mb-12">
                        <h1 class="text-4xl font-bold mb-4">Booking Lapangan</h1>
                        <p class="text-lg text-gray-600">Pilih lapangan dan jadwal yang sesuai dengan keinginan Anda</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                                <h2 class="text-2xl font-bold mb-6">Filter</h2>

                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Booking</label>
                                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" min="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                        <option>Pilih jam...</option>
                                        <?php for($i = 6; $i <= 22; $i++) {
                                            $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                            echo "<option value='$time'>$time</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                        <option>Pilih durasi...</option>
                                        <option value="1">1 jam</option>
                                        <option value="2">2 jam</option>
                                        <option value="3">3 jam</option>
                                        <option value="4">4 jam</option>
                                    </select>
                                </div>

                                <button class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                                    Cari Ketersediaan
                                </button>
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <?php
                            if ($pdo) {
                                try {
                                    $query = "SELECT id, name, location, price_weekday, price_weekend, image_url, status, lighting, floor_type, parking FROM tb_court WHERE status = 'tersedia' ORDER BY created_at DESC";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                    $courts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (empty($courts)) {
                                        echo '<div class="col-span-3 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg text-center">';
                                        echo '<p class="text-blue-700 text-lg">📭 Belum ada lapangan yang tersedia saat ini</p>';
                                        echo '<p class="text-blue-600 text-sm mt-2">Silakan hubungi admin untuk menambahkan lapangan baru</p>';
                                        echo '</div>';
                                    } else {
                                        foreach($courts as $court):
                                            $rating = round(4.5 + (rand(0, 5) / 10), 1);
                                            $image = !empty($court['image_url']) ? $court['image_url'] : 'https://via.placeholder.com/300x200/059669/FACC15?text=' . urlencode($court['name']);
                            ?>
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6 hover:shadow-xl transition">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                                    <div class="md:col-span-1">
                                        <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($court['name']); ?>" class="w-full h-40 object-cover rounded-lg">
                                    </div>

                                    <div class="md:col-span-2">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 class="text-2xl font-bold"><?php echo htmlspecialchars($court['name']); ?></h3>
                                                <p class="text-gray-600">📍 <?php echo htmlspecialchars($court['location']); ?></p>
                                            </div>
                                            <div class="px-3 py-1 rounded-full font-bold" style="background: var(--accent-color); color: var(--dark-color);">
                                                ⭐ <?php echo $rating; ?>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 mb-4 bg-slate-50 p-4 rounded-lg">
                                            <div>
                                                <p class="text-sm text-gray-600">Weekday</p>
                                                <p class="text-lg font-bold text-emerald-600">Rp <?php echo number_format($court['price_weekday'], 0, ',', '.'); ?>/jam</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Weekend</p>
                                                <p class="text-lg font-bold" style="color: var(--accent-color);">Rp <?php echo number_format($court['price_weekend'], 0, ',', '.'); ?>/jam</p>
                                            </div>
                                        </div>

                                        <div class="space-y-2 mb-4 text-sm text-gray-700">
                                            <p>✓ Pencahayaan: <?php echo htmlspecialchars($court['lighting']); ?></p>
                                            <p>✓ Lantai: <?php echo htmlspecialchars($court['floor_type']); ?></p>
                                            <p>✓ Parkir: <?php echo htmlspecialchars($court['parking']); ?></p>
                                        </div>

                                        <div class="flex gap-3">
                                            <button class="flex-1 bg-emerald-600 text-white py-2 rounded-lg font-semibold hover:bg-emerald-700 transition">
                                                Booking
                                            </button>
                                            <button class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">
                                                Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;
                                    }
                                } catch (PDOException $e) {
                                    echo '<div class="col-span-3 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">';
                                    echo '<p class="text-red-700">⚠️ Database Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="col-span-3 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">';
                                echo '<p class="text-red-700">❌ Database tidak terhubung</p>';
                                echo '</div>';
                            }
                            ?>

                            <div class="text-center">
                                <button class="px-8 py-3 border-2 border-emerald-600 text-emerald-600 rounded-lg font-semibold hover:bg-emerald-50 transition">
                                    Muat Lebih Banyak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ============================================================================ -->
        <!-- HISTORY PAGE -->
        <!-- ============================================================================ -->
        <?php elseif ($current_page === 'history'): ?>

            <div class="min-h-screen bg-slate-50 py-12">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold mb-4">Riwayat Booking</h1>
                        <p class="text-lg text-gray-600">Kelola dan lihat semua booking Anda</p>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-8">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-blue-900 mb-1">Silakan Login Terlebih Dahulu</h3>
                                <p class="text-blue-700">Anda harus login untuk melihat riwayat booking Anda. <a href="admin/login.php" class="font-bold underline">Login sekarang</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4 text-5xl">📋</div>
                        <h3 class="text-2xl font-bold mb-2">Belum ada booking</h3>
                        <p class="text-gray-600 mb-6">Anda belum memiliki riwayat booking. Mulai booking lapangan sekarang!</p>
                        <a href="index.php?page=booking" class="inline-block bg-emerald-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                            Booking Lapangan Sekarang →
                        </a>
                    </div>
                </div>
            </div>

        <!-- ============================================================================ -->
        <!-- ABOUT PAGE -->
        <!-- ============================================================================ -->
        <?php elseif ($current_page === 'about'): ?>

            <section class="text-white py-20" style="background: linear-gradient(to right, #059669, #047857);">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 class="text-5xl font-bold mb-6">Tentang Kami</h1>
                    <p class="text-xl">Platform booking lapangan badminton terpercaya untuk kebutuhan Anda</p>
                </div>
            </section>

            <section class="py-20 bg-slate-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                        <div class="bg-white rounded-lg p-8 shadow-lg">
                            <div class="text-4xl mb-4">🎯</div>
                            <h3 class="text-2xl font-bold mb-4">Visi Kami</h3>
                            <p class="text-gray-700">Menjadi platform booking lapangan badminton terdepan di Asia Tenggara yang memberikan kemudahan dan kepuasan kepada setiap pengguna.</p>
                        </div>

                        <div class="bg-white rounded-lg p-8 shadow-lg">
                            <div class="text-4xl mb-4">💼</div>
                            <h3 class="text-2xl font-bold mb-4">Misi Kami</h3>
                            <p class="text-gray-700">Menyediakan solusi booking yang mudah, transparan, dan terjangkau bagi semua orang yang ingin menikmati olahraga badminton.</p>
                        </div>

                        <div class="bg-white rounded-lg p-8 shadow-lg">
                            <div class="text-4xl mb-4">⭐</div>
                            <h3 class="text-2xl font-bold mb-4">Nilai Kami</h3>
                            <p class="text-gray-700">Integritas, inovasi, kepercayaan, dan komitmen untuk memberikan layanan terbaik setiap hari.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-12 mb-8">
                        <h2 class="text-3xl font-bold mb-6">Kisah Kami</h2>
                        <div class="space-y-4 text-gray-700 leading-relaxed">
                            <p>Booking Lapangan Badminton dimulai dengan sebuah ide sederhana: membuat proses booking lapangan badminton lebih mudah, cepat, dan transparan. Kami percaya bahwa setiap orang berhak mendapatkan pengalaman booking yang menyenangkan tanpa ribet dan penuh biaya tersembunyi.</p>
                            <p>Sejak berdiri pada tahun 2024, kami telah melayani lebih dari 1000+ pengguna dan mengelola 50+ lapangan badminton berkualitas di berbagai kota. Kepercayaan Anda adalah aset terbesar kami, dan kami berkomitmen untuk terus berinovasi dan meningkatkan layanan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-4xl font-bold text-center mb-16">Mengapa Memilih Kami?</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xl text-white">✓</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Harga Transparan</h3>
                                <p class="text-gray-700">Tidak ada biaya tersembunyi. Harga yang Anda lihat adalah harga yang Anda bayar.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xl text-white">✓</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Sistem Booking Mudah</h3>
                                <p class="text-gray-700">Interface user-friendly membuat proses booking hanya beberapa klik saja.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xl text-white">✓</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Lapangan Berkualitas</h3>
                                <p class="text-gray-700">Semua lapangan telah melalui verifikasi ketat untuk memastikan kualitas.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xl text-white">✓</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Dukungan 24/7</h3>
                                <p class="text-gray-700">Tim support kami siap membantu Anda kapan saja melalui berbagai channel.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-slate-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-4xl font-bold text-center mb-16">Hubungi Kami</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        <div class="text-center">
                            <div class="text-4xl mb-4">📞</div>
                            <h3 class="text-xl font-bold mb-2">Telepon</h3>
                            <p class="text-gray-700">+62 8XX XXXX XXXX</p>
                            <p class="text-gray-600 text-sm">Senin-Jumat, 08:00-17:00 WIB</p>
                        </div>

                        <div class="text-center">
                            <div class="text-4xl mb-4">📧</div>
                            <h3 class="text-xl font-bold mb-2">Email</h3>
                            <p class="text-gray-700">info@bookinglapangan.com</p>
                            <p class="text-gray-600 text-sm">Respon dalam 24 jam</p>
                        </div>

                        <div class="text-center">
                            <div class="text-4xl mb-4">📍</div>
                            <h3 class="text-xl font-bold mb-2">Alamat</h3>
                            <p class="text-gray-700">Jl. Contoh No. 123</p>
                            <p class="text-gray-600 text-sm">Kota, Indonesia</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CONTACT US SECTION -->
            <section class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">Hubungi Kami</h2>
                        <p class="text-xl text-gray-600">Kami siap membantu Anda dengan pertanyaan atau masalah apapun</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        <!-- Contact Card 1 -->
                        <div class="bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-center">Telepon</h3>
                            <p class="text-gray-700 text-center mb-2 font-semibold">+62 812-3456-7890</p>
                            <p class="text-gray-600 text-center text-sm">Senin-Jumat, 08:00-17:00 WIB</p>
                        </div>

                        <!-- Contact Card 2 -->
                        <div class="bg-gradient-to-br from-slate-50 to-yellow-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto" style="background: var(--accent-color);">
                                <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-center">Email</h3>
                            <p class="text-gray-700 text-center mb-2 font-semibold">info@bookinglapangan.com</p>
                            <p class="text-gray-600 text-center text-sm">Respon dalam 24 jam</p>
                        </div>

                        <!-- Contact Card 3 -->
                        <div class="bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                            <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-center">Lokasi</h3>
                            <p class="text-gray-700 text-center mb-2 font-semibold">Jl. Olahraga No. 123</p>
                            <p class="text-gray-600 text-center text-sm">Jakarta Pusat, Indonesia</p>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="max-w-3xl mx-auto bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-12">
                        <h3 class="text-2xl font-bold mb-8 text-center">Kirim Pesan Kami</h3>
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Anda</label>
                                    <input type="text" placeholder="John Doe" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-600 transition" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input type="email" placeholder="john@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-600 transition" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Subjek</label>
                                <input type="text" placeholder="Subjek pesan Anda" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-600 transition" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                                <textarea placeholder="Tulis pesan Anda di sini..." rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-600 transition resize-none" required></textarea>
                            </div>
                            <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- MAP SECTION -->
            <section class="py-20 bg-slate-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold mb-4">Kunjungi Kami</h2>
                        <p class="text-xl text-gray-600">Lokasi kantor pusat kami</p>
                    </div>

                    <!-- Map Container -->
                    <div class="rounded-xl overflow-hidden shadow-2xl" style="height: 500px;">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            style="border:0; border-radius: 12px;" 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3519071488826!2d106.81720931476919!3d-6.175392395532042!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5c6b6b6b6b7%3A0x1234567890abcdef!2sJakarta%20Pusat!5e0!3m2!1sid!2sid!4v1234567890123" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <!-- Map Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                        <div class="bg-white rounded-lg p-6 shadow-md">
                            <h3 class="text-lg font-bold mb-3 flex items-center">
                                <span class="text-2xl mr-3">🕒</span> Jam Operasional
                            </h3>
                            <ul class="text-gray-700 text-sm space-y-2">
                                <li><strong>Senin - Jumat:</strong> 08:00 - 17:00 WIB</li>
                                <li><strong>Sabtu:</strong> 09:00 - 15:00 WIB</li>
                                <li><strong>Minggu:</strong> Tutup</li>
                            </ul>
                        </div>

                        <div class="bg-white rounded-lg p-6 shadow-md">
                            <h3 class="text-lg font-bold mb-3 flex items-center">
                                <span class="text-2xl mr-3">🚗</span> Transportasi
                            </h3>
                            <ul class="text-gray-700 text-sm space-y-2">
                                <li>✓ Dekat dengan stasiun MRT</li>
                                <li>✓ Area parkir luas tersedia</li>
                                <li>✓ Mudah diakses dengan kendaraan</li>
                            </ul>
                        </div>

                        <div class="bg-white rounded-lg p-6 shadow-md">
                            <h3 class="text-lg font-bold mb-3 flex items-center">
                                <span class="text-2xl mr-3">🎒</span> Fasilitas
                            </h3>
                            <ul class="text-gray-700 text-sm space-y-2">
                                <li>✓ Ruang tunggu ber-AC</li>
                                <li>✓ Toilet bersih</li>
                                <li>✓ WiFi gratis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

        <?php endif; ?>

    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4" style="color: var(--accent-color);">🏸 Booking Lapangan</h3>
                    <p class="text-gray-400 text-sm">Platform booking lapangan badminton terpercaya dengan sistem yang mudah dan transparan.</p>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="index.php?page=home" class="hover:text-yellow-400 transition">Beranda</a></li>
                        <li><a href="index.php?page=booking" class="hover:text-yellow-400 transition">Booking</a></li>
                        <li><a href="index.php?page=history" class="hover:text-yellow-400 transition">Riwayat</a></li>
                        <li><a href="index.php?page=about" class="hover:text-yellow-400 transition">Tentang Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <p class="text-gray-400 text-sm mb-2">📞 +62 8XX XXXX XXXX</p>
                    <p class="text-gray-400 text-sm mb-2">📧 info@bookinglapangan.com</p>
                    <p class="text-gray-400 text-sm">📍 Jl. Contoh No. 123, Kota</p>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition">Twitter</a>
                    </div>
                </div>
            </div>

            <hr class="border-gray-700 mb-6">

            <div class="text-center text-gray-400 text-sm">
                <p>&copy; 2026 Booking Lapangan Badminton. Semua hak dilindungi.</p>
                <p class="mt-2">Dibuat dengan ❤️ untuk para pecinta badminton</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>

</body>
</html>
