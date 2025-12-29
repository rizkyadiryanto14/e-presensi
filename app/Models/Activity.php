<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class Activity extends Model
{

    /**
     * @var string
     */
    protected $table = 'activities';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'guru_id',
        'type',
        'description',
        'data'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }
}
