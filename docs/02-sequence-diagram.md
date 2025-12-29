# Sequence Diagram Sistem E-Presensi

Dokumen ini berisi berbagai sequence diagram untuk proses-proses utama dalam sistem E-Presensi.

## 1. Sequence Diagram: Proses Login

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant AuthController
    participant LoginRequest
    participant Auth as Laravel Auth
    participant Database
    participant Session
    participant DashboardController

    User->>Browser: Akses halaman login
    Browser->>AuthController: GET /login
    AuthController-->>Browser: Tampilkan form login
    Browser-->>User: Form login

    User->>Browser: Input email & password<br/>Klik tombol Login
    Browser->>AuthController: POST /login (email, password)

    AuthController->>LoginRequest: Validasi input
    alt Validasi gagal
        LoginRequest-->>Browser: Error validasi
        Browser-->>User: Tampilkan error
    else Validasi berhasil
        LoginRequest-->>AuthController: Data valid

        AuthController->>Auth: authenticate(email, password)
        Auth->>Database: Query user dengan email

        alt User tidak ditemukan
            Database-->>Auth: User tidak ada
            Auth-->>AuthController: Authentication failed
            AuthController-->>Browser: Error credentials
            Browser-->>User: Email/password salah
        else User ditemukan
            Database-->>Auth: User data
            Auth->>Auth: Verify password hash

            alt Password salah
                Auth-->>AuthController: Authentication failed
                AuthController-->>Browser: Error credentials
                Browser-->>User: Email/password salah
            else Password benar
                Auth-->>AuthController: Authentication success

                AuthController->>Session: Create session
                Session->>Session: Regenerate session ID
                Session-->>AuthController: Session created

                AuthController->>Auth: Check email_verified_at

                alt Email belum verified
                    Auth-->>AuthController: Email not verified
                    AuthController-->>Browser: Redirect ke /verify-email
                    Browser-->>User: Halaman verifikasi email
                else Email sudah verified
                    Auth-->>AuthController: Email verified

                    AuthController-->>Browser: Redirect ke /dashboard
                    Browser->>DashboardController: GET /dashboard

                    DashboardController->>Auth: Get authenticated user
                    Auth-->>DashboardController: User object

                    DashboardController->>Database: Get user roles
                    Database-->>DashboardController: User roles

                    alt Role = Admin/Kepala Sekolah
                        DashboardController->>DashboardController: adminDashboard()
                        DashboardController->>Database: Get statistik sistem
                        Database-->>DashboardController: Data statistik
                        DashboardController-->>Browser: Admin Dashboard view
                        Browser-->>User: Dashboard Admin/Kepsek
                    else Role = Guru
                        DashboardController->>DashboardController: guruDashboard()
                        DashboardController->>Database: Get data guru & absensi
                        Database-->>DashboardController: Data guru
                        DashboardController-->>Browser: Guru Dashboard view
                        Browser-->>User: Dashboard Guru
                    end
                end
            end
        end
    end
