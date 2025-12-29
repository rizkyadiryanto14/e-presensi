<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static updateOrCreate(array $array, array $array1)
 * @method static sum(string $string)
 * @method static whereNotNull(string $string)
 * @method static whereNull(string $string)
 * @method static where(string $string, int $id)
 * @property mixed $bulan
 * @property mixed $tahun
 */
class Gaji extends Model
{
    use softDeletes;

    protected $table = 'gajis';

    protected $fillable = [
        'guru_id',
        'bulan',
        'tahun',
        'jumlah_hadir',
        'jumlah_alpha',
        'jumlah_sakit',
        'jumlah_terlambat',
        'potongan',
        'total_gaji',
        'tanggal_dibayarkan',
        'jumlah_sakit',
        'jumlah_terlambat'
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function statusPencairan(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->bulan && $this->tahun
                ? 'Sudah Dicairkan'
                : 'Belum Dicairkan'
        );
    }

    public function periode(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->bulan && $this->tahun
                ? sprintf('%02d/%d', $this->bulan, $this->tahun)
                : '-'
        );
    }

}
