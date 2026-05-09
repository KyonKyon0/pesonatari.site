# Langit Biru Nusantara - Hari Tari Nasional Indonesia

Portal budaya modern berbasis **PHP Native + MariaDB/MySQL** yang ringan untuk aaPanel, Nginx/OpenLiteSpeed, dan shared VPS.

## Fitur Utama
- Landing page cinematic tema Langit Biru Nusantara.
- Countdown Hari Tari Nasional.
- Katalog Tari + pencarian AJAX ringan.
- Peta Indonesia interaktif (SVG ringan).
- Event festival + checkout tiket.
- Simulasi pembayaran (QRIS dummy, transfer, e-wallet dummy).
- Admin dashboard + CRUD Tari dan Event.

## Stack
- PHP 8+
- MariaDB/MySQL
- Bootstrap 5 + Vanilla JS
- Tanpa NodeJS dan framework berat

## Struktur
- `public/` : web root aaPanel
- `app/` : konfigurasi, helper, views
- `sql/schema.sql` : schema + seed data

## Setup
1. Import `sql/schema.sql`.
2. Sesuaikan kredensial DB di `app/config/config.php`.
3. Arahkan domain document root ke folder `public`.
4. Pastikan extension PHP aktif: `pdo_mysql`, `gd`, `fileinfo`.

## Optimasi yang digunakan
- Gambar upload otomatis dikonversi WebP (quality 75).
- Lazy loading image.
- Asset CSS/JS minified tunggal.
- Prepared statement PDO + index DB.