```

---

## 2. Sequence Diagram: Proses Check-in Presensi (Guru)

```mermaid
sequenceDiagram
    actor Guru
    participant Browser
    participant AbsensiController
    participant RoleMiddleware
    participant Auth as Laravel Auth
    participant AbsensiService
    participant ActivityService
    participant Database
    participant Carbon

    Guru->>Browser: Klik "Presensi Masuk"
    Browser->>AbsensiController: GET /absensi/check-in

    AbsensiController->>RoleMiddleware: Check role 'guru'
    RoleMiddleware->>Auth: Get authenticated user
    Auth-->>RoleMiddleware: User object
    RoleMiddleware->>Database: Check user roles

    alt User bukan Guru
        Database-->>RoleMiddleware: Role tidak sesuai
        RoleMiddleware-->>Browser: Error 403 Forbidden
        Browser-->>Guru: Akses ditolak
    else User adalah Guru
        Database-->>RoleMiddleware: Role 'guru' confirmed
        RoleMiddleware-->>AbsensiController: Access granted

        AbsensiController->>Database: Get guru profile
        Database-->>AbsensiController: Guru data

        AbsensiController->>AbsensiService: hasCheckedInToday(guru_id)
        AbsensiService->>Database: Query absensi hari ini

        alt Sudah check-in
            Database-->>AbsensiService: Absensi exists
            AbsensiService-->>AbsensiController: true
            AbsensiController-->>Browser: View check-in (sudah check-in)
            Browser-->>Guru: Tampil info sudah check-in<br/>+ tombol check-out
        else Belum check-in
            Database-->>AbsensiService: No data
            AbsensiService-->>AbsensiController: false
            AbsensiController-->>Browser: View check-in (belum)
            Browser-->>Guru: Form check-in available

            Guru->>Browser: Klik tombol "Check-in"
            Browser->>AbsensiController: POST /absensi/check-in

            AbsensiController->>Auth: Get authenticated user
            Auth-->>AbsensiController: User object

            AbsensiController->>Database: Get guru from user
            Database-->>AbsensiController: Guru data

            AbsensiController->>Carbon: now() - Get waktu sekarang
            Carbon-->>AbsensiController: Current datetime

            AbsensiController->>AbsensiController: Tentukan status

            alt Waktu < 08:00
                AbsensiController->>AbsensiController: status = 'hadir'
            else Waktu >= 08:00
                AbsensiController->>AbsensiController: status = 'terlambat'
            end

            AbsensiController->>AbsensiService: recordCheckIn(guru_id, status)

            AbsensiService->>Database: BEGIN TRANSACTION

            AbsensiService->>Database: INSERT INTO absensis<br/>(guru_id, tanggal, status, waktu_masuk)

            alt Insert gagal (duplicate)
                Database-->>AbsensiService: Error duplicate entry
                AbsensiService->>Database: ROLLBACK
                AbsensiService-->>AbsensiController: Error
                AbsensiController-->>Browser: Error sudah check-in
                Browser-->>Guru: Pesan error
            else Insert berhasil
                Database-->>AbsensiService: Absensi created

                AbsensiService->>ActivityService: record('hadir/terlambat', description, guru_id)
                ActivityService->>Database: INSERT INTO activities
                Database-->>ActivityService: Activity logged
                ActivityService-->>AbsensiService: Success

                AbsensiService->>Database: COMMIT TRANSACTION
                AbsensiService-->>AbsensiController: Success + absensi data

                AbsensiController-->>Browser: Redirect ke dashboard<br/>dengan flash message
                Browser-->>Guru: Dashboard + pesan sukses<br/>"Check-in berhasil"
            end
        end
    end
```

---

## 3. Sequence Diagram: Proses Tambah Guru Baru (Admin)

```mermaid
sequenceDiagram
    actor Admin
    participant Browser
    participant GuruController
    participant RoleMiddleware
    participant Request as FormRequest
    participant GuruService
    participant Database
    participant Hash
    participant Event
    participant Mail

    Admin->>Browser: Klik "Tambah Guru"
    Browser->>GuruController: GET /admin/guru/create

    GuruController->>RoleMiddleware: Check role 'admin'
    RoleMiddleware->>Database: Verify admin role

    alt Bukan admin
        Database-->>RoleMiddleware: Role tidak sesuai
        RoleMiddleware-->>Browser: Error 403
        Browser-->>Admin: Akses ditolak
    else Admin confirmed
        Database-->>RoleMiddleware: Role admin
        RoleMiddleware-->>GuruController: Access granted
        GuruController-->>Browser: Form tambah guru
        Browser-->>Admin: Tampilkan form

        Admin->>Browser: Isi form data guru:<br/>- NIP<br/>- Nama<br/>- Jabatan<br/>- Status Kepegawaian<br/>- Gaji Pokok<br/>- Tunjangan<br/>- Email<br/>- Password
        Admin->>Browser: Submit form

        Browser->>GuruController: POST /admin/guru (form data)

        GuruController->>Request: Validasi input
        Request->>Request: Validate rules:<br/>- NIP unique<br/>- Email unique<br/>- Password min 8 char<br/>- Required fields

        alt Validasi gagal
            Request-->>GuruController: Validation errors
            GuruController-->>Browser: Redirect back with errors
            Browser-->>Admin: Form + pesan error
        else Validasi berhasil
            Request-->>GuruController: Validated data

            GuruController->>GuruService: createGuru(guruData, userData, sendEmail)

            GuruService->>Database: BEGIN TRANSACTION

            Note over GuruService,Database: Step 1: Create User Account
            GuruService->>Hash: Hash password
            Hash-->>GuruService: Hashed password

            GuruService->>Database: INSERT INTO users<br/>(name, email, password)

            alt Email sudah terdaftar
                Database-->>GuruService: Error duplicate email
                GuruService->>Database: ROLLBACK
                GuruService-->>GuruController: Error
                GuruController-->>Browser: Error email exists
                Browser-->>Admin: Pesan error
            else User created
                Database-->>GuruService: User object (user_id)

                Note over GuruService,Database: Step 2: Assign Role
                GuruService->>Database: INSERT INTO model_has_roles<br/>(role_id='guru', model_id=user_id)
                Database-->>GuruService: Role assigned

                Note over GuruService,Database: Step 3: Create Guru Profile
                GuruService->>Database: INSERT INTO gurus<br/>(user_id, nip, nama, jabatan, etc)

                alt NIP duplicate
                    Database-->>GuruService: Error duplicate NIP
                    GuruService->>Database: ROLLBACK
                    GuruService-->>GuruController: Error
                    GuruController-->>Browser: Error NIP exists
                    Browser-->>Admin: Pesan error
                else Guru created
                    Database-->>GuruService: Guru object

                    GuruService->>Database: COMMIT TRANSACTION

                    alt sendEmail = true
                        Note over GuruService,Event: Step 4: Send Email Verification
                        GuruService->>Event: Fire Registered event
                        Event->>Mail: Queue verification email
                        Mail-->>Event: Email queued
                        Event-->>GuruService: Event dispatched
                    end

                    GuruService-->>GuruController: Success + guru object

                    GuruController-->>Browser: Redirect ke /admin/guru<br/>dengan flash success
                    Browser-->>Admin: Daftar guru + pesan sukses<br/>"Guru berhasil ditambahkan"
                end
            end
        end
    end
