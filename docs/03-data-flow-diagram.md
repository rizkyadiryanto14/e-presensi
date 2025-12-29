# Data Flow Diagram (DFD) Sistem E-Presensi

Dokumen ini berisi Data Flow Diagram untuk sistem E-Presensi, mulai dari Context Diagram (Level 0), DFD Level 1, hingga DFD Level 2 untuk proses-proses kritis.

## 1. Context Diagram (DFD Level 0)

Context Diagram menunjukkan sistem secara keseluruhan dan interaksi dengan entitas eksternal.

```mermaid
flowchart TB
    subgraph External["<b>ENTITAS EKSTERNAL</b>"]
        Admin[("<b>ADMINISTRATOR</b><br/><br/>- Mengelola sistem<br/>- Input data guru<br/>- Monitor kehadiran")]
        Kepsek[("<b>BENDAHARA</b><br/><br/>- Monitoring<br/>- View laporan<br/>- Evaluasi")]
        Guru[("<b>GURU</b><br/><br/>- Presensi harian<br/>- Lihat data pribadi")]
    end

    System(("<b>SISTEM<br/>E-PRESENSI</b>"))

    Admin -->|"Data Guru<br/>Data Absensi Manual<br/>Credentials"| System
    System -->|"Laporan Lengkap<br/>Statistik Sistem<br/>Data Gaji"| Admin

    Kepsek -->|"Request Laporan<br/>Filter Data<br/>Credentials"| System
    System -->|"Laporan Absensi<br/>Statistik Kehadiran<br/>Data Gaji Guru"| Kepsek

    Guru -->|"Check-in/Check-out<br/>Credentials<br/>Request Data Pribadi"| System
    System -->|"Status Presensi<br/>Riwayat Absensi<br/>Detail Gaji Pribadi"| Guru

    style System fill:#4dabf7,stroke:#1971c2,stroke-width:4px,color:#fff
    style Admin fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    style Kepsek fill:#ffd43b,stroke:#f59f00,stroke-width:2px,color:#000
    style Guru fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
```

### Penjelasan Context Diagram

**Entitas Eksternal:**
1. **Administrator**: Mengelola seluruh sistem, input data, dan monitoring
2. **Kepala Sekolah**: Monitoring dan evaluasi kehadiran (read-only)
3. **Guru**: Melakukan presensi dan melihat data pribadi

**Data Flow:**
- **Input ke Sistem**: Data guru, absensi, credentials, request data
- **Output dari Sistem**: Laporan, statistik, status presensi, detail gaji

---

## 2. DFD Level 1 - Dekomposisi Sistem

DFD Level 1 memecah sistem menjadi proses-proses utama.

