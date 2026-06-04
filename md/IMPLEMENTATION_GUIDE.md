# Implementation Guide - Database & Form Update

## 📚 Ringkasan Perubahan

Project badminton telah diupgrade dengan struktur database yang lebih komprehensif, berdasarkan analisis dari project futsal. Berikut panduan implementasi lengkap.

---

## 🔧 Installation Steps

### 1. Database Migration

#### Opsi A: Fresh Database (Rekomendasi untuk Development)
```bash
# Drop existing database
mysql -u root -p -e "DROP DATABASE IF EXISTS db_booking_lapangan_badminton;"

# Create fresh database
mysql -u root -p < md/db_schema.sql
```

#### Opsi B: Upgrade Existing Database
```bash
# Run migration script untuk preserve existing data
mysql -u root -p db_booking_lapangan_badminton < md/migrate.sql
```

**Note:** Jika error "duplicate column", kolom sudah ada dan bisa diabaikan.

---

## 📋 Database Schema Details

### Updated tb_court Table

```sql
CREATE TABLE tb_court (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(150) DEFAULT 'Jakarta',
    price_weekday INT DEFAULT 0,
    price_weekend INT DEFAULT 0,
    status ENUM('tersedia', 'maintenance', 'booking') DEFAULT 'tersedia',
    description TEXT,
    size VARCHAR(50) DEFAULT '17m x 8.5m',
    lighting VARCHAR(100) DEFAULT 'LED Standard',
    parking VARCHAR(100) DEFAULT 'Tersedia',
    floor_type VARCHAR(100) DEFAULT 'Vinyl/PVC',
    facilities TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### New tb_court_gallery Table

```sql
CREATE TABLE tb_court_gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    court_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    image_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (court_id) REFERENCES tb_court(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 👨‍💻 Admin Form Fields

### Form Tambah/Edit Lapangan

| Field | Type | Required | Validasi | Contoh |
|-------|------|----------|----------|---------|
| Nama Lapangan | Text | ✅ Yes | Min 1 char | Lapangan A |
| Lokasi | Text | ❌ No | - | Jakarta Pusat |
| Harga Weekday | Number | ✅ Yes | Min 0 | 50000 |
| Harga Weekend | Number | ✅ Yes | Min 0 | 75000 |
| Status | Select | ✅ Yes | enum | tersedia, maintenance, booking |
| Deskripsi | Textarea | ❌ No | - | Lapangan dengan AC |
| Ukuran | Text | ❌ No | - | 17m x 8.5m |
| Pencahayaan | Text | ❌ No | - | LED Premium |
| Parkir | Text | ❌ No | - | Tersedia (50 spot) |
| Tipe Lantai | Text | ❌ No | - | Vinyl/PVC |
| Fasilitas | Textarea | ❌ No | CSV | AC, Toilet, Kamar Ganti |
| Gambar Utama | URL | ❌ No | Valid URL | https://... |

---

## 🎨 Form UI/UX Improvements

### Layout Changes
- **Before:** Basic 3-field form (name, description, price)
- **After:** Organized multi-section form dengan 12 fields

### Sections:
1. **Basic Info** (Name, Location)
2. **Pricing** (Weekday & Weekend - 2 columns)
3. **Status** (Dropdown selector)
4. **Description** (Main description)
5. **Specifications** (Size, Lighting, Parking, Floor - 2x2 grid)
6. **Facilities** (CSV format with helper text)
7. **Media** (Main image URL + gallery note)

### Input Enhancements:
- ✅ Number inputs dengan min/max/step
- ✅ Status dropdown dengan opsi enum
- ✅ Textarea dengan placeholder
- ✅ URL input validation
- ✅ Helper text untuk CSV format

---

## 📱 Display/Card Updates

### Court Card Komponen

Sebelum:
```
[Card]
├── Image
├── Name
├── Description
└── Price (single)
    └── Action buttons
```

Sesudah:
```
[Card]
├── Image
├── Name
├── Description
├── Price Info (2 prices)
│   ├── Weekday
│   └── Weekend
├── Spec Info (3 icons)
│   ├── Size
│   ├── Lighting
│   └── Parking
└── Action buttons
```

---

## 🔄 Data Migration Examples

### Example 1: Existing Court
```sql
-- Before
INSERT INTO tb_court (name, description, price_per_hour, image_url)
VALUES ('Lapangan A', 'Lapangan bagus', 50000, 'http://...');

-- After (Auto-migrate)
UPDATE tb_court SET 
    price_weekday = 50000,
    price_weekend = 50000 * 1.5,  -- 75000
    location = 'Jakarta',
    status = 'tersedia'
WHERE name = 'Lapangan A';
```

### Example 2: Insert New Court (New Format)
```sql
INSERT INTO tb_court (
    name, location, price_weekday, price_weekend,
    status, description, size, lighting, parking,
    floor_type, facilities, image_url
) VALUES (
    'Lapangan Premium',
    'Jakarta Selatan',
    60000,
    90000,
    'tersedia',
    'Lapangan indoor premium dengan semua fasilitas',
    '17m x 8.5m',
    'LED Premium',
    'Tersedia (30 spot)',
    'Maple Wood',
    'AC, Toilet, Kamar Ganti, WiFi, Penyewaan Raket',
    'https://example.com/lapangan-premium.jpg'
);
```

---

## 🎬 Testing Checklist

### Database Tests
- [ ] Migration script berjalan tanpa error
- [ ] Kolom baru terisi dengan default value
- [ ] Existing data tetap intact
- [ ] Foreign key constraints bekerja

### Form Tests
- [ ] Semua field muncul dengan benar
- [ ] Validasi required fields bekerja
- [ ] Number inputs hanya menerima angka
- [ ] Textarea accept multiple lines
- [ ] URL input validate format
- [ ] Submit berhasil insert ke database

### Display Tests
- [ ] Card menampilkan 2 harga
- [ ] Spec info icons muncul
- [ ] Edit form pre-fill data dengan benar
- [ ] Delete functionality tetap bekerja

### Integration Tests
- [ ] Booking system bisa baca price_weekday & price_weekend
- [ ] Status filter works pada manage booking
- [ ] Gallery images (future) siap untuk expansion

---

## 🚀 Performance Considerations

### Query Optimization
```php
// Optimized query untuk list lapangan
SELECT id, name, location, price_weekday, price_weekend, 
       status, description, size, lighting, parking, 
       floor_type, facilities, image_url, created_at 
FROM tb_court 
ORDER BY created_at DESC;

// Index recommendations
CREATE INDEX idx_status ON tb_court(status);
CREATE INDEX idx_created_at ON tb_court(created_at);
```

### Storage
- Text fields (description, facilities): ~500 bytes average
- VARCHAR fields: ~200 bytes
- Per court: ~1KB average
- Gallery images reference only URLs (~255 bytes each)

---

## 🔐 Security Considerations

### Input Validation
```php
// All inputs are validated:
- name: trim, htmlspecialchars
- price: intval, min 0
- status: enum validation
- image_url: filter_var(FILTER_VALIDATE_URL)
- facilities: trim, sanitize
```

### Database Security
- ✅ Prepared statements untuk prevent SQL injection
- ✅ Foreign key constraints untuk data integrity
- ✅ ON DELETE CASCADE untuk automatic cleanup

---

## 📊 Comparison: Badminton vs Futsal

| Feature | Futsal | Badminton | Notes |
|---------|--------|-----------|-------|
| Multiple Pricing | ✅ Yes | ✅ Yes | Dynamic weekday/weekend |
| Facilities | ✅ Yes | ✅ Yes | Text-based, CSV format |
| Spesifikasi Detail | ✅ Yes | ✅ Yes | Size, Lighting, Parking, Floor |
| Gallery Images | ✅ Yes | ✅ Yes | Separate table setup ready |
| Payment System | ✅ Yes (Midtrans) | ❌ (TODO) | Future integration |
| Booking Flow | ✅ Advanced | ❌ Basic | Can be enhanced |
| Status Management | ✅ Yes | ✅ Yes | tersedia, maintenance, booking |

---

## 📝 Next Steps

### Phase 2 (Recommended)
1. [ ] Implement image upload functionality
2. [ ] Gallery management interface
3. [ ] Update booking to use weekday/weekend pricing
4. [ ] Display specs on public booking page
5. [ ] Add price calculation logic

### Phase 3 (Advanced)
1. [ ] Dynamic pricing per hour
2. [ ] Seasonal pricing
3. [ ] Promo code system
4. [ ] Equipment rental pricing
5. [ ] Advanced analytics

---

**Version:** 2.0
**Last Updated:** Juni 4, 2026
**Status:** ✅ Ready for Testing
**Tested On:** PHP 7.4+, MySQL 5.7+
