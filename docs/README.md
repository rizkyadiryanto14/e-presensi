# Dokumentasi Sistem E-Presensi

Dokumentasi lengkap untuk Skripsi - Sistem Informasi E-Presensi Guru

---

## 📋 Daftar Isi

Folder `docs` ini berisi dokumentasi lengkap sistem E-Presensi dalam format Mermaid diagram untuk keperluan skripsi. Semua diagram dapat di-render langsung di GitHub atau aplikasi yang mendukung Mermaid.

### 1. [Flowchart Perbandingan Akses Role](./01a-flowchart-perbandingan-akses-role.md) ⭐ **MULAI DARI SINI!**
**Isi Dokumen:**
- **1 Flowchart ringkas** yang menunjukkan perbandingan akses semua role (Admin, Kepala Sekolah, Guru) dalam satu diagram
- Menampilkan side-by-side menu dan fitur yang bisa diakses setiap role
- Tabel perbandingan lengkap akses per fitur
- Matriks akses dengan simbol ✅ dan ❌
- Hierarki akses visual
- Skenario penggunaan per role

**Cocok untuk menjelaskan:**
- Perbedaan akses antar role secara visual
- Overview sistem akses dalam 1 halaman
- Presentasi yang jelas tentang RBAC (Role-Based Access Control)

**💡 RECOMMENDED:** Gunakan flowchart ini sebagai **diagram pembuka** di BAB III skripsi untuk memberikan gambaran umum hak akses setiap role!

---

### 2. [Flowchart Akses Role dan Fitur - VERSI SEDERHANA](./01-flowchart-akses-role-simplified.md) ⭐ **RECOMMENDED untuk Detail Proses**
**Isi Dokumen:**
- 7 Flowchart terpisah yang lebih ringkas dan mudah dipahami:
  1. Flowchart Login dan Autentikasi
  2. Flowchart Menu Administrator
  3. Flowchart Menu Kepala Sekolah
  4. Flowchart Menu Guru
  5. Flowchart Proses Check-in Presensi (Detail)
  6. Flowchart Perhitungan Gaji
  7. Flowchart Tambah Guru Baru
- Tabel ringkasan akses per role
- Panduan export ke PNG/SVG untuk Word

**Cocok untuk:**
- Memasukkan ke dokumen Word/PDF skripsi
- Presentasi yang jelas dan tidak terlalu kompleks
- Ukuran diagram yang pas untuk halaman A4

---

### 3. [Flowchart Akses Role dan Fitur - VERSI LENGKAP](./01-flowchart-akses-role.md)
**Isi Dokumen:**
- Flowchart sangat detail dengan semua percabangan
- Alur lengkap dari login sampai logout
- Semua menu dan sub-menu untuk setiap role

**Cocok untuk:**
- Referensi lengkap (opsional)
- Dokumentasi teknis detail

**⚠️ Catatan:** Flowchart ini sangat panjang dan detail, lebih cocok untuk dokumentasi teknis daripada presentasi skripsi.

---

### 5. [Sequence Diagram - VERSI SIMPLE](./02-sequence-diagram-simplified.md) ⭐ **RECOMMENDED untuk Word/PDF**
**Isi Dokumen:**
- 6 Sequence Diagram yang disederhanakan (4-5 komponen saja):
  1. Sequence Diagram: Login
  2. Sequence Diagram: Check-in Presensi
  3. Sequence Diagram: Check-out Presensi
  4. Sequence Diagram: Tambah Guru Baru
  5. Sequence Diagram: Perhitungan Gaji
  6. Sequence Diagram: Export Laporan
- Fokus pada alur utama tanpa detail teknis middleware
- Lebih ringkas dan mudah muat di Word

**Cocok untuk:**
- Skripsi/dokumen formal
- Presentasi
- Menjelaskan interaksi utama sistem

---

### 5b. [Sequence Diagram - VERSI LENGKAP](./02-sequence-diagram.md)
**Isi Dokumen:**
- 6 Sequence Diagram sangat detail (10+ komponen)
- Termasuk middleware, validation, session, event, mail
- Sangat teknis dan lengkap

**Cocok untuk:**
- Dokumentasi teknis
- Referensi developer

**⚠️ Catatan:** Versi ini sangat detail dan mungkin terlalu kompleks untuk skripsi. Gunakan versi simple untuk dokumen skripsi.

---

### 6. [Data Flow Diagram (DFD)](./03-data-flow-diagram.md)
**Isi Dokumen:**
- Context Diagram (DFD Level 0)
- DFD Level 1 - Dekomposisi Sistem
- DFD Level 2 - Proses Autentikasi & Autorisasi
- DFD Level 2 - Proses Manajemen Data Guru
- DFD Level 2 - Proses Presensi Harian
- DFD Level 2 - Proses Perhitungan Gaji
- DFD Level 2 - Proses Pelaporan & Export
- Kamus Data (Data Dictionary)