```mermaid
flowchart TB
    %% External Entities
    Admin[("<b>ADMINISTRATOR</b>")]
    Kepsek[("<b>KEPALA SEKOLAH</b>")]
    Guru[("<b>GURU</b>")]

    %% Processes
    P1["<b>1.0</b><br/>AUTENTIKASI &<br/>AUTORISASI"]
    P2["<b>2.0</b><br/>MANAJEMEN<br/>DATA GURU"]
    P3["<b>3.0</b><br/>PRESENSI<br/>HARIAN"]
    P4["<b>4.0</b><br/>PERHITUNGAN<br/>GAJI"]
    P5["<b>5.0</b><br/>PELAPORAN &<br/>EXPORT"]

    %% Data Stores
    DS1[("D1: Users")]
    DS2[("D2: Gurus")]
    DS3[("D3: Absensis")]
    DS4[("D4: Gajis")]
    DS5[("D5: Activities")]
    DS6[("D6: Roles &<br/>Permissions")]

    %% Flows to/from Process 1 (Autentikasi)
    Admin -->|"1.1: Credentials"| P1
    Kepsek -->|"1.2: Credentials"| P1
    Guru -->|"1.3: Credentials"| P1

    P1 -->|"1.4: Session Valid"| Admin
    P1 -->|"1.5: Session Valid"| Kepsek
    P1 -->|"1.6: Session Valid"| Guru

    P1 <-->|"1.7: Verify User"| DS1
    P1 <-->|"1.8: Check Role"| DS6

    %% Flows to/from Process 2 (Manajemen Guru)
    Admin -->|"2.1: Data Guru Baru"| P2
    Admin -->|"2.2: Update Guru"| P2
    Admin -->|"2.3: Delete Guru"| P2

    P2 -->|"2.4: Konfirmasi"| Admin
    P2 -->|"2.5: Data Guru"| Kepsek

    P2 <-->|"2.6: CRUD Guru"| DS2
    P2 -->|"2.7: Create User"| DS1
    P2 -->|"2.8: Log Activity"| DS5

    %% Flows to/from Process 3 (Presensi)
    Guru -->|"3.1: Check-in/Check-out"| P3
    Admin -->|"3.2: Absensi Manual"| P3

    P3 -->|"3.3: Status Presensi"| Guru
    P3 -->|"3.4: Konfirmasi"| Admin

    P3 <-->|"3.5: Data Presensi"| DS3
    P3 -->|"3.6: Read Guru"| DS2
    P3 -->|"3.7: Log Activity"| DS5

    %% Flows to/from Process 4 (Perhitungan Gaji)
    Guru -->|"4.1: Request Gaji"| P4
    Admin -->|"4.2: Request Gaji Guru"| P4

    P4 -->|"4.3: Detail Gaji Pribadi"| Guru
    P4 -->|"4.4: Detail Gaji Guru"| Admin
    P4 -->|"4.5: Detail Gaji Guru"| Kepsek

    P4 -->|"4.6: Read Absensi"| DS3
    P4 -->|"4.7: Read Guru"| DS2
    P4 <-->|"4.8: CRUD Gaji"| DS4

    %% Flows to/from Process 5 (Pelaporan)
    Admin -->|"5.1: Request Laporan"| P5
    Kepsek -->|"5.2: Request Laporan"| P5
    Guru -->|"5.3: Request Riwayat"| P5

    P5 -->|"5.4: Laporan PDF/Excel"| Admin
    P5 -->|"5.5: Laporan PDF/Excel"| Kepsek
    P5 -->|"5.6: Riwayat Pribadi"| Guru

    P5 -->|"5.7: Read Absensi"| DS3
    P5 -->|"5.8: Read Guru"| DS2
    P5 -->|"5.9: Read Gaji"| DS4
    P5 -->|"5.10: Read Activities"| DS5
    P5 -->|"5.11: Log Export"| DS5

    %% Styling
    classDef processStyle fill:#4dabf7,stroke:#1971c2,stroke-width:2px,color:#fff
    classDef datastoreStyle fill:#e599f7,stroke:#9c36b5,stroke-width:2px,color:#fff
    classDef entityStyle fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff

    class P1,P2,P3,P4,P5 processStyle
    class DS1,DS2,DS3,DS4,DS5,DS6 datastoreStyle
    class Admin,Kepsek,Guru entityStyle
```

### Penjelasan DFD Level 1

**Proses Utama:**
1. **1.0 Autentikasi & Autorisasi**: Login, verifikasi role, session management
2. **2.0 Manajemen Data Guru**: CRUD data guru oleh admin
3. **3.0 Presensi Harian**: Check-in/check-out guru dan input manual admin
4. **4.0 Perhitungan Gaji**: Kalkulasi gaji berdasarkan kehadiran dan potongan
5. **5.0 Pelaporan & Export**: Generate laporan dan export data

**Data Stores:**
- **D1: Users**: Tabel users untuk autentikasi
- **D2: Gurus**: Tabel gurus dengan profil lengkap
- **D3: Absensis**: Tabel absensis untuk record presensi
- **D4: Gajis**: Tabel gajis untuk data penggajian
- **D5: Activities**: Tabel activities untuk log aktivitas
- **D6: Roles & Permissions**: Tabel role dan permission (Spatie)

---

## 3. DFD Level 2 - Proses 1.0 (Autentikasi & Autorisasi)

