<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Validation
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi!';
    } elseif (strlen($username) < 3) {
        $error = 'Username minimal 3 karakter!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok!';
    } else {
        try {
            // Check if username already exists
            $stmt = $pdo->prepare('SELECT id FROM tb_admin WHERE username = ?');
            $stmt->execute([$username]);
            
            if ($stmt->fetch()) {
                $error = 'Username sudah terdaftar!';
            } else {
                // Hash password and insert
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO tb_admin (username, password) VALUES (?, ?)');
                $stmt->execute([$username, $hashed_password]);
                
                $success = 'Akun berhasil dibuat! Silahkan login.';
                // Clear form
                $_POST = [];
            }
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register - Booking Lapangan Badminton</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #059669 0%, #0F172A 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <!-- Logo / Header -->
        <div class="text-center mb-8">
            <div class="inline-block bg-yellow-400 rounded-full p-4 mb-4">
                <svg class="w-8 h-8 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Daftar Admin</h1>
            <p class="text-emerald-200">Booking Lapangan Badminton</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <?php if ($error): ?>
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-lg">
                    <p class="text-rose-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                    <p class="text-emerald-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
                    <p class="text-emerald-600 text-xs mt-2">
                        <a href="login.php" class="font-semibold hover:text-emerald-800">Klik di sini untuk login</a>
                    </p>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <!-- Username Input -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">Username</label>
                    <input 
                        type="text" 
                        name="username" 
                        required 
                        value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="Minimal 3 karakter"
                    >
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="Masukkan password"
                    >
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-8">
                    <label class="block text-slate-700 font-semibold mb-2">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        name="confirm_password" 
                        required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="Ulangi password"
                    >
                </div>

                <!-- Register Button -->
                <button 
                    type="submit" 
                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-bold py-3 rounded-lg transition duration-300 transform hover:scale-105"
                >
                    Daftar
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-slate-600">
                    Sudah punya akun? 
                    <a href="login.php" class="text-emerald-600 font-semibold hover:text-emerald-700">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center text-emerald-100 text-sm">
            <p>© 2024 Booking Lapangan Badminton. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
