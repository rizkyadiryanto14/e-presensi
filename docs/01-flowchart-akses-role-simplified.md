# Flowchart Akses Role dan Fitur (Versi Sederhana)

Dokumen ini berisi flowchart yang disederhanakan agar mudah dimasukkan ke dalam dokumen Word/PDF.

---

## 1. Flowchart Login dan Autentikasi

```mermaid
flowchart TD
    Start([User Akses Sistem]) --> Login[Halaman Login]
    Login --> Input[Input Email & Password]
    Input --> Validate{Validasi<br/>Credentials}

    Validate -->|Gagal| Error[Tampilkan Error]
    Error --> Login

    Validate -->|Berhasil| CheckEmail{Email<br/>Terverifikasi?}

    CheckEmail -->|Belum| Verify[Kirim Email<br/>Verifikasi]
    Verify --> End1([User Verifikasi Email])

    CheckEmail -->|Sudah| CheckRole{Identifikasi<br/>Role User}

    CheckRole -->|Admin| DashAdmin([Dashboard Admin])
    CheckRole -->|Kepala Sekolah| DashKepsek([Dashboard Kepsek])
    CheckRole -->|Guru| DashGuru([Dashboard Guru])

    style Start fill:#51cf66,stroke:#2f9e44,color:#fff
    style DashAdmin fill:#ff6b6b,stroke:#c92a2a,color:#fff
    style DashKepsek fill:#ffd43b,stroke:#f59f00,color:#000
    style DashGuru fill:#4dabf7,stroke:#1971c2,color:#fff
    style Validate fill:#cc5de8,stroke:#9c36b5,color:#fff
    style CheckEmail fill:#cc5de8,stroke:#9c36b5,color:#fff
    style CheckRole fill:#cc5de8,stroke:#9c36b5,color:#fff
```

**Penjelasan:**
1. User mengakses sistem dan masuk ke halaman login
2. Input email dan password
3. Sistem validasi credentials dengan database
4. Jika gagal, tampilkan error dan kembali ke login
5. Jika berhasil, cek apakah email sudah diverifikasi
6. Jika belum verified, kirim email verifikasi
7. Jika sudah verified, cek role user dan redirect ke dashboard sesuai role

---

## 2. Flowchart Menu Administrator

```mermaid
flowchart TD
    Start([Dashboard Admin]) --> Menu{Pilih Menu}

    Menu --> Dash[Dashboard<br/>Lihat Statistik]
    Menu --> Guru[Data Guru]
    Menu --> Absensi[Data Absensi]
    Menu --> Laporan[Laporan]
    Menu --> Profile[Profil]
    Menu --> Logout[Logout]

    Guru --> GuruAction{Pilih Aksi}
    GuruAction --> GuruList[Lihat Daftar Guru]
    GuruAction --> GuruAdd[Tambah Guru Baru]
    GuruAction --> GuruEdit[Edit Data Guru]
    GuruAction --> GuruDelete[Hapus Guru]
    GuruAction --> GuruSalary[Lihat Gaji Guru]

    Absensi --> AbsenAction{Pilih Aksi}
    AbsenAction --> AbsenManual[Input Absensi Manual]
    AbsenAction --> AbsenDaily[Laporan Harian]
    AbsenAction --> AbsenMonthly[Laporan Bulanan]

    Laporan --> LaporanAction{Pilih Aksi}
    LaporanAction --> ExportPDF[Export ke PDF]
    LaporanAction --> ExportExcel[Export ke Excel]

    Dash --> End([Selesai])
    GuruList --> End
    GuruAdd --> End
    GuruEdit --> End
    GuruDelete --> End
    GuruSalary --> End
    AbsenManual --> End
    AbsenDaily --> End
    AbsenMonthly --> End
    ExportPDF --> End
    ExportExcel --> End
    Profile --> End
    Logout --> EndLogout([Kembali ke Login])

    style Start fill:#ff6b6b,stroke:#c92a2a,color:#fff
    style Menu fill:#cc5de8,stroke:#9c36b5,color:#fff
    style GuruAction fill:#cc5de8,stroke:#9c36b5,color:#fff
    style AbsenAction fill:#cc5de8,stroke:#9c36b5,color:#fff
    style LaporanAction fill:#cc5de8,stroke:#9c36b5,color:#fff
    style End fill:#51cf66,stroke:#2f9e44,color:#fff
    style EndLogout fill:#868e96,stroke:#495057,color:#fff
```

