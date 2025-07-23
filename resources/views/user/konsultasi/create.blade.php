<x-home-layout>
    <!-- Tambahkan x-data ke wrapper paling luar -->
    <div
        x-data="{
   open: false,
   preview: null,
   gambar: null,
   selectFromGallery(url) {
     this.preview = url;
     document.getElementById('imagePreview').src = url;
     document.getElementById('imagePreview').classList.remove('hidden');
     document.getElementById('gambarGaleri').value = url;
     document.getElementById('gambar').value = ''; // kosongkan file input jika sebelumnya upload manual
     this.open = false;
     this.gambar = null;
   },
   handleFileUpload(event) {
     this.gambar = event.target.files[0];
     const reader = new FileReader();
     reader.onload = () => {
       this.preview = reader.result;
       document.getElementById('imagePreview').src = reader.result;
       document.getElementById('imagePreview').classList.remove('hidden');
       document.getElementById('gambarGaleri').value = '';
     };
     reader.readAsDataURL(this.gambar);
   }
 }"
        class="min-h-screen flex items-center justify-center bg-orange-100 px-4">
        <div class="bg-[#f9c6a1] shadow-xl rounded-xl p-6 flex flex-col md:flex-row w-full max-w-5xl relative overflow-hidden">

            <!-- Background logo -->
            <div class="absolute inset-0 opacity-10 z-0">
                <img src="{{ asset('img/logo.jpeg') }}" class="w-full h-full object-cover" alt="Background Logo">
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('konsultasi.store') }}" enctype="multipart/form-data" class="relative z-10 flex flex-col md:flex-row w-full space-y-6 md:space-y-0 md:space-x-6">
                @csrf
                <input type="hidden" name="id_pengguna" value="{{ auth()->id() }}">
                <input type="hidden" name="gambar_galeri" id="gambarGaleri">
                <!-- Kiri: Form input -->
                <div class="md:w-1/2 space-y-4 text-sm text-black">
                    <h2 class="text-xl text-center font-bold">Form Konsultasi</h2>

                    <!-- Ukuran -->
                    <div>
                        <x-input-label value="Ukuran Tato" variant="primary" />
                        <div class="flex space-x-2 w-full">
                            <div>
                                <x-text-input type="number" name="panjang" placeholder="Panjang (cm)" required />
                                @error('panjang') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <x-text-input type="number" name="lebar" placeholder="Lebar (cm)" required />
                                @error('lebar') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <x-input-label value="Lokasi Tato" variant="primary" />
                        <select name="id_lokasi_tato" class="w-full border-none px-3 py-2 rounded-full">
                            @foreach ($lokasi_tatos as $lokasi)
                            <option value="{{ $lokasi->id_lokasi_tato }}">{{ $lokasi->nama_lokasi_tato }}</option>
                            @endforeach
                        </select>
                        @error('id_lokasi_tato') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <x-input-label value="Kategori" variant="primary" />
                        <select name="id_kategori" class="w-full border-none px-3 py-2 rounded-full">
                            @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('id_kategori') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Jenis Desain -->
                    <div>
                        <x-input-label value="Jenis Desain" variant="primary" />
                        <select name="jenis_desain" id="jenis_desain" class="w-full border-none px-3 py-2 rounded-full">
                            <option value="Flat">Flat</option>
                            <option value="3D">3D</option>
                            <option value="Realistic">Realistic</option>
                            <option value="Custom">Custom</option>
                        </select>
                        @error('jenis_desain') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Warna -->
                    <div>
                        <x-input-label value="Warna Tato" variant="primary" />
                        <select name="warna" id="warna" class="w-full border-none px-3 py-2 rounded-full">
                            <option value="Satu Warna">Satu Warna</option>
                            <option value="Warna">Lebih dari Satu Warna</option>
                        </select>
                        @error('warna') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Jadwal -->
                    <div>
                        <x-input-label value="Tanggal & Jam" variant="primary" />
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-text-input type="date" name="jadwal_tanggal" min="{{ \Carbon\Carbon::now()->toDateString() }}" class="w-full" />
                                @error('jadwal_tanggal') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <select name="jadwal_jam" required class="w-full border-none px-3 py-2 rounded-full">
                                    @foreach (['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00'] as $jam)
                                    <option value="{{ $jam }}">{{ $jam }}</option>
                                    @endforeach
                                </select>
                                @error('jadwal_jam') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Upload & Gallery Trigger -->
                <div class="md:w-1/2 flex flex-col items-center justify-center text-center space-y-4">
                    <x-input-label for="gambar" value="Gambar Referensi" variant="primary" />
                    <!-- Upload Box -->
                    <!-- <label for="gambar" class="cursor-pointer w-full max-w-sm flex flex-col items-center justify-center border border-dashed border-orange-400 bg-white hover:bg-orange-50 rounded-lg px-4 py-6 transition duration-300">
                        <ion-icon name="cloud-upload-outline" class="text-orange-500 text-4xl mb-2"></ion-icon>
                        <span class="text-sm text-orange-600">Klik untuk unggah gambar</span>
                        <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </label> -->
                    <!-- Preview -->
                    <!-- <img id="imagePreview" class="w-48 h-48 object-cover rounded-lg shadow-md hidden" alt="Preview" x-show="preview"> -->

                    <!-- Upload Box -->
                    <label for="gambar" class="cursor-pointer w-full max-w-sm flex flex-col items-center justify-center border border-dashed border-orange-400 bg-white hover:bg-orange-50 rounded-lg px-4 py-6 transition duration-300">
                        <ion-icon name="cloud-upload-outline" class="text-orange-500 text-4xl mb-2"></ion-icon>
                        <span class="text-sm text-orange-600">Klik untuk unggah gambar</span>
                        <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" @change="handleFileUpload($event)">
                    </label>
                    <!-- Preview -->
                    <img id="imagePreview" x-ref="imagePreview" class="w-48 h-48 object-cover rounded-lg shadow-md hidden" alt="Preview" x-show="preview">
                    @error('gambar') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror

                    <div class="mt-4 flex justify-center gap-2 w-full">
                        <x-primary-button type="button" @click="open = true">
                            {{ __('Pilih dari Galeri') }}
                        </x-primary-button>
                        <x-primary-button>
                            {{ __('Kirim Konsultasi') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>

            <!-- Modal Gallery -->
            <div
                x-show="open"
                x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div
                    @click.away="open = false"
                    class="bg-white max-w-4xl w-full max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative">
                    <button @click="open = false" class="absolute top-3 right-3 text-gray-600 hover:text-black text-2xl">&times;</button>
                    <h2 class="text-2xl font-bold text-center text-orange-700 mb-4">Galeri Portofolio</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($portfolios as $portfolio)
                        <div class="rounded overflow-hidden shadow hover:shadow-lg cursor-pointer transition"
                            @click="selectFromGallery('{{ asset('storage/' . $portfolio->gambar) }}')">
                            <img src="{{ asset('storage/' . $portfolio->gambar) }}" alt="Portfolio"
                                class="w-full h-48 object-cover">
                            <div class="p-2 text-sm">
                                <p class="font-semibold">{{ $portfolio->artis_tato->nama_artis_tato ?? '-' }}</p>
                                <p class="text-gray-500 text-xs">{{ $portfolio->deskripsi ?? '-' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Gambar -->
    <script>
        // function previewImage(event) {
        //     const reader = new FileReader();
        //     reader.onload = function() {
        //         const img = document.getElementById('imagePreview');
        //         img.src = reader.result;
        //         img.classList.remove('hidden');
        //         // Kosongkan input hidden gambar galeri jika user upload manual
        //         document.getElementById('gambarGaleri').value = '';
        //     };
        //     reader.readAsDataURL(event.target.files[0]);
        // }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById('imagePreview');
                img.src = reader.result;
                img.classList.remove('hidden');
                // Update the preview property
                document.querySelector('div[x-data]').preview = reader.result;
                // Kosongkan input hidden gambar galeri jika user upload manual
                document.getElementById('gambarGaleri').value = '';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-home-layout>