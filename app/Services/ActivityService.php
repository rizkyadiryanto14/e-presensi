<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ActivityService
{
    /**
     * Record a new activity
     *
     * @param string $type The activity type
     * @param string $description Activity description
     * @param int|null $guruId Teacher ID (optional)
     * @param int|null $userId User ID (optional, default to current user)
     * @param array $data Additional data (optional)
     * @return Activity
     */
    public function record(string $type, string $description, int $guruId = null, int $userId = null, array $data = []): Activity
    {
        $userId = $userId ?? Auth::id();

        return Activity::create([
            'user_id' => $userId,
            'guru_id' => $guruId,
            'type' => $type,
            'description' => $description,
            'data' => $data
        ]);
    }

    /**
     * Get recent activities
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 10): Collection
    {
        return Activity::with(['user', 'guru'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get activities for a specific teacher
     *
     * @param int $guruId
     * @param int $limit
     * @return Collection
     */
    public function getTeacherActivities(int $guruId, int $limit = 10): Collection
    {
        return Activity::with(['user'])
            ->where('guru_id', $guruId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get activities for today
     *
     * @return Collection
     */
    public function getTodayActivities(): Collection
    {
        return Activity::with(['user', 'guru'])
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
