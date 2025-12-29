<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\Absensi;
use App\Models\Gaji;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class GajiService
{

    public function getAllGajiById(int $id):?Gaji
    {
        return Gaji::where('guru_id', $id)->latest()->first();
    }

    public function hitungGaji(Guru $guru, ?int $bulan = null, ?int $tahun = null): Gaji
    {
        $now = now();

        $bulan = $bulan ?? $now->month;
        $tahun = $tahun ?? $now->year;

        $absensi = Absensi::where('guru_id', $guru->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $hadir     = $absensi->where('status', 'hadir')->count();
        $alpha     = $absensi->where('status', 'alpha')->count();
        $sakit     = $absensi->where('status', 'sakit')->count();
        $terlambat = $absensi->where('status', 'terlambat')->count();


        $potonganAlphaPerHari     = 20000;
        $potonganTerlambatPerHari = 15000;

        $potonganAlpha     = $alpha * $potonganAlphaPerHari;
        $potonganTerlambat = $terlambat * $potonganTerlambatPerHari;

        $totalPotongan = $potonganAlpha + $potonganTerlambat;

        $total = ($guru->gaji_pokok + $guru->tunjangan) - $totalPotongan;

        return Gaji::updateOrCreate(
            [
                'guru_id' => $guru->id,
            ],
            [
                'jumlah_hadir'     => $hadir,
                'jumlah_alpha'     => $alpha,
                'jumlah_sakit'     => $sakit,
                'jumlah_terlambat' => $terlambat,
                'potongan'         => $totalPotongan,
                'total_gaji'       => $total,
                'tanggal_dibayarkan' => null,
            ]
        );

    }

    /**
     * @throws Throwable
     */
    public function hitungGajiSemuaGuru(): void
    {
        $now = Carbon::now();
        $bulan = $now->month;
        $tahun = $now->year;

        DB::transaction(function () use ($bulan, $tahun) {
            $guruList = Guru::all();

            foreach ($guruList as $guru) {
                $this->hitungGaji($guru, $bulan, $tahun);
            }
        });
    }

    public function cairkanGaji(Gaji $gaji): void
    {
        $now = Carbon::now();

        $gaji->update([
            'bulan' => $now->month,
            'tahun' => $now->year,
            'tanggal_dibayarkan' => $now,
        ]);
    }

    /**
     * Get total gaji
     *
     * @return int
     */
    public function getTotalGajiPencairan(): int
    {
        return (int) Gaji::whereNotNull('tanggal_dibayarkan')->sum('total_gaji');
    }

    public function getTotalGajiBelumPencairan(): int
    {
        return (int) Gaji::whereNull('tanggal_dibayarkan')->sum('total_gaji');
    }
}