**Penjelasan:**
Administrator memiliki akses penuh ke semua menu:
- **Dashboard**: Melihat statistik sistem
- **Data Guru**: CRUD guru (Create, Read, Update, Delete)
- **Data Absensi**: Input manual dan lihat laporan
- **Laporan**: Export data ke PDF atau Excel
- **Profil**: Kelola profil admin
- **Logout**: Keluar dari sistem

---

## 3. Flowchart Menu Kepala Sekolah

```mermaid
flowchart TD
    Start([Dashboard<br/>Kepala Sekolah]) --> Menu{Pilih Menu}

    Menu --> Dash[Dashboard<br/>Lihat Statistik]
    Menu --> Guru[Data Guru<br/>Read Only]
    Menu --> Laporan[Laporan Absensi<br/>Read Only]
    Menu --> Profile[Profil]
    Menu --> Logout[Logout]

    Guru --> GuruAction{Pilih Aksi}
    GuruAction --> GuruList[Lihat Daftar Guru]
    GuruAction --> GuruDetail[Lihat Detail Guru]
    GuruAction --> GuruSalary[Lihat Gaji Guru]

    Laporan --> LaporanAction{Pilih Aksi}
    LaporanAction --> LaporanDaily[Laporan Harian]
    LaporanAction --> LaporanMonthly[Laporan Bulanan]
    LaporanAction --> ExportPDF[Export ke PDF]
    LaporanAction --> ExportExcel[Export ke Excel]

    Dash --> End([Selesai])
    GuruList --> End
    GuruDetail --> End
    GuruSalary --> End
    LaporanDaily --> End
    LaporanMonthly --> End
    ExportPDF --> End
    ExportExcel --> End
    Profile --> End
    Logout --> EndLogout([Kembali ke Login])

    style Start fill:#ffd43b,stroke:#f59f00,color:#000
    style Menu fill:#cc5de8,stroke:#9c36b5,color:#fff
    style GuruAction fill:#cc5de8,stroke:#9c36b5,color:#fff
    style LaporanAction fill:#cc5de8,stroke:#9c36b5,color:#fff
    style End fill:#51cf66,stroke:#2f9e44,color:#fff
    style EndLogout fill:#868e96,stroke:#495057,color:#fff
```

**Penjelasan:**
Kepala Sekolah memiliki akses **Read-Only** (hanya lihat):
- **Dashboard**: Monitoring statistik
- **Data Guru**: Lihat daftar dan detail guru (tidak bisa edit/hapus)
- **Laporan Absensi**: Lihat dan export laporan
- **Profil**: Kelola profil sendiri
- **Logout**: Keluar dari sistem

**Perbedaan dengan Admin:** Kepala Sekolah tidak bisa tambah, edit, atau hapus data.

---

## 4. Flowchart Menu Guru

```mermaid
flowchart TD
    Start([Dashboard Guru]) --> Menu{Pilih Menu}

    Menu --> Dash[Dashboard<br/>Lihat Status Personal]
    Menu --> Presensi[Presensi]
    Menu --> Riwayat[Riwayat Absensi]
    Menu --> Gaji[Gaji Saya]
    Menu --> Profile[Profil]
    Menu --> Logout[Logout]

    Presensi --> CheckStatus{Sudah<br/>Check-in?}
    CheckStatus -->|Belum| CheckIn[Tombol Check-in]
    CheckStatus -->|Sudah| CheckOut[Tombol Check-out]

    CheckIn --> ValidateTime{Waktu<br/>Check-in?}
    ValidateTime -->|Sebelum 08:00| StatusHadir[Status: Hadir<br/>Potongan: Rp 0]
    ValidateTime -->|Setelah 08:00| StatusTerlambat[Status: Terlambat<br/>Potongan: Rp 50.000]

    StatusHadir --> SaveCheckin[Simpan ke Database]
    StatusTerlambat --> SaveCheckin
    SaveCheckin --> SuccessCheckin[Berhasil Check-in]

    CheckOut --> SaveCheckout[Simpan Waktu Pulang]
    SaveCheckout --> SuccessCheckout[Berhasil Check-out]

    Riwayat --> ShowHistory[Tampilkan<br/>Riwayat Absensi Personal]

    Gaji --> ShowSalary[Tampilkan Detail Gaji:<br/>- Gaji Pokok<br/>- Tunjangan<br/>- Potongan<br/>- Gaji Bersih]

    Dash --> End([Selesai])
    SuccessCheckin --> End
    SuccessCheckout --> End
    ShowHistory --> End
    ShowSalary --> End
    Profile --> End
    Logout --> EndLogout([Kembali ke Login])

    style Start fill:#4dabf7,stroke:#1971c2,color:#fff
    style Menu fill:#cc5de8,stroke:#9c36b5,color:#fff
    style CheckStatus fill:#cc5de8,stroke:#9c36b5,color:#fff
    style ValidateTime fill:#cc5de8,stroke:#9c36b5,color:#fff
    style StatusHadir fill:#51cf66,stroke:#2f9e44,color:#fff
    style StatusTerlambat fill:#ff8787,stroke:#c92a2a,color:#fff
    style End fill:#51cf66,stroke:#2f9e44,color:#fff
    style EndLogout fill:#868e96,stroke:#495057,color:#fff
```

