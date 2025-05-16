<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-center mb-6">Masuk ke Sistem E-Presensi</h1>

        @if(session('status'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('status') }}</div>
        @endif

        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">Email</label>
                <input id="email" class="w-full border px-3 py-2 rounded" type="email" name="email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block font-semibold mb-1">Kata Sandi</label>
                <input id="password" class="w-full border px-3 py-2 rounded" type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
