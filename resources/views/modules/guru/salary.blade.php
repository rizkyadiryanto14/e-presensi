@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Detail Gaji Guru</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Informasi gaji dan komponen {{ $salaryComponents['guru']->nama }}</p>
        </div>

        <div class="flex space-x-2">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>

            <button type="button" onclick="printSlipGaji()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                Cetak Slip Gaji
            </button>
        </div>
    </div>

    <!-- Filter Bulan -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow mb-6">
        <form action="{{ route('admin.guru.salary', $salaryComponents['guru']->id) }}" method="GET">
            <div class="flex items-center space-x-4">
                <div class="flex-grow">
                    <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Bulan</label>
                    <input type="month" id="month" name="month" value="{{ $salaryComponents['bulan'] }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md">
                </div>
                <div class="flex-shrink-0 pt-5">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="printable-slip">
        <!-- Header Slip Gaji (hanya tampil saat di-print) -->
        <div class="hidden print:block mb-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">E-PRESENSI SEKOLAH</h1>
                <p class="text-lg">SLIP GAJI GURU</p>
                <p>Periode: {{ date('F Y', strtotime($salaryComponents['bulan'] . '-01')) }}</p>
            </div>
        </div>

        <!-- Slip Gaji -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Detail Guru -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden print:border print:border-gray-300">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 print:border-gray-300">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 print:text-gray-800">Informasi Guru</h3>
                </div>

                <div class="p-5 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400 print:text-gray-600">Nama</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 print:text-gray-800">{{ $salaryComponents['guru']->nama }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400 print:text-gray-600">NIP</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 print:text-gray-800">{{ $salaryComponents['guru']->nip }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400 print:text-gray-600">Jabatan</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 print:text-gray-800">{{ $salaryComponents['guru']->jabatan }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400 print:text-gray-600">Status</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 print:text-gray-800">{{ $salaryComponents['guru']->status_kepegawaian }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400 print:text-gray-600">Periode</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 print:text-gray-800">{{ date('F Y', strtotime($salaryComponents['bulan'] . '-01')) }}</span>
                    </div>
                </div>
            </div>

            <!-- Detail Kehadiran -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden print:border print:border-gray-300">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 print:border-gray-300">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 print:text-gray-800">Kehadiran Bulan Ini</h3>
                </div>

                <div class="p-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-100 dark:border-green-800 print:bg-white print:border print:border-gray-300">
                            <h4 class="text-xs font-semibold text-green-800 dark:text-green-400 print:text-gray-800 uppercase tracking-wider">Hadir</h4>
                            <p class="text-2xl font-bold text-green-700 dark:text-green-300 print:text-gray-800 mt-1">{{ $salaryComponents['kehadiran']['hadir'] }} Hari</p>
                        </div>

                        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4 border border-yellow-100 dark:border-yellow-800 print:bg-white print:border print:border-gray-300">
                            <h4 class="text-xs font-semibold text-yellow-800 dark:text-yellow-400 print:text-gray-800 uppercase tracking-wider">Terlambat</h4>
                            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-300 print:text-gray-800 mt-1">{{ $salaryComponents['kehadiran']['terlambat'] }} Hari</p>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-100 dark:border-blue-800 print:bg-white print:border print:border-gray-300">
                            <h4 class="text-xs font-semibold text-blue-800 dark:text-blue-400 print:text-gray-800 uppercase tracking-wider">Sakit</h4>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300 print:text-gray-800 mt-1">{{ $salaryComponents['kehadiran']['sakit'] }} Hari</p>
                        </div>

                        <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border border-red-100 dark:border-red-800 print:bg-white print:border print:border-gray-300">
                            <h4 class="text-xs font-semibold text-red-800 dark:text-red-400 print:text-gray-800 uppercase tracking-wider">Tidak Hadir</h4>
                            <p class="text-2xl font-bold text-red-700 dark:text-red-300 print:text-gray-800 mt-1">{{ $salaryComponents['kehadiran']['tidak_hadir'] }} Hari</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Komponen Gaji -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden print:border print:border-gray-300">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 print:border-gray-300">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 print:text-gray-800">Komponen Gaji</h3>
                </div>

                <div class="p-5 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400 print:text-gray-600">Gaji Pokok</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 print:text-gray-800">Rp {{ number_format($salaryComponents['komponen_gaji']['gaji_pokok'], 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400 print:text-gray-600">Tunjangan</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 print:text-gray-800">Rp {{ number_format($salaryComponents['komponen_gaji']['tunjangan'], 0, ',', '.') }}</span>
                    </div>

                    <div class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-700 print:border-gray-300">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 print:text-gray-700">Total Potongan</span>
                            <span class="text-sm font-medium text-red-500 dark:text-red-400 print:text-red-500">- Rp {{ number_format($salaryComponents['komponen_gaji']['total_potongan'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700 print:border-gray-300">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-700 dark:text-gray-300 print:text-gray-700">Total Gaji Bersih</span>
                            <span class="text-lg font-bold text-green-600 dark:text-green-400 print:text-green-600">Rp {{ number_format($salaryComponents['komponen_gaji']['gaji_bersih'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tanda Tangan (hanya tampil saat di-print) -->
        <div class="hidden print:block mt-12">
            <div class="flex justify-between">
                <div class="text-center w-1/3">
                    <p>Mengetahui,</p>
                    <p>Kepala Sekolah</p>
                    <div class="h-20"></div>
                    <p class="font-semibold">_________________________</p>
                    <p>NIP. </p>
                </div>

                <div class="text-center w-1/3">
                    <p>Jakarta, {{ date('d F Y') }}</p>
                    <p>Bendahara</p>
                    <div class="h-20"></div>
                    <p class="font-semibold">_________________________</p>
                    <p>NIP. </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk print -->
    <script>
        function printSlipGaji() {
            window.print();
        }
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-slip, #printable-slip * {
                visibility: visible;
            }
            #printable-slip {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
            }
            .print\:border {
                border: 1px solid #e2e8f0 !important;
            }
            .print\:border-gray-300 {
                border-color: #e2e8f0 !important;
            }
            .print\:bg-white {
                background-color: white !important;
            }
            .print\:text-gray-800 {
                color: #1a202c !important;
            }
            .print\:text-gray-700 {
                color: #2d3748 !important;
            }
            .print\:text-gray-600 {
                color: #4a5568 !important;
            }
            .card-shadow {
                box-shadow: none !important;
            }
        }
    </style>
@endsection
