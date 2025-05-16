<?php

namespace App\Services;


use App\Models\Absensi;
use App\Models\Guru;
use Carbon\Carbon;

class AbsensiService
{
    public function catatAbsensi(Guru $guru, array $data)
    {
      return Absensi::updateOrCreate(
          [
              'guru_id'   => $guru->id, 'tanggal' => Carbon::parse($data['tanggal'])->toDateString(),
          ],
          [
              'status'  => $data['status'],
              'waktu'   => $data['waktu_masuk'] ?? null,
              'waktu_pulang' => $data['waktu_pulang'] ?? null
          ]
      );
    }
}