```mermaid
flowchart TB
    %% External Entities
    User[("<b>USER</b><br/>(Admin/Kepsek/Guru)")]

    %% Sub Processes
    P11["<b>1.1</b><br/>VALIDASI<br/>CREDENTIALS"]
    P12["<b>1.2</b><br/>VERIFIKASI<br/>EMAIL"]
    P13["<b>1.3</b><br/>CEK ROLE &<br/>PERMISSION"]
    P14["<b>1.4</b><br/>CREATE<br/>SESSION"]
    P15["<b>1.5</b><br/>REDIRECT<br/>DASHBOARD"]

    %% Data Stores
    DS1[("D1: Users")]
    DS6[("D6: Roles &<br/>Permissions")]
    DSS[("Session<br/>Storage")]

    %% Flows
    User -->|"Email + Password"| P11

    P11 -->|"Credentials"| DS1
    DS1 -->|"User Data"| P11

    P11 -->|"Valid Credentials"| P12
    P11 -->|"Invalid Credentials"| User

    P12 -->|"User ID"| DS1
    DS1 -->|"email_verified_at"| P12

    P12 -->|"Email Not Verified"| User
    P12 -->|"Email Verified"| P13

    P13 -->|"User ID"| DS6
    DS6 -->|"User Roles"| P13

    P13 -->|"Role Data"| P14

    P14 -->|"Create Session"| DSS
    DSS -->|"Session ID"| P14

    P14 -->|"Session Created"| P15

    P15 -->|"Role = Admin"| User
    P15 -->|"Role = Kepsek"| User
    P15 -->|"Role = Guru"| User

    %% Styling
    classDef processStyle fill:#4dabf7,stroke:#1971c2,stroke-width:2px,color:#fff
    classDef datastoreStyle fill:#e599f7,stroke:#9c36b5,stroke-width:2px,color:#fff
    classDef entityStyle fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff

    class P11,P12,P13,P14,P15 processStyle
    class DS1,DS6,DSS datastoreStyle
    class User entityStyle
```

---

## 4. DFD Level 2 - Proses 2.0 (Manajemen Data Guru)

```mermaid
flowchart TB
    %% External Entities
    Admin[("<b>ADMINISTRATOR</b>")]
    Kepsek[("<b>KEPALA SEKOLAH</b>")]

    %% Sub Processes
    P21["<b>2.1</b><br/>TAMBAH<br/>GURU BARU"]
    P22["<b>2.2</b><br/>UPDATE<br/>DATA GURU"]
    P23["<b>2.3</b><br/>HAPUS<br/>GURU"]
    P24["<b>2.4</b><br/>LIHAT<br/>DATA GURU"]

    %% Data Stores
    DS1[("D1: Users")]
    DS2[("D2: Gurus")]
    DS5[("D5: Activities")]
    DS6[("D6: Roles &<br/>Permissions")]

    %% Flows - Tambah Guru
    Admin -->|"Data Guru + User"| P21
    P21 -->|"Create User"| DS1
    P21 -->|"Assign Role 'guru'"| DS6
    P21 -->|"Create Guru Profile"| DS2
    P21 -->|"Log: guru_created"| DS5
    P21 -->|"Konfirmasi Success"| Admin

    %% Flows - Update Guru
    Admin -->|"Update Data"| P22
    P22 <-->|"Read Guru"| DS2
    P22 <-->|"Update Guru"| DS2
    P22 <-->|"Update User (optional)"| DS1
    P22 -->|"Log: guru_updated"| DS5
    P22 -->|"Konfirmasi Success"| Admin

    %% Flows - Hapus Guru
    Admin -->|"Guru ID"| P23
    P23 <-->|"Soft Delete Guru"| DS2
    P23 <-->|"Delete User (optional)"| DS1
    P23 <-->|"Revoke Role"| DS6
    P23 -->|"Log: guru_deleted"| DS5
    P23 -->|"Konfirmasi Success"| Admin

    %% Flows - Lihat Data
    Admin -->|"Request Data Guru"| P24
    Kepsek -->|"Request Data Guru"| P24
    P24 -->|"Read Guru"| DS2
    DS2 -->|"List Guru"| P24
    P24 -->|"Data Guru"| Admin
    P24 -->|"Data Guru (read-only)"| Kepsek

    %% Styling
    classDef processStyle fill:#4dabf7,stroke:#1971c2,stroke-width:2px,color:#fff
    classDef datastoreStyle fill:#e599f7,stroke:#9c36b5,stroke-width:2px,color:#fff
    classDef adminStyle fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    classDef kepsekStyle fill:#ffd43b,stroke:#f59f00,stroke-width:2px,color:#000

    class P21,P22,P23,P24 processStyle
    class DS1,DS2,DS5,DS6 datastoreStyle
    class Admin adminStyle
    class Kepsek kepsekStyle
```

