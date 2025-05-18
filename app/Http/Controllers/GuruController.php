<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Services\GuruService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    protected $guruService;

    public function __construct(GuruService $guruService)
    {
        $this->guruService = $guruService;
    }

    /**
     * Display a listing of teachers
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'status_kepegawaian' => $request->input('status_kepegawaian'),
            'jabatan' => $request->input('jabatan'),
        ];

        $gurus = $this->guruService->getAllGuru(10, $filters);
        $statistics = $this->guruService->getGuruStatistics();

        return view('modules.guru.index', compact('gurus', 'statistics'));
    }

    /**
     * Show the form for creating a new teacher
     */
    public function create()
    {
        return view('modules.guru.create');
    }
    /**
     * Store a newly created teacher
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:gurus,nip',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:100',
            'status_kepegawaian' => 'required|in:PNS,Honorer',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'send_verification_email' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $guruData = $request->only([
                'nip', 'nama', 'jabatan', 'status_kepegawaian', 'gaji_pokok', 'tunjangan'
            ]);

            $userData = $request->only([
                'email', 'password'
            ]);

            // Ambil nilai send_verification_email dari request, defaultnya true jika tidak ada
            $sendVerificationEmail = $request->has('send_verification_email') ? (bool)$request->send_verification_email : true;

            $this->guruService->createGuru($guruData, $userData, $sendVerificationEmail);

            return redirect()->route('admin.guru.index')
                ->with('success', 'Guru berhasil ditambahkan.' . ($sendVerificationEmail ? ' Email verifikasi telah dikirim.' : ''));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan guru: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified teacher
     */
    public function show($id)
    {
        try {
            $guru = $this->guruService->getGuruById($id);

            if (!$guru) {
                return redirect()->route('admin.guru.index')
                    ->with('error', 'Guru tidak ditemukan.');
            }

            return view('modules.guru.show', compact('guru'));
        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified teacher
     */
    public function edit($id)
    {
        try {
            $guru = $this->guruService->getGuruById($id);

            if (!$guru) {
                return redirect()->route('admin.guru.index')
                    ->with('error', 'Guru tidak ditemukan.');
            }

            return view('modules.guru.edit', compact('guru'));
        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified teacher
     */
    public function update(Request $request, $id)
    {
        $guru = $this->guruService->getGuruById($id);

        if (!$guru) {
            return redirect()->route('admin.guru.index')
                ->with('error', 'Guru tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:gurus,nip,' . $id,
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:100',
            'status_kepegawaian' => 'required|in:PNS,Honorer',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'email' => 'nullable|email|unique:users,email,' . $guru->user_id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $guruData = $request->only([
                'nip', 'nama', 'jabatan', 'status_kepegawaian', 'gaji_pokok', 'tunjangan'
            ]);

            $userData = null;
            if ($request->filled('email') || $request->filled('password')) {
                $userData = $request->only(['email', 'password']);
            }

            $guru = $this->guruService->updateGuru($id, $guruData, $userData);

            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data guru: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified teacher
     */
    public function destroy($id)
    {
        try {
            $this->guruService->deleteGuru($id);

            return redirect()->route('admin.guru.index')
                ->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')
                ->with('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
    }

    /**
     * Show salary details for a teacher
     */
    public function showSalaryDetails($id, Request $request)
    {
        $month = $request->input('month', date('Y-m'));

        try {
            $salaryComponents = $this->guruService->calculateSalaryComponents($id, $month);

            return view('modules.guru.salary', compact('salaryComponents'));
        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')
                ->with('error', 'Gagal memuat informasi gaji: ' . $e->getMessage());
        }
    }

    /**
     * Display the authenticated teacher's salary information
     */
    public function showMySalary(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil guru tidak ditemukan.');
        }

        $month = $request->input('month', date('Y-m'));

        try {
            $salaryComponents = $this->guruService->calculateSalaryComponents($guru->id, $month);

            return view('modules.guru.salary', compact('salaryComponents'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Gagal memuat informasi gaji: ' . $e->getMessage());
        }
    }

    /**
     * Display the authenticated teacher's attendance history
     */
    public function showMyAttendance(Request $request)
    {
        $guru = auth()->user()->guru;

        if (!$guru) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil guru tidak ditemukan.');
        }

        $absensis = collect();

        return view('modules.guru.attendance', compact('guru', 'absensis'));
    }

    /**
     * Record check-in for the authenticated teacher
     */
//    public function checkIn(Request $request)
//    {
//        $guru = auth()->user()->guru;
//
//        if (!$guru) {
//            return redirect()->route('dashboard')
//                ->with('error', 'Profil guru tidak ditemukan.');
//        }
//
//        return redirect()->route('guru.profile')
//            ->with('success', 'Presensi masuk berhasil dicatat.');
//    }

    /**
     * Record check-out for the authenticated teacher
     */
//    public function checkOut(Request $request)
//    {
//        $guru = auth()->user()->guru;
//
//        if (!$guru) {
//            return redirect()->route('dashboard')
//                ->with('error', 'Profil guru tidak ditemukan.');
//        }
//
//        return redirect()->route('guru.profile')
//            ->with('success', 'Presensi pulang berhasil dicatat.');
//    }

    /**
     * Display the authenticated teacher's profile
     */
    public function showProfile()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil guru tidak ditemukan.');
        }

        return view('modules.guru.profile', compact('guru'));
    }

}
