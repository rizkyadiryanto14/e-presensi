# Sequence Diagram Sistem E-Presensi (Versi Simple)

Dokumen ini berisi Sequence Diagram yang disederhanakan untuk sistem E-Presensi, cocok untuk dimasukkan ke dokumen Word/PDF skripsi.

---

## 1. Sequence Diagram: Login (Simple)

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant Controller
    participant Auth
    participant Database

    User->>Browser: Input email & password
    Browser->>Controller: POST /login
    Controller->>Auth: Validasi credentials
    Auth->>Database: Query user

    alt User tidak ditemukan
        Database-->>Auth: Not found
        Auth-->>Controller: Login gagal
        Controller-->>Browser: Error message
        Browser-->>User: Tampilkan error
    else User ditemukan
        Database-->>Auth: User data
        Auth->>Auth: Verify password

        alt Password salah
            Auth-->>Controller: Login gagal
            Controller-->>Browser: Error message
            Browser-->>User: Tampilkan error
        else Password benar
            Auth-->>Controller: Login sukses
            Controller->>Database: Cek role user
            Database-->>Controller: Role data
            Controller-->>Browser: Redirect ke dashboard
            Browser-->>User: Tampilkan dashboard
        end
    end
```

**Penjelasan:**
- User input email dan password di browser
- Browser kirim request ke Controller
- Controller minta Auth untuk validasi
- Auth query database untuk cek user
- Jika user tidak ada atau password salah → tampilkan error
- Jika berhasil → cek role dan redirect ke dashboard sesuai role

---

## 2. Sequence Diagram: Check-in Presensi (Simple)

```mermaid
sequenceDiagram
    actor Guru
    participant Browser
    participant Controller
    participant Service
    participant Database

    Guru->>Browser: Klik tombol Check-in
    Browser->>Controller: POST /absensi/check-in
    Controller->>Service: hasCheckedInToday(guru_id)
    Service->>Database: Query absensi hari ini

    alt Sudah check-in
        Database-->>Service: Data ditemukan
        Service-->>Controller: true
        Controller-->>Browser: Error: Sudah check-in
        Browser-->>Guru: Tampilkan pesan error
    else Belum check-in
        Database-->>Service: No data
        Service-->>Controller: false

        Controller->>Controller: Get waktu sekarang
        Controller->>Controller: Tentukan status<br/>(hadir/terlambat)

        Controller->>Service: recordCheckIn(guru_id, status)
        Service->>Database: INSERT absensi
        Database-->>Service: Success

        Service->>Database: INSERT activity log
        Database-->>Service: Success

        Service-->>Controller: Check-in berhasil
        Controller-->>Browser: Success message
        Browser-->>Guru: Tampilkan pesan sukses
    end
```

**Penjelasan:**
- Guru klik tombol check-in
- Sistem cek apakah sudah check-in hari ini
- Jika sudah → tampilkan error
- Jika belum → ambil waktu sekarang, tentukan status (hadir jika < 08:00, terlambat jika >= 08:00)
- Simpan ke database dan log aktivitas
- Tampilkan pesan sukses

---

## 3. Sequence Diagram: Tambah Guru Baru (Simple)

```mermaid
sequenceDiagram
    actor Admin
    participant Browser
    participant Controller
    participant Service
    participant Database

    Admin->>Browser: Isi form guru baru
    Browser->>Controller: POST /admin/guru
    Controller->>Controller: Validasi input

    alt Validasi gagal
        Controller-->>Browser: Error validasi
        Browser-->>Admin: Tampilkan error
    else Validasi berhasil
        Controller->>Service: createGuru(data)

        Service->>Database: BEGIN TRANSACTION

        Service->>Database: INSERT users
        Database-->>Service: User created

        Service->>Database: INSERT model_has_roles<br/>(assign role 'guru')
        Database-->>Service: Role assigned

        Service->>Database: INSERT gurus
        Database-->>Service: Guru created

        Service->>Database: COMMIT TRANSACTION

        Service-->>Controller: Guru berhasil dibuat
        Controller-->>Browser: Redirect + success message
        Browser-->>Admin: Tampilkan daftar guru
    end
