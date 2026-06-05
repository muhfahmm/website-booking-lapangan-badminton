<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';
require_once 'includes/upload-handler.php';

$page_title = 'Data Lapangan';
$page_subtitle = 'Kelola data lapangan badminton';

$success = '';
$error = '';
$action = $_GET['action'] ?? '';
$lapangan_id = $_GET['id'] ?? '';

$upload_handler = new UploadHandler();

// Handle Delete
if ($action == 'delete' && $lapangan_id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $stmt = $pdo->prepare('DELETE FROM tb_court WHERE id = ?');
            $stmt->execute([$lapangan_id]);
            $success = 'Data lapangan berhasil dihapus!';
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
        header('Location: lapangan.php');
        exit;
    }
}

// Handle Add/Edit
if ($action == 'add' || $action == 'edit') {
    $lapangan = [
        'id' => '',
        'name' => '',
        'location' => '',
        'price_weekday' => '',
        'price_weekend' => '',
        'status' => 'tersedia',
        'description' => '',
        'size' => '',
        'lighting' => '',
        'parking' => '',
        'floor_type' => '',
        'facilities' => '',
        'image_url' => '',
        'map_url' => ''
    ];

    if ($action == 'edit' && $lapangan_id) {
        try {
            $stmt = $pdo->prepare('SELECT id, name, location, price_weekday, price_weekend, status, description, size, lighting, parking, floor_type, facilities, image_url, map_url FROM tb_court WHERE id = ?');
            $stmt->execute([$lapangan_id]);
            $lapangan = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $price_weekday = trim($_POST['price_weekday'] ?? '');
        $price_weekend = trim($_POST['price_weekend'] ?? '');
        $status = trim($_POST['status'] ?? 'tersedia');
        $description = trim($_POST['description'] ?? '');
        $size = trim($_POST['size'] ?? '');
        $lighting = trim($_POST['lighting'] ?? '');
        $parking = trim($_POST['parking'] ?? '');
        $floor_type = trim($_POST['floor_type'] ?? '');
        $facilities = trim($_POST['facilities'] ?? '');
        $image_url = $lapangan['image_url'] ?? '';
        $map_url = trim($_POST['map_url'] ?? '');

        if (empty($name) || empty($price_weekday) || empty($price_weekend)) {
            $error = 'Nama, harga weekday, dan harga weekend harus diisi!';
        } else {
            // Handle thumbnail upload
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $upload_result = $upload_handler->uploadFile($_FILES['thumbnail'], 'thumbnail');
                if ($upload_result['success']) {
                    $image_url = $upload_result['url'];
                } else {
                    $error = $upload_result['message'];
                }
            }

            if (empty($error)) {
                try {
                    if ($action == 'add') {
                        $stmt = $pdo->prepare('
                            INSERT INTO tb_court 
                            (name, location, price_weekday, price_weekend, status, description, size, lighting, parking, floor_type, facilities, image_url, map_url) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ');
                        $result = $stmt->execute([
                            $name, $location, $price_weekday, $price_weekend, $status, $description, 
                            $size, $lighting, $parking, $floor_type, $facilities, $image_url, $map_url
                        ]);
                        
                        if ($result) {
                            $court_id = $pdo->lastInsertId();
                            
                            // Handle gallery upload
                            if (isset($_FILES['gallery']) && !empty($_FILES['gallery']['name'][0])) {
                                $gallery_results = $upload_handler->uploadMultiple($_FILES['gallery'], 'gallery');
                                $order = 1;
                                
                                foreach ($gallery_results as $result) {
                                    if ($result['success']) {
                                        $stmt = $pdo->prepare('INSERT INTO tb_court_gallery (court_id, image_url, image_order) VALUES (?, ?, ?)');
                                        $stmt->execute([$court_id, $result['url'], $order]);
                                        $order++;
                                    }
                                }
                            }
                            
                            $success = 'Data lapangan berhasil ditambahkan!';
                        }
                    } else {
                        $stmt = $pdo->prepare('
                            UPDATE tb_court 
                            SET name = ?, location = ?, price_weekday = ?, price_weekend = ?, status = ?, 
                                description = ?, size = ?, lighting = ?, parking = ?, floor_type = ?, facilities = ?, image_url = ?, map_url = ? 
                            WHERE id = ?
                        ');
                        $stmt->execute([
                            $name, $location, $price_weekday, $price_weekend, $status, $description, 
                            $size, $lighting, $parking, $floor_type, $facilities, $image_url, $map_url, $lapangan_id
                        ]);
                        
                        // Handle gallery upload untuk edit
                        if (isset($_FILES['gallery']) && !empty($_FILES['gallery']['name'][0])) {
                            $gallery_results = $upload_handler->uploadMultiple($_FILES['gallery'], 'gallery');
                            
                            // Get current max order
                            $stmt = $pdo->prepare('SELECT MAX(image_order) as max_order FROM tb_court_gallery WHERE court_id = ?');
                            $stmt->execute([$lapangan_id]);
                            $result = $stmt->fetch();
                            $order = ($result['max_order'] ?? 0) + 1;
                            
                            foreach ($gallery_results as $result) {
                                if ($result['success']) {
                                    $stmt = $pdo->prepare('INSERT INTO tb_court_gallery (court_id, image_url, image_order) VALUES (?, ?, ?)');
                                    $stmt->execute([$lapangan_id, $result['url'], $order]);
                                    $order++;
                                }
                            }
                        }
                        
                        $success = 'Data lapangan berhasil diupdate!';
                    }
                    $_POST = [];
                } catch (PDOException $e) {
                    $error = 'Error: ' . $e->getMessage();
                }
            }
        }
    }

    include 'templates/header.php';
    ?>

    <!-- Form Add/Edit -->
    <div class="bg-white rounded-2xl shadow-md p-8">
        <h3 class="text-2xl font-bold text-slate-900 mb-6">
            <i class="fas fa-<?php echo $action == 'add' ? 'plus-circle' : 'edit'; ?> text-emerald-600 mr-2"></i>
            <?php echo $action == 'add' ? 'Tambah' : 'Edit'; ?> Lapangan
        </h3>

        <?php if ($error): ?>
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-lg" data-alert>
                <p class="text-rose-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg" data-alert>
                <p class="text-emerald-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <!-- Nama Lapangan -->
            <div class="mb-6">
                <label class="block text-slate-700 font-semibold mb-2">Nama Lapangan <span class="text-rose-600">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    required 
                    value="<?php echo htmlspecialchars($lapangan['name'] ?? $_POST['name'] ?? ''); ?>"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                    placeholder="Contoh: Lapangan 1"
                >
            </div>

            <!-- Lokasi -->
            <div class="mb-6">
                <label class="block text-slate-700 font-semibold mb-2">Lokasi</label>
                <input 
                    type="text" 
                    name="location" 
                    value="<?php echo htmlspecialchars($lapangan['location'] ?? $_POST['location'] ?? ''); ?>"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                    placeholder="Jakarta, Bandung, dll"
                >
            </div>

            <!-- Harga Weekday & Weekend -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">Harga Weekday (Rp) <span class="text-rose-600">*</span></label>
                    <input 
                        type="number" 
                        name="price_weekday" 
                        required 
                        min="0"
                        step="1000"
                        value="<?php echo htmlspecialchars($lapangan['price_weekday'] ?? $_POST['price_weekday'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="50000"
                    >
                </div>
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">Harga Weekend (Rp) <span class="text-rose-600">*</span></label>
                    <input 
                        type="number" 
                        name="price_weekend" 
                        required 
                        min="0"
                        step="1000"
                        value="<?php echo htmlspecialchars($lapangan['price_weekend'] ?? $_POST['price_weekend'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="75000"
                    >
                </div>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block text-slate-700 font-semibold mb-2">Status</label>
                <select 
                    name="status" 
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                >
                    <option value="tersedia" <?php echo ($lapangan['status'] ?? $_POST['status'] ?? 'tersedia') == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                    <option value="maintenance" <?php echo ($lapangan['status'] ?? $_POST['status'] ?? '') == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                    <option value="booking" <?php echo ($lapangan['status'] ?? $_POST['status'] ?? '') == 'booking' ? 'selected' : ''; ?>>Booking</option>
                </select>
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-slate-700 font-semibold mb-2">Deskripsi</label>
                <textarea 
                    name="description" 
                    rows="4"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                    placeholder="Deskripsi lapangan..."
                ><?php echo htmlspecialchars($lapangan['description'] ?? $_POST['description'] ?? ''); ?></textarea>
            </div>

            <!-- Ukuran & Pencahayaan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">Ukuran</label>
                    <input 
                        type="text" 
                        name="size" 
                        value="<?php echo htmlspecialchars($lapangan['size'] ?? $_POST['size'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="17m x 8.5m"
                    >
                </div>
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">Pencahayaan</label>
                    <input 
                        type="text" 
                        name="lighting" 
                        value="<?php echo htmlspecialchars($lapangan['lighting'] ?? $_POST['lighting'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="LED Standard"
                    >
                </div>
            </div>

            <!-- Parkir & Tipe Lantai -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">Parkir</label>
                    <input 
                        type="text" 
                        name="parking" 
                        value="<?php echo htmlspecialchars($lapangan['parking'] ?? $_POST['parking'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="Tersedia (50+ spot)"
                    >
                </div>
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">Tipe Lantai</label>
                    <input 
                        type="text" 
                        name="floor_type" 
                        value="<?php echo htmlspecialchars($lapangan['floor_type'] ?? $_POST['floor_type'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="Vinyl/PVC, Maple, Rubber"
                    >
                </div>
            </div>

            <!-- Fasilitas (Comma-separated) -->
            <div class="mb-6">
                <label class="block text-slate-700 font-semibold mb-2">Fasilitas (pisahkan dengan koma)</label>
                <textarea 
                    name="facilities" 
                    rows="3"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition font-mono text-sm"
                    placeholder="AC, Toilet, Kamar Ganti, Penyewaan Perlengkapan, Kantin, WiFi"
                ><?php echo htmlspecialchars($lapangan['facilities'] ?? $_POST['facilities'] ?? ''); ?></textarea>
                <p class="text-slate-500 text-xs mt-1">Contoh: AC, Toilet, Kamar Ganti, Penyewaan Perlengkapan</p>
            </div>

            <!-- Map Link Input -->
            <div class="mb-6 p-6 bg-blue-50 rounded-lg border border-blue-200">
                <label class="block text-slate-700 font-semibold mb-3">
                    <i class="fas fa-map-location-dot text-blue-600 mr-2"></i> Link Google Maps (Embed Code)
                </label>
                <p class="text-slate-600 text-sm mb-3">Salin embed code dari Google Maps untuk menampilkan lokasi lapangan</p>
                
                <textarea 
                    name="map_url" 
                    rows="4"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition font-mono text-xs"
                    placeholder="Contoh: https://www.google.com/maps/embed?pb=1m18!1m12!1m3!1d..."
                ><?php echo htmlspecialchars($lapangan['map_url'] ?? $_POST['map_url'] ?? ''); ?></textarea>
                
                <div class="mt-3 p-3 bg-white rounded border border-blue-200">
                    <p class="text-slate-600 text-xs mb-2"><strong>Cara mendapatkan embed code:</strong></p>
                    <ol class="text-slate-600 text-xs space-y-1 list-decimal list-inside">
                        <li>Buka <a href="https://maps.google.com" target="_blank" class="text-blue-600 hover:underline">Google Maps</a></li>
                        <li>Cari lokasi lapangan Anda</li>
                        <li>Klik tombol "Share" (ikon bagikan)</li>
                        <li>Pilih tab "Embed a map"</li>
                        <li>Salin HTML code yang tersedia</li>
                        <li>Paste ke kolom di atas</li>
                    </ol>
                </div>
            </div>

            <!-- Upload Thumbnail -->
            <div class="mb-6 p-6 bg-slate-50 rounded-lg border-2 border-dashed border-slate-300">
                <label class="block text-slate-700 font-semibold mb-3">
                    <i class="fas fa-image text-emerald-600 mr-2"></i> Upload Thumbnail Lapangan
                </label>
                <p class="text-slate-600 text-sm mb-3">Foto utama yang akan ditampilkan di halaman utama</p>
                
                <?php if ($lapangan['image_url'] && $action == 'edit'): ?>
                    <div class="mb-4 p-3 bg-white rounded-lg border border-slate-200">
                        <p class="text-slate-600 text-sm mb-2">Foto saat ini:</p>
                        <img src="<?php echo htmlspecialchars($lapangan['image_url']); ?>" alt="Thumbnail" class="h-32 w-auto rounded-lg">
                    </div>
                <?php endif; ?>
                
                <input 
                    type="file" 
                    name="thumbnail" 
                    accept="image/jpeg,image/png,image/webp,image/gif"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 transition cursor-pointer"
                    id="thumbnailInput"
                >
                <p class="text-slate-500 text-xs mt-2">Format: JPG, PNG, WebP, GIF | Max: 5MB</p>
                <div id="thumbnailPreview" class="mt-3"></div>
            </div>

            <!-- Upload Gallery -->
            <div class="mb-8 p-6 bg-slate-50 rounded-lg border-2 border-dashed border-slate-300">
                <label class="block text-slate-700 font-semibold mb-3">
                    <i class="fas fa-images text-emerald-600 mr-2"></i> Upload Galeri Foto (Multiple)
                </label>
                <p class="text-slate-600 text-sm mb-3">Upload lebih dari 1 foto untuk menampilkan galeri lapangan</p>
                
                <input 
                    type="file" 
                    name="gallery[]" 
                    multiple
                    accept="image/jpeg,image/png,image/webp,image/gif"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 transition cursor-pointer"
                    id="galleryInput"
                >
                <p class="text-slate-500 text-xs mt-2">Format: JPG, PNG, WebP, GIF | Max: 5MB per file</p>
                <div id="galleryPreview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3"></div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3 rounded-lg transition duration-300"
                >
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a 
                    href="lapangan.php" 
                    class="text-center bg-slate-300 hover:bg-slate-400 text-slate-900 font-bold px-8 py-3 rounded-lg transition duration-300"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        // Thumbnail Preview
        document.getElementById('thumbnailInput')?.addEventListener('change', function(e) {
            const preview = document.getElementById('thumbnailPreview');
            preview.innerHTML = '';
            
            if (this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = `<img src="${event.target.result}" alt="Preview" class="h-32 w-auto rounded-lg">`;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Gallery Preview
        document.getElementById('galleryInput')?.addEventListener('change', function(e) {
            const preview = document.getElementById('galleryPreview');
            preview.innerHTML = '';
            
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.className = 'h-24 w-full object-cover rounded-lg';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>

    <?php include 'templates/footer.php';
} else {
    // Display list of lapangan
    try {
        $stmt = $pdo->query('SELECT id, name, location, price_weekday, price_weekend, status, description, size, lighting, parking, floor_type, facilities, image_url, map_url, created_at FROM tb_court ORDER BY created_at DESC');
        $lapangan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }

    include 'templates/header.php';
    ?>

    <!-- Data Lapangan List -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-slate-900">Daftar Lapangan</h3>
        <a 
            href="lapangan.php?action=add" 
            class="bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-bold px-4 py-2 rounded-lg transition duration-300 flex items-center gap-2"
        >
            <i class="fas fa-plus"></i> Tambah Lapangan
        </a>
    </div>

    <?php if ($error): ?>
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-lg" data-alert>
            <p class="text-rose-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($lapangan_list)): ?>
            <?php foreach ($lapangan_list as $court): ?>
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
                    <!-- Image -->
                    <div class="h-48 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center overflow-hidden">
                        <?php if ($court['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($court['image_url']); ?>" alt="<?php echo htmlspecialchars($court['name']); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <i class="fas fa-badminton text-white text-6xl opacity-50"></i>
                        <?php endif; ?>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-slate-900 mb-2"><?php echo htmlspecialchars($court['name']); ?></h4>
                        
                        <?php if ($court['description']): ?>
                            <p class="text-slate-600 text-sm mb-4 line-clamp-2"><?php echo htmlspecialchars($court['description']); ?></p>
                        <?php endif; ?>

                        <!-- Price Info -->
                        <div class="mb-4 pb-4 border-b border-slate-200">
                            <p class="text-emerald-600 font-bold text-lg">
                                Rp <?php echo number_format($court['price_weekday'], 0, ',', '.'); ?> 
                                <span class="text-slate-500 font-normal text-sm">/ jam (Weekday)</span>
                            </p>
                            <p class="text-yellow-600 font-bold text-lg">
                                Rp <?php echo number_format($court['price_weekend'], 0, ',', '.'); ?> 
                                <span class="text-slate-500 font-normal text-sm">/ jam (Weekend)</span>
                            </p>
                        </div>

                        <!-- Spec Info -->
                        <div class="mb-4 pb-4 border-b border-slate-200 text-xs text-slate-600 space-y-1">
                            <?php if ($court['size']): ?>
                                <p><i class="fas fa-ruler text-emerald-600 mr-2"></i><?php echo htmlspecialchars($court['size']); ?></p>
                            <?php endif; ?>
                            <?php if ($court['lighting']): ?>
                                <p><i class="fas fa-lightbulb text-yellow-400 mr-2"></i><?php echo htmlspecialchars($court['lighting']); ?></p>
                            <?php endif; ?>
                            <?php if ($court['parking']): ?>
                                <p><i class="fas fa-parking text-blue-600 mr-2"></i><?php echo htmlspecialchars($court['parking']); ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a 
                                href="lapangan.php?action=edit&id=<?php echo $court['id']; ?>" 
                                class="flex-1 text-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 rounded-lg transition duration-300 text-sm"
                            >
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <button 
                                onclick="confirmDelete(<?php echo $court['id']; ?>)" 
                                class="flex-1 bg-rose-100 hover:bg-rose-200 text-rose-700 font-semibold py-2 rounded-lg transition duration-300 text-sm"
                            >
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-12">
                <i class="fas fa-inbox text-slate-300 text-6xl mb-4"></i>
                <p class="text-slate-500 text-lg">Belum ada data lapangan</p>
                <a href="lapangan.php?action=add" class="text-emerald-600 hover:text-emerald-700 font-semibold mt-2 inline-block">
                    Tambah lapangan pertama
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Delete Modal (Hidden) -->
    <form id="deleteForm" method="POST" action="" style="display: none;">
    </form>

    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus lapangan ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = 'lapangan.php?action=delete&id=' + id;
                form.submit();
            }
        }
    </script>

    <?php include 'templates/footer.php';
}
?>
