<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AbsensiExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $summaries;
    protected $monthlyStats;
    protected $month;

    public function __construct($summaries, $monthlyStats, $month)
    {
        $this->summaries = $summaries;
        $this->monthlyStats = $monthlyStats;
        $this->month = $month;
    }

    public function collection()
    {
        $data = new Collection();

        // Add summary row
        $data->push([
            'Laporan Absensi Bulan: ' . Carbon::createFromFormat('Y-m', $this->month)->format('F Y'),
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ]);

        // Add stats rows
        $data->push([
            'Total Guru: ' . $this->monthlyStats['total_guru'],
            'Hari Kerja: ' . $this->monthlyStats['working_days'],
            'Persentase Kehadiran: ' . $this->monthlyStats['persentase_kehadiran'] . '%',
            '',
            '',
            '',
            '',
            ''
        ]);

        // Add empty row
        $data->push([
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ]);

        // Add data rows
        foreach ($this->summaries as $guruId => $summary) {
            $data->push([
                $summary['guru']->nama,
                $summary['guru']->nip,
                $summary['total'],
                $summary['hadir'],
                $summary['terlambat'],
                $summary['izin'],
                $summary['tidak_hadir'],
                $this->calculatePercentage($summary),
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Guru',
            'NIP',
            'Total',
            'Hadir',
            'Terlambat',
            'Izin',
            'Tidak Hadir',
            'Persentase Kehadiran (%)'
        ];
    }

    public function title(): string
    {
        return 'Laporan Absensi ' . Carbon::createFromFormat('Y-m', $this->month)->format('F Y');
    }

    private function calculatePercentage($summary)
    {
        if ($this->monthlyStats['working_days'] > 0) {
            return round(($summary['hadir'] + $summary['terlambat'] + $summary['izin']) / $this->monthlyStats['working_days'] * 100);
        }
        return 0;
    }
}
