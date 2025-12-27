<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Throwable;

class GuruService
{
    /**
     * Get all teachers with pagination
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllGuru(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = Guru::with('user');

        if (isset($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                    ->orWhere('nip', 'like', "%{$searchTerm}%")
                    ->orWhere('jabatan', 'like', "%{$searchTerm}%");
            });
        }

        if (isset($filters['status_kepegawaian'])) {
            $query->where('status_kepegawaian', $filters['status_kepegawaian']);
        }

        if (isset($filters['jabatan'])) {
            $query->where('jabatan', $filters['jabatan']);
        }

        return $query->orderBy('nama')->paginate($perPage);
    }

    /**
     * Get a specific teacher by ID
     *
     * @param int $id
     * @return Guru|null
     */
    public function getGuruById(int $id): ?Guru
    {
        return Guru::with('user')->find($id);
    }

    /**
     * Get a specific teacher by NIP
     *
     * @param string $nip
     * @return Guru|null
     */
    public function getGuruByNip(string $nip): ?Guru
    {
        return Guru::where('nip', $nip)->first();
    }

    /**
     * Create a new teacher with a user account
     *
     *
     * @param array $guruData Data guru (nip, nama, jabatan, dll)
     * @param array $userData Data user (email, password)
     * @param bool $sendVerificationEmail
     * @return Guru
     * @throws Exception|Throwable
     */
    public function createGuru(array $guruData, array $userData, bool $sendVerificationEmail = true): Guru
    {
        // Check if NIP already exists
        $existingGuru = $this->getGuruByNip($guruData['nip']);
        if ($existingGuru) {
            throw new Exception('NIP sudah terdaftar dalam sistem.');
        }

        // Check if email already exists
        $existingUser = User::where('email', $userData['email'])->first();
        if ($existingUser) {
            throw new Exception('Email sudah terdaftar dalam sistem.');
        }

        DB::beginTransaction();
        try {
            // Create user account first
            $user = User::create([
                'name' => $guruData['nama'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            // Assign role guru using Spatie Permission
            $user->assignRole('guru');

            // Create teacher profile
            $guru = Guru::create([
                'user_id' => $user->id,
                'nip' => $guruData['nip'],
                'nama' => $guruData['nama'],
                'jabatan' => $guruData['jabatan'],
                'status_kepegawaian' => $guruData['status_kepegawaian'],
                'gaji_pokok' => $guruData['gaji_pokok'],
                'tunjangan' => $guruData['tunjangan'] ?? 0
            ]);

            if ($sendVerificationEmail) {
                event(new Registered($user));
            }

            DB::commit();
            return $guru;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing teacher
     *
     * @param int $id
     * @param array $guruData
     * @param array|null $userData
     * @return Guru
     * @throws Exception|Throwable
     */
    public function updateGuru(int $id, array $guruData, ?array $userData = null): Guru
    {
        $guru = $this->getGuruById($id);
        if (!$guru) {
            throw new Exception('Guru tidak ditemukan.');
        }

        if ($guru->nip !== $guruData['nip']) {
            $existingGuru = $this->getGuruByNip($guruData['nip']);
            if ($existingGuru) {
                throw new Exception('NIP sudah terdaftar dalam sistem.');
            }
        }

        DB::beginTransaction();
        try {
            if ($userData) {
                $user = $guru->user;
                $updateUserData = [
                    'name' => $guruData['nama']
                ];

                if (isset($userData['email']) && $user->email !== $userData['email']) {
                    $existingEmail = User::where('email', $userData['email'])
                        ->where('id', '!=', $user->id)
                        ->first();

                    if ($existingEmail) {
                        throw new Exception('Email sudah terdaftar dalam sistem.');
                    }

                    $updateUserData['email'] = $userData['email'];
                }

                // Update password if provided
                if (isset($userData['password']) && !empty($userData['password'])) {
                    $updateUserData['password'] = Hash::make($userData['password']);
                }

                $user->update($updateUserData);
            }

            // Update guru data
            $guru->update([
                'nip' => $guruData['nip'],
                'nama' => $guruData['nama'],
                'jabatan' => $guruData['jabatan'],
                'status_kepegawaian' => $guruData['status_kepegawaian'],
                'gaji_pokok' => $guruData['gaji_pokok'],
                'tunjangan' => $guruData['tunjangan'] ?? 0
            ]);

            DB::commit();
            return $guru->fresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a teacher (soft delete)
     *
     * @param int $id
     * @return bool
     * @throws Exception|Throwable
     */
    public function deleteGuru(int $id): bool
    {
        $guru = $this->getGuruById($id);
        if (!$guru) {
            throw new Exception('Guru tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            // Get associated user
            $user = $guru->user;

            // Soft delete the guru
            $guru->delete();

            // Check if user only has 'guru' role and no other roles
            if ($user && $user->roles->count() === 1 && $user->hasRole('guru')) {
                $user->delete(); // Soft delete the user
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    /**
     * Get statistics about teachers
     *
     * @return array
     */
    public function getGuruStatistics(): array
    {
        return [
            'total' => Guru::count(),
            'active' => Guru::where('status_kepegawaian', 'PNS')->count(),
            'contract' => Guru::where('status_kepegawaian', 'Honorer')->count(),
            'avg_salary' => Guru::avg('gaji_pokok') ?? 0,
            'by_jabatan' => Guru::select('jabatan', DB::raw('count(*) as total'))
                ->groupBy('jabatan')
                ->pluck('total', 'jabatan')
                ->toArray(),
        ];
    }

    /**
     * Calculate salary components for a specific teacher
     *
     * @param int $guruId
     * @param string $month Format: YYYY-MM
     * @return array
     * @throws Exception
     */
    public function calculateSalaryComponents(int $guruId, string $month): array
    {
        $guru = $this->getGuruById($guruId);
        if (!$guru) {
            throw new Exception('Guru tidak ditemukan.');
        }

        // Get absences for the specified month
        $absensiService = app(AbsensiService::class);
        $absensis = $absensiService->getAbsensiByGuruAndMonth($guruId, $month);

        $totalHadir = $absensis->where('status', 'hadir')->count();
        $totalTerlambat = $absensis->where('status', 'terlambat')->count();
        $totalIzin = $absensis->where('status', 'izin')->count();
        $totalTidakHadir = $absensis->where('status', 'tidak_hadir')->count();

        $potonganTerlambat = $totalTerlambat * 50000;
        $potonganTidakHadir = $totalTidakHadir * 200000;

        $gajiPokok = $guru->gaji_pokok;
        $tunjangan = $guru->tunjangan;
        $totalPotongan = $potonganTerlambat + $potonganTidakHadir;
        $totalGaji = $gajiPokok + $tunjangan - $totalPotongan;

        return [
            'guru' => $guru,
            'bulan' => $month,
            'kehadiran' => [
                'hadir' => $totalHadir,
                'terlambat' => $totalTerlambat,
                'izin' => $totalIzin,
                'tidak_hadir' => $totalTidakHadir,
            ],
            'komponen_gaji' => [
                'gaji_pokok' => $gajiPokok,
                'tunjangan' => $tunjangan,
                'potongan_terlambat' => $potonganTerlambat,
                'potongan_tidak_hadir' => $potonganTidakHadir,
                'total_potongan' => $totalPotongan,
                'gaji_bersih' => $totalGaji,
            ]
        ];
    }

    /**
     * Get the total number of teachers
     *
     * @return int
     */
    public function getTotalGuru(): int
    {
        return Guru::count();
    }
}