**Penjelasan:**
Guru memiliki akses **Self-Service** (data pribadi saja):
- **Dashboard**: Status presensi dan ringkasan personal
- **Presensi**:
  - Check-in: Rekam kehadiran (auto detect terlambat jika >= 08:00)
  - Check-out: Rekam waktu pulang
- **Riwayat Absensi**: Lihat riwayat presensi pribadi
- **Gaji Saya**: Lihat detail gaji pribadi dengan perhitungan potongan
- **Profil**: Kelola profil pribadi
- **Logout**: Keluar dari sistem

**Perbedaan dengan Admin/Kepsek:** Guru hanya bisa akses data diri sendiri.

---

## 5. Flowchart Proses Check-in Presensi (Detail)

```mermaid
flowchart TD
    Start([Guru Klik<br/>Presensi Masuk]) --> GetTime[Sistem Ambil<br/>Waktu Sekarang]

    GetTime --> CheckToday{Sudah Check-in<br/>Hari Ini?}

    CheckToday -->|Ya| ErrorDuplicate[Error:<br/>Sudah Check-in]
    ErrorDuplicate --> End1([Kembali ke Dashboard])

    CheckToday -->|Belum| CompareTime{Waktu Check-in}

    CompareTime -->|Sebelum 08:00| SetHadir[Set Status: Hadir<br/>Potongan: Rp 0]
    CompareTime -->|Jam 08:00 atau Setelah| SetTerlambat[Set Status: Terlambat<br/>Potongan: Rp 50.000]

    SetHadir --> SaveDB[Simpan ke Database:<br/>- guru_id<br/>- tanggal<br/>- status<br/>- waktu_masuk]
    SetTerlambat --> SaveDB

    SaveDB --> LogActivity[Log Aktivitas<br/>ke Tabel Activities]

    LogActivity --> Success[Tampilkan Pesan:<br/>Check-in Berhasil]

    Success --> UpdateDashboard[Update Dashboard:<br/>- Disable tombol Check-in<br/>- Enable tombol Check-out]

    UpdateDashboard --> End2([Selesai])

    style Start fill:#4dabf7,stroke:#1971c2,color:#fff
    style CheckToday fill:#cc5de8,stroke:#9c36b5,color:#fff
    style CompareTime fill:#cc5de8,stroke:#9c36b5,color:#fff
    style SetHadir fill:#51cf66,stroke:#2f9e44,color:#fff
    style SetTerlambat fill:#ff8787,stroke:#c92a2a,color:#fff
    style SaveDB fill:#e599f7,stroke:#9c36b5,color:#fff
    style Success fill:#51cf66,stroke:#2f9e44,color:#fff
    style End1 fill:#868e96,stroke:#495057,color:#fff
    style End2 fill:#51cf66,stroke:#2f9e44,color:#fff
```

**Penjelasan Proses Check-in:**
1. Guru klik tombol "Presensi Masuk"
2. Sistem ambil waktu sekarang dari server
3. Cek apakah guru sudah check-in hari ini
4. Jika sudah, tampilkan error (tidak bisa check-in 2x)
5. Jika belum, bandingkan waktu dengan batas jam 08:00
6. Jika sebelum 08:00 → Status "Hadir", potongan Rp 0
7. Jika jam 08:00 atau setelah → Status "Terlambat", potongan Rp 50.000
8. Simpan data ke database (guru_id, tanggal, status, waktu_masuk)
9. Log aktivitas ke tabel activities
10. Tampilkan pesan sukses
11. Update dashboard: disable check-in, enable check-out

