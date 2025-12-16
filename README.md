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

## 📁 Struktur Project 

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

### 📌 Public

| Method | Endpoint                    | Description             | Parameters       |
| :----- | :-------------------------- | :---------------------- | :--------------- |
| `GET`  | `/api/news`                 | List all published news | `?page=1`        |
| `GET`  | `/api/news/search`          | Search news             | `?title=keyword` |
| `GET`  | `/api/news/category/{slug}` | Get news by category    | -                |
| `GET`  | `/api/news/{id}`            | Get article detail      | -                |

### 📌 Admin 

| Method   | Endpoint               | Description        |
| :------- | :--------------------- | :----------------- |
| `POST`   | `/api/admin/news`      | Create new article |
| `PUT`    | `/api/admin/news/{id}` | Update article     |
| `DELETE` | `/api/admin/news/{id}` | Delete article     |

---

## 🧪 How to Try in Postman

You can easily test the API endpoints using Postman.

### A. Testing Public Routes

1.  Open **Postman**.
2.  Create a new Request.
3.  Set Method to `GET` and URL to `http://localhost:8000/api/news`.
4.  Go to the **Headers** tab and add:
    -   Key: `Accept`
    -   Value: `application/json`
5.  Click **Send**. You will see the list of articles.

### B. Testing Protected (Admin) Routes

Since this is an API, you normally need an **Access Token**. For development testing, you can generate one quickly using Laravel Tinker:

**Step 1: Generate a Token**
Run this command in your terminal:

```bash
php artisan tinker
```

Then paste these lines:

```php
$user = \App\Models\User::where('email', 'admin@admin.com')->first();
$token = $user->createToken('PostmanTest')->plainTextToken;
echo $token;
```

Copy the long string printed (the token).

**Step 2: Use Token in Postman**

1.  Create a request (e.g., `POST` `http://localhost:8000/api/admin/news`).
2.  Go to the **Authorization** tab.
3.  Select Type: **Bearer Token**.
4.  Paste the token you copied into the **Token** field.
5.  Go to **Body** -> **form-data** to send data (e.g., `title`, `content`, `category_id`, `image`).
6.  Click **Send**.
