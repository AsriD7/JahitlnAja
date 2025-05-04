# **JahitlnAja – Platform Jasa Jahit Online Berbasis Laravel**

---

## **Nama & NIM**

- **Nama:** Asri  
- **NIM:** D0223532

---

## **Mata Kuliah & Tahun**

- **Mata Kuliah:** Framework Berbasis Web (FWB)  
- **Tahun:** 2025

---

## **Role dan Fitur-fiturnya**

### 1. **Admin**
- Kelola data pengguna (penjahit & pelanggan)  
- Kelola jasa jahit  
- Verifikasi pembayaran  
- Monitoring pesanan dan ulasan

### 2. **Penjahit**
- Tambah/edit/hapus jasa jahit  
- Konfirmasi pesanan masuk  
- Update status pengerjaan jahitan

### 3. **Pelanggan**
- Registrasi dan login  
- Lihat daftar jasa jahit  
- Pesan jasa dan upload detail ukuran/desain  
- Lacak status pesanan  
- Memberikan ulasan dan rating

---

## **Tabel-Tabel Database beserta Field dan Tipe Datanya**

### **Tabel: users**

| Nama Field  | Tipe Data | Keterangan                 |
| ----------- | --------- | -------------------------- |
| id          | INT       | Primary key                |
| name        | VARCHAR   | Nama pengguna              |
| email       | VARCHAR   | Email unik                 |
| password    | VARCHAR   | Password hash              |
| role        | ENUM      | admin, penjahit, pelanggan |
| created_at  | TIMESTAMP | Waktu dibuat               |
| updated_at  | TIMESTAMP | Waktu diperbarui           |

---

### **Tabel: jasas**

| Nama Field  | Tipe Data | Keterangan                   |
| ----------- | --------- | ---------------------------- |
| id          | INT       | Primary key                  |
| user_id     | INT       | FK ke tabel users (penjahit) |
| nama_jasa   | VARCHAR   | Nama jasa jahit              |
| deskripsi   | TEXT      | Penjelasan jasa              |
| harga       | INTEGER   | Harga jasa                   |
| foto        | VARCHAR   | Path foto portofolio         |
| created_at  | TIMESTAMP |                              |
| updated_at  | TIMESTAMP |                              |

---

### **Tabel: orders**

| Nama Field  | Tipe Data | Keterangan                  |
| ----------- | --------- | --------------------------- |
| id          | INT       | Primary key                 |
| user_id     | INT       | FK ke pelanggan             |
| jasa_id     | INT       | FK ke jasa jahit            |
| ukuran      | TEXT      | Ukuran pakaian              |
| desain      | VARCHAR   | Path file desain (opsional) |
| alamat      | TEXT      | Alamat pengiriman           |
| status      | ENUM      | Menunggu, Diproses, Selesai |
| created_at  | TIMESTAMP |                             |
| updated_at  | TIMESTAMP |                             |

---

### **Tabel: payments**

| Nama Field      | Tipe Data | Keterangan            |
| --------------- | --------- | --------------------- |
| id              | INT       | Primary key           |
| order_id        | INT       | FK ke tabel orders    |
| bukti_transfer  | VARCHAR   | Path bukti transfer   |
| status          | ENUM      | Pending, Dikonfirmasi |
| created_at      | TIMESTAMP |                       |
| updated_at      | TIMESTAMP |                       |

---

### **Tabel: reviews**

| Nama Field  | Tipe Data | Keterangan          |
| ----------- | --------- | ------------------- |
| id          | INT       | Primary key         |
| jasa_id     | INT       | FK ke tabel jasa    |
| user_id     | INT       | FK ke pelanggan     |
| rating      | INTEGER   | Nilai bintang (1–5) |
| komentar    | TEXT      | Ulasan              |
| created_at  | TIMESTAMP |                     |
| updated_at  | TIMESTAMP |                     |

---

## **Jenis Relasi dan Tabel yang Berelasi**

- `users` → `jasas` (One to Many)  
- `users` → `orders` (One to Many)  
- `jasas` → `orders` (One to Many)  
- `orders` → `payments` (One to One)  
- `jasas` → `reviews` (One to Many)  
- `users` → `reviews` (One to Many)
