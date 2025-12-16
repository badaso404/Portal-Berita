# Portal Berita Laravel

Aplikasi **Portal Berita** berbasis **Laravel** yang digunakan untuk mengelola dan menampilkan berita secara dinamis. Project ini mendukung fitur **CRUD berita**, **kategori**, **pencarian & filter**, **autentikasi**, serta **API endpoint** untuk kebutuhan frontend atau aplikasi mobile.

---

## 🚀 Fitur Utama

* Landing page menampilkan **berita terbaru**
* Manajemen berita (Create, Read, Update, Delete)
* Kategori berita
* Filter & pencarian berita

  * Berdasarkan judul
  * Berdasarkan kategori
  * Berdasarkan tanggal publikasi
* Dashboard admin
* Autentikasi (Login & Logout)
* Export data user
* REST API untuk berita & kategori
* Pagination & sorting data

---

## 🛠️ Teknologi yang Digunakan

* **Laravel** (Backend Framework)
* **PHP >= 8.1**
* **MySQL / MariaDB**
* **Blade Template** (Frontend)
* **Bootstrap / Tailwind CSS** (UI)
* **Laravel Eloquent ORM**
* **Laravel Sanctum / Session Auth**

---

## 📁 Struktur Project (Ringkas)

```
app/
 ├── Models/
 │    ├── User.php
 │    ├── Berita.php
 │    └── Kategori.php
 ├── Http/
 │    ├── Controllers/
 │    │     ├── AuthController.php
 │    │     ├── BeritaController.php
 │    │     └── KategoriController.php
 │    └── Middleware/

routes/
 ├── web.php
 └── api.php

database/
 ├── migrations/
 └── seeders/

resources/
 ├── views/
 │    ├── auth/
 │    ├── dashboard/
 │    └── landing/
```

---

## ⚙️ Instalasi & Konfigurasi

### 1️⃣ Clone Repository

```bash
git clone https://github.com/badaso404/Portal-Berita.git
cd Portal-Berita
```

### 2️⃣ Install Dependency

```bash
composer install
```

### 3️⃣ Copy File Environment

```bash
cp .env.example .env
```

### 4️⃣ Konfigurasi Database

Edit file `.env`:

```
DB_DATABASE=portal_berita
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Generate Key

```bash
php artisan key:generate
```

### 6️⃣ Migrasi & Seeder

```bash
php artisan migrate --seed
```

### 7️⃣ Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di:

```
http://127.0.0.1:8000
```

---

## 🔐 Autentikasi

* Login menggunakan akun admin
* Proteksi route menggunakan **middleware auth**
* User yang belum login tidak dapat mengakses dashboard

---

## 📰 Manajemen Berita

Field utama berita:

* Judul
* Slug
* Konten
* Kategori
* Tanggal publikasi
* Status (draft / published)

---

## 🔍 Pencarian & Filter

Fitur pencarian mendukung:

* Keyword judul berita
* Filter kategori
* Filter tanggal publikasi

---

## 🔗 API Endpoint

### 📌 Berita

| Method | Endpoint         | Deskripsi     |
| ------ | ---------------- | ------------- |
| GET    | /api/berita      | List berita   |
| GET    | /api/berita/{id} | Detail berita |
| POST   | /api/berita      | Tambah berita |
| PUT    | /api/berita/{id} | Update berita |
| DELETE | /api/berita/{id} | Hapus berita  |

### 📌 Kategori

| Method | Endpoint      | Deskripsi     |
| ------ | ------------- | ------------- |
| GET    | /api/kategori | List kategori |

---

## 📤 Export Data User

* Export data user ke format file (CSV / Excel)
* Digunakan untuk kebutuhan laporan admin

---

## 🧪 Testing (Opsional)

```bash
php artisan test
```

---

## 📌 Catatan Penting

* Pastikan folder `storage` dan `bootstrap/cache` memiliki permission write
* Gunakan `php artisan optimize` untuk production

---

## 🤝 Kontribusi

Kontribusi sangat terbuka.

1. Fork repository
2. Buat branch baru
3. Commit perubahan
4. Pull Request

---

## 📄 Lisensi

Project ini menggunakan lisensi **MIT**.

---

## 👨‍💻 Author

**Portal Berita Laravel**
Dikembangkan sebagai project pembelajaran dan portfolio backend Laravel.
