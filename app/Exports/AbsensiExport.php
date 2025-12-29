<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;
use Carbon\Carbon;


class AbsensiExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $summaries;
    protected $monthlyStats;
    protected $month;

    /**
     * @param $summaries
     * @param $monthlyStats
     * @param $month
     */
    public function __construct($summaries, $monthlyStats, $month)
    {
        $this->summaries = $summaries;
        $this->monthlyStats = $monthlyStats;
        $this->month = $month;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        $data = new Collection();

        // Add a summary row
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

        // Add stat rows
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

        // Add an empty row
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

    /**
     * @return string[]
     */
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

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Absensi ' . Carbon::createFromFormat('Y-m', $this->month)->format('F Y');
    }

    /**
     * @param $summary
     * @return float|int
     */
    private function calculatePercentage($summary): float|int
    {
        if ($this->monthlyStats['working_days'] > 0) {
            return round(($summary['hadir'] + $summary['terlambat'] + $summary['izin']) / $this->monthlyStats['working_days'] * 100);
        }
        return 0;
    }
}
