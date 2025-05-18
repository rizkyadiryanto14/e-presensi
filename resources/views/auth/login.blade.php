<x-guest-flowbite-layout>
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 sm:p-8 text-center">
            <div class="mb-6">
                <img src="{{ asset('assets/images/logo_presensi.png') }}" alt="E-Presensi Logo" class="h-20 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">Selamat Datang</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Silakan masuk untuk mengakses sistem presensi</p>
            </div>

            @if(session('status'))
                <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800/20 p-4 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4 text-left">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                                <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                            </svg>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        />
                    </div>
                </div>

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

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        />
                        <label for="remember_me" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Ingat saya
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-500">
                        Lupa kata sandi?
                    </a>
                </div>

                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Masuk
                </button>

{{--                <!-- Register Link -->--}}
{{--                @if (Route::has('register'))--}}
{{--                    <div class="text-center mt-4">--}}
{{--                        <span class="text-sm text-gray-600 dark:text-gray-400">Belum punya akun? </span>--}}
{{--                        <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-500">--}}
{{--                            Daftar--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}
            </form>

            <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} E-Presensi SDN Bajo Soromandi. All rights reserved.
            </div>
        </div>
    </div>
</x-guest-flowbite-layout>
