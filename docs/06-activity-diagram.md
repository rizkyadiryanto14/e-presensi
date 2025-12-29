# Activity Diagram Sistem E-Presensi

Dokumen ini berisi Activity Diagram untuk proses-proses utama dalam sistem E-Presensi. Activity Diagram menunjukkan alur aktivitas dari awal hingga akhir.

---

## 1. Activity Diagram: Login

```mermaid
flowchart TD
    Start([Mulai]) --> InputCredentials[User Input<br/>Email & Password]
    InputCredentials --> Validate{Validasi<br/>Credentials}

    Validate -->|Invalid| ErrorMsg[Tampilkan<br/>Pesan Error]
    ErrorMsg --> InputCredentials

    Validate -->|Valid| CheckEmail{Email<br/>Terverifikasi?}

    CheckEmail -->|Belum| SendVerification[Kirim Email<br/>Verifikasi]
    SendVerification --> WaitVerification[Menunggu<br/>Verifikasi]
    WaitVerification --> End1([Selesai])

    CheckEmail -->|Sudah| CheckRole[Identifikasi<br/>Role User]
    CheckRole --> RedirectDashboard[Redirect ke<br/>Dashboard Sesuai Role]
    RedirectDashboard --> End2([Selesai])

    style Start fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style End1 fill:#868e96,stroke:#495057,stroke-width:3px,color:#fff
    style End2 fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style Validate fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style CheckEmail fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style ErrorMsg fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
```

**Penjelasan:**
- User memasukkan email dan password
- Sistem validasi credentials
- Jika gagal, tampilkan error dan ulangi
- Jika berhasil, cek apakah email sudah diverifikasi
- Jika belum verified, kirim email verifikasi
- Jika sudah verified, identifikasi role dan redirect ke dashboard

---

## 2. Activity Diagram: Presensi Check-in (Guru)

```mermaid
flowchart TD
    Start([Mulai]) --> GuruLogin[Guru Login<br/>ke Sistem]
    GuruLogin --> OpenPresensi[Buka Menu<br/>Presensi]
    OpenPresensi --> CheckStatus{Sudah<br/>Check-in<br/>Hari Ini?}

    CheckStatus -->|Ya| ShowError[Tampilkan Pesan:<br/>Sudah Check-in]
    ShowError --> End1([Selesai])

    CheckStatus -->|Belum| ClickCheckIn[Klik Tombol<br/>Check-in]
    ClickCheckIn --> GetTime[Sistem Ambil<br/>Waktu Sekarang]
    GetTime --> CompareTime{Waktu<br/>< 08:00?}

    CompareTime -->|Ya| SetHadir[Set Status:<br/>Hadir<br/>Potongan: Rp 0]
    CompareTime -->|Tidak| SetTerlambat[Set Status:<br/>Terlambat<br/>Potongan: Rp 50.000]

    SetHadir --> SaveDB[Simpan ke Database]
    SetTerlambat --> SaveDB

    SaveDB --> LogActivity[Log Aktivitas]
    LogActivity --> ShowSuccess[Tampilkan Pesan:<br/>Check-in Berhasil]
    ShowSuccess --> UpdateDashboard[Update Dashboard:<br/>Disable Check-in<br/>Enable Check-out]
    UpdateDashboard --> End2([Selesai])

    style Start fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style End1 fill:#868e96,stroke:#495057,stroke-width:3px,color:#fff
    style End2 fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style CheckStatus fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style CompareTime fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style SetHadir fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
    style SetTerlambat fill:#ff8787,stroke:#c92a2a,stroke-width:2px,color:#fff
    style ShowError fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    style ShowSuccess fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
```

**Penjelasan:**
- Guru login dan buka menu presensi
- Sistem cek apakah sudah check-in hari ini
- Jika sudah, tampilkan error
- Jika belum, guru klik tombol check-in
- Sistem ambil waktu sekarang
- Jika sebelum jam 08:00 → Status Hadir
- Jika jam 08:00 atau lebih → Status Terlambat dengan potongan Rp 50.000
- Simpan ke database dan log aktivitas
- Update dashboard

