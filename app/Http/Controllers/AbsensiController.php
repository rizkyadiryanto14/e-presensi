<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Absensi;
use App\Services\AbsensiService;
use App\Services\GajiService;
use App\Services\GuruService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DomainException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AbsensiController extends Controller
{
    protected AbsensiService $absensiService;
    protected GuruService $guruService;
    protected GajiService $gajiService;

    /**
     * @param AbsensiService $absensiService
     * @param GuruService $guruService
     * @param GajiService $gajiService
     */
    public function __construct(AbsensiService $absensiService, GuruService $guruService, GajiService $gajiService)
    {
        $this->absensiService = $absensiService;
        $this->guruService = $guruService;
        $this->gajiService = $gajiService;
    }


    /**
     * Dashboard for admin to view attendance statistics
     *
     * @return Factory|\Illuminate\Contracts\View\View|View
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
     *
     * @return Factory|\Illuminate\Contracts\View\View|RedirectResponse|View
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
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function checkIn(Request $request)
    {
        try {
            $user = Auth::user();

            $guru = Guru::where('user_id', $user->id)->firstOrFail();

            $status = $request->input('status', 'hadir');
            $absensi = $this->absensiService->recordCheckIn($guru->id, $status);

            return redirect()->route('absensi.check-in')
                ->with(
                    'success',
                    'Absensi berhasil dicatat. Status: ' . ucfirst($absensi->status)
                );

        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());

        } catch (ModelNotFoundException) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }
    }

    /**
     * Process check-out
     *
     * @return RedirectResponse
     */
    public function checkOut()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $absensi = $this->absensiService->recordCheckOut($guru->id);
        $this->gajiService->hitungGaji($guru);

        if (!$absensi) {
            return redirect()->route('absensi.check-in')
                ->with('error', 'Anda belum melakukan check-in hari ini');
        }

        return redirect()->route('absensi.check-in')
            ->with('success', 'Check-out berhasil dicatat');
    }

    /**
     * Display attendance history for a teacher
     *
     * @param Request $request
     * @return Factory|\Illuminate\Contracts\View\View|RedirectResponse|View
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

        // Get the current month's summary
        $currentMonth = Carbon::now()->format('Y-m');
        $summary = $this->absensiService->getAttendanceSummary($guru->id, $currentMonth);

        return view('modules.absensi.history', compact('absensis', 'guru', 'filters', 'summary'));
    }

    /**
     * Admin view to display all teacher attendance for a specific day
     *
     * @param Request $request
     * @return Factory|\Illuminate\Contracts\View\View|View
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
     *
     * @param Request $request
     * @return Factory|\Illuminate\Contracts\View\View|View
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
     *
     * @param Request $request
     * @return RedirectResponse
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
     *
     * @param Request $request
     * @return Response|BinaryFileResponse
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
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
