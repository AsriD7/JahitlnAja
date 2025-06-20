<h1 align="center">JahitlnAja</h1>

<h3 align="center">Platform Jasa Jahit Online</h3>

<p align="center">
  <img src="https://github.com/user-attachments/assets/191c51a4-97a2-451a-84ee-6e6527d81644" width="200" alt="Logo Universitas"/>
</p>

<h3 align="center">Asri</h3>

<h4 align="center">D0223532</h4>

<h4 align="center">Framework Web Based</h4>

<h4 align="center">2025</h4>

---

## **Role dan Fitur-fiturnya**

### 1. **Admin**
- Mengelola data pengguna (penjahit dan pelanggan).
- Mengelola kategori dan layanan jahit.
- verifikasi pembayaran
- *(Catatan: Fitur verifikasi pembayaran dan ulasan belum diimplementasikan dalam kode saat ini, tetapi dapat ditambahkan di masa depan.)*

### 2. **Penjahit**
- Mengelola profil penjahit (spesialisasi dan pengalaman).
- Mengelola daftar layanan yang dikuasai (keahlian).
- Memperbarui status pengerjaan pesanan (pending, accepted, in_progress, completed).

### 3. **Pelanggan**
- Registrasi dan login ke platform.
- Melihat daftar kategori, layanan jahit, dan penjahit yang tersedia.
- Membuat pesanan dengan memilih layanan, penjahit, serta mengunggah detail ukuran dan gambar referensi.
- Mengunggah bukti pembayaran.

---

## **Tabel-Tabel Database beserta Field dan Tipe Datanya**

### **Tabel: users**

| Nama Field         | Tipe Data  | Keterangan                           |
|--------------------|------------|--------------------------------------|
| id                 | BIGINT     | Primary key (auto increment)         |
| name               | VARCHAR    | Nama pengguna                        |
| email              | VARCHAR    | Email unik                           |
| email_verified_at  | TIMESTAMP  | Waktu verifikasi email (nullable)    |
| password           | VARCHAR    | Password hash                        |
| role               | ENUM       | 'admin', 'penjahit', 'user' (default: 'user') |
| remember_token     | VARCHAR    | Token untuk "remember me"            |
| created_at         | TIMESTAMP  | Waktu dibuat                         |
| updated_at         | TIMESTAMP  | Waktu diperbarui                     |

### **Tabel: profiles**

| Nama Field  | Tipe Data  | Keterangan                           |
|-------------|------------|--------------------------------------|
| id          | BIGINT     | Primary key (auto increment)         |
| user_id     | BIGINT     | Foreign key ke users.id              |
| phone       | VARCHAR    | Nomor telepon pengguna               |
| address     | TEXT       | Alamat pengguna                      |
| created_at  | TIMESTAMP  | Waktu dibuat                         |
| updated_at  | TIMESTAMP  | Waktu diperbarui                     |

### **Tabel: tailors**

| Nama Field      | Tipe Data  | Keterangan                           |
|-----------------|------------|--------------------------------------|
| id              | BIGINT     | Primary key (auto increment)         |
| user_id         | BIGINT     | Foreign key ke users.id              |
| specialization  | VARCHAR    | Spesialisasi penjahit (e.g., Atasan) |
| experience      | INTEGER    | Pengalaman (tahun)                   |
| created_at      | TIMESTAMP  | Waktu dibuat                         |
| updated_at      | TIMESTAMP  | Waktu diperbarui                     |

### **Tabel: categories**

| Nama Field  | Tipe Data  | Keterangan                           |
|-------------|------------|--------------------------------------|
| id          | BIGINT     | Primary key (auto increment)         |
| name        | VARCHAR    | Nama kategori (e.g., Atasan, Bawahan) |
| created_at  | TIMESTAMP  | Waktu dibuat                         |
| updated_at  | TIMESTAMP  | Waktu diperbarui                     |

### **Tabel: services**

| Nama Field    | Tipe Data  | Keterangan                           |
|---------------|------------|--------------------------------------|
| id            | BIGINT     | Primary key (auto increment)         |
| category_id   | BIGINT     | Foreign key ke categories.id         |
| name          | VARCHAR    | Nama layanan (e.g., Kemeja, Dress)   |
| description   | TEXT       | Deskripsi layanan (nullable)         |
| price         | DECIMAL(8,2) | Harga layanan                       |
| created_at    | TIMESTAMP  | Waktu dibuat                         |
| updated_at    | TIMESTAMP  | Waktu diperbarui                     |

### **Tabel: orders**

| Nama Field       | Tipe Data  | Keterangan                           |
|------------------|------------|--------------------------------------|
| id               | BIGINT     | Primary key (auto increment)         |
| customer_id      | BIGINT     | Foreign key ke users.id (pelanggan)  |
| tailor_id        | BIGINT     | Foreign key ke tailors.id            |
| service_id       | BIGINT     | Foreign key ke services.id           |
| measurement      | TEXT       | Detail ukuran pakaian                |
| reference_image  | VARCHAR    | Path gambar referensi (nullable)     |
| total_price      | DECIMAL(8,2) | Total harga pesanan                 |
| status           | VARCHAR    | Status: pending, accepted, in_progress, completed |
| payment_proof    | VARCHAR    | Path bukti pembayaran (nullable)     |
| created_at       | TIMESTAMP  | Waktu dibuat                         |
| updated_at       | TIMESTAMP  | Waktu diperbarui                     |

### **Tabel: service_tailor**

| Nama Field  | Tipe Data  | Keterangan                           |
|-------------|------------|--------------------------------------|
| id          | BIGINT     | Primary key (auto increment)         |
| tailor_id   | BIGINT     | Foreign key ke tailors.id            |
| service_id  | BIGINT     | Foreign key ke services.id           |
| created_at  | TIMESTAMP  | Waktu dibuat                         |
| updated_at  | TIMESTAMP  | Waktu diperbarui                     |

---

## **Jenis Relasi dan Tabel yang Berelasi**

- **One-to-One**:
  - `users` → `profiles`: Satu pengguna memiliki satu profil (phone, address).
  - `users` → `tailors`: Satu pengguna (dengan role 'penjahit') memiliki satu data penjahit (specialization, experience).

- **One-to-Many**:
  - `users` → `orders`: Satu pengguna (pelanggan) dapat memiliki banyak pesanan (via customer_id).
  - `tailors` → `orders`: Satu penjahit dapat menangani banyak pesanan (via tailor_id).
  - `categories` → `services`: Satu kategori dapat memiliki banyak layanan.
  - `services` → `orders`: Satu layanan dapat digunakan dalam banyak pesanan.

- **Many-to-Many**:
  - `tailors` ↔ `services`: Satu penjahit dapat menguasai banyak layanan, dan satu layanan dapat ditangani oleh banyak penjahit, dihubungkan melalui tabel pivot `service_tailor`.

---
