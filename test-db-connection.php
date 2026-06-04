<?php
/**
 * Database Connection Test & Sample Data Insertion
 * Akses: http://localhost/project-client-php/website_booking_lapangan_badminton/test-db-connection.php
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Test Database Connection</title>";
echo "<style>body{font-family:Arial;margin:20px;background:#f5f5f5;}";
echo ".container{max-width:800px;margin:0 auto;background:white;padding:20px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1);}";
echo ".success{color:green;background:#d4edda;padding:10px;border-radius:4px;margin:10px 0;border-left:4px solid green;}";
echo ".error{color:red;background:#f8d7da;padding:10px;border-radius:4px;margin:10px 0;border-left:4px solid red;}";
echo ".info{color:#004085;background:#d1ecf1;padding:10px;border-radius:4px;margin:10px 0;border-left:4px solid #004085;}";
echo "table{width:100%;border-collapse:collapse;margin-top:20px;}";
echo "th,td{padding:10px;text-align:left;border-bottom:1px solid #ddd;}";
echo "th{background:#059669;color:white;}";
echo "tr:hover{background:#f5f5f5;}";
echo "button{background:#059669;color:white;padding:10px 20px;border:none;border-radius:4px;cursor:pointer;margin:5px;}";
echo "button:hover{background:#047857;}";
echo "h1{color:#059669;}";
echo "</style></head><body>";
echo "<div class='container'>";

echo "<h1>🔧 Test Database Connection & Management</h1>";

try {
    // Test koneksi
    echo "<div class='success'>✓ Database connection berhasil!</div>";
    
    // Cek tabel tb_court
    $check = $pdo->query("SELECT COUNT(*) FROM tb_court");
    $count = $check->fetchColumn();
    
    echo "<div class='info'>📊 Database: db_booking_lapangan_badminton | Tabel: tb_court | Records: " . $count . "</div>";
    
    // Tampilkan data lapangan
    if ($count > 0) {
        echo "<h2>Data Lapangan yang Sudah Ada:</h2>";
        $query = $pdo->query("SELECT id, name, location, price_weekday, price_weekend, status FROM tb_court ORDER BY id DESC");
        $courts = $query->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table>";
        echo "<tr><th>ID</th><th>Nama Lapangan</th><th>Lokasi</th><th>Weekday</th><th>Weekend</th><th>Status</th></tr>";
        foreach ($courts as $court) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($court['id']) . "</td>";
            echo "<td>" . htmlspecialchars($court['name']) . "</td>";
            echo "<td>" . htmlspecialchars($court['location']) . "</td>";
            echo "<td>Rp " . number_format($court['price_weekday'], 0, ',', '.') . "</td>";
            echo "<td>Rp " . number_format($court['price_weekend'], 0, ',', '.') . "</td>";
            echo "<td><span style='background:#059669;color:white;padding:3px 8px;border-radius:3px;'>" . htmlspecialchars($court['status']) . "</span></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='error'>⚠️ Tidak ada data lapangan di database!</div>";
        echo "<p>Silakan jalankan salah satu cara berikut:</p>";
        echo "<h3>Cara 1: Menggunakan phpMyAdmin</h3>";
        echo "<ol>";
        echo "<li>Buka phpMyAdmin: <a href='http://localhost/phpmyadmin'>http://localhost/phpmyadmin</a></li>";
        echo "<li>Pilih database: db_booking_lapangan_badminton</li>";
        echo "<li>Klik tab 'SQL'</li>";
        echo "<li>Copy-paste isi file: <code>md/insert_sample_data.sql</code></li>";
        echo "<li>Klik 'Go' untuk menjalankan</li>";
        echo "</ol>";
        
        echo "<h3>Cara 2: Menggunakan Form di bawah (Insert Sample Data)</h3>";
    }
    
    // Form untuk insert sample data
    if (isset($_POST['insert_sample'])) {
        try {
            $pdo->beginTransaction();
            
            $sample_data = [
                [
                    'name' => 'Lapangan Premium Sentosa',
                    'location' => 'Jl. Ahmad Yani No. 123, Jakarta Pusat',
                    'price_weekday' => 150000,
                    'price_weekend' => 200000,
                    'status' => 'tersedia',
                    'description' => 'Lapangan badminton premium dengan fasilitas lengkap dan nyaman',
                    'size' => '17m x 8.5m',
                    'lighting' => 'LED Premium',
                    'parking' => 'Tersedia',
                    'floor_type' => 'Vinyl Profesional',
                    'facilities' => 'AC, WiFi, Ruang istirahat, Kantin',
                    'image_url' => 'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Premium+Sentosa'
                ],
                [
                    'name' => 'Lapangan Sports Center',
                    'location' => 'Jl. Sudirman No. 45, Jakarta Selatan',
                    'price_weekday' => 120000,
                    'price_weekend' => 180000,
                    'status' => 'tersedia',
                    'description' => 'Lapangan badminton standar dengan pencahayaan baik',
                    'size' => '17m x 8.5m',
                    'lighting' => 'LED Standar',
                    'parking' => 'Tersedia',
                    'floor_type' => 'Vinyl',
                    'facilities' => 'WiFi, Ruang istirahat, Parkir gratis',
                    'image_url' => 'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Sports+Center'
                ],
                [
                    'name' => 'Lapangan Elite Badminton',
                    'location' => 'Jl. Gatot Subroto No. 89, Jakarta Timur',
                    'price_weekday' => 180000,
                    'price_weekend' => 230000,
                    'status' => 'tersedia',
                    'description' => 'Lapangan badminton elite dengan standar internasional',
                    'size' => '17m x 8.5m',
                    'lighting' => 'LED Premium Internasional',
                    'parking' => 'Tersedia (Luas)',
                    'floor_type' => 'PVC Profesional',
                    'facilities' => 'AC Premium, WiFi, Ruang VIP, Kafetaria, Loker',
                    'image_url' => 'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Elite+Badminton'
                ],
                [
                    'name' => 'Lapangan Rakyat Jakarta',
                    'location' => 'Jl. Merdeka No. 1, Jakarta Barat',
                    'price_weekday' => 80000,
                    'price_weekend' => 120000,
                    'status' => 'tersedia',
                    'description' => 'Lapangan badminton terjangkau untuk pemula',
                    'size' => '17m x 8.5m',
                    'lighting' => 'Neon Standar',
                    'parking' => 'Terbatas',
                    'floor_type' => 'Lantai Semen',
                    'facilities' => 'Parkir, Ruang istirahat sederhana',
                    'image_url' => 'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Rakyat+Jakarta'
                ],
                [
                    'name' => 'Lapangan Champion Club',
                    'location' => 'Jl. Bunderan HI No. 10, Jakarta Pusat',
                    'price_weekday' => 200000,
                    'price_weekend' => 280000,
                    'status' => 'tersedia',
                    'description' => 'Lapangan badminton kelas dunia dengan fasilitas premium',
                    'size' => '17m x 8.5m',
                    'lighting' => 'LED Ultra Premium',
                    'parking' => 'Tersedia (Valet)',
                    'floor_type' => 'PVC Import',
                    'facilities' => 'AC Premium, WiFi, Ruang VIP Mewah, Restaurant, Spa, Gym',
                    'image_url' => 'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Champion+Club'
                ]
            ];
            
            $stmt = $pdo->prepare("INSERT INTO tb_court (name, location, price_weekday, price_weekend, status, description, size, lighting, parking, floor_type, facilities, image_url) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            foreach ($sample_data as $data) {
                $stmt->execute([
                    $data['name'],
                    $data['location'],
                    $data['price_weekday'],
                    $data['price_weekend'],
                    $data['status'],
                    $data['description'],
                    $data['size'],
                    $data['lighting'],
                    $data['parking'],
                    $data['floor_type'],
                    $data['facilities'],
                    $data['image_url']
                ]);
            }
            
            $pdo->commit();
            echo "<div class='success'>✓ Sample data berhasil diinsert! (" . count($sample_data) . " lapangan)</div>";
            echo "<p><a href='" . $_SERVER['PHP_SELF'] . "'>Refresh halaman</a> untuk melihat data terbaru</p>";
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "<div class='error'>✗ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
    
    // Tampilkan form jika belum ada data
    if ($count == 0) {
        echo "<form method='POST'>";
        echo "<button type='submit' name='insert_sample' value='1'>📥 Insert 5 Sample Lapangan</button>";
        echo "</form>";
    }
    
    // Tombol aksi tambahan
    echo "<h2>Aksi Tambahan:</h2>";
    
    if (isset($_POST['delete_all'])) {
        try {
            $pdo->exec("DELETE FROM tb_court");
            echo "<div class='success'>✓ Semua data lapangan berhasil dihapus!</div>";
            echo "<p><a href='" . $_SERVER['PHP_SELF'] . "'>Refresh halaman</a></p>";
        } catch (PDOException $e) {
            echo "<div class='error'>✗ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
    
    if ($count > 0) {
        echo "<form method='POST' style='display:inline;' onsubmit=\"return confirm('Yakin ingin menghapus semua data lapangan?');\">";
        echo "<button type='submit' name='delete_all' value='1' style='background:#dc2626;'>🗑️ Hapus Semua Data</button>";
        echo "</form>";
    }
    
    echo "<p style='margin-top:20px;color:#666;font-size:12px;'>";
    echo "Konfigurasi Database:<br>";
    echo "Host: localhost<br>";
    echo "Database: db_booking_lapangan_badminton<br>";
    echo "User: root<br>";
    echo "Password: (kosong)<br>";
    echo "</p>";
    
} catch (PDOException $e) {
    echo "<div class='error'>✗ Database Connection Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p>Pastikan:</p>";
    echo "<ul>";
    echo "<li>MySQL server sudah running (XAMPP MySQL aktif)</li>";
    echo "<li>Database 'db_booking_lapangan_badminton' sudah dibuat</li>";
    echo "<li>Config database.php sudah benar</li>";
    echo "</ul>";
}

echo "</div></body></html>";
?>
