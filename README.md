# Hotel Paradise - Sistem Pemesanan Kamar Hotel

![Hotel Paradise Logo](https://img.shields.io/badge/Hotel-Paradise-gold?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square)
![Laravel](https://img.shields.io/badge/Laravel-11-red?style=flat-square)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square)

Website pemesanan kamar hotel dengan sistem **real-time updates** menggunakan teknologi modern. Proyek ini dibangun dengan **PHP Laravel** sebagai backend, **MySQL** sebagai database, dan **HTML/CSS/JavaScript** untuk frontend dengan design yang profesional dan responsif.

---

## 📋 Deskripsi Proyek

Hotel Paradise adalah sistem pemesanan kamar hotel yang memungkinkan tamu untuk:
- Melihat daftar kamar yang tersedia
- Memeriksa ketersediaan kamar berdasarkan tanggal
- Melakukan pemesanan kamar secara online
- Menerima konfirmasi pemesanan
- Melihat status pemesanan secara real-time

### ✨ Fitur Utama

1. **Sistem Pemesanan Online**
   - Form pemesanan yang user-friendly
   - Validasi tanggal check-in dan check-out
   - Perhitungan harga otomatis
   - Konfirmasi instant

2. **Real-Time Updates**
   - Update status booking secara real-time
   - Notifikasi untuk booking baru
   - Monitoring ketersediaan kamar

3. **Manajemen Kamar**
   - 4 tipe kamar: Standard, Deluxe, Suite, Family
   - Detail lengkap setiap kamar
   - Galeri foto kamar
   - Status ketersediaan

4. **Design Profesional**
   - Responsive design untuk semua device
   - Modern dan elegant UI/UX
   - Animasi smooth
   - Color scheme premium (Gold & Black)

---

## 🚀 Teknologi yang Digunakan

### Backend
- **PHP 8.2+** - Bahasa pemrograman server-side
- **Laravel 11** - PHP Framework modern dan powerful
- **MySQL 8.0** - Database relational
- **Composer** - PHP Dependency Manager

### Frontend
- **HTML5** - Struktur halaman web
- **CSS3** - Styling dengan custom design
- **JavaScript (Vanilla)** - Interaktivitas dan real-time features
- **Google Fonts** - Typography (Playfair Display & Poppins)
- **Font Awesome 6** - Icon library

---

## 📦 Instalasi

### Prasyarat
Pastikan sistem Anda sudah terinstall:
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (opsional, untuk asset compilation)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/yourusername/hotelparadise.git
cd hotelparadise
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**

Edit file `.env` dan sesuaikan dengan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotelparadise
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Migrasi Database & Seeder**
```bash
php artisan migrate:fresh --seed
```

Perintah ini akan:
- Membuat semua tabel yang diperlukan
- Mengisi data sample (3 users, 14 kamar)

6. **Jalankan Development Server**
```bash
php artisan serve
```

7. **Akses Aplikasi**

Buka browser dan akses: `http://127.0.0.1:8000`

---

## 📊 Struktur Database

### Tabel: `users`
| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary key |
| name | VARCHAR | Nama user |
| email | VARCHAR | Email (unique) |
| password | VARCHAR | Password (hashed) |

### Tabel: `rooms`
| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary key |
| number | VARCHAR | Nomor kamar (unique) |
| type | VARCHAR | Tipe kamar |
| capacity | INTEGER | Kapasitas tamu |
| price | DECIMAL | Harga per malam |
| status | ENUM | available/booked/maintenance |
| description | TEXT | Deskripsi kamar |

### Tabel: `bookings`
| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary key |
| user_id | BIGINT | Foreign key ke users |
| room_id | BIGINT | Foreign key ke rooms |
| check_in | DATE | Tanggal check-in |
| check_out | DATE | Tanggal check-out |
| status | ENUM | pending/confirmed/cancelled |
| total_price | DECIMAL | Total harga |
| notes | TEXT | Catatan tambahan |

---

## 🎯 Fitur Real-Time

Sistem real-time diimplementasikan menggunakan **polling technique** yang mengecek update setiap 10 detik. Fitur ini aktif di:

- **Halaman Booking List** - Update otomatis ketika ada booking baru
- **Halaman Dashboard** - Statistik real-time
- **Notifikasi** - Alert untuk perubahan status

### Cara Kerja Real-Time
1. JavaScript melakukan fetch ke API setiap 10 detik
2. Server mengirim data booking terbaru
3. Frontend update tampilan tanpa reload page
4. User menerima notifikasi visual

File utama: `public/js/realtime-updates.js`

---

## 📱 Halaman Website

### 1. Home (`/`)
- Hero section dengan search widget
- Featured rooms
- Fasilitas hotel
- Call-to-action

### 2. Kamar (`/rooms`)
- Daftar semua kamar
- Filter berdasarkan tipe & tanggal
- Detail lengkap setiap kamar
- Quick booking

### 3. Detail Kamar (`/rooms/{id}`)
- Galeri foto
- Informasi lengkap
- Fasilitas
- Form booking langsung

### 4. Buat Booking (`/bookings/create`)
- Form pemesanan
- Pilih tanggal
- Data tamu
- Summary & konfirmasi

### 5. Konfirmasi (`/bookings/{id}/confirmation`)
- Detail pemesanan
- Booking ID
- Informasi pembayaran
- Print option

### 6. Daftar Booking (`/bookings`)
- Semua booking
- Filter by status
- Real-time updates
- Statistik

### 7. Tentang (`/about`)
- Sejarah hotel
- Nilai-nilai
- Fasilitas

### 8. Kontak (`/contact`)
- Form kontak
- Informasi kontak
- Google Maps
- Social media

---

## 🔌 API Endpoints

### Rooms
```
GET  /api/rooms                  - List semua kamar
GET  /api/rooms/{id}            - Detail kamar
POST /api/rooms/check-availability - Cek ketersediaan
GET  /api/rooms/types           - List tipe kamar
```

### Bookings
```
GET    /api/bookings            - List semua booking
POST   /api/bookings            - Buat booking baru
GET    /api/bookings/{id}       - Detail booking
POST   /api/bookings/{id}/status - Update status
DELETE /api/bookings/{id}       - Batalkan booking
POST   /api/bookings/available-rooms - Kamar tersedia
```

---

## 🎨 Design System

### Color Palette
- **Primary (Gold)**: `#D4AF37`
- **Secondary (Black)**: `#1a1a1a`
- **Accent (Brown)**: `#8B7355`
- **Text**: `#333333`
- **Light Background**: `#f8f8f8`

### Typography
- **Headings**: Playfair Display (Serif)
- **Body**: Poppins (Sans-serif)

### Spacing
- Container max-width: 1400px
- Section padding: 5rem vertical
- Card padding: 2rem

---

## 🧪 Testing

Untuk test aplikasi, gunakan data sample yang sudah disediakan:

### User Accounts
- **Admin**: admin@hotelparadise.com
- **User 1**: john@example.com
- **User 2**: jane@example.com

Password default: `password`

### Sample Rooms
- **Standard**: Kamar 101-105 (Rp 500.000/malam)
- **Deluxe**: Kamar 201-204 (Rp 850.000/malam)
- **Suite**: Kamar 301-302 (Rp 1.500.000/malam)
- **Family**: Kamar 401-403 (Rp 1.200.000/malam)

---

## 📝 Cara Menggunakan

### Membuat Booking Baru

1. Buka halaman Home atau Rooms
2. Pilih tanggal check-in dan check-out
3. Klik "Cek Ketersediaan" atau pilih kamar
4. Isi form data tamu
5. Review summary dan klik "Konfirmasi Pemesanan"
6. Dapatkan konfirmasi dengan Booking ID

### Melihat Status Booking

1. Akses `/bookings`
2. Lihat semua booking dengan statusnya
3. Filter berdasarkan status
4. Klik "View" untuk detail lengkap

### Update Status Booking

1. Di halaman booking list
2. Klik tombol "Konfirmasi" (✓) atau "Batalkan" (×)
3. Status akan update secara real-time

---

## 🎓 Untuk Keperluan Tugas

### Checklist Fitur
- ✅ Frontend HTML/CSS dengan design profesional
- ✅ Backend PHP (Laravel)
- ✅ Database MySQL dengan relasi
- ✅ Sistem Real-time (polling every 10s)
- ✅ CRUD Booking lengkap
- ✅ Responsive design
- ✅ Form validation
- ✅ API endpoints
- ✅ Documentation lengkap

### Fitur Bonus
- ✅ Design modern dan profesional
- ✅ Animasi dan transisi smooth
- ✅ Real-time notifications
- ✅ Multiple room types
- ✅ Availability checking
- ✅ Booking confirmation page
- ✅ Statistics dashboard

---

## 📞 Support

Jika ada pertanyaan atau masalah:
- Email: rifqy@example.com
- GitHub Issues: [Create an issue](https://github.com/yourusername/hotelparadise/issues)

---

**Happy Coding! 🚀**

*Dibuat dengan ❤️ untuk Tugas Besar - Sistem Pemesanan Hotel*
