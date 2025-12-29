<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;


class UserManagementService
{
    /**
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllUser(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = User::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }
}
