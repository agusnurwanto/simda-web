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
- Jika tidak bisa login bisa lakukan bypass dengan menambahkan kode **or 1==1** pada file **aksara/Modules/Auth/Controllers/Auth.php line 128**. Setelah berhasil login lakukan update password user admin dan hapus kode yang tadi sudah ditambahkan. Coba logout dan login kembali.
- Rubah kepemilikan folder **writable** menjadi user webserver. Misalkan menggunakan apache2 dengan user www-data maka jalankan perintah ini:
```
chown -R www-data:www-data writable
```

### Cara Koneksi ke Database SQL Server SIMDA
- Sesuaikan koneksi ke database simda keuangan dengan cara buka menu **Administratif - Konfigurasi - Connection**
- Untuk koneksi dengan PDO ODBC, perlu mengisi kolom DSN dengan nilai **odbc:nama_dsn_odbc**
- Jika menggunakan server linux maka perlu menginstall **freetds** dengan driver **PDO ODBC**. Referensi: https://github.com/agusnurwanto/SIMDA-API-PHP/wiki/Install-driver-freetds-di-server-LINUX-dan-odbc-di-server-SIMDA-Windows-untuk-koneksi-SQL-Server-menggunakan-PHP
- Untuk koneksi dengan PDO ODBC di server linux yang menggunakan freetds, perlu mengisi kolom DSN dengan nilai **odbc:nama_dsn_odbc;DRIVER=freetds**
- Jika kolom port atau password sql server kosong maka perlu diisi dengan nilai **-**
- Untuk koneksi dengan driver sqlserver, perlu disetting dulu. Referensi untuk windows: https://stackoverflow.com/questions/48259319/how-to-install-an-sqlsrv-extension-to-php-xampp

### Catatan Aplikasi
- Fungsi login ada di **aksara/Modules/Auth/Controllers/Auth.php line 74**

### Demo Live Aplikasi
- Kunjungi https://simda.ganjar.id/demo 
- User : **admin**
- Pass : **admin123**