```

---

## 4. Sequence Diagram: Proses Perhitungan Gaji Bulanan

```mermaid
sequenceDiagram
    actor User as Guru/Admin
    participant Browser
    participant Controller
    participant GuruService
    participant AbsensiService
    participant Database
    participant Carbon

    User->>Browser: Akses menu Gaji<br/>Filter: Bulan = 2025-05
    Browser->>Controller: GET /guru/salary?month=2025-05

    Controller->>Controller: Parse month parameter
    Controller->>Carbon: Parse month '2025-05'
    Carbon-->>Controller: Carbon object (bulan, tahun)

    alt User = Guru
        Controller->>Database: Get guru from auth user
        Database-->>Controller: Guru object
    else User = Admin
        Controller->>Database: Get guru by ID from request
        Database-->>Controller: Guru object
    end

    Note over Controller,GuruService: Ambil komponen gaji pokok
    Controller->>GuruService: calculateSalaryComponents(guru_id, month)

    GuruService->>Database: Get guru data<br/>(gaji_pokok, tunjangan)
    Database-->>GuruService: Guru: {<br/>  gaji_pokok: 5000000,<br/>  tunjangan: 1000000<br/>}

    Note over GuruService,AbsensiService: Ambil data kehadiran
    GuruService->>AbsensiService: getAttendanceSummary(guru_id, month)

    AbsensiService->>Carbon: Get date range untuk bulan
    Carbon-->>AbsensiService: startDate, endDate

    AbsensiService->>Database: Query absensis WHERE<br/>guru_id AND<br/>tanggal BETWEEN startDate AND endDate
    Database-->>AbsensiService: Collection of Absensi

    AbsensiService->>AbsensiService: Hitung per status:<br/>hadir = 0<br/>terlambat = 0<br/>izin = 0<br/>sakit = 0<br/>alpha = 0

    loop Setiap absensi
        AbsensiService->>AbsensiService: Switch status:<br/>case 'hadir': hadir++<br/>case 'terlambat': terlambat++<br/>case 'izin': izin++<br/>case 'sakit': sakit++<br/>case 'alpha': alpha++
    end

    AbsensiService->>Carbon: Count hari kerja dalam bulan<br/>(exclude Minggu)
    Carbon-->>AbsensiService: total_hari_kerja

    AbsensiService-->>GuruService: {<br/>  hadir: 18,<br/>  terlambat: 3,<br/>  izin: 1,<br/>  sakit: 0,<br/>  alpha: 1,<br/>  total_hari_kerja: 23<br/>}

    Note over GuruService: Perhitungan gaji
    GuruService->>GuruService: Hitung potongan:<br/>potongan_terlambat = 3 × 50000 = 150000<br/>potongan_alpha = 1 × 200000 = 200000<br/>total_potongan = 350000

    GuruService->>GuruService: Hitung gaji bersih:<br/>gaji_bersih = gaji_pokok + tunjangan - total_potongan<br/>gaji_bersih = 5000000 + 1000000 - 350000<br/>gaji_bersih = 5650000

    GuruService-->>Controller: {<br/>  gaji_pokok: 5000000,<br/>  tunjangan: 1000000,<br/>  kehadiran: {...},<br/>  potongan: {<br/>    terlambat: 150000,<br/>    alpha: 200000,<br/>    total: 350000<br/>  },<br/>  total_gaji: 5650000<br/>}

    Controller-->>Browser: View dengan data gaji
    Browser-->>User: Tampilkan detail gaji:<br/><br/>Gaji Pokok: Rp 5.000.000<br/>Tunjangan: Rp 1.000.000<br/>─────────────────────<br/>Subtotal: Rp 6.000.000<br/><br/>Potongan:<br/>- Terlambat (3×): Rp 150.000<br/>- Alpha (1×): Rp 200.000<br/>─────────────────────<br/>Total Potongan: Rp 350.000<br/><br/>GAJI BERSIH: Rp 5.650.000
