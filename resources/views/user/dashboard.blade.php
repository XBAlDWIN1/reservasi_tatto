<x-app-layout>
    <div class="p-6 bg-[#fff0e5] min-h-screen">
        <div class="max-w-6xl mx-auto">
            {{-- Header --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-6 flex items-center">
                <div class="bg-blue-100 p-4 rounded-full mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Buat Konsultasi Baru</h3>
                    <a href="{{ route('konsultasi.create') }}"
                        class="text-sm text-blue-600 hover:underline">Mulai Sekarang →</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 flex items-center">
                <div class="bg-green-100 p-4 rounded-full mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Lihat Riwayat Reservasi</h3>
                    <a href="{{ route('user.reservasi.index') }}"
                        class="text-sm text-green-600 hover:underline">Lihat Sekarang →</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>