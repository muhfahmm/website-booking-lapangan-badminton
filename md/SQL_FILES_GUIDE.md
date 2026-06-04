# 📂 SQL Files Guide

Panduan lengkap untuk menggunakan file-file SQL di project ini dengan benar.

---

## 📋 File Overview

| File | Purpose | Type | Use Case |
|------|---------|------|----------|
| `db_schema.sql` | **Complete database schema + migration reference** | Full setup | Fresh installation & upgrade guide |
| `reset.sql` | **Database cleanup** | Destructive | Development/testing |

---

## 🎯 Detailed File Descriptions

### 1️⃣ **db_schema.sql** - Fresh Database Setup + Migration Reference

**Fungsi:** Membuat database dan semua tabel dari awal, plus berisi migration commands untuk upgrade

**Konten:**
```sql
CREATE DATABASE IF NOT EXISTS db_booking_lapangan_badminton;
USE db_booking_lapangan_badminton;

CREATE TABLE tb_admin (...)
CREATE TABLE tb_user (...)
CREATE TABLE tb_court (...)
CREATE TABLE tb_booking (...)
CREATE TABLE tb_court_gallery (...)
CREATE TABLE tb_content (...)
CREATE TABLE tb_setting (...)

-- End of schema

-- MIGRATION REFERENCE (Commented out for safety)
-- ALTER TABLE tb_court ADD COLUMN location ...
-- ALTER TABLE tb_court ADD COLUMN price_weekday ...
-- ... (etc)
```

**Kapan Digunakan:**
- ✅ Setup pertama kali (fresh installation)
- ✅ Development environment baru
- ✅ Staging/production initial setup
- ✅ Reference untuk migration commands

**Cara Menggunakan:**
```bash
# Fresh database setup
mysql -u root -p < md/db_schema.sql

# Atau dari MySQL CLI
mysql> SOURCE /path/to/db_schema.sql;
```

**Hasil:**
- Database baru dibuat
- Semua table dibuat dengan struktur terbaru (v2.0)
- Ready untuk langsung digunakan

**Important:**
- Existing database TIDAK akan di-drop
- Jika database sudah ada, tabel tidak akan dibuat ulang
- Safe untuk dijalankan berkali-kali
- Migration commands di akhir file hanya untuk reference (commented out)

---

### 2️⃣ **reset.sql** - Database Cleanup

**Fungsi:** Membersihkan database (untuk development)

**Konten:**
```sql
DROP DATABASE IF EXISTS db_booking_lapangan_badminton;
-- atau
DROP TABLE IF EXISTS tb_court;
DROP TABLE IF EXISTS tb_booking;
-- dll
```

**Kapan Digunakan:**
- ✅ Development/testing environment
- ✅ Reset data untuk fresh testing
- ✅ Cleanup sebelum fresh setup
- ⚠️ JANGAN untuk production!

**Cara Menggunakan:**
```bash
# Reset database
mysql -u root -p < md/reset.sql

# Kemudian setup fresh database
mysql -u root -p < md/db_schema.sql
```

**⚠️ WARNING:**
```
Operasi ini DESTRUCTIVE!
- Menghapus seluruh database
- Semua data hilang (tidak bisa di-recover)
- JANGAN jalankan di production
```

---

## 🛣️ Workflow Scenarios

### Scenario 1: Fresh Development Setup

```bash
# 1. Create fresh database
mysql -u root -p < md/db_schema.sql

# 2. Start developing
# (Development app development)

# 3. Done! Database ready
```

---

### Scenario 2: Upgrade Existing Database

```bash
# 1. Backup existing database (IMPORTANT!)
mysqldump -u root -p db_booking_lapangan_badminton > backup.sql

# 2. Check db_schema.sql for migration commands at the end
# Open file and uncomment/copy the ALTER commands you need

# 3. Run migration commands in MySQL:
mysql -u root -p
> USE db_booking_lapangan_badminton;
> ALTER TABLE tb_court ADD COLUMN location VARCHAR(150) DEFAULT 'Jakarta' AFTER name;
> ALTER TABLE tb_court ADD COLUMN price_weekday INT DEFAULT 0 AFTER location;
> -- ... (copy remaining ALTER commands from db_schema.sql)

# 4. Verify data
mysql -u root -p
> USE db_booking_lapangan_badminton;
> SELECT COUNT(*) FROM tb_court;
> DESCRIBE tb_court;

# 5. Done! Database upgraded
```

---

### Scenario 3: Development - Reset & Fresh Start

```bash
# 1. Clean existing data
mysql -u root -p < md/reset.sql

# 2. Setup fresh database
mysql -u root -p < md/db_schema.sql

# 3. Insert sample data (optional)
# mysql -u root -p db_booking_lapangan_badminton < sample_data.sql

# 4. Start fresh development
```