```

**Penjelasan:**
- Admin isi form data guru baru dan submit
- Controller validasi input (NIP unique, email unique, dll)
- Jika gagal → tampilkan error
- Jika berhasil → Service mulai database transaction:
  1. Buat user account
  2. Assign role 'guru'
  3. Buat profil guru
- Commit transaction
- Redirect ke daftar guru dengan pesan sukses

---

## 4. Sequence Diagram: Perhitungan Gaji (Simple)

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant Controller
    participant Service
    participant Database

    User->>Browser: Pilih bulan & tahun
    Browser->>Controller: GET /gaji?month=2025-05

    Controller->>Service: calculateSalary(guru_id, month)

    Service->>Database: Get data guru<br/>(gaji_pokok, tunjangan)
    Database-->>Service: Guru data

    Service->>Database: Get absensi bulan ini
    Database-->>Service: Absensi data

    Service->>Service: Hitung per status:<br/>- Hadir<br/>- Terlambat<br/>- Alpha

    Service->>Service: Hitung potongan:<br/>Terlambat × 50.000<br/>Alpha × 200.000

    Service->>Service: Hitung gaji bersih:<br/>Pokok + Tunjangan - Potongan

    Service-->>Controller: Data gaji lengkap
    Controller-->>Browser: View gaji
    Browser-->>User: Tampilkan detail gaji
```

**Penjelasan:**
- User pilih bulan dan tahun untuk melihat gaji
- Controller minta Service untuk hitung gaji
- Service ambil data gaji pokok dan tunjangan dari database
- Service ambil data absensi bulan tersebut
- Hitung jumlah per status
- Hitung total potongan
- Hitung gaji bersih
- Tampilkan hasil ke user

---

## 5. Sequence Diagram: Export Laporan (Simple)

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant Controller
    participant Service
    participant Database
    participant PDF

    User->>Browser: Pilih bulan & format (PDF)
    Browser->>Controller: GET /absensi/export?month=2025-05&format=pdf

    Controller->>Service: getAllTeacherSummary(month)

    Service->>Database: Get all guru
    Database-->>Service: List guru

    loop Untuk setiap guru
        Service->>Database: Get absensi guru
        Database-->>Service: Absensi data
        Service->>Service: Hitung ringkasan
    end

    Service-->>Controller: Data summary semua guru

    Controller->>PDF: Generate PDF
    PDF->>PDF: Render data ke PDF
    PDF-->>Controller: PDF binary

    Controller-->>Browser: Download PDF file
    Browser-->>User: File PDF ter-download
```

**Penjelasan:**
- User pilih bulan dan format export (PDF atau Excel)
- Controller minta Service untuk ambil summary semua guru
- Service loop untuk setiap guru:
  - Ambil data absensi
  - Hitung ringkasan (hadir, terlambat, alpha, gaji)
- Service return data lengkap ke Controller
- Controller generate PDF
- Return file PDF untuk di-download

---

## 6. Sequence Diagram: Check-out Presensi (Simple)

```mermaid
sequenceDiagram
    actor Guru
    participant Browser
    participant Controller
    participant Service
    participant Database

    Guru->>Browser: Klik tombol Check-out
    Browser->>Controller: POST /absensi/check-out

    Controller->>Service: Cek sudah check-in?
    Service->>Database: Query absensi hari ini

    alt Belum check-in
        Database-->>Service: No data
        Service-->>Controller: false
        Controller-->>Browser: Error: Belum check-in
        Browser-->>Guru: Tampilkan error
    else Sudah check-in
        Database-->>Service: Absensi data
        Service->>Service: Cek sudah check-out?

        alt Sudah check-out
            Service-->>Controller: Error
            Controller-->>Browser: Error: Sudah check-out
            Browser-->>Guru: Tampilkan error
        else Belum check-out
            Controller->>Controller: Get waktu sekarang

            Controller->>Service: recordCheckOut(guru_id)
            Service->>Database: UPDATE waktu_pulang
            Database-->>Service: Success

            Service->>Database: INSERT activity log
            Database-->>Service: Success

            Service-->>Controller: Check-out berhasil
            Controller-->>Browser: Success message
            Browser-->>Guru: Tampilkan pesan sukses
        end
    end
```

**Penjelasan:**
- Guru klik tombol check-out
- Sistem cek apakah sudah check-in (jika belum → error)
- Sistem cek apakah sudah check-out (jika sudah → error)
- Jika lolos validasi, ambil waktu sekarang
- Update database dengan waktu pulang
- Log aktivitas
- Tampilkan pesan sukses

---

## 7. Sequence Diagram: Logout (Simple)

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant Controller
    participant Auth
    participant Database

    User->>Browser: Klik tombol Logout
    Browser->>Controller: POST /logout

    Controller->>Auth: Get authenticated user
    Auth-->>Controller: User data

    Controller->>Database: Log aktivitas logout
    Database-->>Controller: Success

    Controller->>Auth: Logout & destroy session
    Auth->>Auth: Clear authentication<br/>& session data
    Auth-->>Controller: Logged out

    Controller-->>Browser: Redirect ke /login
    Browser-->>User: Halaman login +<br/>pesan sukses
```

**Penjelasan:**
- User (semua role) klik tombol logout
- Sistem log aktivitas logout ke database
- Sistem destroy session dan clear authentication
- Redirect ke halaman login dengan pesan sukses

