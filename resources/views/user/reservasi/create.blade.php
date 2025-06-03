<x-home-layout>
    {{-- Background Style --}}
    <div class="relative min-h-screen bg-[#fff0e5] overflow-hidden">
        <div class="absolute inset-0 flex justify-center items-center opacity-20 pointer-events-none z-0">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Background Logo" class="w-[600px]">
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 py-8">
            {{-- Step Indicator --}}
            <div class="flex justify-center mb-6">
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs">1</div>
                        <span class="text-sm mt-1">Reservation</span>
                    </div>
                    <div class="w-10 h-1 bg-gray-400"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs">2</div>
                        <span class="text-sm mt-1 text-gray-400">Payment</span>
                    </div>
                    <div class="w-10 h-1 bg-gray-400"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs">3</div>
                        <span class="text-sm mt-1 text-gray-400">Success</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bagian Kiri: Detail Konsultasi -->
                <div class="bg-white p-6 rounded shadow">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold mb-4">Detail Konsultasi</h3>
                        <img src="{{ asset('storage/' . $konsultasi->gambar) }}" class="h-28 object-cover mx-auto mb-4 rounded" alt="">
                    </div>

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

                <!-- Bagian Kanan: Form Pelanggan -->
                <div class="bg-white p-6 rounded shadow">
                    <form method="POST" action="{{ route('user.reservasi.step1.store') }}">
                        @csrf
                        <input type="hidden" name="id_konsultasi" value="{{ $konsultasi->id_konsultasi }}">

                        <!-- Pilih Pelanggan Lama -->
                        <div class="mb-4">
                            <label for="pelanggan_lama" class="block font-medium mb-1">Pilih Pelanggan Lama (opsional)</label>
                            <select name="pelanggan_lama" id="pelanggan_lama" class="w-full border-gray-300 rounded shadow-sm">
                                <option value="">-- Pilih pelanggan lama --</option>
                                @foreach ($pelangganList as $pelanggan)
                                <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nama_lengkap }} ({{ $pelanggan->telepon }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2 text-gray-600 text-sm italic">Atau isi data pelanggan baru:</div>

                        <!-- Nama Lengkap -->
                        <div class="mb-4">
                            <label for="nama_lengkap" class="block font-medium mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('nama_lengkap') }}">
                            @error('nama_lengkap')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="mb-4">
                            <label for="telepon" class="block font-medium mb-1">Nomor Telepon</label>
                            <input type="text" name="telepon" id="telepon"
                                class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('telepon') }}">
                            @error('telepon')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="mt-6">
                            <x-primary-button type="submit" class="font-semibold">
                                Lanjut ke Pembayaran
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-home-layout>