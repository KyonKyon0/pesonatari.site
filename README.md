# Langit Biru Nusantara

Portal budaya fullstack ringan (PHP Native + MariaDB) siap aaPanel.

## Kredensial DB (sesuai foto aaPanel)
- Database: `sql_pesonatari_site`
- Username: `sql_pesonatari_site`
- Password: `dcbf4afe83baa8`

Atur di `app/config/config.php`.

## Deploy aaPanel/XAMPP
1. Import `sql/schema.sql`.
2. Upload folder project.
3. Set document root ke `public/`.
4. Aktifkan PHP 8+ extension: `pdo_mysql`, `gd`, `fileinfo`.

## Optimasi
- CSS/JS minified terpisah.
- Prepared statement + index DB.
- Lazy loading image.
- Upload image tervalidasi + kompres WebP.
- AJAX pencarian tari.