---

### Scenario 4: Production - Initial Setup

```bash
# 1. Production backup (existing system)
mysqldump -u root -p production_db > production_backup.sql

# 2. Create new database
mysql -u root -p < md/db_schema.sql

# 3. Import old data (if needed)
# mysql -u root -p db_booking_lapangan_badminton < old_data.sql

# 4. Verify
mysql -u root -p
> SELECT * FROM tb_court LIMIT 1;

# 5. Deploy to production
```

---

## 🔄 Column Changes in Migration

### Columns Added (migrate.sql)

| Kolom | Default | Purpose |
|-------|---------|---------|
| `location` | 'Jakarta' | Lokasi lapangan |
| `price_weekday` | 0 | Harga weekday |
| `price_weekend` | 0 | Harga weekend |
| `status` | 'tersedia' | Status availability |
| `size` | '17m x 8.5m' | Ukuran lapangan |
| `lighting` | 'LED Standard' | Jenis pencahayaan |
| `parking` | 'Tersedia' | Info parkir |
| `floor_type` | 'Vinyl/PVC' | Jenis lantai |
| `facilities` | NULL | Fasilitas (CSV) |
| `updated_at` | CURRENT_TIMESTAMP | Update timestamp |

### Columns Dropped (migrate.sql)

| Kolom | Alasan |
|-------|--------|
| `price_per_hour` | Diganti dengan price_weekday & price_weekend |

---

## 🔍 Verification Commands

### After db_schema.sql

```sql
-- Check if database exists
SHOW DATABASES LIKE 'db_booking_lapangan_badminton';

-- Check tables
USE db_booking_lapangan_badminton;
SHOW TABLES;

-- Check tb_court structure
DESCRIBE tb_court;

-- Check gallery table
DESCRIBE tb_court_gallery;

-- Count tables
SELECT COUNT(*) FROM information_schema.tables 
WHERE table_schema = 'db_booking_lapangan_badminton';
```

### After migrate.sql

```sql
-- Check new columns exist
DESCRIBE tb_court;

-- Check old column is gone
SHOW COLUMNS FROM tb_court WHERE Field = 'price_per_hour';
-- Result: Empty (column deleted)

-- Check data integrity
SELECT COUNT(*) FROM tb_court;
-- Should show existing court count

-- Check default values
SELECT * FROM tb_court LIMIT 1;
```

---

## ⚠️ Common Issues & Solutions

### Issue 1: "Database already exists"
```
Error: Can't create database 'db_booking_lapangan_badminton'; 
       database exists
```
**Solution:** 
- Gunakan migrate.sql untuk update
- Atau drop database dulu: `DROP DATABASE db_booking_lapangan_badminton;`

### Issue 2: "Duplicate column"
```
Error: Duplicate column name 'location'
```
**Solution:**
- Kolom sudah ada, lanjut running script
- Script menggunakan `IF NOT EXISTS` jadi error bisa diabaikan

### Issue 3: "Can't DROP column"
```
Error: Can't DROP 'price_per_hour'; check that column/key exists
```
**Solution:**
- Script sudah handle dengan `IF EXISTS`
- Error ini bisa diabaikan

### Issue 4: "Foreign key constraint fails"
```
Error: Cannot add foreign key constraint
```
**Solution:**
- Ensure tb_court exists sebelum ALTER
- Check primary key exists: `ALTER TABLE tb_court ADD PRIMARY KEY(id);`

---

## 📊 File Size & Performance

| File | Size | Est. Time |
|------|------|-----------|
| `db_schema.sql` | ~5 KB | < 1 detik |
| `reset.sql` | ~1 KB | 1-2 detik |

---

## 🔐 Backup Best Practices

Sebelum running migration:

```bash
# Full database backup
mysqldump -u root -p db_booking_lapangan_badminton > backup_before_migration.sql

# Specific table backup
mysqldump -u root -p db_booking_lapangan_badminton tb_court > tb_court_backup.sql

# Verify backup
grep "INSERT INTO tb_court" tb_court_backup.sql | wc -l
```

---

## 📝 Summary

| Kebutuhan | File | Command |
|-----------|------|---------|
| Setup baru | db_schema.sql | `mysql -u root -p < db_schema.sql` |
| Upgrade existing | db_schema.sql (see end) | Copy & run ALTER commands from file |
| Dev reset | reset.sql | `mysql -u root -p < reset.sql` |

---

**Version:** 2.0
**Last Updated:** Juni 4, 2026
**Compatibility:** MySQL 5.7+, MariaDB 10.3+
