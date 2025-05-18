<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Services\AbsensiService;
use App\Services\GuruService;
use App\Services\ActivityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $absensiService;
    protected $guruService;
    protected $activityService;

    public function __construct(
        AbsensiService $absensiService,
        GuruService $guruService,
        ActivityService $activityService
    )
    {
        $this->absensiService = $absensiService;
        $this->guruService = $guruService;
        $this->activityService = $activityService;
    }

    /**
     * Display dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole(['admin', 'kepala sekolah'])) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('guru')) {
            return $this->guruDashboard();
        }

        return view('dashboard');
    }

    /**
     * Dashboard for admin and principal
     */
    private function adminDashboard()
    {
        $stats = $this->absensiService->getAttendanceStats();

        $guruStats = $this->guruService->getGuruStatistics();

        $todayAttendance = $this->absensiService->getTodayAttendance();

        $currentMonth = Carbon::now()->format('Y-m');
        $monthlyStats = $this->absensiService->getMonthlyStats($currentMonth);

        $recentActivities = $this->activityService->getRecent(5);
        $weeklyAttendance = $this->absensiService->getWeeklyAttendanceStats();

        return view('dashboard', compact('stats', 'guruStats', 'todayAttendance', 'monthlyStats', 'recentActivities', 'weeklyAttendance'));
    }

    /**
     * Dashboard for teachers
     */
    private function guruDashboard()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get teacher's attendance status today
        $hasCheckedIn = $this->absensiService->hasCheckedInToday($guru->id);
        $absensiToday = null;

        if ($hasCheckedIn) {
            $absensiToday = Absensi::where('guru_id', $guru->id)
                ->where('tanggal', Carbon::today()->toDateString())
                ->first();
        }

        $currentMonth = Carbon::now()->format('Y-m');
        $summary = $this->absensiService->getAttendanceSummary($guru->id, $currentMonth);

        $monthlyStats = $this->absensiService->getMonthlyStats($currentMonth);
        $workingDays = $monthlyStats['working_days'];

        $recentAbsensis = Absensi::where('guru_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        $estimatedSalary = null;
        if ($guru) {
            $salaryData = $this->guruService->calculateSalaryComponents($guru->id, $currentMonth);
            $estimatedSalary = $salaryData['komponen_gaji'];
        }

        $recentPersonalActivities = $this->activityService->getTeacherActivities($guru->id, 5);
        $weeklyAttendance = $this->absensiService->getWeeklyAttendanceStats();


        return view('dashboard', compact(
            'guru',
            'hasCheckedIn',
            'absensiToday',
            'summary',
            'workingDays',
            'recentAbsensis',
            'estimatedSalary',
            'recentPersonalActivities',
            'weeklyAttendance'
        ));
    }
}
