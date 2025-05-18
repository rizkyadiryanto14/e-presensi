@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            @if(auth()->user()->hasRole('admin'))
                Selamat datang di Panel Admin E-Presensi
            @elseif(auth()->user()->hasRole('kepala sekolah'))
                Selamat datang di Panel Kepala Sekolah E-Presensi
            @elseif(auth()->user()->hasRole('guru'))
                Selamat datang di Panel Guru E-Presensi
            @endif
        </p>
    </div>

    <!-- Dashboard Content -->
    @if(auth()->user()->hasRole(['admin', 'kepala sekolah']))
        <!-- Admin & Kepala Sekolah melihat statistik penuh -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Stat Card 1 - Total Guru -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Guru</p>
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $guruStats['total'] }}</h3>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.guru.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                        <span>Lihat detail</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Stat Card 2 - Total Siswa -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Guru Hadir Hari Ini</p>
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['hadir'] }}/{{ $guruStats['total'] }}</h3>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('absensi.daily') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:underline flex items-center">
                        <span>Lihat detail</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Stat Card 3 - Kehadiran Hari Ini -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kehadiran Hari Ini</p>
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['persentase_kehadiran'] }}%</h3>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('absensi.daily') }}" class="text-sm text-green-600 dark:text-green-400 hover:underline flex items-center">
                        <span>Lihat detail</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Stat Card 4 - Total Kelas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Penggajian Bulan Ini</p>
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">Rp {{ number_format($monthlyStats['total_gaji'] ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="#" class="text-sm text-red-600 dark:text-red-400 hover:underline flex items-center">
                        <span>Lihat detail</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->hasRole('guru'))
        <!-- Guru hanya melihat statistik yang relevan untuk mereka -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Stat Card 1 - Status Kehadiran Hari Ini -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Hari Ini</p>
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">
                            @if($hasCheckedIn)
                                {{ ucfirst($absensiToday->status) }}
                            @else
                                Belum Absen
                            @endif
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-lg
            @if(!$hasCheckedIn)
                bg-red-100 dark:bg-red-900/30
            @elseif($absensiToday->status == 'hadir')
                bg-green-100 dark:bg-green-900/30
            @elseif($absensiToday->status == 'terlambat')
                bg-yellow-100 dark:bg-yellow-900/30
            @elseif($absensiToday->status == 'izin')
                bg-blue-100 dark:bg-blue-900/30
            @else
                bg-red-100 dark:bg-red-900/30
            @endif
            flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6
                @if(!$hasCheckedIn)
                    text-red-600 dark:text-red-400
                @elseif($absensiToday->status == 'hadir')
                    text-green-600 dark:text-green-400
                @elseif($absensiToday->status == 'terlambat')
                    text-yellow-600 dark:text-yellow-400
                @elseif($absensiToday->status == 'izin')
                    text-blue-600 dark:text-blue-400
                @else
                    text-red-600 dark:text-red-400
                @endif"
                             viewBox="0 0 20 20" fill="currentColor">
                            @if(!$hasCheckedIn || $absensiToday->status == 'tidak_hadir')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            @elseif($absensiToday->status == 'hadir')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            @elseif($absensiToday->status == 'terlambat')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            @elseif($absensiToday->status == 'izin')
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            @endif
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('absensi.check-in') }}" class="text-sm text-green-600 dark:text-green-400 hover:underline flex items-center">
                        <span>{{ $hasCheckedIn ? 'Lihat detail' : 'Presensi Sekarang' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Stat Card 2 - Total Kehadiran Bulan Ini -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kehadiran Bulan Ini</p>
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">
                            {{ $summary['hadir'] + $summary['terlambat'] + $summary['izin'] }}/{{ $workingDays }}
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('absensi.history') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                        <span>Lihat riwayat</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Stat Card 3 - Estimasi Gaji Bulan Ini -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estimasi Gaji</p>
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">
                            Rp {{ number_format($estimatedSalary['gaji_bersih'], 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="#" class="text-sm text-yellow-600 dark:text-yellow-400 hover:underline flex items-center">
                        <span>Lihat slip gaji</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Dashboard Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if(auth()->user()->hasRole(['admin', 'kepala sekolah']))
            <!-- Recent Activity - Admin dan Kepala Sekolah melihat aktivitas semua pengguna -->
            <!-- Recent Activity - Admin dan Kepala Sekolah melihat aktivitas semua pengguna -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Aktivitas Terbaru</h3>
                </div>
                <div class="p-5">
                    <div class="space-y-5">
                        @forelse($recentActivities as $activity)
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="h-9 w-9 rounded-full
                            @if($activity->type == 'hadir' || $activity->type == 'checkin')
                                bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400
                            @elseif($activity->type == 'terlambat')
                                bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400
                            @elseif($activity->type == 'izin')
                                bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400
                            @elseif($activity->type == 'tidak_hadir')
                                bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400
                            @elseif($activity->type == 'checkout')
                                bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400
                            @elseif($activity->type == 'admin_action')
                                bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400
                            @else
                                bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400
                            @endif
                            flex items-center justify-center">

                                        @if($activity->type == 'hadir' || $activity->type == 'checkin')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($activity->type == 'terlambat' || $activity->type == 'checkout')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($activity->type == 'izin')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 01-1-1v-4a1 1 0 112 0v4a1 1 0 01-1 1z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($activity->type == 'tidak_hadir')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($activity->type == 'admin_action')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-800 dark:text-gray-200">{{ $activity->description }}</p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                                <p>Belum ada aktivitas terbaru.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-5 text-center">
                        <a href="{{ route('absensi.daily') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            Lihat semua aktivitas
                        </a>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->hasRole('guru'))
            <!-- Guru melihat aktivitas mereka sendiri -->
            <!-- Guru melihat aktivitas mereka sendiri -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Aktivitas Presensi Saya</h3>
                </div>
                <div class="p-5">
                    <div class="space-y-5">
                        @forelse($recentPersonalActivities as $activity)
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="h-9 w-9 rounded-full
                            @if($activity->type == 'hadir' || $activity->type == 'checkin')
                                bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400
                            @elseif($activity->type == 'terlambat')
                                bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400
                            @elseif($activity->type == 'izin')
                                bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400
                            @elseif($activity->type == 'tidak_hadir')
                                bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400
                            @elseif($activity->type == 'checkout')
                                bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400
                            @elseif($activity->type == 'admin_action')
                                bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400
                            @else
                                bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400
                            @endif
                            flex items-center justify-center">

                                        @if($activity->type == 'hadir' || $activity->type == 'checkin')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($activity->type == 'terlambat' || $activity->type == 'checkout')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($activity->type == 'izin')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 01-1-1v-4a1 1 0 112 0v4a1 1 0 01-1 1z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($activity->type == 'tidak_hadir')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($activity->type == 'admin_action')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-800 dark:text-gray-200">
                                        @if(str_contains($activity->description, 'Anda telah'))
                                            {{ $activity->description }}
                                        @else
                                            Anda {{ $activity->description }}
                                        @endif
                                    </p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                                <p>Belum ada aktivitas terbaru.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-5 text-center">
                        <a href="{{ route('absensi.history') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            Lihat semua aktivitas
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Calendar & Shortcuts -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Kalender</h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-7 gap-2 text-center">
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Min</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Sen</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Sel</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Rab</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Kam</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Jum</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Sab</div>

                        @php
                            // Mendapatkan waktu saat ini
                            $now = \Carbon\Carbon::now();
                            $today = $now->day;
                            $currentMonth = $now->month;
                            $currentYear = $now->year;

                            // Mendapatkan tanggal pertama bulan ini
                            $firstDayOfMonth = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1);

                            // Mendapatkan jumlah hari dalam bulan ini
                            $daysInMonth = $now->daysInMonth;

                            // Mendapatkan hari dalam seminggu dari tanggal pertama (0 = Minggu, 6 = Sabtu)
                            $firstDayOfWeek = $firstDayOfMonth->dayOfWeek;

                            // Mendapatkan tanggal terakhir bulan sebelumnya
                            $previousMonth = $firstDayOfMonth->copy()->subMonth();
                            $daysInPreviousMonth = $previousMonth->daysInMonth;

                            // Array untuk menyimpan semua tanggal yang akan ditampilkan
                            $calendarDays = [];

                            // Menambahkan hari-hari dari bulan sebelumnya
                            for ($i = 0; $i < $firstDayOfWeek; $i++) {
                                $calendarDays[] = [
                                    'day' => $daysInPreviousMonth - $firstDayOfWeek + $i + 1,
                                    'current' => false,
                                    'today' => false
                                ];
                            }

                            // Menambahkan hari-hari dari bulan ini
                            for ($i = 1; $i <= $daysInMonth; $i++) {
                                $calendarDays[] = [
                                    'day' => $i,
                                    'current' => true,
                                    'today' => $i == $today
                                ];
                            }

                            // Menghitung berapa banyak hari yang perlu ditambahkan dari bulan berikutnya
                            $remainingDays = 42 - count($calendarDays); // 42 = 6 baris * 7 hari

                            // Menambahkan hari-hari dari bulan berikutnya
                            for ($i = 1; $i <= $remainingDays; $i++) {
                                $calendarDays[] = [
                                    'day' => $i,
                                    'current' => false,
                                    'today' => false
                                ];
                            }

                            // Mengelompokkan dalam baris (tiap baris memiliki 7 hari)
                            $calendarRows = array_chunk($calendarDays, 7);
                        @endphp

                            <!-- Render kalendar berdasarkan data yang dihitung -->
                        @foreach($calendarRows as $row)
                            @foreach($row as $day)
                                <div class="text-xs py-1
                            @if(!$day['current']) text-gray-400 dark:text-gray-500 @endif
                            @if($day['today']) bg-blue-100 dark:bg-blue-900/30 rounded-full font-semibold text-blue-800 dark:text-blue-300 @endif">
                                    {{ $day['day'] }}
                                </div>
                            @endforeach
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 text-center">
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $now->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Widget - Dibedakan per role -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Aksi Cepat</h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 gap-3">
                        @if(auth()->user()->hasRole('admin'))
                            <!-- Aksi cepat untuk Admin -->
                            <a href="{{ route('admin.guru.create') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Tambah Guru</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="h-8 w-8 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Tambah Siswa</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0v-7z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Cetak Laporan</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="h-8 w-8 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Pengaturan</span>
                            </a>
                        @elseif(auth()->user()->hasRole('kepala sekolah'))
                            <!-- Aksi cepat untuk Kepala Sekolah -->
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0v-7z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Laporan Kehadiran</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Laporan Keuangan</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="h-8 w-8 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Data Guru</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="h-8 w-8 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Performa Sekolah</span>
                            </a>
                        @elseif(auth()->user()->hasRole('guru'))
                            <!-- Aksi cepat untuk Guru -->
                            @if(!$hasCheckedIn)
                                <!-- Presensi Masuk jika belum absen -->
                                <a href="{{ route('absensi.check-in') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Presensi Masuk</span>
                                </a>
                            @elseif($hasCheckedIn && !$absensiToday->waktu_pulang)
                                <form action="{{ route('absensi.check-out') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex flex-col items-center justify-center p-4 w-full bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Presensi Pulang</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('absensi.history') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="h-8 w-8 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm-1-5h2v4H9v-4zm0-5h2v2H9V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center">Riwayat Absensi</span>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Entries and Statistics -->
    @if(auth()->user()->hasRole(['admin', 'kepala sekolah']))
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Recent Entries - Khusus admin dan kepala sekolah -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Presensi Terbaru</h3>
                    <div>
                        <select class="text-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg py-1 px-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option>Hari Ini</option>
                            <option>Minggu Ini</option>
                            <option>Bulan Ini</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($todayAttendance as $absensi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-medium mr-3">
                                            {{ strtoupper(substr($absensi->guru->nama, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $absensi->guru->nama }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $absensi->guru->jabatan }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $absensi->status == 'hadir' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' :
                                  ($absensi->status == 'terlambat' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' :
                                  ($absensi->status == 'izin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' :
                                   'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300')) }}">
                                {{ ucfirst($absensi->status) }}
                            </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $absensi->waktu_masuk ? \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i') . ' WIB' : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('absensi.daily') }}?date={{ $absensi->tanggal }}" class="text-blue-600 dark:text-blue-400 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data absensi untuk hari ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 text-center">
                    <a href="{{ route('absensi.daily') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat semua presensi
                    </a>
                </div>
            </div>

            <!-- Statistics Chart - Khusus admin dan kepala sekolah -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Statistik Kehadiran</h3>
                    <div>
                        <select id="attendancePeriodSelect" class="text-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg py-1 px-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="semester">Semester Ini</option>
                        </select>
                    </div>
                </div>
                <div class="p-5">
                    <div class="h-64">
                        <canvas id="attendanceChart"></canvas>
                    </div>

                    <!-- Chart Legend -->
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap justify-between">
                            <div class="flex items-center mb-2">
                                <div class="h-3 w-3 rounded-full bg-blue-500 dark:bg-blue-600 mr-2"></div>
                                <span class="text-xs text-gray-700 dark:text-gray-300">Kehadiran</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="h-3 w-3 rounded-full bg-yellow-500 dark:bg-yellow-600 mr-2"></div>
                                <span class="text-xs text-gray-700 dark:text-gray-300">Terlambat</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="h-3 w-3 rounded-full bg-red-500 dark:bg-red-600 mr-2"></div>
                                <span class="text-xs text-gray-700 dark:text-gray-300">Tidak Hadir</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="h-3 w-3 rounded-full bg-green-500 dark:bg-green-600 mr-2"></div>
                                <span class="text-xs text-gray-700 dark:text-gray-300">Izin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->hasRole('guru'))
        <!-- Untuk guru, tampilkan riwayat presensi dan detail gaji -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Riwayat Presensi - Khusus guru -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Riwayat Presensi Saya</h3>
                    <div>
                        <select class="text-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg py-1 px-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option>Minggu Ini</option>
                            <option>Bulan Ini</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pulang</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentAbsensis as $absensi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $absensi->status == 'hadir' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' :
                                  ($absensi->status == 'terlambat' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' :
                                  ($absensi->status == 'izin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' :
                                   'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300')) }}">
                                {{ ucfirst($absensi->status) }}
                            </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $absensi->waktu_masuk ? \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i') . ' WIB' : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $absensi->waktu_pulang ? \Carbon\Carbon::parse($absensi->waktu_pulang)->format('H:i') . ' WIB' : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data absensi yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 text-center">
                    <a href="{{ route('absensi.history') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat semua riwayat
                    </a>
                </div>
            </div>
            <!-- Detail Gaji Guru - Khusus guru -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Informasi Gaji</h3>
                </div>
                <div class="p-5">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Gaji Pokok</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Rp {{ number_format($estimatedSalary['gaji_pokok'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tunjangan</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Rp {{ number_format($estimatedSalary['tunjangan'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Potongan Keterlambatan</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">- Rp {{ number_format($estimatedSalary['potongan_terlambat'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Potongan Ketidakhadiran</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">- Rp {{ number_format($estimatedSalary['potongan_tidak_hadir'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Total Gaji Bulan Ini</span>
                            <span class="text-base font-bold text-green-600 dark:text-green-400">Rp {{ number_format($estimatedSalary['gaji_bersih'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('guru.my-salary') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0v-7z" clip-rule="evenodd" />
                            </svg>
                            Cetak Slip Gaji
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            const weeklyData = @json($weeklyAttendance);

            const attendanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: weeklyData.labels,
                    datasets: [
                        {
                            label: 'Hadir',
                            data: weeklyData.hadir,
                            backgroundColor: '#3B82F6',
                            stack: 'Stack 0',
                        },
                        {
                            label: 'Terlambat',
                            data: weeklyData.terlambat,
                            backgroundColor: '#F59E0B',
                            stack: 'Stack 0',
                        },
                        {
                            label: 'Izin',
                            data: weeklyData.izin,
                            backgroundColor: '#10B981',
                            stack: 'Stack 0',
                        },
                        {
                            label: 'Tidak Hadir',
                            data: weeklyData.tidak_hadir,
                            backgroundColor: '#EF4444',
                            stack: 'Stack 0',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true
                        }
                    }
                }
            });

            // Handler untuk perubahan periode
            document.getElementById('attendancePeriodSelect').addEventListener('change', function(e) {
                const period = e.target.value;
                console.log(`Periode dipilih: ${period}`);
            });
        });
    </script>
@endpush
