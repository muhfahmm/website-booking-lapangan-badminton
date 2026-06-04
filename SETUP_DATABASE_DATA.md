# 📊 Setup Data Lapangan dari Database

## Status Sekarang
✅ Kedua file halaman publik sudah diupdate untuk mengambil data dari database:
- `pages/page-home.php` - Section "Lapangan Populer" (3 lapangan)
- `pages/page-booking.php` - Section "Daftar Lapangan" (semua lapangan)

## Langkah-Langkah Setup

### Step 1: Pastikan Database Sudah Ada
1. Buka XAMPP dan pastikan MySQL sudah **running** (hijau)
2. Akses phpMyAdmin: http://localhost/phpmyadmin
3. Verifikasi database `db_booking_lapangan_badminton` sudah ada
4. Verifikasi tabel `tb_court` sudah ada dengan struktur lengkap

### Step 2: Insert Sample Data

**Pilih salah satu cara:**

#### Cara A: Menggunakan Test Page (PALING MUDAH ✓)
1. Akses: `http://localhost/project-client-php/website_booking_lapangan_badminton/test-db-connection.php`
2. Halaman akan menunjukkan status database connection
3. Jika belum ada data, klik tombol **"📥 Insert 5 Sample Lapangan"**
4. Sistem akan insert 5 lapangan sample otomatis
5. ✓ Selesai!

#### Cara B: Menggunakan phpMyAdmin
1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Pilih database: `db_booking_lapangan_badminton`
3. Klik tab **SQL**
4. Copy-paste isi file `md/insert_sample_data.sql`
5. Klik tombol **Go**
6. ✓ Selesai!

#### Cara C: Menggunakan MySQL Command Line
```bash
cd c:\xampp\mysql\bin
mysql -u root db_booking_lapangan_badminton < c:\path\to\insert_sample_data.sql
```

### Step 3: Verifikasi Data Berhasil Diinsert
1. Akses test page lagi: `test-db-connection.php`
2. Seharusnya ada tabel yang menampilkan data lapangan
3. Atau buka phpMyAdmin → tb_court, harusnya ada 5 records

### Step 4: Lihat Data di Halaman Publik
Sekarang data lapangan dari database sudah tampil di:
- Homepage: `http://localhost/.../` → Section "Lapangan Populer"
- Booking: `http://localhost/.../pages/page.php?page=booking`

## Data Sample yang Diinsert

| Lapangan | Harga Weekday | Harga Weekend | Lokasi |
|----------|---------------|---------------|--------|
| Lapangan Premium Sentosa | Rp 150.000 | Rp 200.000 | Jl. Ahmad Yani No. 123, Jakarta Pusat |
| Lapangan Sports Center | Rp 120.000 | Rp 180.000 | Jl. Sudirman No. 45, Jakarta Selatan |
| Lapangan Elite Badminton | Rp 180.000 | Rp 230.000 | Jl. Gatot Subroto No. 89, Jakarta Timur |
| Lapangan Rakyat Jakarta | Rp 80.000 | Rp 120.000 | Jl. Merdeka No. 1, Jakarta Barat |
| Lapangan Champion Club | Rp 200.000 | Rp 280.000 | Jl. Bunderan HI No. 10, Jakarta Pusat |

## Database Queries yang Digunakan

### Homepage (Lapangan Populer - 3 lapangan)
```php
SELECT id, name, location, price_weekday, price_weekend, 
       image_url, status FROM tb_court 
WHERE status = 'tersedia' 
LIMIT 3
```

### Booking Page (Semua Lapangan)
```php
SELECT id, name, location, price_weekday, price_weekend, 
       image_url, status, lighting, floor_type, parking, facilities 
FROM tb_court 
WHERE status = 'tersedia' 
ORDER BY created_at DESC
```

## Struktur Database

### Tabel: tb_court
```sql
id (INT) - Auto increment
name (VARCHAR) - Nama lapangan
location (VARCHAR) - Lokasi
price_weekday (INT) - Harga weekday
price_weekend (INT) - Harga weekend
status (ENUM) - tersedia/maintenance/booking
description (TEXT) - Deskripsi
size (VARCHAR) - Ukuran lapangan
lighting (VARCHAR) - Jenis pencahayaan
parking (VARCHAR) - Fasilitas parkir
floor_type (VARCHAR) - Jenis lantai
facilities (TEXT) - Fasilitas lainnya (comma-separated)
image_url (VARCHAR) - URL gambar
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

## Fallback System

Jika database kosong atau error, aplikasi akan:
1. Tampilkan pesan error yang informatif
2. Menampilkan 3 sample data hardcoded (untuk testing)
3. Tetap berfungsi tanpa crashing

## Troubleshooting

### Error: "Connection Error"
- ✓ Pastikan MySQL running
- ✓ Cek config/database.php
- ✓ Verifikasi database name, username, password

### Error: "Unknown column"
- ✓ Jalankan db migration dari md/db_schema.sql
- ✓ Pastikan semua kolom sudah ada

### Data tidak tampil
- ✓ Insert sample data menggunakan test-db-connection.php
- ✓ Verifikasi status lapangan = 'tersedia'

## Tips Admin

Untuk menambah lapangan baru:
1. Login ke admin panel
2. Buka menu "Lapangan"
3. Klik "Tambah Lapangan Baru"
4. Isi semua field
5. Klik "Simpan"
6. Otomatis tampil di halaman publik (jika status = 'tersedia')

## URL Penting

| Halaman | URL |
|---------|-----|
| Test Database | `/test-db-connection.php` |
| Insert Data Script | `/md/insert_sample_data.sql` |
| Homepage | `/` |
| Booking | `/?page=booking` |
| Admin Dashboard | `/admin/dashboard.php` |

---

**Status:** ✅ Database integration COMPLETE  
**Siap untuk:** Testing, Development, Production  
**Last Updated:** 2026-06-04

🎾 Data lapangan siap digunakan dari database!
