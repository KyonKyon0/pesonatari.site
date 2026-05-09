# Fix 403 Forbidden (Nginx/aaPanel)

Jika domain menampilkan **403 Forbidden**, biasanya document root mengarah ke folder repo, bukan folder `public`.

## Opsi 1 (Direkomendasikan)
Atur **Site Directory / Root** ke:

`/www/wwwroot/pesonatari.site/public`

lalu reload nginx.

## Opsi 2 (Fallback)
Jika root tidak bisa diubah cepat, file `index.php` di root project sudah disediakan untuk meneruskan ke `public/index.php`.

## Nginx location sederhana
```nginx
index index.php index.html;
location / {
  try_files $uri $uri/ /index.php?$query_string;
}
location ~ \.php$ {
  include fastcgi_params;
  fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
  fastcgi_pass unix:/tmp/php-cgi-82.sock; # sesuaikan versi PHP aaPanel
}
```