---

## 6. Flowchart Perhitungan Gaji

```mermaid
flowchart TD
    Start([Request Lihat Gaji]) --> Input[Input Filter:<br/>Bulan & Tahun]

    Input --> GetGuru[Ambil Data Guru:<br/>- Gaji Pokok<br/>- Tunjangan]

    GetGuru --> GetAbsen[Ambil Data Absensi<br/>Bulan Tersebut]

    GetAbsen --> CountStatus[Hitung per Status:<br/>- Hadir<br/>- Terlambat<br/>- Izin<br/>- Sakit<br/>- Alpha]

    CountStatus --> CalcPotongan[Hitung Potongan:<br/>Terlambat × Rp 50.000<br/>Alpha × Rp 200.000]

    CalcPotongan --> CalcTotal[Hitung Gaji Bersih:<br/>Gaji Pokok<br/>+ Tunjangan<br/>- Total Potongan]

    CalcTotal --> Display[Tampilkan Detail:<br/>✓ Gaji Pokok: Rp X<br/>✓ Tunjangan: Rp Y<br/>✓ Potongan: Rp Z<br/>✓ Gaji Bersih: Rp Total]

    Display --> End([Selesai])

    style Start fill:#4dabf7,stroke:#1971c2,color:#fff
    style GetGuru fill:#e599f7,stroke:#9c36b5,color:#fff
    style GetAbsen fill:#e599f7,stroke:#9c36b5,color:#fff
    style CountStatus fill:#ffd43b,stroke:#f59f00,color:#000
    style CalcPotongan fill:#ff8787,stroke:#c92a2a,color:#fff
    style CalcTotal fill:#51cf66,stroke:#2f9e44,color:#fff
    style Display fill:#51cf66,stroke:#2f9e44,color:#fff
    style End fill:#51cf66,stroke:#2f9e44,color:#fff
```

**Penjelasan Perhitungan Gaji:**
1. User request lihat gaji dengan filter bulan & tahun
2. Sistem ambil data guru (gaji pokok & tunjangan)
3. Sistem ambil semua data absensi bulan tersebut
4. Hitung jumlah per status (hadir, terlambat, izin, sakit, alpha)
5. Hitung total potongan:
   - Terlambat: jumlah hari × Rp 50.000
   - Alpha: jumlah hari × Rp 200.000
6. Hitung gaji bersih = Gaji Pokok + Tunjangan - Total Potongan
7. Tampilkan detail lengkap ke user

**Contoh Perhitungan:**
```
Gaji Pokok: Rp 5.000.000
Tunjangan: Rp 1.000.000
──────────────────────
Subtotal: Rp 6.000.000

Potongan:
- Terlambat (3 hari): Rp 150.000
- Alpha (1 hari): Rp 200.000
──────────────────────
Total Potongan: Rp 350.000

GAJI BERSIH: Rp 5.650.000
```

---

## 7. Flowchart Tambah Guru Baru (Admin)

```mermaid
flowchart TD
    Start([Admin Klik<br/>Tambah Guru]) --> Form[Tampilkan Form:<br/>- NIP<br/>- Nama<br/>- Jabatan<br/>- Status Kepegawaian<br/>- Gaji Pokok<br/>- Tunjangan<br/>- Email<br/>- Password]

    Form --> Submit[Admin Submit Form]

    Submit --> Validate{Validasi Data}

    Validate -->|Gagal| ShowError[Tampilkan Error:<br/>- NIP duplikat?<br/>- Email duplikat?<br/>- Password < 8 karakter?]
    ShowError --> Form

    Validate -->|Berhasil| Transaction[BEGIN TRANSACTION]

    Transaction --> CreateUser[1. Buat User Account:<br/>- Simpan ke tabel users<br/>- Hash password]

    CreateUser --> AssignRole[2. Assign Role 'guru':<br/>- Insert ke model_has_roles]

    AssignRole --> CreateGuru[3. Buat Profil Guru:<br/>- Simpan ke tabel gurus<br/>- Link dengan user_id]

    CreateGuru --> SendEmail{Kirim Email<br/>Verifikasi?}

    SendEmail -->|Ya| QueueEmail[Queue email verifikasi]
    SendEmail -->|Tidak| SkipEmail[Skip email]

    QueueEmail --> Commit[COMMIT TRANSACTION]
    SkipEmail --> Commit

    Commit --> Success[Tampilkan Pesan:<br/>Guru berhasil ditambahkan]

    Success --> Redirect[Redirect ke<br/>Daftar Guru]

    Redirect --> End([Selesai])

    style Start fill:#ff6b6b,stroke:#c92a2a,color:#fff
    style Validate fill:#cc5de8,stroke:#9c36b5,color:#fff
    style SendEmail fill:#cc5de8,stroke:#9c36b5,color:#fff
    style Transaction fill:#e599f7,stroke:#9c36b5,color:#fff
    style CreateUser fill:#ffd43b,stroke:#f59f00,color:#000
    style AssignRole fill:#ffd43b,stroke:#f59f00,color:#000
    style CreateGuru fill:#ffd43b,stroke:#f59f00,color:#000
    style Commit fill:#e599f7,stroke:#9c36b5,color:#fff
    style Success fill:#51cf66,stroke:#2f9e44,color:#fff
    style End fill:#51cf66,stroke:#2f9e44,color:#fff
```

