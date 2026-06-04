-- Insert Sample Data untuk Testing
-- Run this script di phpMyAdmin atau MySQL console

USE db_booking_lapangan_badminton;

-- Insert sample data ke tb_court
INSERT INTO tb_court (name, location, price_weekday, price_weekend, status, description, size, lighting, parking, floor_type, facilities, image_url) 
VALUES 
(
    'Lapangan Premium Sentosa',
    'Jl. Ahmad Yani No. 123, Jakarta Pusat',
    150000,
    200000,
    'tersedia',
    'Lapangan badminton premium dengan fasilitas lengkap dan nyaman',
    '17m x 8.5m',
    'LED Premium',
    'Tersedia',
    'Vinyl Profesional',
    'AC, WiFi, Ruang istirahat, Kantin',
    'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Premium+Sentosa'
),
(
    'Lapangan Sports Center',
    'Jl. Sudirman No. 45, Jakarta Selatan',
    120000,
    180000,
    'tersedia',
    'Lapangan badminton standar dengan pencahayaan baik',
    '17m x 8.5m',
    'LED Standar',
    'Tersedia',
    'Vinyl',
    'WiFi, Ruang istirahat, Parkir gratis',
    'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Sports+Center'
),
(
    'Lapangan Elite Badminton',
    'Jl. Gatot Subroto No. 89, Jakarta Timur',
    180000,
    230000,
    'tersedia',
    'Lapangan badminton elite dengan standar internasional',
    '17m x 8.5m',
    'LED Premium Internasional',
    'Tersedia (Luas)',
    'PVC Profesional',
    'AC Premium, WiFi, Ruang VIP, Kafetaria, Loker',
    'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Elite+Badminton'
),
(
    'Lapangan Rakyat Jakarta',
    'Jl. Merdeka No. 1, Jakarta Barat',
    80000,
    120000,
    'tersedia',
    'Lapangan badminton terjangkau untuk pemula',
    '17m x 8.5m',
    'Neon Standar',
    'Terbatas',
    'Lantai Semen',
    'Parkir, Ruang istirahat sederhana',
    'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Rakyat+Jakarta'
),
(
    'Lapangan Champion Club',
    'Jl. Bunderan HI No. 10, Jakarta Pusat',
    200000,
    280000,
    'tersedia',
    'Lapangan badminton kelas dunia dengan fasilitas premium',
    '17m x 8.5m',
    'LED Ultra Premium',
    'Tersedia (Valet)',
    'PVC Import',
    'AC Premium, WiFi, Ruang VIP Mewah, Restaurant, Spa, Gym',
    'https://via.placeholder.com/400x250/059669/FACC15?text=Lapangan+Champion+Club'
);

-- Verifikasi data yang sudah diinsert
SELECT COUNT(*) as total_lapangan FROM tb_court;
SELECT id, name, location, price_weekday, price_weekend, status FROM tb_court WHERE status = 'tersedia';
