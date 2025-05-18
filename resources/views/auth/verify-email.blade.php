<x-guest-flowbite-layout>
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 sm:p-8 text-center">
            <div class="mb-6">
                <img src="{{ asset('assets/images/logo_presensi.png') }}" alt="E-Presensi Logo" class="h-20 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">Verifikasi Email</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 mb-4">
                    Terima kasih telah mendaftar! Sebelum memulai, dapatkah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan kepada Anda? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan email yang lain.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800/20 p-4 rounded-lg">
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                        Keluar
                    </button>
                </form>
            </div>

            <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} E-Presensi SDN Bajo Soromandi. All rights reserved.
            </div>
        </div>
    </div>
</x-guest-flowbite-layout>
