# 🎾 Website Booking Lapangan Badminton

Platform web untuk manajemen dan booking lapangan badminton dengan admin panel profesional.

## 📋 Table of Contents

- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [Instalasi](#instalasi)
- [Database Setup](#database-setup)
- [Struktur Project](#struktur-project)
- [Admin Panel](#admin-panel)
- [API Endpoints](#api-endpoints)
- [Dokumentasi](#dokumentasi)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)

---

## ✨ Fitur

### User Features (Coming Soon)
- 🔐 Registrasi & Login
- 🎾 Browse lapangan badminton
- 📅 View ketersediaan lapangan
- 💳 Booking & payment
- 📱 Responsive mobile-friendly

### Admin Features
- ✅ Admin authentication (login/register)
- 🏸 CRUD Data Lapangan (Tambah, Edit, Hapus)
- 📊 Dashboard dengan statistik real-time
- 📅 Manage Booking (konfirmasi, ubah status)
- ⚙️ Website Settings & CMS
- 🎨 Professional UI dengan Tailwind CSS

---

## 🛠 Tech Stack

### Backend
- **PHP** 7.4+ (Object-Oriented)
- **MySQL** 5.7+ / MariaDB
- **PDO** (Database abstraction)

### Frontend
- **HTML5** + **CSS3**
- **Tailwind CSS** 3+ (Styling)
- **JavaScript** (Vanilla/ES6)
- **FontAwesome** 6+ (Icons)

### Tools & Libraries
- **Git** (Version Control)
- **Composer** (PHP Package Manager - optional)

---

## 🚀 Instalasi

### Prerequisites
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau MariaDB 10.3+
- XAMPP / WAMP / Laragon (atau server lokal lainnya)
- Git

### Step 1: Clone Repository

```bash
cd C:\xampp\htdocs
git clone https://github.com/muhfahmm/website-booking-lapangan-badminton.git
cd website-booking-lapangan-badminton
```

### Step 2: Setup Database

#### Opsi A: Fresh Installation
```bash
# Create fresh database
mysql -u root -p < md/db_schema.sql
```

#### Opsi B: Upgrade dari v1.0
```bash
# Backup existing database (IMPORTANT!)
mysqldump -u root -p db_booking_lapangan_badminton > backup.sql

# Run migration
mysql -u root -p db_booking_lapangan_badminton < md/migrate.sql
```

### Step 3: Konfigurasi Database

Edit file `config/database.php`:

```php
$host = 'localhost';
$db = 'db_booking_lapangan_badminton';
$user = 'root';
$password = ''; // Set password jika ada
```

### Step 4: Access Admin Panel

```
URL: http://localhost/website-booking-lapangan-badminton/admin/register.php
```

1. **Register** akun admin pertama
2. **Login** dengan credentials
3. **Dashboard** siap digunakan!

---

## 💾 Database Setup

### File SQL

| File | Fungsi | Kapan Digunakan |
|------|--------|-----------------|
| `db_schema.sql` | Create fresh database | Instalasi baru |
| `migrate.sql` | Upgrade existing DB | Update dari v1.0 |
| `reset.sql` | Clean database | Development/testing |

Untuk detail lengkap, baca: **`md/SQL_FILES_GUIDE.md`**

### Database Structure

```
db_booking_lapangan_badminton/
├── tb_admin (Admin users)
├── tb_user (Customer users - future)
├── tb_court (Lapangan badminton)
├── tb_court_gallery (Images per court)
├── tb_booking (Reservations)
├── tb_content (CMS pages)
└── tb_setting (Site settings)
```

---

## 📁 Struktur Project

```
website-booking-lapangan-badminton/
│
├── config/
│   └── database.php              # Database configuration
│
├── assets/
│   ├── css/
│   │   └── style.css             # Tailwind CSS
│   ├── js/
│   │   └── main.js               # Custom JavaScript
│   └── uploads/                  # User uploads directory
│
├── admin/
│   ├── login.php                 # Admin login page
│   ├── register.php              # Admin registration
│   ├── logout.php                # Logout handler
│   ├── dashboard.php             # Dashboard dengan stats
│   ├── lapangan.php              # CRUD lapangan
│   ├── booking-manage.php        # Manage bookings
│   ├── website-setting.php       # Settings & CMS
│   └── templates/
│       ├── header.php            # Sidebar & navbar
│       └── footer.php            # Footer layout
│
├── auth/                         # User auth (future)
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── md/
│   ├── db_schema.sql             # Database schema
│   ├── migrate.sql               # Migration script
│   ├── reset.sql                 # Database cleanup
│   ├── DATABASE_ANALYSIS.md      # DB comparison
│   ├── IMPLEMENTATION_GUIDE.md   # Technical guide
│   ├── UPDATE_SUMMARY.md         # v2.0 updates
│   └── SQL_FILES_GUIDE.md        # SQL files guide
│
├── templates/                    # Public site templates
│   ├── header.php
│   └── footer.php
│
├── index.php                     # Landing page (future)
├── booking.php                   # Booking page (future)
├── riwayat.php                   # History page (future)
├── README.md                     # This file
└── UPDATE_SUMMARY.md             # Version updates

```

---

## 👨‍💼 Admin Panel

### Login & Register
- **URL:** `http://localhost/.../admin/login.php`
- **Register:** `http://localhost/.../admin/register.php`
- **Email:** Menggunakan akun GitHub (fahimfahim0407@gmail.com)

### Dashboard Features
- 📊 Statistics (Bookings hari ini, pending, users, courts)
- 📅 Recent bookings table
- ⚡ Quick access ke menu utama

### Menu Utama

#### 1. Data Lapangan
```
Fitur:
- ✅ View semua lapangan (card grid)
- ✅ Tambah lapangan baru
- ✅ Edit data lapangan
- ✅ Hapus lapangan dengan konfirmasi

Fields:
- Nama Lapangan
- Lokasi
- Harga Weekday & Weekend
- Status (tersedia, maintenance, booking)
- Deskripsi
- Ukuran, Pencahayaan, Parkir, Tipe Lantai
- Fasilitas (CSV format)
- Gambar utama
```

#### 2. Manage Booking
```
Fitur:
- ✅ Filter by status (pending, confirmed, cancelled)
- ✅ View booking details
- ✅ Confirm payment
- ✅ Cancel booking
- ✅ Track status changes

Kolom:
- User info (nama, email, phone)
- Court name
- Booking time & duration
- Price
- Status badge
- Action buttons
```

#### 3. Website Settings
```
Tab 1: Pengaturan Umum
- Site name
- Email
- Phone
- Address

Tab 2: Manajemen Konten
- Create/edit pages
- Store pages by slug
- View all pages
```

---

## 🎨 Design & Theme

### Color Palette
- **Primary:** Emerald Green (#059669) - Main actions
- **Secondary:** Yellow (#FACC15) - Accent/CTA
- **Dark:** Charcoal (#0F172A) - Sidebar
- **Light:** Off-White (#F8FAFC) - Backgrounds

### Components
- Modern cards dengan shadow & hover effects
- Responsive grid layouts
- Tailwind CSS utilities
- FontAwesome icons

---

## 📚 Dokumentasi

Dokumentasi lengkap tersedia di folder `md/`:

### 1. **SQL_FILES_GUIDE.md** ⭐
Panduan lengkap tentang penggunaan SQL files:
- File comparison & purposes
- Workflow scenarios
- Verification commands
- Backup best practices
- Troubleshooting

### 2. **DATABASE_ANALYSIS.md**
Analisis detail database:
- Perbandingan Badminton vs Futsal
- Schema details
- Field specifications
- Migration plan
- Sample data

### 3. **IMPLEMENTATION_GUIDE.md**
Technical implementation guide:
- Installation steps
- Database migration
- Form validation
- Security considerations
- Performance tips

### 4. **UPDATE_SUMMARY.md**
Quick reference untuk v2.0:
- Apa yang berubah
- Field baru
- Form updates
- Use cases
- Roadmap

### 5. **design.md**
UI/UX design specifications:
- Color palette
- Typography
- Component design
- Admin panel layout

---

## 🔌 API Endpoints (Future)

```
// Admin Auth
POST   /admin/login.php
POST   /admin/register.php
GET    /admin/logout.php

// Lapangan Management
GET    /admin/lapangan.php              # List all
GET    /admin/lapangan.php?action=add   # Add form
POST   /admin/lapangan.php              # Create/Update
GET    /admin/lapangan.php?action=edit&id=X  # Edit form
GET    /admin/lapangan.php?action=delete&id=X # Delete

// Booking Management
GET    /admin/booking-manage.php        # List
GET    /admin/booking-manage.php?status=pending
POST   /admin/booking-manage.php?action=update_status # Update status

// Settings
GET    /admin/website-setting.php?tab=general   # General
GET    /admin/website-setting.php?tab=content   # Content
POST   /admin/website-setting.php               # Save
```

---

## 🧪 Testing

### Database Testing
```bash
# Verify installation
mysql -u root -p
> USE db_booking_lapangan_badminton;
> SHOW TABLES;
> DESCRIBE tb_court;
```

### Admin Panel Testing
- [ ] Register admin account
- [ ] Login dengan credentials
- [ ] Tambah lapangan baru
- [ ] Edit lapangan existing
- [ ] Hapus lapangan
- [ ] Check dashboard stats
- [ ] View bookings
- [ ] Update website settings

### Browser Testing
- [ ] Chrome/Edge
- [ ] Firefox
- [ ] Safari
- [ ] Mobile responsive

---

## ⚙️ Konfigurasi

### Database Config (`config/database.php`)
```php
$host = 'localhost';      // Server hostname
$db = 'db_booking_lapangan_badminton';
$user = 'root';           // MySQL user
$password = '';           // MySQL password
```

### Environment Variables (Optional - Future)
```php
// .env file (future implementation)
DB_HOST=localhost
DB_NAME=db_booking_lapangan_badminton
DB_USER=root
DB_PASS=password
```

---

## 🔐 Security

### Current Implementation
- ✅ Password hashing dengan `password_hash()` & `PASSWORD_DEFAULT`
- ✅ Prepared statements untuk prevent SQL injection
- ✅ Session-based authentication
- ✅ Input validation & sanitization

### Best Practices
- 🔒 Never hardcode credentials
- 🔒 Use environment variables (future)
- 🔒 Regular backups
- 🔒 HTTPS for production
- 🔒 Rate limiting (future)

---

## 🐛 Troubleshooting

### Database Issues

**Error: Connection refused**
```
Solution: Check MySQL running
- XAMPP: Start MySQL dari control panel
- Verify host/user/password di config/database.php
```

**Error: Database doesn't exist**
```
Solution: Run db_schema.sql
mysql -u root -p < md/db_schema.sql
```

**Error: Duplicate column in migration**
```
Solution: Kolom sudah ada, aman diabaikan
- Lanjut jalankan migrate script
- Check DESCRIBE tb_court untuk verify
```

### Admin Panel Issues

**Error: Login gagal**
```
Solution: Check credentials
- Username case-sensitive
- Password hashing: verify_password bukan ==
- Check tb_admin table
```

**Error: Form tidak submit**
```
Solution: Check validation
- Required fields: name, price_weekday, price_weekend
- Check browser console untuk JS errors
- Verify database connection
```

**Error: 404 tidak ada file**
```
Solution: Check file paths
- URL harus http://localhost/website-booking-lapangan-badminton/...
- Check folder structure
- Verify file permissions
```

---

## 📊 Project Status

### ✅ Completed (v2.0)
- [x] Admin authentication system
- [x] Database with 14 detailed fields
- [x] CRUD Data Lapangan
- [x] Dashboard dengan statistics
- [x] Manage Booking page
- [x] Website Settings / CMS
- [x] Professional UI/UX
- [x] Comprehensive documentation
- [x] Gallery table setup

### 🚀 In Progress
- [ ] User authentication
- [ ] Public booking page
- [ ] Payment integration
- [ ] Gallery image upload

### 📋 TODO (Future)
- [ ] Email notifications
- [ ] SMS notifications
- [ ] Invoice system
- [ ] Analytics dashboard
- [ ] Report generation
- [ ] API documentation
- [ ] Mobile app

---

## 📈 Version History

### v2.0 (June 4, 2026)
- ✨ Database schema enhancement
- ✨ Extended court data fields (14 fields)
- ✨ Dynamic pricing (weekday/weekend)
- ✨ Status management
- ✨ Facilities & specifications
- ✨ Gallery table structure
- 📚 Comprehensive documentation

### v1.0 (June 3, 2026)
- 🎉 Initial release
- ✅ Admin authentication
- ✅ Basic CRUD operations
- ✅ Dashboard

---

## 🤝 Contributing

Kontribusi welcome! Silakan:
1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

---

## 📄 License

Project ini open source. Silakan gunakan untuk keperluan komersial maupun non-komersial.

---

## 👤 Author

**Muhfahmm**
- GitHub: [@muhfahmm](https://github.com/muhfahmm)
- Email: fahimfahim0407@gmail.com
- Projects: https://github.com/muhfahmm

---

## 📞 Support & Questions

Untuk pertanyaan atau issues:
1. Check dokumentasi di folder `md/`
2. Review troubleshooting section
3. Check existing issues di GitHub
4. Create new issue dengan detail

---

## 🔗 Links

- 📖 **Dokumentasi Lengkap:** `md/`
- 📊 **Database Guide:** `md/SQL_FILES_GUIDE.md`
- 🎨 **Design Specs:** `md/design.md`
- 🔄 **Update Notes:** `UPDATE_SUMMARY.md`

---

**Last Updated:** June 4, 2026  
**Current Version:** 2.0  
**Status:** ✅ Production Ready

🎾 **Selamat menggunakan Website Booking Lapangan Badminton!**