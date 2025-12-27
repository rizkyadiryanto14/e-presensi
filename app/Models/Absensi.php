<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static count()
 * @method static where(string $string, string $today)
 * @method static whereYear(string $string, int $year)
 */
class Absensi extends Model
{
    use hasFactory, SoftDeletes;

    protected $table = 'absensis';

    protected $fillable = [
        'guru_id',
        'tanggal',
        'status',
        'waktu_pulang',
        'waktu_masuk',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
