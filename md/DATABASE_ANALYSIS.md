# Analisis Database Structure - Lapangan Badminton vs Futsal

## 📊 Perbandingan Struktur Database

### Project Futsal (Reference)
Futsal project memiliki struktur yang lebih komprehensif dengan field-field detail:

```sql
CREATE TABLE tb_lapangan (
    id, nama, harga (weekday), harga_weekend, status,
    gambar, deskripsi, deskripsi_lengkap, fasilitas,
    lokasi, ukuran, pencahayaan, parkir, tipe_lantai
);

CREATE TABLE tb_lapangan_gallery (
    id, lapangan_id, foto, urutan, dibuat_pada
);
```

**Fitur Utama Futsal:**
- ✅ Harga berbeda untuk Weekday & Weekend
- ✅ Fasilitas dalam format text (comma-separated)
- ✅ Spesifikasi lengkap (ukuran, pencahayaan, parkir, tipe lantai)
- ✅ Gallery images terpisah
- ✅ Status management (tersedia, maintenance)
- ✅ Deskripsi lengkap & deskripsi singkat

---

## 🎾 Struktur Badminton (Updated)

### Sebelum Update
```sql
tb_court (
    id, name, description, price_per_hour, image_url, created_at
)
```
**Keterbatasan:** Hanya field dasar, tidak ada spesifikasi detail

### Sesudah Update
```sql
tb_court (
    id, name, location, price_weekday, price_weekend,
    status, description, size, lighting, parking,
    floor_type, facilities, image_url,
    created_at, updated_at
)

tb_court_gallery (
    id, court_id, image_url, image_order, created_at
)
```

---

## 📋 Kolom Detail Lapangan Badminton

| Kolom | Tipe | Deskripsi | Contoh |
|-------|------|-----------|---------|
| `name` | VARCHAR(100) | Nama lapangan | Lapangan 1, Lapangan Premium |
| `location` | VARCHAR(150) | Lokasi fisik | Jakarta Pusat, Bandung |
| `price_weekday` | INT | Harga Senin-Jumat | 50000, 75000 |
| `price_weekend` | INT | Harga Sabtu-Minggu | 75000, 100000 |
| `status` | ENUM | Status lapangan | tersedia, maintenance, booking |
| `description` | TEXT | Deskripsi singkat | Lapangan dengan pencahayaan standar |
| `size` | VARCHAR(50) | Ukuran lapangan | 17m x 8.5m (standar badminton) |
| `lighting` | VARCHAR(100) | Jenis pencahayaan | LED Standard, LED Premium, Halogen |
| `parking` | VARCHAR(100) | Info parkir | Tersedia (50 spot), Gratis, Berbayar |
| `floor_type` | VARCHAR(100) | Jenis lantai | Vinyl/PVC, Maple, Rubber, Kayu |
| `facilities` | TEXT | Fasilitas tersedia | AC, Toilet, Kamar Ganti, WiFi, Kantin |
| `image_url` | VARCHAR(255) | Gambar utama | https://... |

---

## 📸 Gallery Images Structure

### Table: tb_court_gallery
```sql
CREATE TABLE tb_court_gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    court_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    image_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (court_id) REFERENCES tb_court(id) ON DELETE CASCADE
)
```

**Fungsi:**
- Menyimpan multiple images per lapangan
- Urutan images dapat diatur (image_order)
- Otomatis terhapus ketika lapangan dihapus (CASCADE)

---

## 🔄 Migration Plan

### Step 1: Backup Existing Data
```sql
-- Backup data lama
CREATE TABLE tb_court_backup AS SELECT * FROM tb_court;
```

### Step 2: Run Migration Script
File: `migrate.sql` - Menambahkan kolom baru tanpa menghapus data lama

### Step 3: Verify Data
```sql
SELECT COUNT(*) FROM tb_court;
SELECT * FROM tb_court LIMIT 1;
```

---

## ✨ Fitur yang Ditambahkan

### 1. **Harga Dinamis (Weekday/Weekend)**
- Admin dapat set harga berbeda untuk hari kerja & libur
- Sistem booking bisa auto-calculate harga berdasarkan hari
- Meningkatkan revenue pada peak hours

### 2. **Spesifikasi Detail Lapangan**
- Ukuran lapangan (standar badminton: 17m x 8.5m)
- Jenis pencahayaan (penting untuk indoor badminton)
- Fasilitas (toilet, AC, kamar ganti, dll)
- Tipe lantai (Vinyl/PVC, Maple, Rubber)
- Lokasi detail

### 3. **Gallery Images**
- Multiple images per lapangan
- Display di halaman detail lapangan
- Admin dapat upload multiple gambar
- Ordering untuk showcase terbaik

### 4. **Status Management**
- `tersedia`: Lapangan aktif dan bisa booking
- `maintenance`: Sedang diperbaiki
- `booking`: Sudah ada booking aktif

---

## 🚀 Rekomendasi Implementasi Berikutnya

### Phase 1 (Current)
✅ Database schema update
✅ Admin form untuk edit data lapangan

### Phase 2 (TODO)
- [ ] Upload gambar (file upload bukan URL)
- [ ] Gallery management page
- [ ] Auto-calculate harga berdasarkan weekday/weekend
- [ ] Display spesifikasi di halaman public

### Phase 3 (Future)
- [ ] Harga dinamis per jam (peak pricing)
- [ ] Seasonal pricing
- [ ] Promo/diskon management
- [ ] Equipment rental pricing
- [ ] Cancellation policy management

---

## 📝 Sample Data Structure

```php
$lapangan = [
    'name' => 'Lapangan A',
    'location' => 'Jakarta Pusat',
    'price_weekday' => 50000,
    'price_weekend' => 75000,
    'status' => 'tersedia',
    'description' => 'Lapangan badminton indoor dengan AC penuh',
    'size' => '17m x 8.5m',
    'lighting' => 'LED Premium',
    'parking' => 'Tersedia (50 spot)',
    'floor_type' => 'Vinyl/PVC',
    'facilities' => 'AC, Toilet, Kamar Ganti, Penyewaan Raket, WiFi, Kantin',
    'image_url' => 'https://...'
];
```

---

## 🔗 Relasi Database

```
tb_court
├── 1 : N tb_booking
├── 1 : N tb_court_gallery
└── metadata (deskripsi, fasilitas, dll)

tb_court_gallery
├── N : 1 tb_court
└── Menyimpan multiple images per court
```

---

## ⚠️ Important Notes

1. **Backward Compatibility**: Migration script preserves existing data
2. **Default Values**: Semua kolom baru memiliki default value
3. **Nullable Fields**: Beberapa field optional untuk fleksibilitas
4. **Data Validation**: Admin form validates all inputs
5. **Timezone**: Gunakan WIB (UTC+7) untuk konsistensi

---

**Last Updated:** Juni 4, 2026
**Status:** ✅ Implemented
**Version:** 2.0
