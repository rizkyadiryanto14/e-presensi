<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static count()
 * @method static where(string $string, string $today)
 * @method static whereYear(string $string, int $year)
 * @method static updateOrCreate(array $array, array $array1)
 * @method static whereDate(string $string, string $format)
 * @method static firstOrCreate(array $array, array $array1)
 * @property mixed $status
 */
class Absensi extends Model
{
    use SoftDeletes;

    protected $table = 'absensis';

    protected $fillable = [
        'guru_id',
        'tanggal',
        'status',
        'waktu_pulang',
        'waktu_masuk',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }
}
