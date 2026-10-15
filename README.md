# MVC PHP Native - Data Buku

Aplikasi CRUD sederhana untuk mengelola data buku perpustakaan, dibangun dengan PHP Native menggunakan pola Model-View-Controller (MVC), PDO, dan Git.

**Nama:** Aneira Najla Mutia
**NIM:** 109062500062

## Fitur
- Menampilkan daftar buku
- Menambah, mengubah, dan menghapus data buku
- Validasi input (field wajib, tahun terbit, harga berupa angka)
- Prepared statement PDO untuk semua query yang menerima input
- Escaping output dengan `htmlspecialchars()`
- Pesan sukses dan gagal (flash message), termasuk penanganan ISBN kembar

## Kebutuhan
- PHP 8.0 atau lebih baru
- MySQL/MariaDB
- Web server lokal seperti XAMPP atau Laragon
- Git

## Instalasi
1. Clone atau salin project ke folder web server (XAMPP: `htdocs`).
2. Import `database/perpustakaan.sql` lewat phpMyAdmin.
3. Sesuaikan koneksi pada `config/database.php` jika user atau password MySQL berbeda.
4. Buka `http://localhost/mvc-native/public/index.php`.

## Struktur Folder
```
mvc-native/
├── app/
│   ├── controllers/BukuController.php
│   ├── models/Buku.php
│   └── views/
│       ├── buku/ (index.php, create.php, edit.php)
│       └── partials/flash.php
├── config/database.php
├── database/perpustakaan.sql
├── public/index.php
├── .gitignore
└── README.md
```

## Struktur MVC
- `app/models/` : akses dan operasi data (query PDO).
- `app/controllers/` : alur request, validasi, dan pemanggilan Model/View.
- `app/views/` : tampilan HTML.
- `config/` : konfigurasi koneksi database.
- `database/` : skema dan data awal SQL.
- `public/` : entry point dan router sederhana.

## Struktur Tabel `buku`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | INT | Primary key, auto increment |
| isbn | VARCHAR(20) | Unik |
| judul | VARCHAR(150) | Wajib |
| penulis | VARCHAR(100) | Wajib |
| penerbit | VARCHAR(100) | Wajib |
| tahun_terbit | INT | Wajib, 1900 sampai tahun sekarang |
| harga | INT | Wajib, angka bulat |
| created_at | TIMESTAMP | Terisi otomatis |

## Histori Git
Versi modul (CRUD Mahasiswa) ditandai dengan tag `v1-modul`. Commit setelahnya adalah pengembangan studi kasus Buku.

Lihat riwayat lengkap dengan:

```bash
git log --oneline --graph --decorate
```

## Repository
https://github.com/najlaneira-lab/mvc-native.git