---

## 5. DFD Level 2 - Proses 3.0 (Presensi Harian)

```mermaid
flowchart TB
    %% External Entities
    Guru[("<b>GURU</b>")]
    Admin[("<b>ADMINISTRATOR</b>")]

    %% Sub Processes
    P31["<b>3.1</b><br/>VALIDASI<br/>STATUS HARI INI"]
    P32["<b>3.2</b><br/>PROSES<br/>CHECK-IN"]
    P33["<b>3.3</b><br/>PROSES<br/>CHECK-OUT"]
    P34["<b>3.4</b><br/>INPUT<br/>MANUAL ADMIN"]
    P35["<b>3.5</b><br/>DETEKSI<br/>KETERLAMBATAN"]

    %% Data Stores
    DS2[("D2: Gurus")]
    DS3[("D3: Absensis")]
    DS5[("D5: Activities")]
    Clock[("System<br/>Clock")]

    %% Flows - Check-in
    Guru -->|"Request Check-in"| P31
    P31 -->|"Guru ID + Tanggal"| DS3
    DS3 -->|"Status Hari Ini"| P31

    P31 -->|"Belum Check-in"| P32
    P31 -->|"Sudah Check-in"| Guru

    P32 -->|"Waktu Sekarang"| Clock
    Clock -->|"Current Time"| P32

    P32 -->|"Waktu"| P35
    P35 -->|"Waktu < 08:00"| P32
    P35 -->|"Waktu >= 08:00"| P32

    P32 -->|"Status = hadir/terlambat"| DS3
    P32 -->|"Guru ID"| DS2
    P32 -->|"Log Check-in"| DS5
    P32 -->|"Konfirmasi"| Guru

    %% Flows - Check-out
    Guru -->|"Request Check-out"| P33
    P33 -->|"Cek Absensi Hari Ini"| DS3
    DS3 -->|"Data Absensi"| P33

    P33 -->|"Waktu Sekarang"| Clock
    Clock -->|"Current Time"| P33

    P33 -->|"Update waktu_pulang"| DS3
    P33 -->|"Log Check-out"| DS5
    P33 -->|"Konfirmasi"| Guru

    %% Flows - Input Manual
    Admin -->|"Data Absensi Manual"| P34
    P34 -->|"Guru ID"| DS2
    P34 -->|"Create/Update Absensi"| DS3
    P34 -->|"Log Admin Action"| DS5
    P34 -->|"Konfirmasi"| Admin

    %% Styling
    classDef processStyle fill:#4dabf7,stroke:#1971c2,stroke-width:2px,color:#fff
    classDef datastoreStyle fill:#e599f7,stroke:#9c36b5,stroke-width:2px,color:#fff
    classDef guruStyle fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
    classDef adminStyle fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    classDef systemStyle fill:#ffd43b,stroke:#f59f00,stroke-width:2px,color:#000

    class P31,P32,P33,P34,P35 processStyle
    class DS2,DS3,DS5 datastoreStyle
    class Guru guruStyle
    class Admin adminStyle
    class Clock systemStyle
```

---

## 6. DFD Level 2 - Proses 4.0 (Perhitungan Gaji)

