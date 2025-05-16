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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <!-- Component Styling -->
    @include('components.admin-styling')

</head>
<body class="h-full font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

<!-- Overlay when sidebar is open on mobile -->
<div @click="sidebarOpen = false"
     x-show="sidebarOpen"
     class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"></div>

<!-- Navbar -->
@include('components.navbar-admin')

<!-- Layout -->
<div class="pt-16 flex h-screen overflow-hidden">

    <!-- Component Sidebar -->
    @include('components.aside-admin')

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto ml-0 md:ml-64 px-6 py-6 bg-gray-50 dark:bg-gray-900">
        @include('components.flash-message')

        @yield('content')

        <!-- Component Footer -->
        @include('components.footer-admin')
    </main>
</div>

</body>
</html>
