<x-home-layout>
    <div class="relative min-h-screen bg-[#fff0e5] overflow-hidden">
        <div class="absolute inset-0 flex justify-center items-center opacity-20 pointer-events-none z-0">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Background Logo" class="w-[600px]">
        </div>

        <div class="relative z-10 max-w-3xl mx-auto px-4 py-16">
            {{-- Step Indicator --}}
            <div class="flex justify-center mb-8">
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs">1</div>
                        <span class="text-sm mt-1 text-gray-400">Reservation</span>
                    </div>
                    <div class="w-10 h-1 bg-gray-400"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs">2</div>
                        <span class="text-sm mt-1 text-gray-400">Payment</span>
                    </div>
                    <div class="w-10 h-1 bg-gray-400"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center text-xs">3</div>
                        <span class="text-sm mt-1 text-green-600 font-semibold">Success</span>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="bg-white p-10 rounded shadow text-center">
                <h2 class="text-2xl font-bold text-green-700 mb-4">✅ Pembayaran Berhasil Dikirim</h2>
                <p class="text-gray-700 mb-6">Terima kasih! Bukti pembayaran Anda telah berhasil dikirim dan sedang menunggu verifikasi oleh tim kami.</p>

                <x-primary-link href="{{ route('user.reservasi.index') }}"
                    class="inline-block font-semibold">
                    Lihat Reservasi Saya
                </x-primary-link>
            </div>
        </div>
    </div>
</x-home-layout>