```mermaid
flowchart TB
    %% External Entities
    Guru[("<b>GURU</b>")]
    Admin[("<b>ADMINISTRATOR</b>")]
    Kepsek[("<b>KEPALA SEKOLAH</b>")]

    %% Sub Processes
    P41["<b>4.1</b><br/>AMBIL DATA<br/>GURU & GAJI"]
    P42["<b>4.2</b><br/>HITUNG<br/>KEHADIRAN"]
    P43["<b>4.3</b><br/>HITUNG<br/>POTONGAN"]
    P44["<b>4.4</b><br/>HITUNG<br/>GAJI BERSIH"]
    P45["<b>4.5</b><br/>SIMPAN/UPDATE<br/>DATA GAJI"]

    %% Data Stores
    DS2[("D2: Gurus")]
    DS3[("D3: Absensis")]
    DS4[("D4: Gajis")]

    %% Flows
    Guru -->|"Request Gaji Pribadi"| P41
    Admin -->|"Request Gaji Guru"| P41
    Kepsek -->|"Request Gaji Guru"| P41

    P41 -->|"Guru ID"| DS2
    DS2 -->|"gaji_pokok, tunjangan"| P41

    P41 -->|"Data Guru + Bulan"| P42

    P42 -->|"Guru ID + Bulan"| DS3
    DS3 -->|"List Absensi"| P42

    P42 -->|"Count per Status:<br/>- hadir<br/>- terlambat<br/>- izin<br/>- sakit<br/>- alpha"| P43

    P43 -->|"Hitung:<br/>terlambat × 50,000<br/>alpha × 200,000"| P44

    P44 -->|"Formula:<br/>Gaji Bersih = <br/>Gaji Pokok + Tunjangan<br/>- Total Potongan"| P45

    P45 -->|"Save/Update Gaji"| DS4

    P45 -->|"Detail Gaji Pribadi"| Guru
    P45 -->|"Detail Gaji Guru"| Admin
    P45 -->|"Detail Gaji Guru"| Kepsek

    %% Styling
    classDef processStyle fill:#4dabf7,stroke:#1971c2,stroke-width:2px,color:#fff
    classDef datastoreStyle fill:#e599f7,stroke:#9c36b5,stroke-width:2px,color:#fff
    classDef guruStyle fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
    classDef adminStyle fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    classDef kepsekStyle fill:#ffd43b,stroke:#f59f00,stroke-width:2px,color:#000

    class P41,P42,P43,P44,P45 processStyle
    class DS2,DS3,DS4 datastoreStyle
    class Guru guruStyle
    class Admin adminStyle
    class Kepsek kepsekStyle
```

---

## 7. DFD Level 2 - Proses 5.0 (Pelaporan & Export)