**Cocok untuk menjelaskan:**
- Aliran data dalam sistem
- Input dan output setiap proses
- Data store (database tables)
- Entitas eksternal (users)

---

### 7. [Class Diagram](./04-class-diagram.md)
**Isi Dokumen:**
- Class Diagram lengkap dengan semua atribut dan method
- Model Classes (User, Guru, Absensi, Gaji, Activity, Role, Permission)
- Controller Classes (Dashboard, Guru, Absensi, Auth, Profile)
- Service Classes (GuruService, AbsensiService, ActivityService, GajiService)
- Middleware Classes (RoleMiddleware, Authenticate, VerifyEmail)
- Request Classes (LoginRequest, ProfileUpdateRequest, dll)
- Penjelasan relasi antar class
- Design patterns yang digunakan
- Business rules dan constraints

**Cocok untuk menjelaskan:**
- Struktur kode aplikasi
- Object-oriented design
- Database schema dalam bentuk class
- Relasi antar entity

---

### 8. [Activity Diagram](./06-activity-diagram.md) ⭐ **BARU!**
**Isi Dokumen:**
- 7 Activity Diagram untuk proses utama (simple & mudah dipahami):
  1. Activity Diagram: Login
  2. Activity Diagram: Presensi Check-in (Guru)
  3. Activity Diagram: Presensi Check-out (Guru)
  4. Activity Diagram: Tambah Guru Baru (Admin)
  5. Activity Diagram: Perhitungan Gaji
  6. Activity Diagram: Lihat Laporan Bulanan
  7. Activity Diagram: Input Absensi Manual (Admin)
- Tabel ringkasan activity diagram
- Tips menggunakan di skripsi

**Cocok untuk menjelaskan:**
- Alur proses bisnis sistem
- Aktivitas yang dilakukan user
- Decision point dan exception handling
- Proses dari awal hingga akhir

---

### 9. [Entity Relationship Diagram (ERD)](./05-entity-relationship-diagram.md)
**Isi Dokumen:**
- ERD Notasi Chen
- ERD Notasi Crow's Foot (dengan detail kolom)
- Tabel Pivot untuk Many-to-Many relations
- Primary Keys, Foreign Keys, dan Unique Constraints
- Indexes untuk performa
- Kardinalitas dan penjelasan relasi
- Enum values dan data types
- Normalisasi database (1NF, 2NF, 3NF)
- Security considerations (soft deletes, password hashing)

**Cocok untuk menjelaskan:**
- Struktur database
- Relasi antar tabel
- Constraint dan data integrity
- Database design dan normalisasi

---

## 🎯 Sistem E-Presensi - Overview

### Deskripsi Sistem
Sistem Informasi E-Presensi adalah aplikasi web berbasis Laravel 11 untuk manajemen presensi guru di sekolah. Sistem ini memiliki fitur:
- Presensi harian dengan check-in/check-out
- Deteksi keterlambatan otomatis
- Perhitungan gaji dengan sistem potongan
- Manajemen data guru
- Laporan dan export (PDF/Excel)
- Multi-role access (Admin, Kepala Sekolah, Guru)

### Teknologi
- **Framework:** Laravel 11
- **Database:** MySQL
- **Frontend:** Livewire + Flowbite + Tailwind CSS
- **Authentication:** Laravel Breeze
- **Authorization:** Spatie Laravel Permission
- **PDF Export:** DomPDF
- **Excel Export:** Maatwebsite Excel

### Role dan Akses

#### 1. Administrator
**Hak Akses:** Full Control (CRUD)
- Manajemen data guru
- Input/edit absensi manual
- Lihat semua laporan
- Export data
- Dashboard statistik lengkap

#### 2. Kepala Sekolah
**Hak Akses:** Read-Only & Export
- Lihat data guru
- Lihat laporan absensi
- Export laporan
- Dashboard monitoring
- **TIDAK BISA:** Edit, hapus, atau tambah data

#### 3. Guru
**Hak Akses:** Self-Service
- Check-in/check-out presensi
- Lihat riwayat absensi pribadi
- Lihat detail gaji pribadi
- Edit profil pribadi
- **TIDAK BISA:** Akses data guru lain

---

## 📊 Entity Relationship

### Model Utama dan Relasi

```
User (1) ────── (0..1) Guru
                  │
                  ├──── (Many) Absensi
                  ├──── (Many) Gaji
                  └──── (Many) Activity

User (Many) ────── (Many) Role ────── (Many) Permission
```

