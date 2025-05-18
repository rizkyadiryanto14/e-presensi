@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Presensi Harian</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Silahkan lakukan absensi kehadiran Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900/30 dark:text-green-300 dark:border-green-600" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 dark:bg-red-900/30 dark:text-red-300 dark:border-red-600" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Current Date & Time -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700 card-shadow mb-6 text-center">
            <h3 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ \Carbon\Carbon::now()->format('d F Y') }}</h3>
            <div class="text-4xl font-bold text-blue-600 dark:text-blue-400" id="clock">{{ \Carbon\Carbon::now()->format('H:i:s') }}</div>
        </div>

        <!-- Teacher Info & Attendance Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Informasi Guru</h3>
                <div class="flex items-center mb-4">
                    <div class="h-16 w-16 rounded-full bg-blue-500 text-white flex items-center justify-center text-xl font-bold">
                        {{ strtoupper(substr($guru->nama, 0, 2)) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $guru->nama }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $guru->jabatan }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        <span class="font-medium">NIP:</span> {{ $guru->nip }}
                    </p>
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        <span class="font-medium">Status Kepegawaian:</span> {{ $guru->status_kepegawaian }}
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status Absensi Hari Ini</h3>

                @if($hasCheckedIn)
                    <div class="mb-4">
                        <div class="flex items-center mb-2">
                            <span class="font-medium text-gray-700 dark:text-gray-300 w-32">Status:</span>
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $absensiToday->status == 'hadir' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' :
                                  ($absensiToday->status == 'terlambat' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' :
                                  ($absensiToday->status == 'izin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' :
                                   'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300')) }}">
                                {{ ucfirst($absensiToday->status) }}
                            </span>
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="font-medium text-gray-700 dark:text-gray-300 w-32">Waktu Masuk:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $absensiToday->waktu_masuk ? \Carbon\Carbon::parse($absensiToday->waktu_masuk)->format('H:i') : '-' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-700 dark:text-gray-300 w-32">Waktu Pulang:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $absensiToday->waktu_pulang ? \Carbon\Carbon::parse($absensiToday->waktu_pulang)->format('H:i') : '-' }}</span>
                        </div>
                    </div>

                    @if(!$absensiToday->waktu_pulang)
                        <form action="{{ route('absensi.check-out') }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm">
                                Check Out
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center">
                            <p class="text-gray-800 dark:text-gray-200">Anda telah menyelesaikan absensi hari ini.</p>
                        </div>
                    @endif
                @else
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center mb-4">
                        <p class="text-gray-800 dark:text-gray-200">Anda belum melakukan absensi hari ini.</p>
                    </div>

                    <form action="{{ route('absensi.check-in.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Kehadiran</label>
                            <select name="status" id="status" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md">
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm">
                            Check In
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Attendance History Link -->
        <div class="text-center">
            <a href="{{ route('absensi.history') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                </svg>
                Lihat Riwayat Absensi
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi untuk memperbarui jam digital
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Perbarui jam setiap detik
        setInterval(updateClock, 1000);
        updateClock(); // Inisialisasi jam
    </script>
@endpush
