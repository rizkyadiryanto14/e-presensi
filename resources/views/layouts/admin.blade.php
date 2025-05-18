<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('darkMode') === 'true',
                       dropdownOpen: false, currentMenu: 'dashboard',
                       toggleDarkMode() { this.darkMode = !this.darkMode; localStorage.setItem('darkMode', this.darkMode) } }"
      :class="{ 'dark': darkMode }"
      class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Presensi Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_presensi.png') }}" type="image/x-icon" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <!-- Component Styling -->
   <x-admin-styling />

</head>
<body class="h-full font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

<!--Compoment Overlay-->
    <x-overlay-mobile />

<!-- Component Navbar -->
<x-navbar-admin />

<!-- Layout -->
<div class="pt-16 flex h-screen overflow-hidden">

    <!-- Component Sidebar -->
    <x-aside-admin />

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto ml-0 md:ml-64 px-6 py-6 bg-gray-50 dark:bg-gray-900">
        <x-flash-message />

        @yield('content')

        <!-- Component Footer -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <x-footer-admin />
    </main>
</div>

@stack('scripts')

</body>
</html>
