<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Absensi;
use App\Services\AbsensiService;
use App\Services\GuruService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;

class AbsensiController extends Controller
{
    protected $absensiService;
    protected $guruService;

    public function __construct(AbsensiService $absensiService, GuruService $guruService)
    {
        $this->absensiService = $absensiService;
        $this->guruService = $guruService;
    }

    /**
     * Dashboard for admin to view attendance statistics
     */
    public function dashboard()
    {
        $stats = $this->absensiService->getAttendanceStats();
        $todayAttendance = $this->absensiService->getTodayAttendance();

        $currentMonth = Carbon::now()->format('Y-m');
        $monthlyStats = $this->absensiService->getMonthlyStats($currentMonth);

        return view('modules.absensi.index', compact('stats', 'todayAttendance', 'monthlyStats'));
    }

    /**
     * Display attendance form for teachers to check in/out
     */
    public function checkInForm()
    {
        $user = Auth::user();

        // Check if the logged-in user is a teacher
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $hasCheckedIn = $this->absensiService->hasCheckedInToday($guru->id);
        $absensiToday = null;

        if ($hasCheckedIn) {
            $absensiToday = Absensi::where('guru_id', $guru->id)
                ->where('tanggal', Carbon::today()->toDateString())
                ->first();
        }

        return view('modules.absensi.check-in', compact('guru', 'hasCheckedIn', 'absensiToday'));
    }

    /**
     * Process check-in
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $status = $request->input('status', 'hadir');

        $absensi = $this->absensiService->recordCheckIn($guru->id, $status);

        return redirect()->route('absensi.check-in')
            ->with('success', 'Absensi berhasil dicatat. Status: ' . ucfirst($absensi->status));
    }

    /**
     * Process check-out
     */
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $absensi = $this->absensiService->recordCheckOut($guru->id);

        if (!$absensi) {
            return redirect()->route('absensi.check-in')
                ->with('error', 'Anda belum melakukan check-in hari ini');
        }

        return redirect()->route('absensi.check-in')
            ->with('success', 'Check-out berhasil dicatat');
    }

    /**
     * Display attendance history for a teacher
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $filters = [
            'start_date' => $request->input('start_date', Carbon::now()->startOfMonth()->toDateString()),
            'end_date' => $request->input('end_date', Carbon::now()->toDateString()),
            'status' => $request->input('status')
        ];

        $absensis = $this->absensiService->getAbsensiByGuru($guru->id, $filters);

        // Get current month's summary
        $currentMonth = Carbon::now()->format('Y-m');
        $summary = $this->absensiService->getAttendanceSummary($guru->id, $currentMonth);

        return view('modules.absensi.history', compact('absensis', 'guru', 'filters', 'summary'));
    }

    /**
     * Admin view to display all teacher attendance for a specific day
     */
    public function daily(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $attendance = $this->absensiService->getDailyAttendance($date);

        $allTeachers = $this->guruService->getAllGuru(100)->items();
        $attendedTeacherIds = $attendance->pluck('guru_id')->toArray();

        $notAttendedTeachers = collect($allTeachers)->filter(function ($guru) use ($attendedTeacherIds) {
            return !in_array($guru->id, $attendedTeacherIds);
        });

        return view('modules.absensi.daily', compact('attendance', 'notAttendedTeachers', 'date', 'allTeachers'));
    }

    /**
     * Admin view to display monthly attendance reports
     */
    public function monthly(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $summaries = $this->absensiService->getAllTeacherAttendanceSummary($month);
        $monthlyStats = $this->absensiService->getMonthlyStats($month);

        return view('modules.absensi.monthly', compact('summaries', 'month', 'monthlyStats'));
    }

    /**
     * Admin function to manually record attendance
     */
    public function recordManual(Request $request)
    {
        $this->validate($request, [
            'guru_id' => 'required|exists:gurus,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,terlambat,izin,alpha,sakit',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_pulang' => 'nullable|date_format:H:i',
        ]);

        $guru = $this->guruService->getGuruById($request->guru_id);

        $data = [
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'waktu_masuk' => $request->waktu_masuk,
            'waktu_pulang' => $request->waktu_pulang
        ];

        $this->absensiService->catatAbsensi($guru, $data);

        return redirect()->back()->with('success', 'Absensi berhasil dicatat');
    }

    /**
     * Export attendance data
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'pdf');
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $summaries = $this->absensiService->getAllTeacherAttendanceSummary($month);
        $monthlyStats = $this->absensiService->getMonthlyStats($month);
        $formattedMonth = Carbon::createFromFormat('Y-m', $month)->format('F Y');

        if ($type == 'pdf') {
            $pdf = PDF::loadView('exports.absensi.pdf', compact('summaries', 'monthlyStats', 'formattedMonth'));
            return $pdf->download('laporan-absensi-' . $month . '.pdf');
        } else {
            return Excel::download(new AbsensiExport($summaries, $monthlyStats, $month), 'laporan-absensi-' . $month . '.xlsx');
        }
    }
}
