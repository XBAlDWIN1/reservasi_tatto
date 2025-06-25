<x-home-layout>
    <div class="min-h-screen flex items-center justify-center bg-orange-100 px-4">
        <div class="bg-[#f9c6a1] shadow-xl rounded-xl p-6 flex flex-col md:flex-row w-full max-w-5xl relative overflow-hidden">

            <!-- Background logo -->
            <div class="absolute inset-0 opacity-10 z-0">
                <img src="{{ asset('img/logo.jpeg') }}" class="w-full h-full object-cover" alt="Background Logo">
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('konsultasi.store') }}" enctype="multipart/form-data" class="relative z-10 flex flex-col md:flex-row w-full space-y-6 md:space-y-0 md:space-x-6">
                @csrf
                <input type="hidden" name="id_pengguna" value="{{ auth()->id() }}">

                <!-- Kiri: Form input -->
                <div class="md:w-1/2 space-y-4 text-sm text-black">
                    <h2 class="text-xl text-center font-bold">Form Konsultasi</h2>

                    <div>
                        <x-input-label value="Ukuran Tato" variant="primary" />
                        <div class="flex space-x-2 w-full">
                            <div>
                                <x-text-input type="number" name="panjang" placeholder="Panjang (cm)" required />
                                @error('panjang')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <x-text-input type="number" name="lebar" placeholder="Lebar (cm)" required />
                                @error('lebar')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <x-input-label value="Lokasi Tato" variant="primary" />
                        <select name="id_lokasi_tato" class="w-full border-none px-3 py-2 rounded-full">
                            @foreach ($lokasi_tatos as $lokasi)
                            <option value="{{ $lokasi->id_lokasi_tato }}">{{ $lokasi->nama_lokasi_tato }}</option>
                            @endforeach
                        </select>
                        @error('id_lokasi_tato')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <x-input-label value="Kategori" variant="primary" />
                        <select name="id_kategori" class="w-full border-none px-3 py-2 rounded-full">
                            @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-input-label value="Jenis Desain" variant="primary" />
                        <select name="jenis_desain" id="jenis_desain" class="w-full border-none px-3 py-2 rounded-full">
                            <option value="Flat">Flat</option>
                            <option value="3D">3D</option>
                            <option value="Realistic">Realistic</option>
                            <option value="Custom">Custom</option>
                        </select>
                        @error('jenis_desain')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <x-input-label value="Warna Tato" variant="primary" />
                        <select name="warna" id="warna" class="w-full border-none px-3 py-2 rounded-full">
                            <option value="Satu Warna">Satu Warna</option>
                            <option value="Warna">Lebih dari Satu Warna</option>
                        </select>
                        @error('warna')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <x-input-label value="Tanggal & Jam" variant="primary" />
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-text-input type="date" name="jadwal_tanggal" min="{{ \Carbon\Carbon::now()->toDateString() }}" class="w-full" />
                                @error('jadwal_tanggal')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <x-text-input type="time" name="jadwal_jam" id="jadwal_jam" required autofocus autocomplete="jadwal_jam" min="09:00" max="17:00" class="w-full" />
                                @error('jadwal_jam')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Upload dan Preview -->
                <div class="md:w-1/2 flex flex-col items-center justify-center text-center space-y-4">
                    <x-input-label for="gambar" value="Gambar Referensi" variant="primary" />

                    <!-- Upload Box -->
                    <label for="gambar" class="cursor-pointer w-full max-w-sm flex flex-col items-center justify-center border border-dashed border-orange-400 bg-white hover:bg-orange-50 rounded-lg px-4 py-6 transition duration-300">
                        <!-- Ionicon Upload Icon -->
                        <ion-icon name="cloud-upload-outline" class="text-orange-500 text-4xl mb-2"></ion-icon>
                        <span class="text-sm text-orange-600">Klik untuk unggah gambar</span>
                        <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </label>

                    <!-- Preview Gambar -->
                    <img id="imagePreview" class="w-48 h-48 object-cover rounded-lg shadow-md hidden" alt="Preview" />

                    @error('gambar')
                    <div class="text-red-500 text-xs">{{ $message }}</div>
                    @enderror

                    <x-primary-button>
                        {{ __('Kirim Konsultasi') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById('imagePreview');
                img.src = reader.result;
                img.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-home-layout>