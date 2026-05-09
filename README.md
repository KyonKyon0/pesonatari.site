# Langit Biru Nusantara
Portal budaya Hari Tari Nasional Indonesia (PHP Native + MariaDB) yang ringan, premium, dan siap aaPanel.

## Kredensial Database (sesuai panel)
- DB: `sql_pesonatari_site`
- User: `sql_pesonatari_site`
- Password: `dcbf4afe83baa8`

## Fitur
- Homepage premium: hero video, countdown, tari populer, peta interaktif, tentang, video tari, top vote, artikel budaya, komentar.
- User: cari tari AJAX, favorit, vote, pesan tiket, pembayaran + upload bukti.
- Admin: sidebar dashboard, kelola tari, kelola event, kelola tiket/user.

## Deploy
1. Import `sql/schema.sql`
2. Upload source ke server aaPanel
3. Set document root ke `public/`
4. Aktifkan PHP 8+: `pdo_mysql`, `gd`, `fileinfo`
