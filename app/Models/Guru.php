<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static count()
 * @method static where(string $string, string $string1)
 * @method static avg(string $string)
 * @method static select(string $string, Expression|\Illuminate\Database\Query\Expression $raw)
 * @method static find(int $guruId)
 * @method static findOrFail(int $guruId)
 * @property mixed $tunjangan
 * @property mixed $id
 * @property mixed $gaji_pokok
 * @property mixed $user_id
 */
class Guru extends Model
{
    use SoftDeletes;

    protected $table = 'gurus';

    protected $fillable = [
      'user_id',
        'nip',
        'nama',
        'jabatan',
        'status_kepegawaian',
        'gaji_pokok',
        'tunjangan'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function gajis(): hasMany
    {
        return $this->hasMany(Gaji::class);
    }

    public function latestGaji()
    {
        return $this->hasOne(Gaji::class)->latestOfMany();
    }

}