---

## 3. Activity Diagram: Presensi Check-out (Guru)

```mermaid
flowchart TD
    Start([Mulai]) --> GuruLogin[Guru Sudah Login<br/>& Sudah Check-in]
    GuruLogin --> ClickCheckOut[Klik Tombol<br/>Check-out]
    ClickCheckOut --> CheckIn{Sudah<br/>Check-in?}

    CheckIn -->|Belum| ShowError1[Tampilkan Error:<br/>Belum Check-in]
    ShowError1 --> End1([Selesai])

    CheckIn -->|Sudah| CheckOut{Sudah<br/>Check-out?}

    CheckOut -->|Sudah| ShowError2[Tampilkan Error:<br/>Sudah Check-out]
    ShowError2 --> End2([Selesai])

    CheckOut -->|Belum| GetTime[Sistem Ambil<br/>Waktu Sekarang]
    GetTime --> UpdateDB[Update Database:<br/>Simpan Waktu Pulang]
    UpdateDB --> LogActivity[Log Aktivitas<br/>Check-out]
    LogActivity --> ShowSuccess[Tampilkan Pesan:<br/>Check-out Berhasil]
    ShowSuccess --> UpdateDashboard[Update Dashboard:<br/>Disable Check-out]
    UpdateDashboard --> End3([Selesai])

    style Start fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style End1 fill:#868e96,stroke:#495057,stroke-width:3px,color:#fff
    style End2 fill:#868e96,stroke:#495057,stroke-width:3px,color:#fff
    style End3 fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style CheckIn fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style CheckOut fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style ShowError1 fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    style ShowError2 fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    style ShowSuccess fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
```

**Penjelasan:**
- Guru yang sudah check-in klik tombol check-out
- Sistem validasi: apakah sudah check-in?
- Sistem validasi: apakah sudah check-out?
- Jika lolos validasi, ambil waktu sekarang
- Update database dengan waktu pulang
- Log aktivitas check-out
- Update dashboard

---

## 4. Activity Diagram: Tambah Guru Baru (Admin)

```mermaid
flowchart TD
    Start([Mulai]) --> AdminLogin[Admin Login]
    AdminLogin --> OpenMenu[Buka Menu<br/>Data Guru]
    OpenMenu --> ClickAdd[Klik Tambah<br/>Guru Baru]
    ClickAdd --> ShowForm[Tampilkan Form<br/>Input Data]
    ShowForm --> FillForm[Admin Isi Form:<br/>NIP, Nama, Email,<br/>Gaji, dll]
    FillForm --> Submit[Submit Form]
    Submit --> Validate{Validasi<br/>Data}

    Validate -->|Gagal| ShowError[Tampilkan Error:<br/>NIP/Email Duplikat<br/>atau Data Invalid]
    ShowError --> FillForm

    Validate -->|Berhasil| BeginTrx[BEGIN<br/>TRANSACTION]
    BeginTrx --> CreateUser[Buat User Account<br/>di Tabel Users]
    CreateUser --> AssignRole[Assign Role<br/>'Guru']
    AssignRole --> CreateGuru[Buat Profil Guru<br/>di Tabel Gurus]
    CreateGuru --> SendEmail{Kirim Email<br/>Verifikasi?}

    SendEmail -->|Ya| QueueEmail[Queue<br/>Email Verifikasi]
    SendEmail -->|Tidak| SkipEmail[Skip Email]

    QueueEmail --> Commit[COMMIT<br/>TRANSACTION]
    SkipEmail --> Commit

    Commit --> ShowSuccess[Tampilkan Pesan:<br/>Guru Berhasil<br/>Ditambahkan]
    ShowSuccess --> Redirect[Redirect ke<br/>Daftar Guru]
    Redirect --> End([Selesai])

    style Start fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style End fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style Validate fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style SendEmail fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style ShowError fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    style ShowSuccess fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
    style BeginTrx fill:#e599f7,stroke:#9c36b5,stroke-width:2px,color:#fff
    style Commit fill:#e599f7,stroke:#9c36b5,stroke-width:2px,color:#fff
```

