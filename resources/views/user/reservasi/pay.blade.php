<!-- Step 2: Pembayaran -->
<x-home-layout>
    <div class="relative min-h-screen bg-[#fff0e5] overflow-hidden">
        <div class="absolute inset-0 flex justify-center items-center opacity-20 pointer-events-none z-0">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Background Logo" class="w-[600px]">
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 py-8">
            {{-- Step Indicator --}}
            <div class="flex justify-center mb-6">
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs">1</div>
                        <span class="text-sm mt-1 text-gray-400">Reservation</span>
                    </div>
                    <div class="w-10 h-1 bg-gray-400"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs">2</div>
                        <span class="text-sm mt-1">Payment</span>
                    </div>
                    <div class="w-10 h-1 bg-gray-400"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs">3</div>
                        <span class="text-sm mt-1 text-gray-400">Success</span>
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-semibold mb-6 text-center">Step 2: Pembayaran</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kiri: Detail Konsultasi + QR -->
                <div class="bg-white p-6 rounded shadow space-y-6">
                    <div>
                        <h3 class="text-lg font-bold mb-4">Detail Konsultasi</h3>
                        <div class="text-sm space-y-2">
                            <div class="flex justify-between">
                                <span class="font-semibold">Nama Artis:</span>
                                <span>{{ $konsultasi->artisTato->nama_artis_tato ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Kategori:</span>
                                <span>{{ $konsultasi->kategori->nama_kategori ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Ukuran:</span>
                                <span>{{ $konsultasi->panjang }} x {{ $konsultasi->lebar }} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Lokasi:</span>
                                <span>{{ $konsultasi->lokasiTato->nama_lokasi_tato ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Total Biaya Estimasi:</span>
                                <span class="font-semibold text-green-600">Rp{{ number_format($total_biaya, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="text-center pt-4 border-t border-dashed">
                        <h4 class="font-semibold mb-2">Scan QR untuk Pembayaran</h4>
                        <img src="{{ asset('img/QR.jpg') }}" alt="QR Code" class="mx-auto h-40 rounded border border-gray-200 shadow">
                        <p class="text-sm text-gray-500 mt-2">Gunakan aplikasi e-wallet untuk scan dan bayar.</p>
                    </div>
                </div>

                <!-- Kanan: Form Upload -->
                <div class="bg-white p-6 rounded shadow">
                    <form method="POST" action="{{ route('user.reservasi.step2.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_reservasi" value="{{ $reservasi->id_reservasi }}">

                        <div class="mb-6">
                            <label for="bukti_pembayaran" class="block font-semibold mb-2">Upload Bukti Pembayaran</label>

                            <label for="bukti_pembayaran"
                                class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 hover:border-blue-500 transition">
                                <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16l4-4m0 0l4 4m-4-4v12M12 4h4m4 0h-4a4 4 0 00-4 4v4"></path>
                                </svg>
                                <p class="text-sm text-gray-600 text-center">Klik atau seret file bukti pembayaran ke sini</p>
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                    class="hidden" accept="image/*"
                                    onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').classList.remove('hidden')">
                            </label>

                            @error('bukti_pembayaran')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <div class="mt-4">
                                <img id="preview" src="#" alt="Preview Gambar"
                                    class="hidden w-full h-40 object-cover rounded shadow border">
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <x-primary-button type="submit"
                                class="font-semibold">
                                Konfirmasi Pembayaran
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-home-layout>