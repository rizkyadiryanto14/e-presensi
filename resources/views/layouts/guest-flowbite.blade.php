<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true',
                toggleDarkMode() { this.darkMode = !this.darkMode; localStorage.setItem('darkMode', this.darkMode) } }"
      :class="{ 'dark': darkMode }"
      class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Presensi - SDN BAJO</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/logo_presensi.png') }}" type="image/x-icon" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
<div class="min-h-screen flex flex-col justify-center items-center">
    {{ $slot }}
</div>
</body>
</html>