```mermaid
flowchart TB
    %% External Entities
    Admin[("<b>ADMINISTRATOR</b>")]
    Kepsek[("<b>KEPALA SEKOLAH</b>")]
    Guru[("<b>GURU</b>")]

    %% Sub Processes
    P51["<b>5.1</b><br/>LAPORAN<br/>HARIAN"]
    P52["<b>5.2</b><br/>LAPORAN<br/>BULANAN"]
    P53["<b>5.3</b><br/>RIWAYAT<br/>PRIBADI"]
    P54["<b>5.4</b><br/>GENERATE<br/>PDF"]
    P55["<b>5.5</b><br/>GENERATE<br/>EXCEL"]
    P56["<b>5.6</b><br/>STATISTIK<br/>& DASHBOARD"]

    %% Data Stores
    DS2[("D2: Gurus")]
    DS3[("D3: Absensis")]
    DS4[("D4: Gajis")]
    DS5[("D5: Activities")]
    FileSystem[("File<br/>System")]

    %% Flows - Laporan Harian
    Admin -->|"Request Laporan Harian"| P51
    Kepsek -->|"Request Laporan Harian"| P51

    P51 -->|"Filter Tanggal"| DS3
    DS3 -->|"Absensi per Tanggal"| P51
    P51 -->|"Read Guru"| DS2
    DS2 -->|"Data Guru"| P51

    P51 -->|"Data Laporan"| Admin
    P51 -->|"Data Laporan"| Kepsek

    %% Flows - Laporan Bulanan
    Admin -->|"Request Laporan Bulanan"| P52
    Kepsek -->|"Request Laporan Bulanan"| P52

    P52 -->|"Filter Bulan"| DS3
    DS3 -->|"Absensi per Bulan"| P52
    P52 -->|"Read Guru"| DS2
    P52 -->|"Read Gaji"| DS4
    DS2 -->|"Data Guru"| P52
    DS4 -->|"Data Gaji"| P52

    P52 -->|"Aggregate Data"| P52
    P52 -->|"Data Laporan Bulanan"| Admin
    P52 -->|"Data Laporan Bulanan"| Kepsek

    %% Flows - Riwayat Pribadi
    Guru -->|"Request Riwayat"| P53
    P53 -->|"Guru ID + Filter"| DS3
    DS3 -->|"Absensi Pribadi"| P53
    P53 -->|"Riwayat Absensi"| Guru

    %% Flows - Export PDF
    Admin -->|"Export PDF"| P54
    Kepsek -->|"Export PDF"| P54

    P54 -->|"Get Data"| P51
    P54 -->|"Get Data"| P52
    P51 -->|"Data"| P54
    P52 -->|"Data"| P54

    P54 -->|"Generate PDF"| FileSystem
    FileSystem -->|"PDF File"| P54
    P54 -->|"Download PDF"| Admin
    P54 -->|"Download PDF"| Kepsek

    P54 -->|"Log Export"| DS5

    %% Flows - Export Excel
    Admin -->|"Export Excel"| P55
    Kepsek -->|"Export Excel"| P55

    P55 -->|"Get Data"| P52
    P52 -->|"Data"| P55

    P55 -->|"Generate Excel"| FileSystem
    FileSystem -->|"Excel File"| P55
    P55 -->|"Download Excel"| Admin
    P55 -->|"Download Excel"| Kepsek

    P55 -->|"Log Export"| DS5

    %% Flows - Statistik Dashboard
    Admin -->|"View Dashboard"| P56
    Kepsek -->|"View Dashboard"| P56
    Guru -->|"View Dashboard"| P56

    P56 -->|"Aggregate Queries"| DS3
    P56 -->|"Read Guru"| DS2
    P56 -->|"Read Activities"| DS5

    DS3 -->|"Statistics"| P56
    DS2 -->|"Guru Count"| P56
    DS5 -->|"Recent Activities"| P56

    P56 -->|"Dashboard Data"| Admin
    P56 -->|"Dashboard Data"| Kepsek
    P56 -->|"Dashboard Data Pribadi"| Guru

    %% Styling
    classDef processStyle fill:#4dabf7,stroke:#1971c2,stroke-width:2px,color:#fff
    classDef datastoreStyle fill:#e599f7,stroke:#9c36b5,stroke-width:2px,color:#fff
    classDef guruStyle fill:#51cf66,stroke:#2f9e44,stroke-width:2px,color:#fff
    classDef adminStyle fill:#ff6b6b,stroke:#c92a2a,stroke-width:2px,color:#fff
    classDef kepsekStyle fill:#ffd43b,stroke:#f59f00,stroke-width:2px,color:#000
    classDef systemStyle fill:#868e96,stroke:#495057,stroke-width:2px,color:#fff

    class P51,P52,P53,P54,P55,P56 processStyle
    class DS2,DS3,DS4,DS5 datastoreStyle
    class Guru guruStyle
    class Admin adminStyle
    class Kepsek kepsekStyle
    class FileSystem systemStyle
```

---

## Kamus Data (Data Dictionary)

### Data Flow Descriptions