### Database Tables
1. **users** - Akun login
2. **gurus** - Profil guru
3. **absensis** - Record presensi
4. **gajis** - Data penggajian
5. **activities** - Log aktivitas
6. **roles** - Master role
7. **permissions** - Master permission
8. **model_has_roles** - Pivot user-role

---

## 🔄 Proses Bisnis Utama

### 1. Presensi Check-in
```
Guru login → Dashboard → Check-in
  ↓
Sistem cek waktu:
  - < 08:00 → Status: Hadir (Rp 0)
  - ≥ 08:00 → Status: Terlambat (Potongan Rp 50.000)
  ↓
Simpan ke database → Log aktivitas → Redirect dashboard
```

### 2. Perhitungan Gaji
```
Request gaji → Ambil data guru (gaji_pokok, tunjangan)
  ↓
Ambil data absensi bulan terkait
  ↓
Hitung kehadiran per status
  ↓
Hitung potongan:
  - Terlambat: count × Rp 50.000
  - Alpha: count × Rp 200.000
  ↓
Gaji Bersih = Gaji Pokok + Tunjangan - Total Potongan
```

### 3. Tambah Guru (Admin)
```
Admin input data → Validasi
  ↓
BEGIN TRANSACTION
  ↓
Create User → Assign Role 'guru' → Create Profil Guru
  ↓
Send Email Verification (optional)
  ↓
COMMIT TRANSACTION → Redirect dengan pesan sukses
```

---

## 📁 Struktur File Dokumentasi

```
docs/
├── README.md                                  # File ini (Mulai di sini!)
│
├── 01a-flowchart-perbandingan-akses-role.md  # ⭐ Perbandingan akses role (1 diagram simple)
├── 01-flowchart-akses-role-simplified.md     # ⭐ Detail proses per role (7 diagram)
├── 01-flowchart-akses-role.md                # Flowchart lengkap (sangat detail)
│
├── 02-sequence-diagram-simplified.md         # ⭐ Sequence diagram SIMPLE (6 proses)
├── 02-sequence-diagram.md                    # Sequence diagram LENGKAP (detail teknis)
│
├── 03-data-flow-diagram.md                   # DFD Level 0, 1, 2 + Kamus Data
├── 04-class-diagram.md                       # Class diagram lengkap
├── 05-entity-relationship-diagram.md         # ERD dengan berbagai notasi
└── 06-activity-diagram.md                    # ⭐ Activity diagram (7 proses)
```

---

## 🎓 Panduan Penggunaan untuk Skripsi

### 1. BAB II - Landasan Teori
Gunakan untuk menjelaskan:
- Sistem Informasi berbasis web
- Framework Laravel dan arsitekturnya
- Role-Based Access Control (RBAC)
- MVC Pattern

### 2. BAB III - Analisis dan Perancangan

#### 3.1 Analisis Sistem Berjalan
- Gunakan **Context Diagram** dari `03-data-flow-diagram.md`
- Jelaskan entitas eksternal dan interaksinya

#### 3.2 Analisis Sistem Usulan
- Gunakan **DFD Level 1** untuk gambaran proses utama
- Gunakan **Flowchart** dari `01-flowchart-akses-role.md` untuk flow bisnis

#### 3.3 Perancangan Database
- Gunakan **ERD** dari `05-entity-relationship-diagram.md`
- Gunakan **Class Diagram** dari `04-class-diagram.md` sebagai pelengkap
- Jelaskan atribut, relasi, constraint, dan normalisasi

#### 3.4 Perancangan Proses
- Gunakan **DFD Level 2** untuk detail setiap proses
- Gunakan **Sequence Diagram** untuk timeline interaksi
- Sertakan kamus data untuk dokumentasi field

#### 3.5 Perancangan Antarmuka
- Screenshot dari aplikasi (capture sendiri)
- Wireframe (bisa buat dari screenshot)

### 3. BAB IV - Implementasi dan Pengujian

#### 4.1 Implementasi Sistem
- Jelaskan teknologi yang digunakan
- Struktur folder Laravel
- Penjelasan kode penting (Controller, Service, Model)

#### 4.2 Pengujian Sistem
- Unit testing (PHPUnit)
- Integration testing
- User Acceptance Testing (UAT)

---

## 🛠️ Cara Render Diagram Mermaid

### Di GitHub
- File `.md` dengan Mermaid otomatis di-render di GitHub
- Cukup buka file di GitHub repository

### Di VS Code
1. Install extension: "Markdown Preview Mermaid Support"
2. Buka file `.md`
3. Klik "Open Preview" (Ctrl+Shift+V)

### Di Aplikasi Lain
- **Draw.io**: Import sebagai Mermaid
- **Typora**: Native support Mermaid
- **Notion**: Copy paste code Mermaid
- **Online**: https://mermaid.live/

