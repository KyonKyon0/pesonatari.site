# Langit Biru Nusantara (Single File Edition)

Semua logic aplikasi dipusatkan di **`public/index.php`** agar mudah deploy cepat di aaPanel shared hosting.

## Konfigurasi Database (sesuai screenshot aaPanel)
Edit baris paling atas `public/index.php`:
- `$dbName='sql_pesonatari_site'`
- `$dbUser='sql_pesonatari_site'`
- `$dbPass='PASSWORD_DB_AAPANEL'`

## Deploy
1. Import `sql/schema.sql` ke database.
2. Upload project ke aaPanel.
3. Set document root domain ke folder `public`.
4. Pastikan PHP 8+ dengan extension: `pdo_mysql`, `gd`, `fileinfo`.

## Catatan
- Desain UI premium biru-cyan dibuat langsung inline agar 1 file inti.
- Tetap menggunakan prepared statement, CSRF, validasi upload, WebP conversion, lazy load, AJAX ringan.
