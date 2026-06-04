<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$page_title = 'Website Settings';
$page_subtitle = 'Kelola konten dan pengaturan website';

$success = '';
$error = '';
$tab = $_GET['tab'] ?? 'general';

// Handle save settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $setting_type = $_POST['setting_type'] ?? '';

    if ($setting_type == 'general') {
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
    } elseif ($setting_type == 'content') {
        $page_slug = $_POST['page_slug'] ?? '';
        $title = $_POST['title'] ?? '';
        $body = $_POST['body'] ?? '';

        if (empty($page_slug) || empty($title) || empty($body)) {
            $error = 'Semua field harus diisi!';
        } else {
            try {
                $stmt = $pdo->prepare('
                    INSERT INTO tb_content (page_slug, title, body) 
                    VALUES (?, ?, ?) 
                    ON DUPLICATE KEY UPDATE title = ?, body = ?
                ');
                $stmt->execute([$page_slug, $title, $body, $title, $body]);
                $success = 'Konten berhasil disimpan!';
            } catch (PDOException $e) {
                $error = 'Error: ' . $e->getMessage();
            }
        }
    }
}

// Get settings
try {
    $stmt = $pdo->query('SELECT `key`, `value` FROM tb_setting');
    $settings = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $settings[$row['key']] = $row['value'];
    }

    // Get content pages
    $stmt = $pdo->query('SELECT * FROM tb_content ORDER BY page_slug');
    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = 'Error: ' . $e->getMessage();
}

include 'templates/header.php';
?>

<!-- Tab Navigation -->
<div class="flex gap-4 mb-6 border-b border-slate-200">
    <a href="?tab=general" class="px-4 py-3 font-semibold border-b-2 transition <?php echo $tab == 'general' ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-slate-600 hover:text-slate-900'; ?>">
        <i class="fas fa-cog mr-2"></i> Pengaturan Umum
    </a>
    <a href="?tab=content" class="px-4 py-3 font-semibold border-b-2 transition <?php echo $tab == 'content' ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-slate-600 hover:text-slate-900'; ?>">
        <i class="fas fa-file-alt mr-2"></i> Manajemen Konten
    </a>
</div>

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

<!-- Tab: Pengaturan Umum -->
<?php if ($tab == 'general'): ?>
    <div class="bg-white rounded-2xl shadow-md p-8">
        <h3 class="text-2xl font-bold text-slate-900 mb-6">
            <i class="fas fa-cog text-emerald-600 mr-2"></i> Pengaturan Umum Website
        </h3>

        <form method="POST" action="">
            <input type="hidden" name="setting_type" value="general">

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
                class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3 rounded-lg transition duration-300"
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

<?php else: ?>
    <!-- Tab: Manajemen Konten -->
    <div class="space-y-6">
        <!-- Tambah Konten -->
        <div class="bg-white rounded-2xl shadow-md p-8">
            <h3 class="text-2xl font-bold text-slate-900 mb-6">
                <i class="fas fa-plus-circle text-emerald-600 mr-2"></i> Tambah / Edit Konten
            </h3>

            <form method="POST" action="">
                <input type="hidden" name="setting_type" value="content">

                <!-- Page Slug -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">Slug Halaman <span class="text-rose-600">*</span></label>
                    <input 
                        type="text" 
                        name="page_slug" 
                        required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="about, rules, contact, dll"
                    >
                    <p class="text-slate-500 text-xs mt-1">Gunakan huruf kecil dan underscore (_) atau dash (-)</p>
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">Judul <span class="text-rose-600">*</span></label>
                    <input 
                        type="text" 
                        name="title" 
                        required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="Judul halaman"
                    >
                </div>

                <!-- Body/Content -->
                <div class="mb-8">
                    <label class="block text-slate-700 font-semibold mb-2">Konten <span class="text-rose-600">*</span></label>
                    <textarea 
                        name="body" 
                        required 
                        rows="8"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition font-mono text-sm"
                        placeholder="Masukkan konten halaman..."
                    ></textarea>
                    <p class="text-slate-500 text-xs mt-1">Anda dapat menggunakan HTML basic untuk formatting</p>
                </div>

                <!-- Submit -->
                <button 
                    type="submit" 
                    class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3 rounded-lg transition duration-300"
                >
                    <i class="fas fa-save mr-2"></i> Simpan Konten
                </button>
            </form>
        </div>

        <!-- Daftar Konten -->
        <div class="bg-white rounded-2xl shadow-md p-8">
            <h3 class="text-2xl font-bold text-slate-900 mb-6">
                <i class="fas fa-list text-emerald-600 mr-2"></i> Daftar Konten
            </h3>

            <?php if (!empty($pages)): ?>
                <div class="space-y-4">
                    <?php foreach ($pages as $page): ?>
                        <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900 mb-1"><?php echo htmlspecialchars($page['title']); ?></h4>
                                    <p class="text-slate-500 text-sm mb-2">
                                        <span class="inline-block bg-slate-100 px-2 py-1 rounded text-xs font-mono">
                                            <?php echo htmlspecialchars($page['page_slug']); ?>
                                        </span>
                                    </p>
                                    <p class="text-slate-600 text-sm line-clamp-2">
                                        <?php 
                                        $preview = strip_tags($page['body']);
                                        echo htmlspecialchars(substr($preview, 0, 100)) . (strlen($preview) > 100 ? '...' : '');
                                        ?>
                                    </p>
                                    <p class="text-slate-400 text-xs mt-2">
                                        Update: <?php echo date('d M Y H:i', strtotime($page['updated_at'])); ?>
                                    </p>
                                </div>
                                <div class="ml-4">
                                    <button 
                                        onclick="editContent('<?php echo htmlspecialchars(json_encode($page)); ?>')"
                                        class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-semibold rounded transition"
                                    >
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-slate-300 text-6xl mb-4"></i>
                    <p class="text-slate-500">Belum ada konten</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<script>
    function editContent(data) {
        const page = JSON.parse(data);
        document.querySelector('input[name="page_slug"]').value = page.page_slug;
        document.querySelector('input[name="title"]').value = page.title;
        document.querySelector('textarea[name="body"]').value = page.body;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        document.querySelector('input[name="page_slug"]').focus();
    }
</script>

<?php include 'templates/footer.php'; ?>
