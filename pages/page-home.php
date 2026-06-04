<?php
/**
 * Home Page Content
 * Halaman utama / landing page
 */
?>

<!-- HERO SECTION -->
<section class="bg-gradient-to-r from-slate-900 via-emerald-900 to-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="animate-fade-in">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Booking Lapangan <span class="text-yellow-400">Badminton</span> Mudah & Cepat
                </h1>
                <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                    Temukan dan pesan lapangan badminton favorit Anda dengan mudah. Sistem transparan, harga terjangkau, dan pelayanan terbaik.
                </p>
                <div class="flex gap-4">
                    <a href="page.php?page=booking" class="cta-btn bg-yellow-400 text-slate-900 hover:bg-yellow-500">
                        Mulai Booking Sekarang
                    </a>
                    <a href="page.php?page=about" class="cta-btn bg-transparent border-2 border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-slate-900">
                        Pelajari Lebih Lanjut
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-12">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-yellow-400">50+</div>
                        <p class="text-gray-300 mt-2">Lapangan</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-yellow-400">1000+</div>
                        <p class="text-gray-300 mt-2">Pengguna</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-yellow-400">5000+</div>
                        <p class="text-gray-300 mt-2">Booking</p>
                    </div>
                </div>
            </div>

            <!-- Hero Image -->
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
            <h2 class="text-4xl font-bold text-slate-900 mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-xl text-gray-600">Kami menyediakan pengalaman booking terbaik untuk Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3 text-center">Mudah & Cepat</h3>
                <p class="text-gray-600 text-center">Proses booking hanya membutuhkan beberapa klik. Sistem kami dirancang untuk kemudahan maksimal.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gradient-to-br from-slate-50 to-yellow-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3 text-center">Harga Transparan</h3>
                <p class="text-gray-600 text-center">Tidak ada biaya tersembunyi. Harga yang Anda lihat adalah harga yang Anda bayar. Fleksibel untuk weekday dan weekend.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gradient-to-br from-slate-50 to-emerald-50 rounded-xl p-8 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.172l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3 text-center">Dukungan 24/7</h3>
                <p class="text-gray-600 text-center">Tim support kami siap membantu Anda kapan saja. Chat, email, atau telepon - pilih cara yang paling nyaman.</p>
            </div>
        </div>
    </div>
</section>

<!-- LAPANGAN SECTION -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-slate-900 mb-4">Lapangan Populer</h2>
            <p class="text-xl text-gray-600">Pilihan terbaik dari berbagai lokasi</p>
        </div>

        <!-- Court Cards from Database -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            // Include database connection
            require_once '../config/database.php';

            try {
                // Query lapangan dengan status tersedia, limit 3
                $query = "SELECT id, name, location, price_weekday, price_weekend, 
                          image_url, status FROM tb_court 
                          WHERE status = 'tersedia' 
                          LIMIT 3";
                
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $courts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Jika data kosong, tampilkan sample data
                if (empty($courts)) {
                    $courts = [
                        [
                            'id' => 1,
                            'name' => 'Lapangan A',
                            'location' => 'Jl. Utama No. 1',
                            'price_weekday' => 150000,
                            'price_weekend' => 200000,
                            'image_url' => 'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+A',
                            'status' => 'tersedia'
                        ],
                        [
                            'id' => 2,
                            'name' => 'Lapangan B',
                            'location' => 'Jl. Sudirman No. 45',
                            'price_weekday' => 120000,
                            'price_weekend' => 180000,
                            'image_url' => 'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+B',
                            'status' => 'tersedia'
                        ],
                        [
                            'id' => 3,
                            'name' => 'Lapangan C',
                            'location' => 'Jl. Gatot Subroto No. 89',
                            'price_weekday' => 180000,
                            'price_weekend' => 230000,
                            'image_url' => 'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+C',
                            'status' => 'tersedia'
                        ]
                    ];
                }

                // Generate random rating antara 4.5-5.0
                foreach($courts as $court):
                    $rating = round(4.5 + (rand(0, 5) / 10), 1);
                    $image = !empty($court['image_url']) ? $court['image_url'] : 'https://via.placeholder.com/400x250/059669/FACC15?text=' . urlencode($court['name']);
                ?>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300 transform hover:scale-105">
                    <!-- Image -->
                    <div class="relative h-48 overflow-hidden bg-gray-200">
                        <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($court['name']); ?>" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-yellow-400 text-slate-900 px-3 py-1 rounded-full text-sm font-bold">
                            ⭐ <?php echo $rating; ?>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-2"><?php echo htmlspecialchars($court['name']); ?></h3>
                        <p class="text-gray-600 text-sm mb-4">📍 <?php echo htmlspecialchars($court['location']); ?></p>

                        <!-- Price -->
                        <div class="bg-slate-50 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600 text-sm">Weekday:</span>
                                <span class="font-bold text-emerald-600">Rp <?php echo number_format($court['price_weekday'], 0, ',', '.'); ?>/jam</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Weekend:</span>
                                <span class="font-bold text-yellow-500">Rp <?php echo number_format($court['price_weekend'], 0, ',', '.'); ?>/jam</span>
                            </div>
                        </div>

                        <!-- Button -->
                        <a href="page.php?page=booking" class="w-full bg-emerald-600 text-white py-2 rounded-lg font-semibold hover:bg-emerald-700 transition text-center">
                            Booking Sekarang
                        </a>
                    </div>
                </div>
                <?php endforeach;

            } catch (PDOException $e) {
                echo '<div class="col-span-3 bg-red-50 border-l-4 border-red-500 p-4 rounded">';
                echo '<p class="text-red-700"><strong>Database Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
                echo '<p class="text-red-600 text-sm mt-2">Pastikan database sudah disetup dan tabel tb_court ada.</p>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="page.php?page=booking" class="inline-block cta-btn bg-emerald-600 text-white hover:bg-emerald-700">
                Lihat Semua Lapangan →
            </a>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="py-20 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold mb-6">Siap Booking Lapangan?</h2>
        <p class="text-xl text-emerald-100 mb-8">Jangan tunda lagi! Pesan lapangan favorit Anda sekarang dan nikmati pengalaman bermain badminton yang menyenangkan.</p>
        <a href="page.php?page=booking" class="inline-block cta-btn bg-yellow-400 text-slate-900 text-lg font-bold px-8 py-4 hover:bg-yellow-500">
            Booking Sekarang →
        </a>
    </div>
</section>
