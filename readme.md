# SIMDA WEB PHP Open Source
- Aplikasi SIMDA berbasis WEB dengan bahasa pemrogramman PHP, framwork CI-Aksara dan database SQL Server
- Grup telegram untuk koordinasi dan monitoring udpate aplikasi https://t.me/sipd_chrome_extension

### Cara Setup 
- Clone atau download master zip repository ini
- Import database simda_web.sql ke Mysql Database 
- Copy file config.php.example ke config.php dan edit nilai dari variable di bawah ini, agar terkoneksi ke database mysql
```
DB_HOSTNAME 
DB_USERNAME 
DB_PASSWORD 
DB_DATABASE 
``` 
- Buka aplikasi dan Login sebagai administrator 
```
User : admin 
Pass : admin123 
```
- Rubah kepemilikan folder **writable** menjadi user webserver. Misalkan menggunakan apache2 dengan user www-data maka jalankan perintah ini:
```
chown -R www-data:www-data writable
```

### Cara Koneksi ke Database SQL Server SIMDA
- Instal terlebih dahulu sqlserver connect. Ini untuk windows: https://stackoverflow.com/questions/48259319/how-to-install-an-sqlsrv-extension-to-php-xampp 
- Sesuaikan koneksi ke database simda keuangan dengan cara buka menu **Administratif - Konfigurasi - Connection**

### Catatan Aplikasi
- Fungsi login ada di **aksara/Modules/Auth/Controllers/Auth.php line 74**

### Demo Live Aplikasi
- Kunjungi https://simda.ganjar.id/demo 
- User : **admin**
- Pass : **admin123**