```

---

## 5. Sequence Diagram: Proses Export Laporan (Admin/Kepala Sekolah)

```mermaid
sequenceDiagram
    actor User as Admin/Kepsek
    participant Browser
    participant AbsensiController
    participant AbsensiService
    participant Database
    participant PDF as DomPDF / Excel
    participant Storage

    User->>Browser: Pilih laporan bulanan<br/>Filter: Bulan = 2025-05<br/>Format = PDF
    User->>Browser: Klik "Export"

    Browser->>AbsensiController: GET /absensi/export?<br/>month=2025-05&format=pdf

    AbsensiController->>AbsensiController: Validasi parameter<br/>- month: required<br/>- format: pdf|excel

    alt Validasi gagal
        AbsensiController-->>Browser: Error 400 Bad Request
        Browser-->>User: Pesan error
    else Validasi berhasil
        AbsensiController->>AbsensiService: getAllTeacherAttendanceSummary(month)

        Note over AbsensiService,Database: Ambil semua guru
        AbsensiService->>Database: SELECT * FROM gurus<br/>WHERE deleted_at IS NULL
        Database-->>AbsensiService: Collection of Guru

        Note over AbsensiService: Loop setiap guru untuk summary
        loop Untuk setiap Guru
            AbsensiService->>Database: Query absensi guru<br/>WHERE guru_id AND month
            Database-->>AbsensiService: Absensi data

            AbsensiService->>AbsensiService: Hitung ringkasan:<br/>- Total hadir<br/>- Total terlambat<br/>- Total izin<br/>- Total sakit<br/>- Total alpha<br/>- Potongan<br/>- Gaji bersih
        end

        AbsensiService-->>AbsensiController: Array of summary per guru

        AbsensiController->>AbsensiService: getMonthlyStats(month)
        AbsensiService->>Database: Aggregate statistics
        Database-->>AbsensiService: {<br/>  total_guru: 25,<br/>  total_hadir: 450,<br/>  total_terlambat: 45,<br/>  total_alpha: 12,<br/>  persentase_hadir: 92%<br/>}
        AbsensiService-->>AbsensiController: Monthly stats

        alt Format = PDF
            AbsensiController->>PDF: Load view 'laporan.pdf'<br/>dengan data summary
            PDF->>PDF: Render HTML to PDF<br/>- Header: Logo + Judul<br/>- Tabel data guru<br/>- Footer: Statistik
            PDF-->>AbsensiController: PDF Binary

            AbsensiController-->>Browser: Response download PDF<br/>Header: Content-Type: application/pdf<br/>Filename: laporan-absensi-2025-05.pdf
            Browser-->>User: Download file PDF

        else Format = Excel
            AbsensiController->>PDF: Excel::download()<br/>dengan data summary
            PDF->>PDF: Generate Excel:<br/>- Sheet 1: Ringkasan<br/>- Sheet 2: Detail per guru<br/>- Formatting & styling
            PDF-->>AbsensiController: Excel Binary

            AbsensiController-->>Browser: Response download Excel<br/>Header: Content-Type: application/vnd.ms-excel<br/>Filename: laporan-absensi-2025-05.xlsx
            Browser-->>User: Download file Excel
        end

        Note over AbsensiController,Database: Log aktivitas export
        AbsensiController->>Database: INSERT INTO activities<br/>(type='export', description, user_id)
        Database-->>AbsensiController: Activity logged
    end
