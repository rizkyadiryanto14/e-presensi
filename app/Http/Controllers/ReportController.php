<?php

namespace App\Http\Controllers;

use App\Services\AbsensiService;
use App\Services\GuruService;

class ReportController extends Controller
{
    protected AbsensiService $absensiService;
    protected GuruService $guruService;

    public function __construct(AbsensiService $absensiService, GuruService $guruService)
    {
        $this->absensiService = $absensiService;
        $this->guruService = $guruService;
    }

    public function index()
    {
        $totalGuru = $this->guruService->getTotalGuru();
        $totalAbsensi = $this->absensiService->getTotalAbsensi();
        $dailyAbsensi = $this->absensiService->getTodayAttendance()->count();
        return view('modules.report.index', compact('totalGuru', 'totalAbsensi', 'dailyAbsensi'));
    }
}
