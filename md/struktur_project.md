jalur-project/
│
├── config/
│   └── database.php          # Koneksi PDO / MySQLi ke db_booking_lapangan_badminton
│
├── assets/
│   ├── css/
│   │   └── style.css         # Hasil compile Tailwind CSS
│   ├── js/
│   │   └── main.js           # Script custom (jika ada)
│   └── uploads/              # Folder untuk menyimpan foto lapangan & bukti transfer
│
├── admin/                    # KONTROL PENUH ADMIN PANEL
│   ├── login.php             # Login session untuk tb_admin
│   ├── logout.php
│   ├── dashboard.php         # Ringkasan total booking dan status hari ini
│   ├── lapangan.php          # CRUD Data Lapangan (tb_lapangan)
│   ├── booking-manage.php    # Konfirmasi pembayaran & update status (tb_booking)
│   ├── website-setting.php   # Manajemen konten dinamis landing page (tb_setting)
│   └── templates/
│       ├── header.php        # Sidebar & Navbar Admin Panel (Tailwind)
│       └── footer.php
│
├── auth/                     # SISTEM USER AUTH
│   ├── login.php             # Login user (tb_user)
│   ├── register.php          # Register user baru
│   └── logout.php
│
├── templates/                # KOMPONEN LANDING PAGE
│   ├── header.php            # Navbar responsif
│   └── footer.php            # Footer informasi gedung
│
├── index.php                 # LANDING PAGE (Dinamis dari db: Nama Gedung, List Lapangan)
├── booking.php               # Halaman pilih jam & tanggal main (Cek ketersediaan)
├── riwayat.php               # Halaman user untuk upload bukti transfer
├── tailwind.config.js        # Konfigurasi kustomisasi warna Emerald & Yellow
└── package.json              # Depedensi Tailwind CLI