```

---

## 6. Sequence Diagram: Proses Check-out Presensi (Guru)

```mermaid
sequenceDiagram
    actor Guru
    participant Browser
    participant AbsensiController
    participant AbsensiService
    participant ActivityService
    participant Database
    participant Carbon

    Guru->>Browser: Klik tombol "Check-out"
    Browser->>AbsensiController: POST /absensi/check-out

    AbsensiController->>Database: Get guru from auth user
    Database-->>AbsensiController: Guru object

    AbsensiController->>AbsensiService: hasCheckedInToday(guru_id)
    AbsensiService->>Database: Query absensi hari ini

    alt Belum check-in
        Database-->>AbsensiService: No data
        AbsensiService-->>AbsensiController: false
        AbsensiController-->>Browser: Error: Belum check-in
        Browser-->>Guru: Pesan: "Anda belum check-in hari ini"
    else Sudah check-in
        Database-->>AbsensiService: Absensi data
        AbsensiService-->>AbsensiController: true + absensi object

        AbsensiService->>AbsensiService: Check waktu_pulang

        alt Sudah check-out
            AbsensiService-->>AbsensiController: Error: Sudah check-out
            AbsensiController-->>Browser: Error
            Browser-->>Guru: Pesan: "Anda sudah check-out"
        else Belum check-out
            AbsensiController->>Carbon: now() - Get waktu sekarang
            Carbon-->>AbsensiController: Current time

            AbsensiController->>AbsensiService: recordCheckOut(guru_id)

            AbsensiService->>Database: BEGIN TRANSACTION

            AbsensiService->>Database: UPDATE absensis<br/>SET waktu_pulang = current_time<br/>WHERE guru_id AND tanggal = today
            Database-->>AbsensiService: Update success

            AbsensiService->>ActivityService: record('checkout', description, guru_id)
            ActivityService->>Database: INSERT INTO activities
            Database-->>ActivityService: Activity logged

            AbsensiService->>Database: COMMIT TRANSACTION
            AbsensiService-->>AbsensiController: Success

            AbsensiController-->>Browser: Redirect ke dashboard<br/>dengan flash message
            Browser-->>Guru: Dashboard + pesan:<br/>"Check-out berhasil"<br/>Waktu: HH:mm
        end
    end
```

## 7. Sequence Diagram: Proses Logout (Shared Activity)

```mermaid
sequenceDiagram
    actor User as User (Any Role)
    participant Browser
    participant AuthController
    participant Auth as Laravel Auth
    participant Session
    participant ActivityService
    participant Database

    User->>Browser: Klik tombol "Logout"
    Browser->>AuthController: POST /logout

    AuthController->>Auth: Get authenticated user
    Auth-->>AuthController: User object

    AuthController->>Database: Get user ID
    Database-->>AuthController: User data

    Note over AuthController,ActivityService: Log aktivitas logout
    AuthController->>ActivityService: record('logout', description, user_id)
    ActivityService->>Database: INSERT INTO activities<br/>(type='logout', user_id, timestamp)
    Database-->>ActivityService: Activity logged
    ActivityService-->>AuthController: Success

    Note over AuthController,Session: Destroy session
    AuthController->>Session: Invalidate session
    Session->>Session: Delete session data
    Session->>Session: Regenerate CSRF token
    Session-->>AuthController: Session destroyed

    AuthController->>Auth: Logout user
    Auth->>Auth: Clear authentication
    Auth-->>AuthController: User logged out

    AuthController-->>Browser: Redirect ke /login<br/>dengan flash message
    Browser-->>User: Halaman login + pesan:<br/>"Anda berhasil logout"
