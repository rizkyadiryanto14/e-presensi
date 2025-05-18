<?php

namespace App\Console\Commands;

use App\Models\Guru;
use App\Models\Absensi;
use App\Services\ActivityService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkAbsentTeachers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:mark-absent {--date= : Tanggal dalam format Y-m-d (default: hari ini)} {--force : Jalankan bahkan pada akhir pekan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menandai guru sebagai tidak hadir jika belum melakukan absensi hari ini';

    /**
     * The activity service instance.
     */
    protected $activityService;

    /**
     * Create a new command instance.
     */
    public function __construct(ActivityService $activityService)
    {
        parent::__construct();
        $this->activityService = $activityService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateOption = $this->option('date');
        $targetDate = $dateOption ? Carbon::parse($dateOption) : Carbon::today();
        $forceRun = $this->option('force');

        $this->info("Memproses ketidakhadiran untuk tanggal: {$targetDate->format('Y-m-d')}");

        if ($targetDate->isWeekend() && !$forceRun) {
            $this->info("Tanggal {$targetDate->format('Y-m-d')} adalah akhir pekan. Proses dibatalkan.");
//            $this->info("Gunakan flag --force untuk menjalankan pada akhir pekan.");
            return 0;
        }

        if ($targetDate->isAfter(Carbon::today())) {
            $this->error("Tidak dapat menandai ketidakhadiran untuk tanggal di masa depan.");
            return 1;
        }

        $guru = Guru::all();
        $this->info("Ditemukan {$guru->count()} guru untuk diproses.");
        $count = 0;

        $bar = $this->output->createProgressBar($guru->count());
        $bar->start();

        foreach ($guru as $g) {
            $hasAttendance = Absensi::where('guru_id', $g->id)
                ->whereDate('tanggal', $targetDate->toDateString())
                ->exists();

            if (!$hasAttendance) {
                try {
                    $absensi = Absensi::create([
                        'guru_id' => $g->id,
                        'tanggal' => $targetDate->toDateString(),
                        'status' => 'alpha',
                        'waktu_masuk' => null,
                        'waktu_pulang' => null
                    ]);

                    // Catat aktivitas
                    $this->activityService->record(
                        'tidak_hadir',
                        "{$g->nama} tidak hadir tanpa keterangan pada {$targetDate->format('d-m-Y')}",
                        $g->id
                    );

                    $count++;
                } catch (\Exception $e) {
                    Log::error("Gagal menandai guru ID: {$g->id} sebagai tidak hadir: " . $e->getMessage());
                    $this->error("Gagal menandai guru {$g->nama} sebagai tidak hadir: " . $e->getMessage());
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Berhasil menandai {$count} guru sebagai tidak hadir untuk tanggal {$targetDate->format('Y-m-d')}.");

        Log::info("Proses penandaan ketidakhadiran selesai untuk {$targetDate->format('Y-m-d')}. {$count} guru ditandai tidak hadir.");

        return 0;
    }
}