---

## 8. Sequence Diagram: Lihat Gaji (Simple)

```mermaid
sequenceDiagram
    actor Guru
    participant Browser
    participant Controller
    participant Database

    Guru->>Browser: Klik menu "Gaji Saya"<br/>Pilih bulan
    Browser->>Controller: GET /guru/gaji?month=2025-05

    Controller->>Database: Get data guru & absensi
    Database-->>Controller: Data gaji & kehadiran

    Controller->>Controller: Hitung gaji:<br/>Pokok + Tunjangan - Potongan

    Controller-->>Browser: View detail gaji
    Browser-->>Guru: Tampilkan detail gaji
```

**Penjelasan:**
- Guru pilih bulan untuk melihat gaji
- Sistem ambil data gaji dan absensi dari database
- Sistem hitung gaji bersih (Pokok + Tunjangan - Potongan)
- Tampilkan detail gaji lengkap

---

## 9. Sequence Diagram: Lihat Absensi (Simple)

```mermaid
sequenceDiagram
    actor Guru
    participant Browser
    participant Controller
    participant Database

    Guru->>Browser: Klik menu "Riwayat Absensi"<br/>Pilih bulan
    Browser->>Controller: GET /guru/absensi?month=2025-05

    Controller->>Database: Query absensi guru<br/>untuk bulan tersebut
    Database-->>Controller: Data absensi

    Controller->>Controller: Hitung ringkasan:<br/>Total per status & persentase

    Controller-->>Browser: View riwayat absensi
    Browser-->>Guru: Tampilkan tabel absensi<br/>+ ringkasan
```

**Penjelasan:**
- Guru pilih bulan untuk melihat riwayat absensi
- Sistem query data absensi dari database
- Sistem hitung ringkasan (total per status dan persentase)
- Tampilkan tabel absensi dengan ringkasan kehadiran

---

## 10. Sequence Diagram: Update Data Guru (Simple)

```mermaid
sequenceDiagram
    actor Admin
    participant Browser
    participant Controller
    participant Service
    participant Database

    Admin->>Browser: Klik "Edit" pada data guru
    Browser->>Controller: GET /admin/guru/{id}/edit

    Controller->>Database: Get guru by ID
    Database-->>Controller: Guru data

    alt Guru tidak ditemukan
        Controller-->>Browser: Error 404
        Browser-->>Admin: Guru tidak ditemukan
    else Guru ditemukan
        Controller-->>Browser: Form edit dengan data
        Browser-->>Admin: Tampilkan form terisi

        Admin->>Browser: Edit data & submit
        Browser->>Controller: PUT /admin/guru/{id}

        Controller->>Controller: Validasi input

        alt Validasi gagal
            Controller-->>Browser: Error validasi
            Browser-->>Admin: Tampilkan error
        else Validasi berhasil
            Controller->>Service: updateGuru(guru_id, data)

            Service->>Database: BEGIN TRANSACTION

            Service->>Database: UPDATE users<br/>(name, email, password)
            Database-->>Service: User updated

            Service->>Database: UPDATE gurus<br/>(nip, nama, jabatan, gaji, dll)
            Database-->>Service: Guru updated

            Service->>Database: INSERT activity log
            Database-->>Service: Activity logged

            Service->>Database: COMMIT TRANSACTION

            Service-->>Controller: Update berhasil
            Controller-->>Browser: Redirect + success message
            Browser-->>Admin: Daftar guru +<br/>pesan sukses
        end
    end
```

**Penjelasan:**
- Admin klik tombol "Edit" pada data guru
- Sistem ambil data guru yang akan diedit
- Jika tidak ditemukan, tampilkan error 404
- Jika ditemukan, tampilkan form dengan data existing
- Admin edit data (semua field atau sebagian) dan submit
- Sistem validasi input (NIP unique, email unique, dll)
- Jika berhasil, mulai transaction:
  1. Update user account (name, email, password jika diubah)
  2. Update profil guru (NIP, jabatan, gaji, dll)
  3. Log aktivitas admin
- Commit transaction dan redirect dengan pesan sukses

---

## Perbandingan Versi Lengkap vs Simple

| Aspek | Versi Lengkap | Versi Simple |
|-------|---------------|--------------|
| **Participants** | 10+ komponen | 4-5 komponen utama |
| **Detail** | Sangat detail (middleware, validation, dll) | Fokus alur utama |
| **Ukuran** | Sangat tinggi/panjang | Lebih pendek |
| **Cocok untuk** | Dokumentasi teknis lengkap | Skripsi/presentasi |
| **Readability** | Kompleks | Mudah dipahami |

---

## Komponen yang Disederhanakan

