<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\Absensi;
use App\Models\Gaji;
use Carbon\Carbon;
use DB;

class GajiService
{
    public function hitungGaji(Guru $guru, int $bulan, int $tahun): Gaji
    {
        $absensi = Absensi::where('guru_id', $guru->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $hadir = $absensi->where('status', 'hadir')->count();
        $alpha = $absensi->where('status', 'alpha')->count();
        $potonganPerHari = 50000; // bisa dibuat configurable

        $potongan = $alpha * $potonganPerHari;
        $total = $guru->gaji_pokok + $guru->tunjangan - $potongan;

        return Gaji::updateOrCreate(
            ['guru_id' => $guru->id, 'bulan' => $bulan, 'tahun' => $tahun],
            [
                'jumlah_hadir' => $hadir,
                'jumlah_alpha' => $alpha,
                'potongan' => $potongan,
                'total_gaji' => $total,
                'tanggal_dibayarkan' => null
            ]
        );
    }
}