**Penjelasan:**
- Admin login dan buka menu Data Guru
- Klik tambah guru baru, tampilkan form
- Admin isi semua field dan submit
- Sistem validasi data (NIP unique, email unique, dll)
- Jika gagal, tampilkan error dan kembali ke form
- Jika berhasil, mulai database transaction
- Buat user account → Assign role → Buat profil guru
- Opsional kirim email verifikasi
- Commit transaction
- Tampilkan pesan sukses dan redirect

---

## 5. Activity Diagram: Perhitungan Gaji

```mermaid
flowchart TD
    Start([Mulai]) --> UserRequest[User Request<br/>Lihat Gaji]
    UserRequest --> InputFilter[Input Filter:<br/>Bulan & Tahun]
    InputFilter --> GetGuru[Ambil Data Guru:<br/>Gaji Pokok<br/>& Tunjangan]
    GetGuru --> GetAbsen[Ambil Data Absensi<br/>Bulan Tersebut]
    GetAbsen --> CountStatus[Hitung Jumlah<br/>per Status:<br/>Hadir, Terlambat,<br/>Izin, Sakit, Alpha]
    CountStatus --> CalcPotongan[Hitung Potongan:<br/>Terlambat × Rp 50.000<br/>Alpha × Rp 200.000]
    CalcPotongan --> CalcTotal[Hitung Gaji Bersih:<br/>Gaji Pokok<br/>+ Tunjangan<br/>- Total Potongan]
    CalcTotal --> DisplayResult[Tampilkan Hasil:<br/>Detail Gaji]
    DisplayResult --> End([Selesai])

    style Start fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style End fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style CalcPotongan fill:#ff8787,stroke:#c92a2a,stroke-width:2px,color:#fff
    style CalcTotal fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
    style DisplayResult fill:#4dabf7,stroke:#1971c2,stroke-width:2px,color:#fff
```

**Penjelasan:**
- User (Guru/Admin/Kepsek) request lihat gaji
- Input filter bulan dan tahun
- Sistem ambil data gaji pokok dan tunjangan dari tabel Guru
- Sistem ambil data absensi bulan tersebut
- Hitung jumlah per status (hadir, terlambat, izin, sakit, alpha)
- Hitung total potongan: (Terlambat × 50.000) + (Alpha × 200.000)
- Hitung gaji bersih: Gaji Pokok + Tunjangan - Total Potongan
- Tampilkan hasil detail gaji

---

## 6. Activity Diagram: Lihat Laporan Bulanan (Admin/Kepsek)

```mermaid
flowchart TD
    Start([Mulai]) --> UserLogin[Admin/Kepsek<br/>Login]
    UserLogin --> OpenMenu[Buka Menu<br/>Laporan Bulanan]
    OpenMenu --> SelectMonth[Pilih Bulan<br/>& Tahun]
    SelectMonth --> GetAllGuru[Ambil Data<br/>Semua Guru]
    GetAllGuru --> LoopGuru{Untuk Setiap<br/>Guru}

    LoopGuru -->|Ada Guru| GetAbsen[Ambil Absensi<br/>Guru Tersebut]
    GetAbsen --> CalcSummary[Hitung Ringkasan:<br/>Hadir, Terlambat,<br/>Alpha, Potongan,<br/>Gaji Bersih]
    CalcSummary --> AddToList[Tambahkan ke<br/>List Hasil]
    AddToList --> LoopGuru

    LoopGuru -->|Tidak Ada| CalcStats[Hitung Statistik<br/>Keseluruhan:<br/>Total Guru,<br/>Total Kehadiran,<br/>Persentase]
    CalcStats --> DisplayResult[Tampilkan Laporan<br/>Bulanan]
    DisplayResult --> ExportOption{User Pilih<br/>Export?}

    ExportOption -->|Ya| SelectFormat{Pilih Format}
    SelectFormat -->|PDF| ExportPDF[Generate PDF]
    SelectFormat -->|Excel| ExportExcel[Generate Excel]

    ExportPDF --> Download[Download File]
    ExportExcel --> Download
    Download --> End1([Selesai])

    ExportOption -->|Tidak| End2([Selesai])

    style Start fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style End1 fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style End2 fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style LoopGuru fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style ExportOption fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style SelectFormat fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style DisplayResult fill:#4dabf7,stroke:#1971c2,stroke-width:2px,color:#fff
```

