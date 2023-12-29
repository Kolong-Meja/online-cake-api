# Online Cake Shop API

## Deskripsi
Ini adalah API toko kue online yang saya kembangkan. API ini di bentuk untuk keperluan pre-screening test. Projek ini dikembangkan menggunakan framework Laravel versi 10 serta menggunakan database MySQL. 

Pada awal pengembangan, tantangan yang saya hadapi adalah permasalahan relasi antar tabel. Terutama relasi User model dengan Cart model. Saya juga menemui hambatan, ketika harus dihadapkan dengan penggunaan pembatasan Route kepada setiap Role, dimana masing-masing Role memiliki akesibilitas sendiri saat mengunjungi beberapa route. Contohnya, seperti GET users route. Dimana rute ini hanya bisa dipakai oleh user dengan role admin saja.

Untuk tool tambahan, saya menggunakan Google Chrome sebagai media untuk mencari resource mengenai error, bug, method baru, dsb. Serta saya menggunakan aplikasi Postman sebagai tempat bagi saya untuk melakukan testing API ini. 


## Konten utama
Fitur yang tersedia pada API ini adalah:

1. Authentication (login dan logout) dengan registration user (guest).
2. Basic CRUD (create, read, update, dan delete) untuk semua Route, kecuali Authentication route (hanya POST method).

## Penggunaan

Untuk memulai menggunakan API ini, anda hanya perlu:
1. Jalankan perintah (Pastikan anda melakukan setting url local terlebih dahulu.) di terminal anda. 

```bash
php artisan serve 
```

2. Jalankan server apache dan mysql di Xampp (Windows) atau Lampp (Linux).

3. Buka browser anda, lalu ketika http://localhost/phpmyadmin

4. Buka aplikasi Postman anda.

5. Masukkan URL dari server lokal Laravel anda dan api route (letak file di routes/api.php) di kolom input URL Postman, seperti:

```bash
http://127.0.0.1:8000/api/{nama_route}
```

6. Lalu klik tombol Send (pastikan metode route di Postman sama dengan metode route pada file api.php).
