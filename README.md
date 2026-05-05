# uts-pemrograman-web-2-60324019

# Nama dan NIM
Rachel Karima Abdullah-60324019
# Deskripsi Singkat aplikasi
Aplikasi web sederhana untuk mengelola Kategori Buku di perpustakaan, dibuat menggunakan PHP native dan MySQL. Aplikasi memiliki fitur CRUD lengkap (Create, Read, Update, Delete) dengan tampilan Bootstrap 5.
# Cara instalasi dan menjalankan aplikasi
- Install XAMPP (pastikan Apache & MySQL aktif)
- Copy folder project ke: C:/xampp/htdocs/uts_60324019/
- Buka phpMyAdmin → http://localhost/phpmyadmin
- Buat database: uts_perpustakaan_60324019
- Buat SQL:
   CREATE TABLE kategori (
       id_kategori INT AUTO_INCREMENT PRIMARY KEY,
       kode_kategori VARCHAR(10) UNIQUE NOT NULL,
       nama_kategori VARCHAR(50) NOT NULL,
       deskripsi TEXT,
       status ENUM('Aktif','Nonaktif') DEFAULT 'Aktif',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
- Buka browser → http://localhost/uts_60324019/
# Struktur folder
folder utama bernama uts_60324019. di dalamnya punya folder config yang berisi file database.php Untuk file utama aplikasi, terdapat index.php sebagai halaman utama yang menampilkan seluruh data kategori, lalu ada file create.php untuk menambah kategori baru, edit.php untuk mengubah data kategori yang sudah ada, delete.php untuk menghapus kategori, serta README.md sebagai dokumentasi aplikasi.
# Link repository GitHub
https://github.com/raxhelkarima/uts-pemrograman-web-2-60324019.git
