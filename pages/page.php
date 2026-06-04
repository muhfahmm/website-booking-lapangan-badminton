<?php
/**
 * Public Pages Router
 * File ini menangani routing untuk semua halaman publik
 * URL: /pages/page.php?page=home|booking|history|about
 */

// Tentukan halaman aktif dari URL parameter, default ke 'home'
$current_page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'home';

// Validasi halaman yang diizinkan
$allowed_pages = ['home', 'booking', 'history', 'about'];

if (!in_array($current_page, $allowed_pages)) {
    $current_page = 'home';
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php 
        $titles = [
            'home' => 'Beranda - Booking Lapangan Badminton',
            'booking' => 'Booking Lapangan - Booking Lapangan Badminton',
            'history' => 'Riwayat Booking - Booking Lapangan Badminton',
            'about' => 'Tentang Kami - Booking Lapangan Badminton'
        ];
        echo $titles[$current_page] ?? 'Booking Lapangan Badminton';
    ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <style>
        /* Custom styles */
        :root {
            --primary-color: #059669;
            --accent-color: #FACC15;
            --dark-color: #0F172A;
            --light-color: #F8FAFC;
        }

        body {
            font-family: 'Inter', 'Roboto', sans-serif;
        }

        .text-primary { color: var(--primary-color); }
        .bg-primary { background-color: var(--primary-color); }
        .text-accent { color: var(--accent-color); }
        .bg-accent { background-color: var(--accent-color); }
        .border-primary { border-color: var(--primary-color); }

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
        }

        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light-color text-dark-color">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="../" class="text-2xl font-bold text-primary">
                        🏸 Booking Lapangan
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="page.php?page=home" class="nav-link <?php echo ($current_page === 'home') ? 'active text-primary' : 'text-gray-700'; ?>">
                        Beranda
                    </a>
                    <a href="page.php?page=booking" class="nav-link <?php echo ($current_page === 'booking') ? 'active text-primary' : 'text-gray-700'; ?>">
                        Booking
                    </a>
                    <a href="page.php?page=history" class="nav-link <?php echo ($current_page === 'history') ? 'active text-primary' : 'text-gray-700'; ?>">
                        Riwayat
                    </a>
                    <a href="page.php?page=about" class="nav-link <?php echo ($current_page === 'about') ? 'active text-primary' : 'text-gray-700'; ?>">
                        Tentang
                    </a>
                    <a href="../admin/login.php" class="cta-btn">
                        Admin Login
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-primary" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a href="page.php?page=home" class="block px-2 py-2 text-gray-700 hover:text-primary">Beranda</a>
                <a href="page.php?page=booking" class="block px-2 py-2 text-gray-700 hover:text-primary">Booking</a>
                <a href="page.php?page=history" class="block px-2 py-2 text-gray-700 hover:text-primary">Riwayat</a>
                <a href="page.php?page=about" class="block px-2 py-2 text-gray-700 hover:text-primary">Tentang</a>
                <a href="../admin/login.php" class="block px-2 py-2 text-gray-700 hover:text-primary">Admin Login</a>
            </div>
        </div>
    </nav>

    <!-- CONTENT AREA -->
    <main class="min-h-screen">
        <?php
        // Load content berdasarkan halaman yang dipilih
        switch($current_page) {
            case 'home':
                include 'page-home.php';
                break;
            case 'booking':
                include 'page-booking.php';
                break;
            case 'history':
                include 'page-history.php';
                break;
            case 'about':
                include 'page-about.php';
                break;
            default:
                include 'page-home.php';
        }
        ?>
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Tentang -->
                <div>
                    <h3 class="text-lg font-bold text-accent mb-4">🏸 Booking Lapangan</h3>
                    <p class="text-gray-400 text-sm">Platform booking lapangan badminton terpercaya dengan sistem yang mudah dan transparan.</p>
                </div>

                <!-- Navigasi -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="page.php?page=home" class="hover:text-accent transition">Beranda</a></li>
                        <li><a href="page.php?page=booking" class="hover:text-accent transition">Booking</a></li>
                        <li><a href="page.php?page=history" class="hover:text-accent transition">Riwayat</a></li>
                        <li><a href="page.php?page=about" class="hover:text-accent transition">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <p class="text-gray-400 text-sm mb-2">📞 +62 8XX XXXX XXXX</p>
                    <p class="text-gray-400 text-sm mb-2">📧 info@bookinglapangan.com</p>
                    <p class="text-gray-400 text-sm">📍 Jl. Contoh No. 123, Kota</p>
                </div>

                <!-- Sosial Media -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-accent transition">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-accent transition">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-accent transition">Twitter</a>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="border-gray-700 mb-6">

            <!-- Copyright -->
            <div class="text-center text-gray-400 text-sm">
                <p>&copy; 2026 Booking Lapangan Badminton. Semua hak dilindungi.</p>
                <p class="mt-2">Dibuat dengan ❤️ untuk para pecinta badminton</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../public/assets/js/main.js"></script>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Highlight nav link berdasarkan halaman aktif
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = '<?php echo $current_page; ?>';
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.href.includes('page=' + currentPage)) {
                    link.classList.add('active', 'text-primary');
                }
            });
        });
    </script>

</body>
</html>
