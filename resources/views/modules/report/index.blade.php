@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Laporan</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Daftar Laporan Penggajian dan Absensi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Guru -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Guru</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $summary['totalGuru'] }}</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                  <x-heroicon-o-user-group class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>

        <!-- Total Absensi -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Absensi</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $summary['totalAbsensi'] }}</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                   <x-heroicon-o-check class="h-6 w-6 text-green-600 dark:text-green-400" />
                </div>
            </div>
        </div>

        <!-- Total Absensi Hari Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Absensi Hari ini</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $summary['dailyAbsensi'] }}</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                    <x-heroicon-o-document-check class="h-6 w-6 text-yellow-600 dark:text-yellow-400" />
                </div>
            </div>
        </div>

        <!-- Total Pencairan Gaji -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pencairan Gaji</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">Rp.{{ number_format($summary['totalGajiPencairan']) }}</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                   <x-heroicon-o-currency-dollar class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                </div>
            </div>
        </div>

        <!-- Total Belum Pencairan Gaji -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Belum Pencairan Gaji</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">Rp.{{ number_format($summary['totalGajiBelumPencairan']) }}</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <x-heroicon-o-currency-dollar class="h-6 w-6 text-red-600 dark:text-red-400" />
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2 p-4 ">
                <div class="relative overflow-x-auto bg-neutral-primary-soft ">
                    @if (session('success'))
                        <div class="mb-4 p-3 rounded bg-green-100 text-green-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-3 rounded bg-red-100 text-red-700 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <caption class="p-5 text-lg font-medium text-heading">
                            <div class="flex items-start justify-between gap-4">
                                <!-- Kiri -->
                                <div class="text-left">
                                    Rekap Penggajian
                                    <p class="mt-1.5 text-sm font-normal text-body">
                                        Daftar laporan Penggajian Guru dan Pembayaran Gaji.
                                    </p>
                                </div>
                            </div>
                        </caption>

                        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Gaji Pokok
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Gaji Bersih
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Potongan
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Pencairan
                            </th>
                            @role('bendahara')
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Aksi
                                </th>
                            @endrole
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($summary['guruList'] as $guru)
                            <tr class="bg-neutral-primary-soft border-b border-default">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $guru->nama }}
                                </th>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($guru->gaji_pokok, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($guru->latestGaji->total_gaji ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($guru->latestGaji->potongan ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($guru->latestGaji)
                                        <span class="text-sm
                                            {{ $guru->latestGaji->bulan ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ $guru->latestGaji->status_pencairan }}
                                        </span>
                                        <div class="text-xs text-gray-500">
                                            {{ $guru->latestGaji->periode }}
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>

                                @role('bendahara')
                                    <td class="px-6 py-4">
                                        @if ($guru->latestGaji && !$guru->latestGaji->bulan)
                                            <form method="POST"
                                                  action="{{ route('admin.report.cairkan-gaji', $guru->latestGaji) }}">
                                                @csrf
                                                <button
                                                    class="text-blue-600 hover:underline">
                                                    Pencairan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm">—</span>
                                        @endif
                                    </td>
                                @endrole
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data guru
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $summary['guruList']->links() }}
                </div>
            </div>

            <div class="w-full md:w-1/2 p-4">
                <div class="relative overflow-x-auto bg-neutral-primary-soft ">
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <caption class="p-5 text-lg font-medium text-heading">
                            <div class="flex items-start justify-between gap-4">
                                <!-- Kiri -->
                                <div class="text-left">
                                    Rekap Presensi
                                    <p class="mt-1.5 text-sm font-normal text-body">
                                        Daftar Seluruh Presensi Guru
                                    </p>
                                </div>
                            </div>
                        </caption>

                        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Total Presensi
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Hadir
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Terlambat
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Sakit
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Alpha
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($summary['listAbsensi'] as $absensiGuru)
                            <tr class="bg-neutral-primary-soft border-b border-default">

                                <th scope="row"
                                    class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $absensiGuru->nama }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $absensiGuru->total_absensi }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $absensiGuru->total_hadir }}
                                </td>
                                <td class="px-6 py-4">
                                  {{ $absensiGuru->total_terlambat }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $absensiGuru->total_sakit }}
                                </td>
                                <td class="px-6 py-4">
                                  {{ $absensiGuru->total_alpha }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data guru
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $summary['guruList']->links() }}
                </div>
            </div>
        </div>
        <div class="pt-4">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Statistik Kehadiran</h3>
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            const weeklyData = @json($summary['weeklyAttendance']);

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