**Penjelasan Proses Tambah Guru:**
1. Admin klik tombol "Tambah Guru"
2. Sistem tampilkan form input data guru
3. Admin isi semua field dan submit
4. Sistem validasi:
   - NIP belum terdaftar?
   - Email belum terdaftar?
   - Password minimal 8 karakter?
5. Jika gagal validasi, tampilkan error dan kembali ke form
6. Jika valid, mulai database transaction:
   - **Step 1**: Buat user account di tabel `users` (hash password)
   - **Step 2**: Assign role 'guru' menggunakan Spatie Permission
   - **Step 3**: Buat profil guru di tabel `gurus` dengan foreign key ke user
7. Opsional: Kirim email verifikasi (jika diaktifkan)
8. Commit transaction
9. Tampilkan pesan sukses
10. Redirect ke halaman daftar guru

**Catatan:** Menggunakan transaction untuk memastikan data konsisten. Jika salah satu step gagal, semua perubahan di-rollback.

---

## Ringkasan Akses per Role

| Fitur | Admin | Kepala Sekolah | Guru |
|-------|-------|----------------|------|
| **Dashboard** | ✅ Full Stats | ✅ Monitoring | ✅ Personal |
| **Data Guru - Lihat** | ✅ | ✅ | ❌ |
| **Data Guru - Tambah** | ✅ | ❌ | ❌ |
| **Data Guru - Edit** | ✅ | ❌ | ❌ |
| **Data Guru - Hapus** | ✅ | ❌ | ❌ |
| **Absensi - Check-in/out** | ❌ | ❌ | ✅ |
| **Absensi - Input Manual** | ✅ | ❌ | ❌ |
| **Laporan - Lihat** | ✅ | ✅ | ✅ Personal |
| **Laporan - Export** | ✅ | ✅ | ❌ |
| **Gaji - Lihat Semua** | ✅ | ✅ | ❌ |
| **Gaji - Lihat Pribadi** | ❌ | ❌ | ✅ |

**Keterangan:**
- ✅ = Bisa akses
- ❌ = Tidak bisa akses
- **Full Stats** = Statistik lengkap semua data
- **Monitoring** = Statistik untuk monitoring (read-only)
- **Personal** = Hanya data pribadi

---

## Tips Memasukkan ke Word/PDF

### 1. Export Diagram ke Gambar
- Buka https://mermaid.live/
- Copy-paste kode diagram
- Klik "Actions" → "PNG" atau "SVG"
- Download dan insert ke Word

### 2. Ukuran Optimal
- PNG: 1200-1600px width untuk kualitas baik
- Compress jika file terlalu besar

### 3. Layout di Word
- Gunakan text wrapping "In line with text" atau "Top and Bottom"
- Beri caption: "Gambar X. [Judul Flowchart]"
- Beri penjelasan di bawah gambar

### 4. Alternatif
Jika diagram masih terlalu besar, bisa dipecah menjadi sub-flowchart per proses:
- Flowchart Login
- Flowchart Menu Admin
- Flowchart Presensi Guru
- dst.

---

## Keuntungan Versi Sederhana Ini

✅ **Lebih Ringkas** - Setiap flowchart fokus pada 1 proses
✅ **Mudah Dipahami** - Tidak terlalu kompleks
✅ **Cocok untuk Word** - Ukuran pas untuk dokumen
✅ **Tetap Lengkap** - Semua proses utama tercakup
✅ **Penjelasan Jelas** - Dilengkapi keterangan detail
