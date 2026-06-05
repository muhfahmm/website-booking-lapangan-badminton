<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$page_title = 'Website Settings';
$page_subtitle = 'Kelola pengaturan website';

$success = '';
$error = '';

// Handle save settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $settings = [
        'site_name' => $_POST['site_name'] ?? '',
        'site_email' => $_POST['site_email'] ?? '',
        'site_phone' => $_POST['site_phone'] ?? '',
        'site_address' => $_POST['site_address'] ?? ''
    ];

    try {
        foreach ($settings as $key => $value) {
            $stmt = $pdo->prepare('
                INSERT INTO tb_setting (`key`, `value`) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE `value` = ?
            ');
            $stmt->execute([$key, $value, $value]);
        }
        $success = 'Pengaturan umum berhasil disimpan!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}

// Get settings
try {
    $stmt = $pdo->query('SELECT `key`, `value` FROM tb_setting');
    $settings = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $settings[$row['key']] = $row['value'];
    }
} catch (PDOException $e) {
    $error = 'Error: ' . $e->getMessage();
}

include 'templates/header.php';
?>

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

<!-- Pengaturan Umum Website -->
<div class="bg-white rounded-2xl shadow-md p-8">
    <h3 class="text-2xl font-bold text-slate-900 mb-6">
        <i class="fas fa-cog text-emerald-600 mr-2"></i> Pengaturan Umum Website
    </h3>

    <form method="POST" action="">
        <!-- Site Name -->
        <div class="mb-6">
            <label class="block text-slate-700 font-semibold mb-2">Nama Website</label>
            <input 
                type="text" 
                name="site_name" 
                value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                placeholder="Booking Lapangan Badminton"
            >
        </div>

        <!-- Site Email -->
        <div class="mb-6">
            <label class="block text-slate-700 font-semibold mb-2">Email Website</label>
            <input 
                type="email" 
                name="site_email" 
                value="<?php echo htmlspecialchars($settings['site_email'] ?? ''); ?>"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                placeholder="info@example.com"
            >
        </div>

        <!-- Site Phone -->
        <div class="mb-6">
            <label class="block text-slate-700 font-semibold mb-2">Nomor Telepon</label>
            <input 
                type="tel" 
                name="site_phone" 
                value="<?php echo htmlspecialchars($settings['site_phone'] ?? ''); ?>"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                placeholder="081234567890"
            >
        </div>

        <!-- Site Address -->
        <div class="mb-8">
            <label class="block text-slate-700 font-semibold mb-2">Alamat</label>
            <textarea 
                name="site_address" 
                rows="4"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                placeholder="Jln. Example No. 123, Kota, Provinsi"
            ><?php echo htmlspecialchars($settings['site_address'] ?? ''); ?></textarea>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3 rounded-lg transition duration-300"
        >
            <i class="fas fa-save mr-2"></i> Simpan Pengaturan
        </button>
    </form>

    <!-- Info Box -->
    <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
        <h4 class="font-bold text-blue-900 mb-2">
            <i class="fas fa-info-circle mr-2"></i> Informasi
        </h4>
        <p class="text-blue-800 text-sm">
            Pengaturan umum ini akan ditampilkan di footer dan halaman kontak website.
        </p>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
