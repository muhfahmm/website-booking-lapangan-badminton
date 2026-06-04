<?php
// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - ' : ''; ?>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-900 text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-400 text-slate-900 rounded-lg p-2">
                        <i class="fas fa-badminton w-6 h-6 text-center"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">Admin Panel</h1>
                        <p class="text-slate-400 text-xs">Booking Lapangan</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6">
                <ul class="space-y-2">
                    <li>
                        <a 
                            href="dashboard.php" 
                            class="block px-4 py-3 rounded-lg hover:bg-emerald-600 transition <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-emerald-600' : 'text-slate-300'; ?>"
                        >
                            <i class="fas fa-chart-line mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a 
                            href="lapangan.php" 
                            class="block px-4 py-3 rounded-lg hover:bg-emerald-600 transition <?php echo basename($_SERVER['PHP_SELF']) == 'lapangan.php' ? 'bg-emerald-600' : 'text-slate-300'; ?>"
                        >
                            <i class="fas fa-table mr-3"></i> Data Lapangan
                        </a>
                    </li>
                    <li>
                        <a 
                            href="booking-manage.php" 
                            class="block px-4 py-3 rounded-lg hover:bg-emerald-600 transition <?php echo basename($_SERVER['PHP_SELF']) == 'booking-manage.php' ? 'bg-emerald-600' : 'text-slate-300'; ?>"
                        >
                            <i class="fas fa-calendar-check mr-3"></i> Manage Booking
                        </a>
                    </li>
                    <li>
                        <a 
                            href="website-setting.php" 
                            class="block px-4 py-3 rounded-lg hover:bg-emerald-600 transition <?php echo basename($_SERVER['PHP_SELF']) == 'website-setting.php' ? 'bg-emerald-600' : 'text-slate-300'; ?>"
                        >
                            <i class="fas fa-cog mr-3"></i> Website Settings
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Info & Logout -->
            <div class="p-4 border-t border-slate-700">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="bg-yellow-400 text-slate-900 rounded-full w-8 h-8 flex items-center justify-center">
                            <i class="fas fa-user-shield text-sm"></i>
                        </div>
                        <span class="text-sm text-slate-300"><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                    </div>
                </div>
                <a 
                    href="logout.php" 
                    class="w-full block text-center px-4 py-2 bg-rose-600 hover:bg-rose-700 rounded-lg text-white text-sm font-semibold transition"
                >
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <div class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900"><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Dashboard'; ?></h2>
                    <?php if (isset($page_subtitle)): ?>
                        <p class="text-slate-500 text-sm mt-1"><?php echo htmlspecialchars($page_subtitle); ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm text-slate-600">Selamat datang kembali,</p>
                        <p class="font-semibold text-slate-900"><?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-auto p-6">