```

**Penjelasan:**
- User dari role apapun (Admin/Guru/Kepsek) bisa logout
- Klik tombol logout
- Sistem log aktivitas logout terlebih dahulu
- Sistem destroy session dan clear authentication
- Regenerate CSRF token untuk keamanan
- Redirect ke halaman login dengan pesan sukses

---

## 8. Sequence Diagram: Proses Lihat Gaji (Guru Activity)

```mermaid
sequenceDiagram
    actor Guru
    participant Browser
    participant GajiController
    participant RoleMiddleware
    participant Auth as Laravel Auth
    participant GuruService
    participant AbsensiService
    participant Database
    participant Carbon

    Guru->>Browser: Klik menu "Gaji Saya"
    Browser->>GajiController: GET /guru/gaji

    GajiController->>RoleMiddleware: Check role 'guru'
    RoleMiddleware->>Auth: Get authenticated user
    Auth-->>RoleMiddleware: User object
    RoleMiddleware->>Database: Check user roles

    alt User bukan Guru
        Database-->>RoleMiddleware: Role tidak sesuai
        RoleMiddleware-->>Browser: Error 403 Forbidden
        Browser-->>Guru: Akses ditolak
    else User adalah Guru
        Database-->>RoleMiddleware: Role 'guru' confirmed
        RoleMiddleware-->>GajiController: Access granted

        GajiController-->>Browser: Tampilkan form filter bulan
        Browser-->>Guru: Form pilih bulan/tahun

        Guru->>Browser: Pilih bulan (misal: 2025-05)<br/>Klik "Lihat Gaji"
        Browser->>GajiController: GET /guru/gaji?month=2025-05

        GajiController->>Carbon: Parse month parameter
        Carbon-->>GajiController: Month object

        GajiController->>Auth: Get authenticated user
        Auth-->>GajiController: User object

        GajiController->>Database: Get guru from user_id
        Database-->>GajiController: Guru object

        Note over GajiController,GuruService: Hitung komponen gaji
        GajiController->>GuruService: calculateSalaryComponents(guru_id, month)

        GuruService->>Database: Get guru data<br/>(gaji_pokok, tunjangan)
        Database-->>GuruService: Guru: {<br/>  gaji_pokok: 5000000,<br/>  tunjangan: 1000000<br/>}

        Note over GuruService,AbsensiService: Ambil data kehadiran
        GuruService->>AbsensiService: getAttendanceSummary(guru_id, month)

        AbsensiService->>Carbon: Get date range untuk bulan
        Carbon-->>AbsensiService: startDate, endDate

        AbsensiService->>Database: Query absensis WHERE<br/>guru_id AND<br/>tanggal BETWEEN startDate AND endDate
        Database-->>AbsensiService: Collection of Absensi

        AbsensiService->>AbsensiService: Hitung per status:<br/>hadir = 18<br/>terlambat = 3<br/>izin = 1<br/>sakit = 0<br/>alpha = 1

        AbsensiService->>Carbon: Count hari kerja dalam bulan
        Carbon-->>AbsensiService: total_hari_kerja = 23

        AbsensiService-->>GuruService: {<br/>  hadir: 18,<br/>  terlambat: 3,<br/>  izin: 1,<br/>  sakit: 0,<br/>  alpha: 1,<br/>  total_hari_kerja: 23<br/>}

        Note over GuruService: Perhitungan gaji
        GuruService->>GuruService: Hitung potongan:<br/>potongan_terlambat = 3 × 50000 = 150000<br/>potongan_alpha = 1 × 200000 = 200000<br/>total_potongan = 350000

        GuruService->>GuruService: Hitung gaji bersih:<br/>gaji_bersih = 5000000 + 1000000 - 350000<br/>gaji_bersih = 5650000

        GuruService-->>GajiController: {<br/>  gaji_pokok: 5000000,<br/>  tunjangan: 1000000,<br/>  kehadiran: {...},<br/>  potongan: {<br/>    terlambat: 150000,<br/>    alpha: 200000,<br/>    total: 350000<br/>  },<br/>  total_gaji: 5650000<br/>}

        GajiController-->>Browser: View detail gaji
        Browser-->>Guru: Tampilkan detail gaji:<br/><br/>Gaji Pokok: Rp 5.000.000<br/>Tunjangan: Rp 1.000.000<br/>─────────────────────<br/>Subtotal: Rp 6.000.000<br/><br/>Kehadiran:<br/>- Hadir: 18 hari<br/>- Terlambat: 3 hari<br/>- Alpha: 1 hari<br/><br/>Potongan:<br/>- Terlambat (3×): Rp 150.000<br/>- Alpha (1×): Rp 200.000<br/>─────────────────────<br/>Total Potongan: Rp 350.000<br/><br/>GAJI BERSIH: Rp 5.650.000
    end
