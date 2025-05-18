<x-guest-flowbite-layout>
<section class="py-14 md:py-20 bg-[#f3f4fe] relative">
    <div class="container px-4 text-center">
        <h1 class="text-6xl pt-20 font-bold text-red-700">500</h1>
        <p class="text-xl text-gray-700 mt-4">Terjadi Kesalahan</p>
        <p class="text-gray-600 mt-2">
            Maaf, sistem mengalami masalah. Silakan coba lagi nanti atau hubungi kami jika masalah terus berlanjut.
        </p>

        <!-- Informasi Kontak -->
        <div class="mt-6">
            <p class="text-lg text-gray-700">Hubungi Kami:</p>
            <p class="text-lg font-semibold text-blue-600">
                📞 <a href="https://wa.me/6285333411680" target="_blank" class="underline">WhatsApp</a>
            </p>
            <p class="text-lg font-semibold text-blue-600">
                📧 <a href="mailto:adiryantorizky140820@gmail.com" class="underline">E-Mail</a>
            </p>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ url('/') }}"
            class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</section>
</x-guest-flowbite-layout>
