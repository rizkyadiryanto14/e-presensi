<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    class="transition-smooth fixed top-16 left-0 bottom-0 w-64 bg-white dark:bg-gray-800 shadow-lg md:shadow-md z-20 overflow-y-auto hide-scrollbar">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    @if(auth()->user()->hasRole('admin'))
                        Administrator
                    @elseif(auth()->user()->hasRole('kepala sekolah'))
                        Kepala Sekolah
                    @elseif(auth()->user()->hasRole('guru'))
                        Guru
                    @else
                        Pengguna
                    @endif
                </p>
            </div>
        </div>
    </div>

    <nav class="p-4 space-y-1">
        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider pl-3 mb-2">Menu Utama</p>

        <!-- Dashboard - Semua role dapat mengakses -->
        <a @click="currentMenu = 'dashboard'" :class="currentMenu == 'dashboard' ? 'active' : ''" href="{{ route('dashboard') }}" class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Data Master - Hanya Admin dan Kepala Sekolah -->
        @if(auth()->user()->hasRole(['admin', 'kepala sekolah']))
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider pl-3 mt-6 mb-2">Data Master</p>

            <!-- Data Guru - Admin dan Kepala Sekolah -->
            <a @click="currentMenu = 'guru'" :class="currentMenu == 'guru' ? 'active' : ''" href="{{ route('admin.guru.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
                <span>Data Guru</span>
            </a>

        @endif

        <!-- Presensi - Semua role dapat mengakses -->
        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider pl-3 mt-6 mb-2">Presensi</p>

        <!-- Presensi Guru - Semua role dapat mengakses, tetapi dengan izin yang berbeda -->
        <a @click="currentMenu = 'presensi-guru'" :class="currentMenu == 'presensi-guru' ? 'active' : ''"
           href="{{ auth()->user()->hasRole('guru') ? route('absensi.check-in') : route('absensi.dashboard') }}"
           class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            <span>
                @if(auth()->user()->hasRole('guru'))
                    Presensi Saya
                @else
                    Presensi Guru
                @endif
            </span>
        </a>

        <!-- Laporan - Hanya Admin dan Kepala Sekolah -->
        @if(auth()->user()->hasRole(['admin', 'kepala sekolah']))
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider pl-3 mt-6 mb-2">Laporan</p>
            <a @click="currentMenu = 'laporan'" :class="currentMenu == 'laporan' ? 'active' : ''" href="{{ route('admin.report.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600 dark:text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0v-7z" />
                </svg>
                <span>Laporan</span>
            </a>

            <a @click="currentMenu = 'rekap'" :class="currentMenu == 'rekap' ? 'active' : ''" href="#" class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600 dark:text-pink-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" />
                </svg>
                <span>Rekap Kehadiran</span>
            </a>
            <a @click="currentMenu = 'absensi-harian'" :class="currentMenu == 'absensi-harian' ? 'active' : ''"
               href="{{ route('absensi.daily') }}"
               class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                <span>Absensi Harian</span>
            </a>
            <a @click="currentMenu = 'laporan-bulanan'" :class="currentMenu == 'laporan-bulanan' ? 'active' : ''"
               href="{{ route('absensi.monthly') }}"
               class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600 dark:text-pink-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" />
                </svg>
                <span>Laporan Bulanan</span>
            </a>
        @endif

        <!-- Pengaturan - Hanya Admin -->
        @if(auth()->user()->hasRole('admin'))
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider pl-3 mt-6 mb-2">Pengaturan</p>
            <a @click="currentMenu = 'pengguna'" :class="currentMenu == 'pengguna' ? 'active' : ''" href="#" class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <span>Pengguna</span>
            </a>
            <a @click="currentMenu = 'aplikasi'" :class="currentMenu == 'aplikasi' ? 'active' : ''" href="#" class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                <span>Pengaturan Aplikasi</span>
            </a>
        @endif

        <!-- Profil Guru - Hanya Guru -->
        @if(auth()->user()->hasRole('guru'))
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider pl-3 mt-6 mb-2">Guru</p>
            <a @click="currentMenu = 'profil-guru'" :class="currentMenu == 'profil-guru' ? 'active' : ''" href="{{ route('guru.profile') }}" class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <span>Profil Saya</span>
            </a>
            <a @click="currentMenu = 'gaji-guru'" :class="currentMenu == 'gaji-guru' ? 'active' : ''" href="{{ route('guru.my-salary') }}" class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 dark:text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                </svg>
                <span>Slip Gaji Saya</span>
            </a>
            <a @click="currentMenu = 'riwayat-absensi'" :class="currentMenu == 'riwayat-absensi' ? 'active' : ''"
               href="{{ route('absensi.history') }}"
               class="sidebar-item flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                </svg>
                <span>Riwayat Absensi</span>
            </a>
        @endif
    </nav>
</aside>