```

**Penjelasan:**
- Guru login dan klik menu "Gaji Saya"
- Middleware check role 'guru'
- Tampilkan form filter bulan/tahun
- Guru pilih bulan dan klik "Lihat Gaji"
- Sistem ambil data gaji pokok dan tunjangan dari tabel Guru
- Sistem ambil data absensi untuk bulan tersebut
- Hitung jumlah per status (hadir, terlambat, izin, sakit, alpha)
- Hitung total potongan: (Terlambat × 50.000) + (Alpha × 200.000)
- Hitung gaji bersih: Gaji Pokok + Tunjangan - Total Potongan
- Tampilkan detail gaji lengkap dengan breakdown

---

## 9. Sequence Diagram: Proses Lihat Absensi (Guru Activity)

```mermaid
sequenceDiagram
    actor Guru
    participant Browser
    participant AbsensiController
    participant RoleMiddleware
    participant Auth as Laravel Auth
    participant AbsensiService
    participant Database
    participant Carbon

    Guru->>Browser: Klik menu "Riwayat Absensi"
    Browser->>AbsensiController: GET /guru/absensi

    AbsensiController->>RoleMiddleware: Check role 'guru'
    RoleMiddleware->>Auth: Get authenticated user
    Auth-->>RoleMiddleware: User object
    RoleMiddleware->>Database: Check user roles

    alt User bukan Guru
        Database-->>RoleMiddleware: Role tidak sesuai
        RoleMiddleware-->>Browser: Error 403 Forbidden
        Browser-->>Guru: Akses ditolak
    else User adalah Guru
        Database-->>RoleMiddleware: Role 'guru' confirmed
        RoleMiddleware-->>AbsensiController: Access granted

        AbsensiController-->>Browser: Tampilkan form filter
        Browser-->>Guru: Form filter bulan/tahun

        Guru->>Browser: Pilih bulan (2025-05)<br/>atau biarkan default (bulan ini)
        Browser->>AbsensiController: GET /guru/absensi?month=2025-05

        AbsensiController->>Carbon: Parse month parameter
        Carbon-->>AbsensiController: Month object

        AbsensiController->>Auth: Get authenticated user
        Auth-->>AbsensiController: User object

        AbsensiController->>Database: Get guru from user_id
        Database-->>AbsensiController: Guru object

        Note over AbsensiController,AbsensiService: Ambil data absensi
        AbsensiController->>AbsensiService: getGuruAttendance(guru_id, month)

        AbsensiService->>Carbon: Get date range untuk bulan
        Carbon-->>AbsensiService: startDate, endDate

        AbsensiService->>Database: Query absensis WHERE<br/>guru_id = ? AND<br/>tanggal BETWEEN ? AND ?<br/>ORDER BY tanggal DESC
        Database-->>AbsensiService: Collection of Absensi

        AbsensiService->>AbsensiService: Format data:<br/>- Tanggal<br/>- Hari<br/>- Status<br/>- Waktu Masuk<br/>- Waktu Pulang<br/>- Total Jam Kerja

        AbsensiService->>AbsensiService: Hitung ringkasan:<br/>- Total hadir<br/>- Total terlambat<br/>- Total izin<br/>- Total sakit<br/>- Total alpha<br/>- Persentase kehadiran

        AbsensiService-->>AbsensiController: {<br/>  data: [array of absensi],<br/>  summary: {<br/>    hadir: 18,<br/>    terlambat: 3,<br/>    izin: 1,<br/>    sakit: 0,<br/>    alpha: 1,<br/>    total_hari: 23,<br/>    persentase: 91.3%<br/>  }<br/>}

        AbsensiController-->>Browser: View riwayat absensi
        Browser-->>Guru: Tampilkan tabel absensi:<br/><br/>Ringkasan:<br/>- Hadir: 18 hari<br/>- Terlambat: 3 hari<br/>- Alpha: 1 hari<br/>- Persentase: 91.3%<br/><br/>Detail per tanggal:<br/>| Tanggal | Status | Masuk | Pulang |
    end
