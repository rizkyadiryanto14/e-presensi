@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Profil Guru</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profil Guru -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 text-center">
                <div class="h-24 w-24 rounded-full bg-blue-500 text-white flex items-center justify-center text-3xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $guru->nama }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $guru->jabatan }}</p>

                <div class="mt-3">
                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $guru->status_kepegawaian == 'tetap' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                        {{ ucfirst($guru->status_kepegawaian) }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Informasi Kontak</h4>

                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ auth()->user()->email }}</span>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Informasi Kepegawaian</h4>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">NIP</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $guru->nip }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Jabatan</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $guru->jabatan }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Status</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ ucfirst($guru->status_kepegawaian) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('profile.edit') }}" class="flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <!-- Ringkasan Kehadiran dan Gaji -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Ringkasan Bulan Ini</h3>
                </div>

                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 border border-gray-100 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Kehadiran</h4>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <div class="flex justify-center items-center h-28">
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400">90%</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">Tingkat Kehadiran</div>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 text-center">
                                <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                    Lihat detail kehadiran
                                </a>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 border border-gray-100 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Estimasi Gaji</h4>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <div class="flex justify-center items-center h-28">
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($guru->gaji_pokok + $guru->tunjangan - 250000, 0, ',', '.') }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">Prediksi Gaji Bulan Ini</div>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 text-center">
                                <a href="#" class="text-sm font-medium text-green-600 dark:text-green-400 hover:underline">
                                    Lihat slip gaji
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jadwal Presensi -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Jadwal Presensi</h3>
                </div>

                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Jam Kerja</h4>

                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Jam Masuk</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Senin - Sabtu</div>
                                    </div>
                                </div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">07:30 WIB</div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Jam Pulang</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Senin - Sabtu</div>
                                    </div>
                                </div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">15:30 WIB</div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Status Presensi Hari Ini</h4>

                            <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ date('d F Y') }}</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                        Hadir
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Jam Masuk</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">07:45 WIB</span>
                                    </div>

                                    <div class="flex items-center">
                                        <div class="h-1 w-16 bg-gray-200 dark:bg-gray-600 rounded-full mx-3">
                                            <div class="h-1 bg-blue-500 dark:bg-blue-600 rounded-full" style="width: 60%"></div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col text-right">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Jam Pulang</span>
                                        <span class="text-sm font-medium text-gray-400 dark:text-gray-500">- - : - -</span>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        Presensi Pulang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Presensi Terbaru -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Riwayat Presensi Terbaru</h3>
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat semua
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jam Masuk
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jam Keluar
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Dummy data untuk demonstrasi -->
                        @php
                            $dummyData = [
                                ['date' => date('d M Y', strtotime('-1 day')), 'status' => 'hadir', 'in' => '07:30', 'out' => '15:30'],
                                ['date' => date('d M Y', strtotime('-2 day')), 'status' => 'hadir', 'in' => '07:25', 'out' => '15:35'],
                                ['date' => date('d M Y', strtotime('-3 day')), 'status' => 'terlambat', 'in' => '08:15', 'out' => '15:45'],
                                ['date' => date('d M Y', strtotime('-4 day')), 'status' => 'hadir', 'in' => '07:28', 'out' => '15:40'],
                                ['date' => date('d M Y', strtotime('-5 day')), 'status' => 'izin', 'in' => '-', 'out' => '-'],
                            ];

                            $statusClasses = [
                                'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                'tidak_hadir' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                            ];
                        @endphp

                        @foreach($dummyData as $record)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record['date'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$record['status']] }}">
                                        {{ ucfirst($record['status']) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record['in'] }} WIB
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record['out'] }} WIB
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
