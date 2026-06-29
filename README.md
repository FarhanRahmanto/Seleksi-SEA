# SEAPEDIA — E-Commerce Multi-Role (PHP Native)

SEAPEDIA adalah sebuah purwarupa (prototype) toko online seperti Shopee atau Tokopedia yang dibuat menggunakan PHP native tanpa framework. Keunikan proyek ini adalah sistem **Multi-Role**, di mana satu akun pengguna bisa mendaftar sekaligus memiliki tiga peran berbeda (sebagai Pembeli/Buyer, Penjual/Seller, dan Kurir/Driver) serta berganti peran aktif di dalam sistem tanpa perlu keluar akun (logout). Seluruh data pengguna dan ulasan tidak disimpan di database SQL besar, melainkan langsung ditulis ke dalam file teks lokal berformat JSON di folder `data/`.

## 🛠️ Alur Kerja Utama Aplikasi (Workflow)

Untuk memahami proyek ini tanpa pusing melihat kode, ikuti alur jalannya data berikut:
1. **Akses Publik (`landing.php` & `product.php`)**: Pengunjung umum (tamu/guest) bisa bebas melihat-lihat katalog produk dan menulis ulasan aplikasi di halaman utama tanpa harus masuk atau bertransaksi terlebih dahulu.
2. **Pendaftaran Akun (`register.php`)**: Pengunjung membuat akun baru dan bisa mencentang peran apa saja yang mereka inginkan (Buyer, Seller, dan/atau Driver). Data ini akan diamankan dengan enkripsi `password_hash()` lalu disimpan ke dalam `data/users.json`.
3. **Penyaringan Peran saat Masuk (`login.php`)**: Saat masuk akun, jika pengguna memiliki lebih dari satu peran, sistem akan memunculkan halaman khusus untuk memilih peran mana yang ingin diaktifkan pada sesi tersebut.
4. **Proteksi Dashboard Terkunci (`dashboard.php`)**: Setelah masuk, pengguna akan diarahkan ke panel kendali. Sistem mengunci akses halaman secara ketat menggunakan session (`$_SESSION`); jika peran aktifmu saat itu adalah Penjual (Seller), kamu tidak akan bisa membuka halaman Pembeli (Buyer) sebelum kamu menukar peran aktifmu melalui menu dropdown yang tersedia di sidebar.

## 🚀 Cara Menjalankan

1. Masuk ke folder proyek melalui Terminal / Command Prompt:
   ```bash
   cd SEAPEDIA
