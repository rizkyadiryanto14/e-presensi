<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class AbsensiService
{

    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Record attendance for a teacher
     */
    public function catatAbsensi(Guru $guru, array $data)
    {
        $absensi = Absensi::updateOrCreate(
            [
                'guru_id' => $guru->id,
                'tanggal' => Carbon::parse($data['tanggal'])->toDateString(),
            ],
            [
                'status' => $data['status'],
                'waktu_masuk' => $data['waktu_masuk'] ?? null,
                'waktu_pulang' => $data['waktu_pulang'] ?? null
            ]
        );

        $admin = Auth::user();
        $this->activityService->record(
            'admin_action',
            "Admin telah mencatat/mengubah presensi {$guru->nama}",
            $guru->id,
            $admin->id
        );

        return $absensi;
    }

    /**
     * Get attendance data for a specific teacher and month
     *
     * @param int $guruId
     * @param string $month Format: YYYY-MM
     * @return Collection
     */
    public function getAbsensiByGuruAndMonth(int $guruId, string $month): Collection
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        $year = $date->year;
        $monthNumber = $date->month;

        return Absensi::where('guru_id', $guruId)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $monthNumber)
            ->orderBy('tanggal')
            ->get();
    }

    /**
     * Get attendance data for a specific teacher
     *
     * @param int $guruId
     * @param array $filters
     * @return Collection
     */
    public function getAbsensiByGuru(int $guruId, array $filters = []): Collection
    {
        $query = Absensi::where('guru_id', $guruId);

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('tanggal', [
                Carbon::parse($filters['start_date'])->toDateString(),
                Carbon::parse($filters['end_date'])->toDateString()
            ]);
        }

        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    /**
     * Get attendance summary for a specific teacher
     *
     * @param int $guruId
     * @param string $month Format: YYYY-MM
     * @return array
     */
    public function getAttendanceSummary(int $guruId, string $month): array
    {
        $absensis = $this->getAbsensiByGuruAndMonth($guruId, $month);

        return [
            'total' => $absensis->count(),
            'hadir' => $absensis->where('status', 'hadir')->count(),
            'terlambat' => $absensis->where('status', 'terlambat')->count(),
            'izin' => $absensis->where('status', 'izin')->count(),
            'tidak_hadir' => $absensis->where('status', 'alpha')->count(),
        ];
    }

    /**
     * Get attendance summaries for all teachers in a specific month
     *
     * @param string $month Format: YYYY-MM
     * @return array
     */
    public function getAllTeacherAttendanceSummary(string $month): array
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        $year = $date->year;
        $monthNumber = $date->month;

        // Get all teachers
        $gurus = Guru::all();
        $summaries = [];

        foreach ($gurus as $guru) {
            $absensis = Absensi::where('guru_id', $guru->id)
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $monthNumber)
                ->get();

            $summaries[$guru->id] = [
                'guru' => $guru,
                'total' => $absensis->count(),
                'hadir' => $absensis->where('status', 'hadir')->count(),
                'terlambat' => $absensis->where('status', 'terlambat')->count(),
                'izin' => $absensis->where('status', 'izin')->count(),
                'tidak_hadir' => $absensis->where('status', 'alpha')->count(),
            ];
        }

        return $summaries;
    }

    /**
     * Get daily attendance data for all teachers
     *
     * @param string $date Format: YYYY-MM-DD
     * @return Collection
     */
    public function getDailyAttendance(string $date): Collection
    {
        return Absensi::with('guru')
            ->where('tanggal', Carbon::parse($date)->toDateString())
            ->orderBy('waktu_masuk')
            ->get();
    }

    /**
     * Get today's attendance data for all teachers
     *
     * @return Collection
     */
    public function getTodayAttendance(): Collection
    {
        return $this->getDailyAttendance(Carbon::today()->toDateString());
    }

    /**
     * Check if a teacher has checked in today
     *
     * @param int $guruId
     * @return bool
     */
    public function hasCheckedInToday(int $guruId): bool
    {
        return Absensi::where('guru_id', $guruId)
            ->where('tanggal', Carbon::today()->toDateString())
            ->exists();
    }

    /**
     * Record check-in for a teacher
     */
    public function recordCheckIn(int $guruId, string $status = 'hadir'): Absensi
    {
        $now = Carbon::now();
        $isLate = $now->hour >= 8;

        if ($isLate && $status === 'hadir') {
            $status = 'terlambat';
        }

        $absensi = Absensi::updateOrCreate(
            [
                'guru_id' => $guruId,
                'tanggal' => $now->toDateString(),
            ],
            [
                'status' => $status,
                'waktu_masuk' => $now->toTimeString(),
                'waktu_pulang' => null
            ]
        );

        $guru = Guru::find($guruId);
        $this->activityService->record(
            $status,
            "{$guru->nama} telah melakukan presensi masuk",
            $guruId
        );

        return $absensi;
    }
    /**
     * Record check-out for a teacher
     */
    public function recordCheckOut(int $guruId): ?Absensi
    {
        $now = Carbon::now();
        $absensi = Absensi::where('guru_id', $guruId)
            ->where('tanggal', $now->toDateString())
            ->first();

        if (!$absensi) {
            return null;
        }

        $absensi->waktu_pulang = $now->toTimeString();
        $absensi->save();

        $guru = Guru::find($guruId);
        $this->activityService->record(
            'checkout',
            "{$guru->nama} telah melakukan presensi pulang",
            $guruId
        );

        return $absensi;
    }
    /**
     * Get attendance statistics for admin dashboard
     *
     * @return array
     */
    public function getAttendanceStats(): array
    {
        $today = Carbon::today()->toDateString();
        $totalGuru = Guru::count();
        $todayAttendance = Absensi::where('tanggal', $today)->count();
        $hadirCount = Absensi::where('tanggal', $today)
            ->where('status', 'hadir')
            ->count();
        $terlambatCount = Absensi::where('tanggal', $today)
            ->where('status', 'terlambat')
            ->count();
        $izinCount = Absensi::where('tanggal', $today)
            ->where('status', 'izin')
            ->count();
        $tidakHadirCount = $totalGuru - $hadirCount - $terlambatCount - $izinCount;

        $attendancePercentage = $totalGuru > 0 ?
            round(($hadirCount + $terlambatCount + $izinCount) / $totalGuru * 100) : 0;

        return [
            'total_guru' => $totalGuru,
            'hadir' => $hadirCount,
            'terlambat' => $terlambatCount,
            'izin' => $izinCount,
            'tidak_hadir' => $tidakHadirCount,
            'persentase_kehadiran' => $attendancePercentage,
        ];
    }

    /**
     * Get monthly attendance statistics
     *
     * @param string $month Format: YYYY-MM
     * @return array
     */
    public function getMonthlyStats(string $month): array
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        $year = $date->year;
        $monthNumber = $date->month;

        $daysInMonth = $date->daysInMonth;
        $workingDays = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = Carbon::create($year, $monthNumber, $day);
            // Skip weekends (Sunday)
            if ($currentDate->dayOfWeek !== Carbon::SUNDAY) {
                $workingDays++;
            }
        }

        $attendanceByStatus = Absensi::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $monthNumber)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $hadirCount = $attendanceByStatus['hadir'] ?? 0;
        $terlambatCount = $attendanceByStatus['terlambat'] ?? 0;
        $izinCount = $attendanceByStatus['izin'] ?? 0;
        $tidakHadirCount = $attendanceByStatus['alpha'] ?? 0;

        $totalGuru = Guru::count();
        $totalPotentialAttendances = $totalGuru * $workingDays;

        $attendancePercentage = $totalPotentialAttendances > 0 ?
            round(($hadirCount + $terlambatCount + $izinCount) / $totalPotentialAttendances * 100) : 0;

        // Calculate total salary for the month
        $gurus = Guru::all();
        $totalGaji = 0;

        foreach ($gurus as $guru) {
            // Calculate salary components for each guru
            $gajiPokok = $guru->gaji_pokok;
            $tunjangan = $guru->tunjangan ?? 0;

            // Calculate deductions based on attendance
            $absensiGuru = Absensi::where('guru_id', $guru->id)
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $monthNumber)
                ->get();

            $totalTerlambat = $absensiGuru->where('status', 'terlambat')->count();
            $totalTidakHadir = $absensiGuru->where('status', 'alpha')->count();

            $potonganTerlambat = $totalTerlambat * 50000;
            $potonganTidakHadir = $totalTidakHadir * 200000;

            $totalPotongan = $potonganTerlambat + $potonganTidakHadir;
            $gajiBersih = $gajiPokok + $tunjangan - $totalPotongan;

            $totalGaji += $gajiBersih;
        }

        return [
            'working_days' => $workingDays,
            'total_guru' => $totalGuru,
            'hadir' => $hadirCount,
            'terlambat' => $terlambatCount,
            'izin' => $izinCount,
            'tidak_hadir' => $tidakHadirCount,
            'persentase_kehadiran' => $attendancePercentage,
            'total_gaji' => $totalGaji,
        ];
    }

    /**
     * Get weekly attendance statistics
     *
     * @return array
     */
    public function getWeeklyAttendanceStats(): array
    {
        $today = Carbon::now();
        $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $today->copy()->endOfWeek(Carbon::SATURDAY); // Exclude Sunday

        $days = [];
        $dayLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $hadirData = [];
        $terlambatData = [];
        $izinData = [];
        $tidakHadirData = [];

        for ($i = 0; $i < 6; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);

            if ($currentDate->isAfter($today)) {
                $hadirData[] = 0;
                $terlambatData[] = 0;
                $izinData[] = 0;
                $tidakHadirData[] = 0;
                continue;
            }

            // Get attendance data for this day
            $attendanceByStatus = Absensi::whereDate('tanggal', $currentDate->format('Y-m-d'))
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();

            $hadirData[] = $attendanceByStatus['hadir'] ?? 0;
            $terlambatData[] = $attendanceByStatus['terlambat'] ?? 0;
            $izinData[] = $attendanceByStatus['izin'] ?? 0;
            $tidakHadirData[] = $attendanceByStatus['alpha'] ?? 0; // Using 'alpha' as in your code
        }

        return [
            'labels' => $dayLabels,
            'hadir' => $hadirData,
            'terlambat' => $terlambatData,
            'izin' => $izinData,
            'tidak_hadir' => $tidakHadirData
        ];
    }
}