**Penjelasan:**
- Admin/Kepala Sekolah login dan buka menu Laporan Bulanan
- Pilih bulan dan tahun yang ingin dilihat
- Sistem ambil data semua guru
- Loop untuk setiap guru:
  - Ambil data absensi bulan tersebut
  - Hitung ringkasan (hadir, terlambat, alpha, potongan, gaji)
  - Tambahkan ke list hasil
- Setelah loop selesai, hitung statistik keseluruhan
- Tampilkan laporan bulanan
- User bisa pilih export ke PDF atau Excel (opsional)

---

## 7. Activity Diagram: Input Absensi Manual (Admin)

```mermaid
flowchart TD
    Start([Mulai]) --> AdminLogin[Admin Login]
    AdminLogin --> OpenMenu[Buka Menu<br/>Input Absensi Manual]
    OpenMenu --> SelectGuru[Pilih Guru]
    SelectGuru --> SelectDate[Pilih Tanggal]
    SelectDate --> CheckExist{Absensi<br/>Sudah Ada?}

    CheckExist -->|Ya| ShowConfirm{Konfirmasi<br/>Overwrite?}
    ShowConfirm -->|Tidak| End1([Batal])
    ShowConfirm -->|Ya| ShowForm

    CheckExist -->|Belum| ShowForm[Tampilkan Form<br/>Input Absensi]
    ShowForm --> SelectStatus[Pilih Status:<br/>Hadir, Terlambat,<br/>Izin, Sakit, Alpha]
    SelectStatus --> InputTime[Input Waktu<br/>Masuk & Pulang<br/>opsional]
    InputTime --> Submit[Submit Data]
    Submit --> SaveDB[Simpan/Update<br/>ke Database]
    SaveDB --> LogActivity[Log Aktivitas<br/>Admin Action]
    LogActivity --> ShowSuccess[Tampilkan Pesan:<br/>Absensi Berhasil<br/>Disimpan]
    ShowSuccess --> End2([Selesai])

    style Start fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style End1 fill:#868e96,stroke:#495057,stroke-width:3px,color:#fff
    style End2 fill:#51cf66,stroke:#2f9e44,stroke-width:3px,color:#fff
    style CheckExist fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style ShowConfirm fill:#cc5de8,stroke:#9c36b5,stroke-width:2px,color:#fff
    style ShowSuccess fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
```

**Penjelasan:**
- Admin login dan buka menu Input Absensi Manual
- Pilih guru yang akan diinput absensinya
- Pilih tanggal
- Cek apakah absensi untuk guru dan tanggal tersebut sudah ada
- Jika sudah ada, tanya konfirmasi untuk overwrite
- Jika belum ada atau user konfirmasi overwrite, tampilkan form
- Pilih status dan input waktu (opsional)
- Submit dan simpan ke database
- Log aktivitas admin
- Tampilkan pesan sukses

---

## Ringkasan Activity Diagram

