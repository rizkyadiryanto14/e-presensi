<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/profile', [GuruController::class, 'showProfile'])->name('guru.profile');
        Route::get('/guru/salary', [GuruController::class, 'showMySalary'])->name('guru.my-salary');
        Route::get('/guru/attendance', [GuruController::class, 'showMyAttendance'])->name('guru.my-attendance');

        Route::get('/absensi/check-in', [AbsensiController::class, 'checkInForm'])->name('absensi.check-in');
        Route::post('/absensi/check-in', [AbsensiController::class, 'checkIn'])->name('absensi.check-in.store');
        Route::post('/absensi/check-out', [AbsensiController::class, 'checkOut'])->name('absensi.check-out');
        Route::get('/absensi/history', [AbsensiController::class, 'history'])->name('absensi.history');
    });

    Route::middleware('role_or_permission:admin|kepala sekolah')->group(function () {
        Route::get('/absensi/dashboard', [AbsensiController::class, 'dashboard'])->name('absensi.dashboard');
        Route::get('/absensi/daily', [AbsensiController::class, 'daily'])->name('absensi.daily');
        Route::get('/absensi/monthly', [AbsensiController::class, 'monthly'])->name('absensi.monthly');
        Route::post('/absensi/record-manual', [AbsensiController::class, 'recordManual'])->name('absensi.record-manual');
        Route::get('/absensi/export', [AbsensiController::class, 'export'])->name('absensi.export');
    });
});

Route::middleware(['auth'])->middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('guru', GuruController::class);
    Route::get('guru/{id}/salary', [GuruController::class, 'showSalaryDetails'])->name('guru.salary');
});

Route::middleware(['auth'])->middleware('role:kepala sekolah')->prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
    Route::get('guru', [GuruController::class, 'index'])->name('guru.index');
    Route::get('guru/{id}', [GuruController::class, 'show'])->name('guru.show');
    Route::get('guru/{id}/salary', [GuruController::class, 'showSalaryDetails'])->name('guru.salary');
});

require __DIR__.'/auth.php';
