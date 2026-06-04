# Panduan Desain Website Booking Lapangan Badminton

## 1. Palet Warna (Theme: Badminton Court & Modern Sporty)
* **Primary (Warna Utama):** Emerald Green (`#059669` / Tailwind: `emerald-600`) - Merepresentasikan warna karpet lapangan badminton modern.
* **Secondary/Accent (Aksen):** Shuttlecock Yellow (`#FACC15` / Tailwind: `yellow-440`) - Memberikan kesan dinamis, energik, dan kontras yang pas untuk tombol CTA (Booking).
* **Dark Neutral (Teks & Dark Mode):** Charcoal (`#0F172A` / Tailwind: `slate-900`) - Untuk background elegan atau teks utama.
* **Light Neutral (Background):** Off-White (`#F8FAFC` / Tailwind: `slate-50`) - Bersih, modern, dan tidak melelahkan mata.

## 2. Tipografi
* **Font Heading:** Inter / Montserrat (Bold, Sporty, Clean)
* **Font Body:** Inter / Roboto (Sangat terbaca di perangkat mobile)

## 3. Komponen Desain Modern (Tailwind)
* **Hero Section:** Background gelap (`bg-slate-900`) dipadukan dengan teks putih, tombol booking warna kuning cerah (`bg-yellow-400`), dan gambar lapangan dengan efek *overlay gradient* hijau.
* **Card Lapangan:** Menggunakan grid Tailwind (`grid-cols-1 md:grid-cols-3`), efek shadow halus (`shadow-md hover:shadow-xl transition-all duration-300`), dan border radius yang membulat (`rounded-2xl`).
* **Status Badge:** * Tersedia: `bg-emerald-100 text-emerald-800`
    * Penuh/Perbaikan: `bg-rose-100 text-rose-800`

## 4. Layouting Admin Panel
* **Sidebar:** `bg-slate-900` dengan navigasi teks warna putih/abu-abu. Menu aktif menggunakan highlight `bg-emerald-600`.
* **Content Area:** `bg-slate-50` dengan tabel data (`table-auto w-full`) yang bersih, responsif, dan tombol aksi yang jelas (Edit, Hapus).