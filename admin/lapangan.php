<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$page_title = 'Data Lapangan';
$page_subtitle = 'Kelola data lapangan badminton';

$success = '';
$error = '';
$action = $_GET['action'] ?? '';
$lapangan_id = $_GET['id'] ?? '';

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
        'description' => '',
        'price_per_hour' => '',
        'image_url' => ''
    ];

    if ($action == 'edit' && $lapangan_id) {
        try {
            $stmt = $pdo->prepare('SELECT * FROM tb_court WHERE id = ?');
            $stmt->execute([$lapangan_id]);
            $lapangan = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price_per_hour = trim($_POST['price_per_hour'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');

        if (empty($name) || empty($price_per_hour)) {
            $error = 'Nama dan harga lapangan harus diisi!';
        } else {
            try {
                if ($action == 'add') {
                    $stmt = $pdo->prepare('INSERT INTO tb_court (name, description, price_per_hour, image_url) VALUES (?, ?, ?, ?)');
                    $stmt->execute([$name, $description, $price_per_hour, $image_url]);
                    $success = 'Data lapangan berhasil ditambahkan!';
                } else {
                    $stmt = $pdo->prepare('UPDATE tb_court SET name = ?, description = ?, price_per_hour = ?, image_url = ? WHERE id = ?');
                    $stmt->execute([$name, $description, $price_per_hour, $image_url, $lapangan_id]);
                    $success = 'Data lapangan berhasil diupdate!';
                }
                $_POST = [];
            } catch (PDOException $e) {
                $error = 'Error: ' . $e->getMessage();
            }
        }
    }

    include 'templates/header.php';
    ?>

    <!-- Form Add/Edit -->
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-md p-8">
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

        <form method="POST" action="">
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

            <!-- Harga per jam -->
            <div class="mb-6">
                <label class="block text-slate-700 font-semibold mb-2">Harga per Jam (Rp) <span class="text-rose-600">*</span></label>
                <input 
                    type="number" 
                    name="price_per_hour" 
                    required 
                    min="0"
                    step="1000"
                    value="<?php echo htmlspecialchars($lapangan['price_per_hour'] ?? $_POST['price_per_hour'] ?? ''); ?>"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                    placeholder="50000"
                >
            </div>

            <!-- URL Gambar -->
            <div class="mb-8">
                <label class="block text-slate-700 font-semibold mb-2">URL Gambar</label>
                <input 
                    type="url" 
                    name="image_url" 
                    value="<?php echo htmlspecialchars($lapangan['image_url'] ?? $_POST['image_url'] ?? ''); ?>"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                    placeholder="https://example.com/image.jpg"
                >
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg transition duration-300"
                >
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a 
                    href="lapangan.php" 
                    class="flex-1 text-center bg-slate-300 hover:bg-slate-400 text-slate-900 font-bold py-3 rounded-lg transition duration-300"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <?php include 'templates/footer.php';
} else {
    // Display list of lapangan
    try {
        $stmt = $pdo->query('SELECT * FROM tb_court ORDER BY created_at DESC');
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

                        <div class="mb-4 pb-4 border-b border-slate-200">
                            <p class="text-emerald-600 font-bold text-lg">
                                Rp <?php echo number_format($court['price_per_hour'], 0, ',', '.'); ?> / jam
                            </p>
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
