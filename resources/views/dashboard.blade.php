@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Selamat datang di Panel Admin E-Presensi</p>
    </div>

    <!-- Dashboard Content -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Stat Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Guru</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">24</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                    <span>Lihat detail</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Siswa</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">320</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="#" class="text-sm text-purple-600 dark:text-purple-400 hover:underline flex items-center">
                    <span>Lihat detail</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kehadiran Hari Ini</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">95%</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="#" class="text-sm text-green-600 dark:text-green-400 hover:underline flex items-center">
                    <span>Lihat detail</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 border border-gray-200 dark:border-gray-700 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kelas</p>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">12</h3>
                </div>
                <div class="h-12 w-12 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
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

    <!-- Dashboard Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Aktivitas Terbaru</h3>
            </div>
            <div class="p-5">
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="h-9 w-9 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 dark:text-gray-200"><span class="font-medium">Budi Santoso</span> telah melakukan presensi masuk</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Hari ini, 07:45 WIB</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="h-9 w-9 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 dark:text-gray-200"><span class="font-medium">Admin</span> telah menambahkan data baru pada Mata Pelajaran</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Kemarin, 14:30 WIB</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="h-9 w-9 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 dark:text-gray-200"><span class="font-medium">Sistem</span> telah mendeteksi 3 siswa yang belum melakukan presensi</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Kemarin, 10:15 WIB</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="h-9 w-9 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 dark:text-gray-200"><span class="font-medium">Admin</span> telah menghasilkan laporan presensi bulan April</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400">2 hari yang lalu, 16:20 WIB</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat semua aktivitas
                    </a>
                </div>
            </div>
        </div>

        <!-- Calendar & Shortcuts -->
        <div class="space-y-6">
            <!-- Calendar Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Kalender</h3>
                </div>
                <div class="p-5">
                    <!-- Simple Calendar Widget -->
                    <div class="grid grid-cols-7 gap-2 text-center">
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Min</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Sen</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Sel</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Rab</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Kam</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Jum</div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Sab</div>

                        <!-- Calendar days - just an example, would be dynamically generated in real app -->
                        <div class="text-xs text-gray-400 dark:text-gray-500 py-1">30</div>
                        <div class="text-xs py-1">1</div>
                        <div class="text-xs py-1">2</div>
                        <div class="text-xs py-1">3</div>
                        <div class="text-xs py-1">4</div>
                        <div class="text-xs py-1">5</div>
                        <div class="text-xs py-1">6</div>

                        <div class="text-xs py-1">7</div>
                        <div class="text-xs py-1">8</div>
                        <div class="text-xs py-1">9</div>
                        <div class="text-xs py-1">10</div>
                        <div class="text-xs py-1">11</div>
                        <div class="text-xs py-1">12</div>
                        <div class="text-xs py-1">13</div>

                        <div class="text-xs py-1">14</div>
                        <div class="text-xs py-1">15</div>
                        <div class="text-xs py-1">16</div>
                        <div class="text-xs py-1 bg-blue-100 dark:bg-blue-900/30 rounded-full font-semibold text-blue-800 dark:text-blue-300">17</div>
                        <div class="text-xs py-1">18</div>
                        <div class="text-xs py-1">19</div>
                        <div class="text-xs py-1">20</div>

                        <div class="text-xs py-1">21</div>
                        <div class="text-xs py-1">22</div>
                        <div class="text-xs py-1">23</div>
                        <div class="text-xs py-1">24</div>
                        <div class="text-xs py-1">25</div>
                        <div class="text-xs py-1">26</div>
                        <div class="text-xs py-1">27</div>

                        <div class="text-xs py-1">28</div>
                        <div class="text-xs py-1">29</div>
                        <div class="text-xs py-1">30</div>
                        <div class="text-xs py-1">31</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 py-1">1</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 py-1">2</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 py-1">3</div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 text-center">
                        <p class="text-xs text-gray-600 dark:text-gray-400">Mei 2025</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Aksi Cepat</h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Entries and Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Recent Entries -->
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
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-medium mr-3">BS</div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Budi Santoso</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Guru Matematika</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                        Hadir
                                    </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            07:45 WIB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-purple-500 text-white flex items-center justify-center font-medium mr-3">SR</div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Siti Rahayu</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Guru Bahasa Inggris</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                        Hadir
                                    </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            07:30 WIB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-red-500 text-white flex items-center justify-center font-medium mr-3">AH</div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Ahmad Hidayat</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Guru Fisika</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                        Terlambat
                                    </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            08:15 WIB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-green-500 text-white flex items-center justify-center font-medium mr-3">DW</div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Dewi Wijaya</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Guru Biologi</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                        Tidak Hadir
                                    </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            -
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Detail</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 text-center">
                <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                    Lihat semua presensi
                </a>
            </div>
        </div>

        <!-- Statistics Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Statistik Kehadiran</h3>
                <div>
                    <select class="text-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg py-1 px-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option>Minggu Ini</option>
                        <option>Bulan Ini</option>
                        <option>Semester Ini</option>
                    </select>
                </div>
            </div>
            <div class="p-5">
                <!-- Chart container - height set for a better chart display -->
                <div class="h-64">
                    <!-- Simple chart representation (would be replaced by an actual chart library in real app) -->
                    <div class="h-full flex items-end space-x-2">
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 dark:bg-blue-600 rounded-t-lg h-48"></div>
                            <span class="text-xs mt-2 text-gray-500 dark:text-gray-400">Sen</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 dark:bg-blue-600 rounded-t-lg h-56"></div>
                            <span class="text-xs mt-2 text-gray-500 dark:text-gray-400">Sel</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 dark:bg-blue-600 rounded-t-lg h-40"></div>
                            <span class="text-xs mt-2 text-gray-500 dark:text-gray-400">Rab</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 dark:bg-blue-600 rounded-t-lg h-52"></div>
                            <span class="text-xs mt-2 text-gray-500 dark:text-gray-400">Kam</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 dark:bg-blue-600 rounded-t-lg h-44"></div>
                            <span class="text-xs mt-2 text-gray-500 dark:text-gray-400">Jum</span>
                        </div>
                    </div>
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
