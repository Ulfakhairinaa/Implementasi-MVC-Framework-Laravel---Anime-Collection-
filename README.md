# 🎌 Anime Collection — Tugas Praktikum Laravel

Aplikasi web pengelolaan koleksi anime berbasis framework **Laravel**, dibuat sebagai tugas mata kuliah Pemrograman Berbasis Web.

---

## 📋 Informasi Tugas

| Item | Keterangan |
|------|------------|
| Nama | Ulfa Khairina |
| NPM  | P2408107010013 |
| Mata Kuliah | Pemrograman Berbsis Web |
| Framework | Laravel (PHP) |
| Database | SQLite |
| Tugas | Tugas 1 (MVC) & Tugas 2 (ORM Eloquent) |

---

## 📌 Tugas 1 — Implementasi MVC Laravel

Tugas pertama berfokus pada penerapan arsitektur **Model-View-Controller (MVC)** menggunakan Laravel untuk membangun aplikasi Anime Collection.

### Komponen MVC

| Komponen | File | Fungsi |
|----------|------|--------|
| **Model** | `app/Models/Anime.php` | Merepresentasikan data anime dan berinteraksi dengan database |
| **View** | `resources/views/anime/*.blade.php` | Menampilkan data kepada pengguna (index, create, edit, show) |
| **Controller** | `app/Http/Controllers/AnimeController.php` | Menangani logika request dan menghubungkan Model dengan View |

---

## 📌 Tugas 2 — ORM Eloquent Laravel

Tugas kedua mengembangkan aplikasi dari Tugas 1 dengan menerapkan **Eloquent ORM** secara penuh, termasuk relasi antar tabel dan fitur CRUD lengkap.

### Komponen Baru yang Ditambahkan

- `app/Models/Genre.php` — Model untuk tabel genres
- `app/Models/Studio.php` — Model untuk tabel studios
- Migration `create_genres_table` — Membuat tabel genres
- Migration `create_studios_table` — Membuat tabel studios
- Migration `add_foreign_keys_to_animes_table` — Menambahkan relasi foreign key
- Relasi `belongsTo` / `hasMany` antar model
- Method `where()` untuk filter anime by genre
- Dropdown Genre & Studio di form create/edit
- Route `byGenre` untuk menampilkan anime per genre

### Relasi Antar Tabel

```
Genre ──< Anime >── Studio
```

| Model | Relasi | Target | Keterangan |
|-------|--------|--------|------------|
| Anime | belongsTo | Genre | Satu anime punya satu genre |
| Anime | belongsTo | Studio | Satu anime punya satu studio |
| Genre | hasMany | Anime | Satu genre punya banyak anime |
| Studio | hasMany | Anime | Satu studio punya banyak anime |

### Method Eloquent yang Digunakan

| Method | Lokasi | Keterangan |
|--------|--------|------------|
| `create()` | `store()` | Menyimpan data anime baru |
| `findOrFail()` | `show()`, `edit()`, `update()`, `destroy()` | Mencari anime by ID |
| `where()` | `byGenre()` | Filter anime berdasarkan genre |
| `update()` | `update()` | Memperbarui data anime |
| `delete()` | `destroy()` | Menghapus data anime |
| `with()` | `index()`, `show()` | Eager loading relasi genre & studio |
| `firstOrCreate()` | `store()`, `update()` | Cari atau buat genre/studio baru |

---

## ✨ Fitur Aplikasi

- ✅ Menampilkan daftar anime beserta genre dan studio
- ✅ Menambahkan anime baru (dengan opsi tambah genre/studio baru)
- ✅ Mengedit data anime
- ✅ Menghapus anime beserta gambarnya
- ✅ Melihat detail lengkap satu anime
- ✅ Filter anime berdasarkan genre

---

## 🗂️ Struktur Database

```
genres          studios
  id              id
  nama            nama
  timestamps      timestamps
       \          /
        \        /
         animes
           id
           judul
           genre_id (FK)
           studio_id (FK)
           episode
           rating
           sinopsis
           tahun_rilis
           gambar
           timestamps
```

---

## 🚀 Cara Menjalankan

```bash
# Clone project
git clone <repo-url>
cd Implementasi-MVC-Framework-Laravel---Anime-Collection-

# Install dependencies
composer install

# Salin file environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Jalankan migrasi database
php artisan migrate

# Jalankan server
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

---

## 📁 Struktur Folder Penting

```
app/
├── Http/Controllers/
│   └── AnimeController.php
└── Models/
    ├── Anime.php
    ├── Genre.php
    └── Studio.php

database/migrations/
├── create_animes_table.php
├── create_genres_table.php
├── create_studios_table.php
└── add_foreign_keys_to_animes_table.php

resources/views/anime/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
└── show.blade.php
```