### Yang Dihilangkan di Versi Simple:
- ❌ Middleware (Auth, Role, VerifyEmail)
- ❌ FormRequest validation detail
- ❌ Session management
- ❌ Event dispatcher
- ❌ Mail queue
- ❌ Multiple conditional branches yang terlalu detail

### Yang Dipertahankan:
- ✅ Actor (User/Admin/Guru)
- ✅ Browser/Frontend
- ✅ Controller
- ✅ Service (business logic)
- ✅ Database
- ✅ Alur utama proses
- ✅ Decision point penting

---

## Tips Export ke Word

### 1. Gunakan Width yang Tepat
```
Width: 1400-1600px (untuk versi simple)
Height: Auto
```

### 2. Layout di Word
- Orientation: **Portrait** untuk diagram vertikal
- Text wrapping: **In line with text**
- Size: Maksimal 15cm width (jangan terlalu kecil)

### 3. Caption Format
```
Gambar X.X. Sequence Diagram [Nama Proses]

Contoh:
Gambar 3.5. Sequence Diagram Proses Login
Gambar 3.6. Sequence Diagram Proses Check-in Presensi
```

### 4. Penjelasan
Setelah gambar, beri penjelasan 1-2 paragraf:
- Jelaskan participants yang terlibat
- Jelaskan alur komunikasi
- Jelaskan decision point (alt/else)

---

## Rekomendasi untuk Skripsi

### Pilih 3-4 Sequence Diagram Paling Penting:

1. **Sequence Diagram Login** ⭐⭐⭐ (Wajib)
   - Menunjukkan autentikasi sistem
   - Menunjukkan role-based redirect

2. **Sequence Diagram Check-in** ⭐⭐⭐ (Sangat Penting)
   - Proses inti sistem
   - Menunjukkan business logic (deteksi terlambat)

3. **Sequence Diagram Tambah Guru** ⭐⭐ (Penting)
   - Contoh proses CRUD
   - Menunjukkan database transaction

4. **Sequence Diagram Perhitungan Gaji** ⭐⭐ (Penting)
   - Menunjukkan business logic kompleks
   - Menunjukkan perhitungan

5. **Sequence Diagram Check-out** ⭐ (Opsional)
   - Mirip dengan check-in, bisa diskip

6. **Sequence Diagram Export** ⭐ (Opsional)
   - Menunjukkan fitur export
   - Bisa diskip jika sudah banyak diagram

---

## Struktur BAB III (Dengan Sequence Diagram)

### 3.1 Perancangan Hak Akses
- Gambar 3.1: Flowchart Perbandingan Akses Role

### 3.2 Perancangan Proses Bisnis
- Gambar 3.2: Activity Diagram Login
- Gambar 3.3: Activity Diagram Check-in

### 3.3 Perancangan Interaksi Sistem ← **Gunakan Sequence Diagram Simple di sini!**
- **Gambar 3.4**: Sequence Diagram Login ← **File ini (versi simple)**
- **Gambar 3.5**: Sequence Diagram Check-in ← **File ini (versi simple)**
- **Gambar 3.6**: Sequence Diagram Tambah Guru ← **File ini (versi simple)**
- **Gambar 3.7**: Sequence Diagram Perhitungan Gaji ← **File ini (versi simple)**

### 3.4 Perancangan Aliran Data
- Gambar 3.8: Context Diagram (DFD Level 0)
- Gambar 3.9: DFD Level 1

### 3.5 Perancangan Database
- Gambar 3.10: ERD

---

## Cara Export dari Mermaid Live

1. **Buka**: https://mermaid.live/
2. **Copy-paste** kode diagram dari file ini
3. **Atur Configuration**:
   ```
   Width: 1400px (untuk versi simple sudah cukup)
   Scale: 1.5 atau 2
   ```
4. **Export**: Actions → PNG Image
5. **Download** dan insert ke Word

---

## Penjelasan Notasi Sequence Diagram

### Simbol:
- `actor User` = Aktor (manusia)
- `participant Browser` = Komponen sistem
- `->>` = Synchronous message (request)
- `-->>` = Response message
- `alt/else/end` = Conditional (percabangan)
- `loop` = Perulangan

### Arti Panah:
- **Solid arrow** (`->>`) = Request/call
- **Dashed arrow** (`-->>`) = Return/response

---

## Kesimpulan

Sequence Diagram versi simple ini:
- ✅ Lebih ringkas dan mudah dipahami
- ✅ Fokus pada alur utama
- ✅ Cocok untuk dokumen skripsi
- ✅ Ukuran pas untuk halaman A4
- ✅ Tetap menunjukkan interaksi penting antar komponen

Gunakan versi ini untuk skripsi, dan versi lengkap (file `02-sequence-diagram.md`) sebagai referensi teknis jika diperlukan.
