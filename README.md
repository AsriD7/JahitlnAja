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
