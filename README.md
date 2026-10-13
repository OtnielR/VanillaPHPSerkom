## Sistem Manajemen Makanan & Dasbor (Food Management & Dashboard System)

Aplikasi web MVC kustom modular yang dibangun menggunakan **Vanilla PHP**, **MySQL**, dan HTML/CSS. Proyek ini dilengkapi fitur manajemen pengguna, manajemen menu makanan, pemrosesan pesanan, dan sistem penyiapan basis data otomatis yang menginisialisasi tabel secara mandiri saat pertama kali dijalankan.

---

## 🛠️ Prasyarat

* **Laragon** (sangat direkomendasikan) atau stack WAMP/XAMPP apa pun yang menjalankan:
* **Apache**
* **PHP 8.x** (atau PHP 7.4+)
* **MySQL / MariaDB**

---

## 🗄️ Pengaturan Basis Data & Inisialisasi Otomatis

Aplikasi dikonfigurasi untuk secara otomatis memeriksa dan membuat tabel basis data yang diperlukan pada peluncuran awal (`CREATE TABLE IF NOT EXISTS`).

### Konfigurasi Basis Data

Perbarui kredensial basis data Anda di `app/core/config.php`

```php
-- Change this based on your own credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'food_db');

-- Change this if you want different default admin account
define("DEFAULT_ADMIN_USERNAME", "admin");
define("DEFAULT_ADMIN_GMAIL", "admin@gmail.com");
define("DEFAULT_ADMIN_PASSWORD", "admin");

-- Change this based on your folder name
define("__BASEURL__", "/LearnPHP/auth");

```

### Skema Otomatis (Referensi)

Ketika aplikasi berjalan, aplikasi akan memverifikasi dan membuat struktur berikut secara otomatis jika belum ada:

```sql
-- Tabel Pengguna (Users)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(20) DEFAULT 'user'
);

-- Tabel Menu Makanan (Foods)
CREATE TABLE IF NOT EXISTS `foods` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `category` ENUM("makanan", "minuman", "cemilan") NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `description` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pesanan (Orders)
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `customer_name` VARCHAR (100) NOT NULL,
  `table_number` INT NOT NULL,
  `total_price` DECIMAL(10, 2) NOT NULL,
  `status` ENUM("diproses", "pending", "selesai") NOT NULL,
  `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Detail Pesanan (Order Details)
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `food_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `subtotal` DECIMAL(10, 2) NOT NULL,
  `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (food_id) REFERENCES foods(id)
);

```

---

## 🚀 Cara Menjalankan Proyek

### 1. Menyiapkan Laragon

1. Unduh dan pasang [Laragon](https://laragon.org/).
2. Letakkan folder proyek ini ke dalam direktori root Laragon Anda:
```text
C:\laragon\www\nama-proyek-anda

```

3. Nyalakan **Apache** dan **MySQL** dari Panel Kontrol Laragon.

### 2. Memulai Aplikasi

1. Buka **HeidiSQL** atau **phpMyAdmin** dari Laragon dan buat basis data kosong secara manual dengan nama `food_db` (atau sesuaikan dengan nama di berkas `config.php` Anda).
2. Arahkan peramban (browser) Anda ke URL proyek:
* **Laragon Virtual Host:** `[http://nama-proyek-anda.test](http://nama-proyek-anda.test)`
* **URL Standar:** `http://localhost/nama-proyek-anda`


3. Pada pemuatan halaman pertama, pemeriksaan inisialisasi basis data akan berjalan secara otomatis dan menyiapkan semua tabel yang diperlukan. Permintaan berikutnya akan melewati pembuatan tabel jika sudah ada.

---

## 💻 Cara Penggunaan

### 1. Autentikasi

* Kunjungi halaman masuk (`/view/login.php` atau rute utama) untuk masuk.
* Lalu login menggunakan data default yang sudah di siap kan dalam file `config.php`
* Akhiri sesi dengan aman menggunakan `logout.php`.

### 2. Manajemen Dasbor

Akses berbagai fitur melalui rute dasbor:

* **Manajemen Pengguna (`/view/dashboard/user-list.php`)**:
* Melihat pengguna aktif, membuat akun baru (`user-form.php`), mengubah detail, atau menghapus akun (`user-delete.php`).


* **Manajemen Menu Makanan (`/view/dashboard/food-list.php`)**:
* Mengelola item katalog, mengategorikan makanan, menetapkan harga, dan memperbarui item (`food-form.php`, `food-delete.php`).


* **Pemrosesan Pesanan**:
* Membuat dan memperbarui detail pesanan pelanggan melalui formulir pesanan komponen.


### 3. Utilitas Pembantu & Komponen UI

* **Komponen UI**: Elemen antarmuka disusun di dalam `view/components/` (kartu, tabel, filter, form).
* **Utilitas Backend**: `app/utils/` mencakup kelas pembantu (`ComponentUtils`, `ElementUtils`, `FileUtils`) untuk menangani pembuatan templat dinamis dan pengunggahan berkas. 
