<?php

namespace App\Services;

use App\Models\Gaji;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class SlipGajiService
{
    public function generatePdf(Gaji $gaji): Response
    {
        $pdf = PDF::loadView('pdf.slip_gaji', compact('gaji'));
        return $pdf->download('slip-gaji-'.$gaji->guru->nama.'-'.$gaji->bulan.'-'.$gaji->tahun.'.pdf');
    }
}
