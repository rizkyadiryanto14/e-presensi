<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Gaji;
use App\Services\AbsensiService;
use App\Services\GajiService;
use App\Services\GuruService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ReportController extends Controller
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
     * @return Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        $summary = [
            'totalGuru' => $this->guruService->getTotalGuru(),
            'totalAbsensi' => $this->absensiService->getTotalAbsensi(),
            'totalGajiPencairan' => $this->gajiService->getTotalGajiPencairan(),
            'totalGajiBelumPencairan' => $this->gajiService->getTotalGajiBelumPencairan(),
            'dailyAbsensi' => $this->absensiService->getTodayAttendance()->count(),
            'guruList'      => $this->guruService->getAllGuru(),
            'listAbsensi' => $this->guruService->getAllListAbsensi(),
            'weeklyAttendance' => $this->absensiService->getWeeklyAttendanceStats()
        ];
        return view('modules.report.index', compact('summary'));
    }

    /**
     * calculateFinance
     *
     * @throws Throwable
     */
    public function calculateFinance()
    {
        try {
            $this->gajiService->hitungGajiSemuaGuru();
            return redirect()->route('admin.report.index')->with('success', 'Penggajian berhasil dihitung.');
        } catch (Throwable) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghitung penggajian.');
        }
    }

    /**
     * @param Gaji $gaji
     * @return RedirectResponse
     */
    public function cairkanGaji(Gaji $gaji)
    {
        if ($gaji->bulan && $gaji->tahun) {
            return back()->with('error', 'Gaji sudah dicairkan.');
        }

        $this->gajiService->cairkanGaji($gaji);

        return back()->with('success', 'Gaji berhasil dicairkan.');
    }

}