### Export ke Gambar (PNG/SVG)
1. Buka https://mermaid.live/
2. Copy paste kode Mermaid
3. Klik "Actions" → "PNG" atau "SVG"
4. Download untuk dimasukkan ke dokumen Word/PDF

---

## 📝 Kamus Istilah

| Istilah | Penjelasan |
|---------|-----------|
| **NIP** | Nomor Induk Pegawai - ID unique untuk guru |
| **Check-in** | Presensi masuk/datang |
| **Check-out** | Presensi pulang |
| **PNS** | Pegawai Negeri Sipil |
| **Honorer** | Pegawai Honorer/Non-PNS |
| **Gaji Pokok** | Gaji dasar bulanan |
| **Tunjangan** | Tambahan gaji (tunjangan profesi, dll) |
| **Potongan** | Pengurangan gaji karena terlambat/alpha |
| **Gaji Bersih** | Gaji yang diterima (pokok + tunjangan - potongan) |
| **RBAC** | Role-Based Access Control - Sistem otorisasi berbasis role |
| **CRUD** | Create, Read, Update, Delete |
| **Soft Delete** | Hapus data secara logical (tidak benar-benar dihapus dari database) |
| **Eloquent** | ORM (Object-Relational Mapping) Laravel |
| **Middleware** | Lapisan filter request HTTP |
| **Service Layer** | Lapisan business logic terpisah dari controller |
| **DTO** | Data Transfer Object |
| **Migration** | Script perubahan database schema |
| **Seeder** | Script untuk insert data awal |
| **Factory** | Generator data dummy untuk testing |

---

## ✅ Checklist untuk Skripsi

### Dokumentasi yang Sudah Ada
- [x] Flowchart Akses Role dan Fitur
- [x] Sequence Diagram (6 proses utama)
- [x] Activity Diagram (7 proses utama)
- [x] Data Flow Diagram (Context, Level 1, Level 2)
- [x] Class Diagram lengkap
- [x] Entity Relationship Diagram (ERD)
- [x] Kamus Data
- [x] Penjelasan Business Rules
- [x] Normalisasi Database (1NF, 2NF, 3NF)

### Yang Perlu Ditambahkan (Optional)
- [ ] Use Case Diagram - Bisa dibuat dari Flowchart
- [ ] Wireframe / Mockup UI
- [ ] Screenshot aplikasi
- [ ] Test Case Documentation
- [ ] User Manual

---

## 📞 Informasi Tambahan

### Struktur Aplikasi
```
e-presensi/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # HTTP Controllers
│   │   ├── Middleware/       # Custom Middleware
│   │   └── Requests/         # Form Requests
│   ├── Models/               # Eloquent Models
│   └── Services/             # Business Logic Services
├── database/
│   ├── migrations/           # Database Schema
│   └── seeders/              # Data Seeders
├── resources/
│   └── views/                # Blade Templates
├── routes/
│   ├── web.php               # Web Routes
│   └── auth.php              # Auth Routes
└── docs/                     # Dokumentasi (folder ini)
```

### Contact & Support
Jika ada pertanyaan tentang dokumentasi ini atau sistem E-Presensi, silakan:
1. Baca dokumentasi dengan teliti
2. Cek source code di folder terkait
3. Trace flow dari diagram yang tersedia

---

## 📄 Lisensi
Dokumentasi ini dibuat untuk keperluan akademis/skripsi.

---

**Dibuat dengan:** Claude Code & Mermaid
**Tanggal:** 2025-11-09
**Untuk:** Keperluan Skripsi - Sistem Informasi E-Presensi
**Author:** Rizky Adi Ryanto

---

## 🎯 Tips Menggunakan Dokumentasi Ini

1. **Mulai dari Context Diagram** (DFD Level 0) untuk gambaran besar
2. **Lanjut ke Flowchart** untuk memahami flow user
3. **Pelajari DFD Level 1 & 2** untuk detail proses
4. **Pahami Class Diagram** untuk struktur kode
5. **Gunakan Sequence Diagram** untuk menjelaskan interaksi
6. **Referensi Kamus Data** untuk detail field

### Urutan Penjelasan di Skripsi
```
BAB III - ANALISIS DAN PERANCANGAN

3.1 Analisis Kebutuhan
    → Context Diagram (DFD Level 0)
    → Flowchart Akses Role

3.2 Perancangan Proses
    → DFD Level 1 (Proses Utama)
    → DFD Level 2 (Detail Proses)
    → Sequence Diagram (Timeline)

3.3 Perancangan Database
    → Class Diagram (sebagai ERD)
    → Kamus Data

3.4 Perancangan Antarmuka
    → Screenshot aplikasi
    → Wireframe
```

**Semoga sukses dengan skripsinya! 🎓**
