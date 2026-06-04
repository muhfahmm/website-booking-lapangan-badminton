<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$page_title = 'Dashboard';
$page_subtitle = 'Ringkasan informasi booking lapangan badminton hari ini';

// Get statistics
try {
    // Total bookings today
    $stmt = $pdo->query("
        SELECT COUNT(*) as total_today, 
               SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed_today,
               SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_today,
               SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_today
        FROM tb_booking 
        WHERE DATE(created_at) = CURDATE()
    ");
    $today_stats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Total courts
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM tb_court");
    $total_courts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Total users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM tb_user");
    $total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Total bookings all time
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM tb_booking");
    $total_bookings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Recent bookings
    $stmt = $pdo->query("
        SELECT tb_booking.id, tb_user.name, tb_court.name as court_name, 
               tb_booking.start_time, tb_booking.status, tb_court.price_per_hour
        FROM tb_booking
        JOIN tb_user ON tb_booking.user_id = tb_user.id
        JOIN tb_court ON tb_booking.court_id = tb_court.id
        ORDER BY tb_booking.created_at DESC
        LIMIT 5
    ");
    $recent_bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = 'Error: ' . $e->getMessage();
}

include 'templates/header.php';
?>

<!-- Dashboard Content -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card: Total Bookings Today -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6 border-l-4 border-emerald-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm mb-1">Booking Hari Ini</p>
                <h3 class="text-3xl font-bold text-slate-900"><?php echo $today_stats['total_today'] ?? 0; ?></h3>
                <p class="text-xs text-slate-500 mt-2">
                    <span class="text-emerald-600 font-semibold"><?php echo $today_stats['confirmed_today'] ?? 0; ?></span> terkonfirmasi
                </p>
            </div>
            <div class="bg-emerald-100 rounded-full p-4">
                <i class="fas fa-calendar-check text-emerald-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card: Pending Payments -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6 border-l-4 border-yellow-400">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm mb-1">Pending Payment</p>
                <h3 class="text-3xl font-bold text-slate-900"><?php echo $today_stats['pending_today'] ?? 0; ?></h3>
                <p class="text-xs text-slate-500 mt-2">Menunggu konfirmasi</p>
            </div>
            <div class="bg-yellow-100 rounded-full p-4">
                <i class="fas fa-hourglass-half text-yellow-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card: Total Courts -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm mb-1">Total Lapangan</p>
                <h3 class="text-3xl font-bold text-slate-900"><?php echo $total_courts; ?></h3>
                <p class="text-xs text-slate-500 mt-2">Data aktif</p>
            </div>
            <div class="bg-blue-100 rounded-full p-4">
                <i class="fas fa-table text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card: Total Users -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6 border-l-4 border-purple-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm mb-1">Total User</p>
                <h3 class="text-3xl font-bold text-slate-900"><?php echo $total_users; ?></h3>
                <p class="text-xs text-slate-500 mt-2">Terdaftar</p>
            </div>
            <div class="bg-purple-100 rounded-full p-4">
                <i class="fas fa-users text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings Section -->
<div class="bg-white rounded-2xl shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fas fa-clock text-emerald-600"></i> Booking Terbaru
        </h3>
        <a href="booking-manage.php" class="text-emerald-600 hover:text-emerald-700 text-sm font-semibold">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <?php if (!empty($recent_bookings)): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="px-4 py-3 text-left text-slate-700 font-semibold">Nama User</th>
                        <th class="px-4 py-3 text-left text-slate-700 font-semibold">Lapangan</th>
                        <th class="px-4 py-3 text-left text-slate-700 font-semibold">Waktu Main</th>
                        <th class="px-4 py-3 text-left text-slate-700 font-semibold">Harga</th>
                        <th class="px-4 py-3 text-left text-slate-700 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_bookings as $booking): ?>
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-900"><?php echo htmlspecialchars($booking['name']); ?></td>
                            <td class="px-4 py-3 text-slate-900"><?php echo htmlspecialchars($booking['court_name']); ?></td>
                            <td class="px-4 py-3 text-slate-600 text-xs">
                                <?php echo date('d M Y H:i', strtotime($booking['start_time'])); ?>
                            </td>
                            <td class="px-4 py-3 text-slate-900 font-semibold">
                                Rp <?php echo number_format($booking['price_per_hour'], 0, ',', '.'); ?>
                            </td>
                            <td class="px-4 py-3">
                                <?php
                                $status_class = match($booking['status']) {
                                    'confirmed' => 'bg-emerald-100 text-emerald-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'cancelled' => 'bg-rose-100 text-rose-800',
                                    default => 'bg-slate-100 text-slate-800'
                                };
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $status_class; ?>">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center py-8">
            <i class="fas fa-inbox text-slate-300 text-4xl mb-4"></i>
            <p class="text-slate-500">Belum ada booking hari ini</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>