| No | Data Flow | Deskripsi | Komposisi Data |
|----|-----------|-----------|----------------|
| 1 | Credentials | Data login user | email + password |
| 2 | Data Guru Baru | Data untuk membuat guru baru | nip + nama + jabatan + status_kepegawaian + gaji_pokok + tunjangan + email + password |
| 3 | Update Guru | Data untuk update guru | [field yang diupdate] |
| 4 | Check-in/Check-out | Request presensi | guru_id + timestamp |
| 5 | Absensi Manual | Input manual oleh admin | guru_id + tanggal + status + waktu_masuk + waktu_pulang |
| 6 | Request Gaji | Request perhitungan gaji | guru_id + bulan + tahun |
| 7 | Detail Gaji | Detail perhitungan gaji | gaji_pokok + tunjangan + kehadiran + potongan + total_gaji |
| 8 | Request Laporan | Request laporan dengan filter | tanggal/bulan + format (PDF/Excel) |
| 9 | Laporan PDF/Excel | File laporan yang dihasilkan | Binary file (PDF/XLSX) |
| 10 | Riwayat Pribadi | Riwayat absensi guru | List(tanggal + status + waktu_masuk + waktu_pulang) |
| 11 | Session Valid | Session authentication | user_id + roles + session_token |
| 12 | Status Presensi | Status presensi hari ini | sudah_checkin (boolean) + waktu_masuk + waktu_pulang |
| 13 | Log Activity | Log aktivitas sistem | type + description + user_id + guru_id + data (JSON) |

### Data Store Descriptions

| Data Store | Nama Tabel | Deskripsi | Primary Key | Foreign Keys |
|------------|------------|-----------|-------------|--------------|
| D1 | users | Data akun pengguna | id | - |
| D2 | gurus | Data profil guru | id | user_id → users(id) |
| D3 | absensis | Data presensi harian | id | guru_id → gurus(id) |
| D4 | gajis | Data penggajian bulanan | id | guru_id → gurus(id) |
| D5 | activities | Log aktivitas sistem | id | user_id → users(id)<br/>guru_id → gurus(id) |
| D6 | roles, permissions,<br/>model_has_roles | Data role & permission | id | - |

### Process Descriptions

| Process | Nama Proses | Deskripsi | Input | Output |
|---------|-------------|-----------|-------|--------|
| 1.0 | Autentikasi & Autorisasi | Proses login dan verifikasi akses | Credentials | Session Valid |
| 2.0 | Manajemen Data Guru | CRUD data guru | Data Guru | Konfirmasi |
| 3.0 | Presensi Harian | Check-in/out dan input manual | Request Presensi | Status Presensi |
| 4.0 | Perhitungan Gaji | Kalkulasi gaji berdasarkan kehadiran | Request Gaji | Detail Gaji |
| 5.0 | Pelaporan & Export | Generate dan export laporan | Request Laporan | File Laporan |

---

## Catatan Penting untuk Skripsi

### Penjelasan Aliran Data

1. **Autentikasi (DFD 1.0):**
   - User memasukkan credentials
   - Sistem verifikasi dengan database users
   - Cek email verification
   - Cek role dari tabel roles
   - Buat session
   - Redirect sesuai role

2. **Manajemen Guru (DFD 2.0):**
   - Admin input data guru dan user
   - Sistem buat user account terlebih dahulu
   - Assign role 'guru' menggunakan Spatie Permission
   - Buat profil guru dengan foreign key ke user
   - Log semua aktivitas

3. **Presensi (DFD 3.0):**
   - Guru request check-in
   - Sistem ambil waktu dari system clock
   - Deteksi keterlambatan (>= 08:00)
   - Simpan ke database dengan status sesuai
   - Log aktivitas presensi

4. **Perhitungan Gaji (DFD 4.0):**
   - Request gaji dengan guru_id dan bulan
   - Ambil data gaji pokok dari tabel gurus
   - Hitung kehadiran dari tabel absensis
   - Hitung potongan sesuai aturan bisnis
   - Return total gaji bersih

5. **Pelaporan (DFD 5.0):**
   - Request laporan dengan filter
   - Aggregate data dari multiple tables
   - Generate file sesuai format (PDF/Excel)
   - Log aktivitas export

### Validasi DFD

✅ **Balancing**: Setiap dekomposisi level memiliki input/output yang sama
✅ **Konsistensi**: Naming conventions konsisten di semua level
✅ **Completeness**: Semua proses, data store, dan data flow terdokumentasi
✅ **Numbering**: Sistem penomoran hierarkis (1.0, 1.1, 1.2, dst)
