<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gaji extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'gajis';

    protected $fillable = [
        'guru_id',
        'bulan',
        'tahun',
        'jumlah_hadir',
        'jumlah_alpha',
        'potongan',
        'total_gaji',
        'tanggal_dibayarkan'
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }
}
