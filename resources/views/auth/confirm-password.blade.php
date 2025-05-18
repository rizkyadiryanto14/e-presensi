<x-guest-flowbite-layout>
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 sm:p-8 text-center">
            <div class="mb-6">
                <img src="{{ asset('assets/images/logo_presensi.png') }}" alt="E-Presensi Logo" class="h-20 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">Konfirmasi Kata Sandi</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 mb-4">
                    Ini adalah area yang aman dari aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.
                </p>
            </div>

            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4 text-left">
                @csrf

                <!-- Password -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required
                            autocomplete="current-password"
                        />
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Konfirmasi
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} E-Presensi SDN Bajo Soromandi. All rights reserved.
            </div>
        </div>
    </div>
</x-guest-flowbite-layout>