```

**Penjelasan:**
- Guru login dan klik menu "Riwayat Absensi"
- Middleware check role 'guru'
- Tampilkan form filter bulan/tahun (default: bulan ini)
- Guru bisa memilih bulan lain atau menggunakan default
- Sistem ambil data absensi guru untuk bulan tersebut, diurutkan dari terbaru
- Format data dengan informasi lengkap (tanggal, status, waktu masuk/pulang, jam kerja)
- Hitung ringkasan kehadiran (total per status dan persentase)
- Tampilkan tabel riwayat absensi dengan ringkasan di atas

---

## 10. Sequence Diagram: Proses Update Data Guru (Admin Activity)

```mermaid
sequenceDiagram
    actor Admin
    participant Browser
    participant GuruController
    participant RoleMiddleware
    participant Request as FormRequest
    participant GuruService
    participant Database
    participant Hash
    participant ActivityService

    Admin->>Browser: Klik "Edit" pada data guru
    Browser->>GuruController: GET /admin/guru/{id}/edit

    GuruController->>RoleMiddleware: Check role 'admin'
    RoleMiddleware->>Database: Verify admin role

    alt Bukan admin
        Database-->>RoleMiddleware: Role tidak sesuai
        RoleMiddleware-->>Browser: Error 403
        Browser-->>Admin: Akses ditolak
    else Admin confirmed
        Database-->>RoleMiddleware: Role admin
        RoleMiddleware-->>GuruController: Access granted

        GuruController->>Database: Get guru by ID
        Database-->>GuruController: Guru object

        alt Guru tidak ditemukan
            GuruController-->>Browser: Error 404 Not Found
            Browser-->>Admin: Guru tidak ditemukan
        else Guru ditemukan
            GuruController-->>Browser: Form edit guru<br/>dengan data existing
            Browser-->>Admin: Tampilkan form terisi

            Admin->>Browser: Edit data:<br/>- Nama<br/>- NIP<br/>- Jabatan<br/>- Status Kepegawaian<br/>- Gaji Pokok<br/>- Tunjangan<br/>- Email<br/>- Password (opsional)
            Admin->>Browser: Submit form

            Browser->>GuruController: PUT /admin/guru/{id}

            GuruController->>Request: Validasi input
            Request->>Request: Validate rules:<br/>- NIP unique (except self)<br/>- Email unique (except self)<br/>- Password min 8 char (if provided)<br/>- Required fields

            alt Validasi gagal
                Request-->>GuruController: Validation errors
                GuruController-->>Browser: Redirect back with errors
                Browser-->>Admin: Form + pesan error
            else Validasi berhasil
                Request-->>GuruController: Validated data

                GuruController->>GuruService: updateGuru(guru_id, guruData, userData)

                GuruService->>Database: BEGIN TRANSACTION

                Note over GuruService,Database: Step 1: Update User Account
                GuruService->>Database: Get user from guru
                Database-->>GuruService: User object

                alt Password diubah
                    GuruService->>Hash: Hash new password
                    Hash-->>GuruService: Hashed password
                    GuruService->>Database: UPDATE users<br/>SET name, email, password
                else Password tidak diubah
                    GuruService->>Database: UPDATE users<br/>SET name, email
                end

                alt Email sudah dipakai user lain
                    Database-->>GuruService: Error duplicate email
                    GuruService->>Database: ROLLBACK
                    GuruService-->>GuruController: Error
                    GuruController-->>Browser: Error email exists
                    Browser-->>Admin: Pesan error
                else User updated
                    Database-->>GuruService: User updated

                    Note over GuruService,Database: Step 2: Update Guru Profile
                    GuruService->>Database: UPDATE gurus<br/>SET nip, nama, jabatan,<br/>status_kepegawaian,<br/>gaji_pokok, tunjangan

                    alt NIP sudah dipakai guru lain
                        Database-->>GuruService: Error duplicate NIP
                        GuruService->>Database: ROLLBACK
                        GuruService-->>GuruController: Error
                        GuruController-->>Browser: Error NIP exists
                        Browser-->>Admin: Pesan error
                    else Guru updated
                        Database-->>GuruService: Guru updated

                        Note over GuruService,ActivityService: Step 3: Log aktivitas
                        GuruService->>ActivityService: record('update_guru', description, admin_id)
                        ActivityService->>Database: INSERT INTO activities
                        Database-->>ActivityService: Activity logged
                        ActivityService-->>GuruService: Success

                        GuruService->>Database: COMMIT TRANSACTION

                        GuruService-->>GuruController: Success + updated guru object

                        GuruController-->>Browser: Redirect ke /admin/guru<br/>dengan flash success
                        Browser-->>Admin: Daftar guru + pesan sukses<br/>"Data guru berhasil diupdate"
                    end
                end
            end
        end
    end
```

**Penjelasan:**
- Admin login dan klik tombol "Edit" pada data guru tertentu
- Middleware check role 'admin'
- Sistem ambil data guru yang akan diedit
- Jika tidak ditemukan, return error 404
- Jika ditemukan, tampilkan form edit dengan data existing
- Admin edit data yang ingin diubah (bisa semua field atau sebagian)
- Password bersifat opsional (jika tidak diisi, password lama tetap digunakan)
- Submit form dan validasi input
- Jika validasi gagal, kembali ke form dengan error
- Jika berhasil, mulai database transaction:
  1. Update user account (name, email, dan password jika diubah)
  2. Update profil guru (NIP, nama, jabatan, gaji, dll)
  3. Log aktivitas admin
- Commit transaction
- Redirect ke daftar guru dengan pesan sukses

---

## Penjelasan Komponen Sequence Diagram

### Aktor
- **User**: Pengguna umum yang belum login
- **Admin**: Administrator sistem dengan full access
- **Kepala Sekolah**: User dengan role kepala sekolah (read-only)
- **Guru**: User dengan role guru (self-service)

### Participants (Komponen Sistem)
1. **Browser**: Interface pengguna (frontend)
2. **Controller**: HTTP Controller (AbsensiController, GuruController, dll)
3. **Middleware**: RoleMiddleware, AuthMiddleware
4. **Service Layer**: GuruService, AbsensiService, ActivityService
5. **Database**: MySQL Database
6. **Auth**: Laravel Authentication System
7. **Session**: Session Manager
8. **Carbon**: Date/Time Library
9. **Hash**: Password Hashing
10. **Event**: Event Dispatcher
11. **Mail**: Email Service
12. **PDF/Excel**: Export Library

### Flow Pattern
Semua sequence diagram mengikuti pattern:
1. **Request** dari user
2. **Authentication & Authorization** check
3. **Validation** input data
4. **Business Logic** processing
5. **Database Transaction** (jika ada perubahan data)
6. **Response** ke user

### Error Handling
Setiap diagram menunjukkan alt/else untuk:
- Validasi gagal
- Authentication gagal
- Authorization ditolak
- Database constraint violation
- Business logic error