| No | Proses | Actor | Kompleksitas |
|----|--------|-------|--------------|
| 1 | Login | Semua User | Sedang |
| 2 | Presensi Check-in | Guru | Sedang |
| 3 | Presensi Check-out | Guru | Simple |
| 4 | Tambah Guru Baru | Admin | Kompleks |
| 5 | Perhitungan Gaji | Semua User | Sedang |
| 6 | Lihat Laporan Bulanan | Admin/Kepsek | Kompleks |
| 7 | Input Absensi Manual | Admin | Sedang |

---

## Notasi Activity Diagram

### Simbol yang Digunakan:

| Simbol | Nama | Keterangan |
|--------|------|------------|
| `([...])` | Start/End Node | Awal dan akhir aktivitas |
| `[...]` | Activity | Aktivitas/proses yang dilakukan |
| `{...}` | Decision | Percabangan/keputusan |
| `-->` | Flow | Aliran aktivitas |

### Warna:

| Warna | Keterangan |
|-------|------------|
| 🟢 Hijau | Start/End/Success |
| 🟣 Ungu | Decision/Choice |
| 🔴 Merah | Error/Terlambat |
| 🔵 Biru | Display/Show Result |
| ⚪ Abu-abu | Cancel/Stop |

---

## Tips Menggunakan Activity Diagram di Skripsi

### Untuk BAB III - Perancangan Sistem:

1. **Sub-bab: Perancangan Proses Bisnis**
   - Gunakan activity diagram untuk menjelaskan alur proses
   - Setiap proses utama punya 1 activity diagram
   - Beri penjelasan di bawah diagram

2. **Format Caption:**
   ```
   Gambar 3.X. Activity Diagram [Nama Proses]
   Contoh: Gambar 3.5. Activity Diagram Proses Check-in Presensi
   ```

3. **Penjelasan:**
   - Jelaskan swimlane jika ada (actor yang terlibat)
   - Jelaskan decision point (percabangan)
   - Jelaskan exception handling (error flow)

4. **Rekomendasi Diagram untuk Skripsi:**
   - ⭐⭐⭐ Activity Diagram Login (wajib)
   - ⭐⭐⭐ Activity Diagram Check-in (proses utama)
   - ⭐⭐ Activity Diagram Tambah Guru (contoh CRUD)
   - ⭐⭐ Activity Diagram Perhitungan Gaji (business logic)
   - ⭐ Activity Diagram Laporan (opsional)

---

## Cara Export ke Word

1. Buka https://mermaid.live/
2. Copy-paste kode diagram yang ingin di-export
3. Atur ukuran:
   - Width: 1600-2000px
   - Scale: 2
4. Export ke PNG
5. Insert ke Word dengan caption

**Ukuran Optimal:**
- Width: 1800px untuk diagram vertikal
- Width: 2000px untuk diagram horizontal

---

## Perbedaan Activity Diagram vs Flowchart

| Aspek | Activity Diagram | Flowchart |
|-------|------------------|-----------|
| **Fokus** | Aktivitas/proses | Alur keputusan |
| **Swimlane** | Bisa pakai swimlane untuk actor | Biasanya tidak |
| **Notasi** | UML standard | Bebas |
| **Paralel** | Bisa menunjukkan proses paralel | Lebih linear |
| **Cocok untuk** | Proses bisnis kompleks | Algoritma/logika sederhana |

**Rekomendasi:**
- Gunakan **Activity Diagram** untuk menjelaskan **proses bisnis** (check-in, tambah guru, dll)
- Gunakan **Flowchart** untuk menjelaskan **hak akses role** dan **decision flow**

---

## Kesimpulan

Activity Diagram ini cocok digunakan di **BAB III - Analisis dan Perancangan Sistem** untuk:
- Menjelaskan alur proses bisnis sistem
- Menunjukkan aktivitas yang dilakukan user
- Menunjukkan decision point dan exception handling
- Melengkapi dokumentasi flowchart dan sequence diagram

Semua diagram sudah dibuat **simple** dan **mudah dipahami** agar cocok untuk dokumen skripsi.
