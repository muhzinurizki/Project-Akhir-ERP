---
# 📦 ERP Tekstil - Core Engine

Sistem ERP (Enterprise Resource Planning) yang dirancang khusus untuk industri tekstil menggunakan framework **Laravel 11**, **Tailwind CSS**, dan **Spatie Roles & Permissions**. Sistem ini mengelola seluruh alur kerja mulai dari Master Data, Procurement, Inventory, hingga Finance.

---

## ✨ Fitur Utama

* **Role-Based Access Control (RBAC):** Manajemen hak akses mendalam menggunakan Spatie (Admin, Manager, Warehouse, Sales, Finance, dll).
* **Inventory Management:** Stock Ledger, Internal Transfer, dan Stock Entry.
* **Procurement:** Alur Purchase Request (PR) ke Purchase Order (PO) dengan sistem approval.
* **Sales & Distribution:** Manajemen Sales Order (SO) dan Delivery Order (DO).
* **Finance & Accounting:** Account Payable (AP) dan Account Receivable (AR).
* **Modern UI:** Antarmuka minimalis berbasis Tailwind CSS dan Lucide Icons.

---

## 🧩 Prasyarat Sistem (Wajib Diinstal)

Pastikan tools berikut sudah terpasang di sistem Anda sebelum melakukan instalasi proyek:

### 🔧 Software Utama

| Software       | Versi Minimum      | Keterangan                        |
| -------------- | ------------------ | --------------------------------- |
| **PHP**        | >= 8.3             | Dibutuhkan oleh Laravel 11        |
| **Composer**   | Latest             | Dependency manager PHP            |
| **Node.js**    | >= 18.x            | Untuk build asset frontend        |
| **NPM**        | >= 9.x             | Package manager JavaScript        |
| **Git**        | Latest             | Version control                   |
| **Web Server** | Apache / Nginx     | Opsional (Laravel serve tersedia) |
| **Database**   | MySQL / PostgreSQL | Penyimpanan data                  |

### 📌 Ekstensi PHP yang Direkomendasikan

Pastikan ekstensi berikut aktif:

* OpenSSL
* PDO
* Mbstring
* Tokenizer
* XML
* Ctype
* JSON
* BCMath
* Fileinfo

Cek dengan:

```bash
php -m
```

---

## 🚀 Langkah Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan lokal Anda:

### 1. Kloning Repositori

```bash
git clone https://github.com/username/erp-tekstil.git
cd erp-tekstil
```

---

### 2. Instalasi Dependensi

```bash
# Instal dependensi PHP
composer install

# Instal dependensi JavaScript
npm install && npm run build
```

---

### 3. Konfigurasi Lingkungan

Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda:

```bash
cp .env.example .env
php artisan key:generate
```

**Pengaturan Database di `.env`:**

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_db_anda
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4. Migrasi & Seeding (Sangat Penting)

Langkah ini akan membuat tabel dan mengisi data awal (Role, Permissions, dan User Admin):

```bash
php artisan migrate:fresh --seed
```

---

### 5. Jalankan Server

```bash
php artisan serve
```

Akses di browser:
👉 `http://127.0.0.1:8000`

---

## 🔑 Data Akun Default (Seeder)

Setelah menjalankan seeder, Anda dapat login menggunakan akun berikut:

| Role          | Email                | Password   |
| ------------- | -------------------- | ---------- |
| **Admin**     | `admin@erp.test`     | `password` |
| **Warehouse** | `warehouse@erp.test` | `password` |
| **Sales**     | `sales@erp.test`     | `password` |

---

## 🛠 Perintah Penting

Jika Anda melakukan perubahan pada Role atau Permission:

```bash
# Membersihkan cache permission
php artisan permission:cache-reset

# Jika menu sidebar tidak muncul
php artisan optimize:clear
```

---

## 📝 Tech Stack

* **Backend:** Laravel 11
* **Frontend:** Tailwind CSS, Alpine.js
* **Icons:** Lucide Icons
* **Security:** Spatie Laravel-Permission
* **Database:** MySQL / PostgreSQL

---

## 🤝 Kontribusi

1. Fork proyek ini.
2. Buat branch fitur baru (`git checkout -b feature/FiturKeren`).
3. Commit perubahan Anda (`git commit -m 'feat: Add Fitur Keren'`).
4. Push ke branch (`git push origin feature/FiturKeren`).
5. Buat Pull Request.

---
