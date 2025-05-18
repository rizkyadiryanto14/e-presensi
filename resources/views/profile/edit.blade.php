@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Profil Saya</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Informasi Profil -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Informasi Profil</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Perbarui informasi profil dan alamat email akun Anda.
                </p>
            </div>

            <div class="p-5">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Perbarui Kata Sandi</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.
                </p>
            </div>

            <div class="p-5">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
@endsection
