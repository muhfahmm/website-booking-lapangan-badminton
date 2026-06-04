<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$page_title = 'Manage Booking';
$page_subtitle = 'Kelola dan konfirmasi pembayaran booking';

$success = '';
$error = '';
$action = $_GET['action'] ?? '';
$booking_id = $_GET['id'] ?? '';
$filter_status = $_GET['status'] ?? 'all';

// Handle status update
if ($action == 'update_status' && $booking_id) {
    $new_status = $_POST['status'] ?? '';
    
    if (!in_array($new_status, ['pending', 'confirmed', 'cancelled'])) {
        $error = 'Status tidak valid!';
    } else {
        try {
            $stmt = $pdo->prepare('UPDATE tb_booking SET status = ? WHERE id = ?');
            $stmt->execute([$new_status, $booking_id]);
            $success = 'Status booking berhasil diupdate!';
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
        header('Location: booking-manage.php');
        exit;
    }
}

// Get bookings
try {
    $query = '
        SELECT tb_booking.id, tb_booking.status, tb_booking.start_time, tb_booking.end_time,
               tb_user.name as user_name, tb_user.email, tb_user.phone,
               tb_court.name as court_name, tb_court.price_per_hour,
               tb_booking.created_at
        FROM tb_booking
        JOIN tb_user ON tb_booking.user_id = tb_user.id
        JOIN tb_court ON tb_booking.court_id = tb_court.id
    ';

    if ($filter_status !== 'all') {
        $query .= ' WHERE tb_booking.status = ?';
        $stmt = $pdo->prepare($query . ' ORDER BY tb_booking.created_at DESC');
        $stmt->execute([$filter_status]);
    } else {
        $stmt = $pdo->prepare($query . ' ORDER BY tb_booking.created_at DESC');
        $stmt->execute();
    }

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get count by status
    $stmt = $pdo->query("
        SELECT status, COUNT(*) as count FROM tb_booking GROUP BY status
    ");
    $status_counts = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $status_counts[$row['status']] = $row['count'];
    }
    $status_counts['all'] = array_sum($status_counts);

} catch (PDOException $e) {
    $error = 'Error: ' . $e->getMessage();
}

include 'templates/header.php';
?>

<!-- Filter Tabs -->
<div class="flex gap-2 mb-6 overflow-x-auto pb-2">
    <a href="?status=all" class="px-4 py-2 rounded-full font-semibold transition whitespace-nowrap <?php echo $filter_status == 'all' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100'; ?>">
        Semua <span class="ml-1 text-sm">(<?php echo $status_counts['all'] ?? 0; ?>)</span>
    </a>
    <a href="?status=pending" class="px-4 py-2 rounded-full font-semibold transition whitespace-nowrap <?php echo $filter_status == 'pending' ? 'bg-yellow-400 text-slate-900' : 'bg-white text-slate-700 hover:bg-slate-100'; ?>">
        Pending <span class="ml-1 text-sm">(<?php echo $status_counts['pending'] ?? 0; ?>)</span>
    </a>
    <a href="?status=confirmed" class="px-4 py-2 rounded-full font-semibold transition whitespace-nowrap <?php echo $filter_status == 'confirmed' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100'; ?>">
        Confirmed <span class="ml-1 text-sm">(<?php echo $status_counts['confirmed'] ?? 0; ?>)</span>
    </a>
    <a href="?status=cancelled" class="px-4 py-2 rounded-full font-semibold transition whitespace-nowrap <?php echo $filter_status == 'cancelled' ? 'bg-rose-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100'; ?>">
        Cancelled <span class="ml-1 text-sm">(<?php echo $status_counts['cancelled'] ?? 0; ?>)</span>
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

<!-- Bookings Table -->
<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <?php if (!empty($bookings)): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-left text-slate-700 font-semibold text-sm">User</th>
                        <th class="px-6 py-4 text-left text-slate-700 font-semibold text-sm">Lapangan</th>
                        <th class="px-6 py-4 text-left text-slate-700 font-semibold text-sm">Waktu</th>
                        <th class="px-6 py-4 text-left text-slate-700 font-semibold text-sm">Harga</th>
                        <th class="px-6 py-4 text-left text-slate-700 font-semibold text-sm">Status</th>
                        <th class="px-6 py-4 text-center text-slate-700 font-semibold text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-slate-900"><?php echo htmlspecialchars($booking['user_name']); ?></p>
                                    <p class="text-slate-600 text-xs"><?php echo htmlspecialchars($booking['email']); ?></p>
                                    <p class="text-slate-600 text-xs"><?php echo htmlspecialchars($booking['phone']); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-900 font-semibold">
                                <?php echo htmlspecialchars($booking['court_name']); ?>
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-sm">
                                <p><?php echo date('d M Y', strtotime($booking['start_time'])); ?></p>
                                <p class="text-xs text-slate-500">
                                    <?php echo date('H:i', strtotime($booking['start_time'])); ?> - 
                                    <?php echo date('H:i', strtotime($booking['end_time'])); ?>
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900">
                                    Rp <?php echo number_format($booking['price_per_hour'], 0, ',', '.'); ?>
                                </p>
                                <p class="text-slate-500 text-xs">Dibuat: <?php echo date('d M Y H:i', strtotime($booking['created_at'])); ?></p>
                            </td>
                            <td class="px-6 py-4">
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
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <?php if ($booking['status'] != 'confirmed'): ?>
                                        <form method="POST" action="?action=update_status&id=<?php echo $booking['id']; ?>" style="display: inline;">
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="px-3 py-1 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 text-xs font-semibold rounded transition">
                                                Confirm
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($booking['status'] != 'cancelled'): ?>
                                        <form method="POST" action="?action=update_status&id=<?php echo $booking['id']; ?>" style="display: inline;" onsubmit="return confirm('Batalkan booking ini?');">
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="px-3 py-1 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-semibold rounded transition">
                                                Cancel
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <i class="fas fa-inbox text-slate-300 text-6xl mb-4"></i>
            <p class="text-slate-500 text-lg">Belum ada booking</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>
