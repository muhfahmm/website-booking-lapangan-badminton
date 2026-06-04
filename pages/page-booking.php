<?php
/**
 * Booking Page Content
 * Halaman untuk memilih dan membooking lapangan
 */
?>

<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-slate-900 mb-4">Booking Lapangan</h1>
            <p class="text-lg text-gray-600">Pilih lapangan dan jadwal yang sesuai dengan keinginan Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Filter & Form Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Filter</h2>

                    <!-- Tanggal -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Booking</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-600" min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <!-- Jam Mulai -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-600">
                            <option>Pilih jam...</option>
                            <?php
                            for($i = 6; $i <= 22; $i++) {
                                $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                echo "<option value='$time'>$time</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Durasi -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-600">
                            <option>Pilih durasi...</option>
                            <option value="1">1 jam</option>
                            <option value="2">2 jam</option>
                            <option value="3">3 jam</option>
                            <option value="4">4 jam</option>
                        </select>
                    </div>

                    <!-- Tipe Hari -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Hari</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="day_type" value="weekday" checked class="w-4 h-4 text-emerald-600">
                                <span class="ml-2 text-gray-700">Weekday (Sen-Jum)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="day_type" value="weekend" class="w-4 h-4 text-emerald-600">
                                <span class="ml-2 text-gray-700">Weekend (Sab-Min)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Cari Button -->
                    <button class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                        Cari Ketersediaan
                    </button>
                </div>
            </div>

            <!-- Lapangan List Section -->
            <div class="lg:col-span-2">
                <?php
                // Include database connection
                require_once '../config/database.php';

                try {
                    // Query semua lapangan
                    $query = "SELECT id, name, location, price_weekday, price_weekend, 
                              image_url, status, lighting, floor_type, parking, facilities 
                              FROM tb_court 
                              WHERE status = 'tersedia' 
                              ORDER BY created_at DESC";
                    
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $courts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($courts)) {
                        echo '<div class="col-span-3 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">';
                        echo '<p class="text-blue-700"><strong>Info:</strong> Belum ada lapangan yang tersedia saat ini.</p>';
                        echo '<p class="text-blue-600 text-sm mt-2">Silakan hubungi admin untuk menambahkan lapangan baru.</p>';
                        echo '</div>';
                    } else {
                        foreach($courts as $court):
                            $rating = round(4.5 + (rand(0, 5) / 10), 1);
                            $image = !empty($court['image_url']) ? $court['image_url'] : 'https://via.placeholder.com/300x200/059669/FACC15?text=' . urlencode($court['name']);
                            
                            // Parse facilities jika ada
                            $facilities = !empty($court['facilities']) ? explode(',', $court['facilities']) : [];
                        ?>
                <!-- Court Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6 hover:shadow-xl transition">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                        <!-- Image -->
                        <div class="md:col-span-1">
                            <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($court['name']); ?>" class="w-full h-40 object-cover rounded-lg">
                        </div>

                        <!-- Info -->
                        <div class="md:col-span-2">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-2xl font-bold text-slate-900"><?php echo htmlspecialchars($court['name']); ?></h3>
                                    <p class="text-gray-600">📍 <?php echo htmlspecialchars($court['location']); ?></p>
                                </div>
                                <div class="bg-yellow-400 text-slate-900 px-3 py-1 rounded-full font-bold">
                                    ⭐ <?php echo $rating; ?>
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="grid grid-cols-2 gap-4 mb-4 bg-slate-50 p-4 rounded-lg">
                                <div>
                                    <p class="text-sm text-gray-600">Weekday</p>
                                    <p class="text-lg font-bold text-emerald-600">Rp <?php echo number_format($court['price_weekday'], 0, ',', '.'); ?>/jam</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Weekend</p>
                                    <p class="text-lg font-bold text-yellow-500">Rp <?php echo number_format($court['price_weekend'], 0, ',', '.'); ?>/jam</p>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="space-y-2 mb-4 text-sm text-gray-700">
                                <p>✓ Pencahayaan: <?php echo htmlspecialchars($court['lighting']); ?></p>
                                <p>✓ Lantai: <?php echo htmlspecialchars($court['floor_type']); ?></p>
                                <p>✓ Parkir: <?php echo htmlspecialchars($court['parking']); ?></p>
                            </div>

                            <!-- Buttons -->
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
                        <?php 
                        endforeach;
                    }

                } catch (PDOException $e) {
                    echo '<div class="col-span-3 bg-red-50 border-l-4 border-red-500 p-4 rounded">';
                    echo '<p class="text-red-700"><strong>Database Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
                    echo '<p class="text-red-600 text-sm mt-2">Pastikan database sudah disetup dan tabel tb_court ada.</p>';
                    echo '</div>';
                }
                ?>

                <!-- Load More -->
                <div class="text-center">
                    <button class="px-8 py-3 border-2 border-emerald-600 text-emerald-600 rounded-lg font-semibold hover:bg-emerald-50 transition">
                        Muat Lebih Banyak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
