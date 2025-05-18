@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Detail Guru</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Informasi lengkap guru</p>
        </div>

        <div class="flex space-x-2">
            <a href="{{ route('admin.guru.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>

            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.guru.edit', $guru->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profil Guru -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 text-center">
                <div class="h-20 w-20 rounded-full bg-blue-500 text-white flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($guru->nama, 0, 2)) }}
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
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $guru->user->email }}</span>
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

                    @if(auth()->user()->hasRole(['admin', 'kepala sekolah']) || auth()->id() == $guru->user_id)
                        <div>
                            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Informasi Finansial</h4>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Gaji Pokok</span>
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Rp {{ number_format($guru->gaji_pokok, 0, ',', '.') }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Tunjangan</span>
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Rp {{ number_format($guru->tunjangan, 0, ',', '.') }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Total</span>
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Rp {{ number_format($guru->gaji_pokok + $guru->tunjangan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Kehadiran dan Gaji -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Grafik Kehadiran Bulanan -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Kehadiran Bulanan</h3>
                </div>

                <div class="p-5">
                    <!-- Dummy Chart - In a real implementation, this would be a chart showing attendance data -->
                    <div class="h-64 flex items-end space-x-2">
                        @php
                            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
                            $values = [85, 92, 90, 88, 95, 91];
                        @endphp

                        @foreach($months as $index => $month)
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-500 dark:bg-blue-600 rounded-t-lg" style="height: {{ $values[$index] }}%"></div>
                                <span class="text-xs mt-2 text-gray-500 dark:text-gray-400">{{ $month }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex flex-wrap justify-between">
                            <div class="flex items-center mb-2">
                                <div class="h-3 w-3 rounded-full bg-blue-500 dark:bg-blue-600 mr-2"></div>
                                <span class="text-xs text-gray-700 dark:text-gray-300">Persentase Kehadiran</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Absensi -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Riwayat Absensi Terbaru</h3>
                    <div>
                        <select class="text-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg py-1 px-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option>Bulan Ini</option>
                            <option>Bulan Lalu</option>
                        </select>
                    </div>
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
                        <!-- Dummy data for demonstration -->
                        @for($i = 10; $i > 0; $i--)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ date('d M Y', strtotime("-$i days")) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statuses = ['hadir', 'hadir', 'hadir', 'terlambat', 'izin'];
                                        $status = $statuses[array_rand($statuses)];
                                        $statusClasses = [
                                            'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$status] }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    @if($status == 'izin')
                                        -
                                    @else
                                        @php
                                            $minutes = $status == 'terlambat' ? rand(15, 45) : rand(0, 15);
                                            $time = strtotime("07:00:00 +$minutes minutes");
                                            echo date('H:i', $time) . ' WIB';
                                        @endphp
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    @if($status == 'izin')
                                        -
                                    @else
                                        @php
                                            $minutes = rand(0, 30);
                                            $time = strtotime("15:00:00 +$minutes minutes");
                                            echo date('H:i', $time) . ' WIB';
                                        @endphp
                                    @endif
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-200 dark:border-gray-700 text-center">
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat semua riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
