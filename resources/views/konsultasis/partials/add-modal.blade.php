<div x-show="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-4xl" @click.away="addModal = false">
        <h3 class="text-xl font-bold mb-4">Tambah Konsultasi</h3>

        <form method="POST" action="{{ route('konsultasis.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold">Nama</label>
                    <select name="id_pengguna" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Pengguna --</option>
                        @foreach($pengguna as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    @error('id_pengguna')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Artis</label>
                    <select name="id_artis_tato" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Artis --</option>
                        @foreach($artisTatos as $a)
                        <option value="{{ $a->id_artis_tato }}">{{ $a->nama_artis_tato }}</option>
                        @endforeach
                    </select>
                    @error('id_artis_tato')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label class="block mb-1 font-semibold">Ukuran</label>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <input type="number" name="panjang" placeholder="Panjang (cm)" class="w-full border rounded px-3 py-2">
                            @error('panjang')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <input type="number" name="lebar" placeholder="Lebar (cm)" class="w-full border rounded px-3 py-2">
                            @error('lebar')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Lokasi</label>
                    <select name="id_lokasi_tato" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($lokasiTatos as $l)
                        <option value="{{ $l->id_lokasi_tato }}">{{ $l->nama_lokasi_tato }}</option>
                        @endforeach
                    </select>
                    @error('id_lokasi_tato')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1 font-semibold">Jadwal Konsultasi</label>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <input type="date" name="jadwal_tanggal" class="w-full border rounded px-3 py-2">
                            @error('jadwal_tanggal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <input type="time" name="jadwal_jam" class="w-full border rounded px-3 py-2">
                            @error('jadwal_jam')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Kategori</label>
                    <select name="id_kategori" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Gambar Referensi</label>
                    <input type="file" name="gambar" class="w-full border rounded px-3 py-2">
                    @error('gambar')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" @click="addModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>