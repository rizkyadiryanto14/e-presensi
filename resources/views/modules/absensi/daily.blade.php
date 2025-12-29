@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Absensi Harian</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Kelola dan pantau absensi guru harian</p>
        </div>

        <div>
            <a href="{{ route('absensi.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('absensi.monthly') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Laporan Bulanan
            </a>
        </div>
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

    @if(auth()->user()->hasRole(['admin', 'guru']))
    <!-- Date Selector & Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
                <form action="{{ route('absensi.daily') }}" method="GET" class="flex items-end gap-4">
                    <div class="flex-grow">
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ $date }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md">
                    </div>
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Tampilkan
                    </button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Input Absensi Manual</h3>
                <button type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        data-modal-target="manualAbsensiModal"
                        data-modal-toggle="manualAbsensiModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Absensi Manual
                </button>
            </div>
        </div>
    @endif

    <!-- Attendance Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100">Daftar Kehadiran - {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($date)->format('l') }}</p>
        </div>

        <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="attendanceTabs" data-tabs-toggle="#attendanceTabsContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="present-tab" data-tabs-target="#present" type="button" role="tab" aria-controls="present" aria-selected="false">
                            Hadir/Terlambat/Izin ({{ $attendance->count() }})
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="absent-tab" data-tabs-target="#absent" type="button" role="tab" aria-controls="absent" aria-selected="false">
                            Belum Absen ({{ $notAttendedTeachers->count() }})
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="attendanceTabsContent">
            <!-- Present Tab -->
            <div class="tab-pane fade show active" id="present" role="tabpanel" aria-labelledby="present-tab">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Guru
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                NIP
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Waktu Masuk
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Waktu Pulang
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Durasi
                            </th>
                            @role('admin')
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            @endrole
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($attendance as $absensi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-medium">
                                            {{ strtoupper(substr($absensi->guru->nama, 0, 2)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $absensi->guru->nama }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $absensi->guru->jabatan }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $absensi->guru->nip }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $absensi->status == 'hadir' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' :
                                              ($absensi->status == 'terlambat' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' :
                                              ($absensi->status == 'izin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' :
                                               'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300')) }}">
                                            {{ ucfirst($absensi->status) }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $absensi->waktu_masuk ? \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $absensi->waktu_pulang ? \Carbon\Carbon::parse($absensi->waktu_pulang)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    @if($absensi->waktu_masuk && $absensi->waktu_pulang)
                                            <?php
                                            $start = \Carbon\Carbon::parse($absensi->waktu_masuk);
                                            $end = \Carbon\Carbon::parse($absensi->waktu_pulang);
                                            $duration = $end->diff($start);
                                            echo $duration->format('%H:%I');
                                            ?>
                                    @else
                                        -
                                    @endif
                                </td>
                                @role('admin')
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="button" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                                onclick="editAbsensi('{{ $absensi->id }}', '{{ $absensi->guru->id }}', '{{ $absensi->guru->nama }}', '{{ $absensi->tanggal }}', '{{ $absensi->status }}', '{{ $absensi->waktu_masuk }}', '{{ $absensi->waktu_pulang }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                    </td>
                                @endrole
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data absensi untuk tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Absent Tab -->
            <div class="tab-pane fade" id="absent" role="tabpanel" aria-labelledby="absent-tab">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Guru
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                NIP
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jabatan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($notAttendedTeachers as $guru)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-500 text-white flex items-center justify-center font-medium">
                                            {{ strtoupper(substr($guru->nama, 0, 2)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $guru->nama }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $guru->jabatan }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $guru->nip }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $guru->jabatan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            Belum Absen
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button"
                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                            onclick="addAbsensi('{{ $guru->id }}', '{{ $guru->nama }}', '{{ $date }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Semua guru telah melakukan absensi untuk tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Attendance Modal -->
    <div id="manualAbsensiModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white" id="manualAbsensiModalLabel">
                        Input Absensi Manual
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="manualAbsensiModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <form action="{{ route('absensi.record-manual') }}" method="POST">
                    @csrf
                    <input type="hidden" name="absensi_id" id="absensi_id">
                    <div class="p-4 md:p-5">
                        <div class="mb-4">
                            <label for="guru_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guru</label>
                            <select name="guru_id" id="guru_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                <option value="">Pilih Guru</option>
                                @foreach($allTeachers as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }} ({{ $guru->nip }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ $date }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                <option value="hadir">Hadir</option>
                                <option value="terlambat">Terlambat</option>
                                <option value="izin">Izin</option>
                                <option value="alpha">Tidak Hadir</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="waktu_masuk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu Masuk</label>
                            <input type="time" name="waktu_masuk" id="waktu_masuk" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Opsional untuk status izin atau tidak hadir</p>
                        </div>

                        <div class="mb-4">
                            <label for="waktu_pulang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu Pulang</label>
                            <input type="time" name="waktu_pulang" id="waktu_pulang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Opsional untuk status izin atau tidak hadir</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" class="py-2.5 px-5 mr-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" data-modal-hide="manualAbsensiModal">Batal</button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function addAbsensi(guruId, guruNama, tanggal) {
            document.getElementById('absensi_id').value = '';
            document.getElementById('guru_id').value = guruId;
            document.getElementById('tanggal').value = tanggal;
            document.getElementById('status').value = 'hadir';
            document.getElementById('waktu_masuk').value = '';
            document.getElementById('waktu_pulang').value = '';

            document.getElementById('manualAbsensiModalLabel').textContent = 'Tambah Absensi - ' + guruNama;

            const modalElement = document.getElementById('manualAbsensiModal');
            const modalOptions = {
                placement: 'center',
                backdrop: 'dynamic',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true
            };
            const modal = new Modal(modalElement, modalOptions);
            modal.show();
        }

        function editAbsensi(absensiId, guruId, guruNama, tanggal, status, waktu, waktuPulang) {
            // Set nilai form
            document.getElementById('absensi_id').value = absensiId;
            document.getElementById('guru_id').value = guruId;
            document.getElementById('tanggal').value = tanggal;
            document.getElementById('status').value = status;

            if (waktu) {
                const waktuArr = waktu.split(':');
                document.getElementById('waktu_masuk').value = `${waktuArr[0]}:${waktuArr[1]}`;
            } else {
                document.getElementById('waktu_masuk').value = '';
            }

            if (waktuPulang) {
                const waktuPulangArr = waktuPulang.split(':');
                document.getElementById('waktu_pulang').value = `${waktuPulangArr[0]}:${waktuPulangArr[1]}`;
            } else {
                document.getElementById('waktu_pulang').value = '';
            }

            document.getElementById('manualAbsensiModalLabel').textContent = 'Edit Absensi - ' + guruNama;

            const modalElement = document.getElementById('manualAbsensiModal');
            const modalOptions = {
                placement: 'center',
                backdrop: 'dynamic',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true
            };
            const modal = new Modal(modalElement, modalOptions);
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const $targetEl = document.getElementById('manualAbsensiModal');
            const modal = new Modal($targetEl);
        });
    </script>
@endpush
