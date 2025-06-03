<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-4xl" @click.away="editModal = false">
        <h3 class="text-xl font-bold mb-4">Edit Konsultasi</h3>

        <form method="POST" :action="`{{ url('konsultasis') }}/` + konsultasi.id_konsultasi" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <!-- Nama Pengguna -->
                <div>
                    <label class="block mb-1">Nama Pengguna</label>
                    <select name="id_pengguna" class="w-full border rounded px-3 py-2" x-model="konsultasi.id_pengguna">
                        <option value="">-- Pilih Pengguna --</option>
                        @foreach($pengguna as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    <template x-if="errors?.id_pengguna">
                        <p class="text-red-600 text-sm" x-text="errors.id_pengguna"></p>
                    </template>
                </div>

                <!-- Artis Tato -->
                <div>
                    <label class="block mb-1">Artis Tato</label>
                    <select name="id_artis_tato" class="w-full border rounded px-3 py-2" x-model="konsultasi.id_artis_tato">
                        <option value="">-- Pilih Artis --</option>
                        @foreach($artisTatos as $a)
                        <option value="{{ $a->id_artis_tato }}">{{ $a->nama_artis_tato }}</option>
                        @endforeach
                    </select>
                    <template x-if="errors?.id_artis_tato">
                        <p class="text-red-600 text-sm" x-text="errors.id_artis_tato"></p>
                    </template>
                </div>

                <!-- Ukuran Tato -->
                <div>
                    <label class="block mb-1">Ukuran Tato</label>
                    <div class="flex gap-4">
                        <input type="number" name="panjang" placeholder="Panjang (cm)" class="w-1/2 border rounded px-3 py-2" x-model="konsultasi.panjang">
                        <input type="number" name="lebar" placeholder="Lebar (cm)" class="w-1/2 border rounded px-3 py-2" x-model="konsultasi.lebar">
                    </div>
                </div>

                <!-- Lokasi Tato -->
                <div>
                    <label class="block mb-1">Lokasi Tato</label>
                    <select name="id_lokasi_tato" class="w-full border rounded px-3 py-2" x-model="konsultasi.id_lokasi_tato">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($lokasiTatos as $l)
                        <option value="{{ $l->id_lokasi_tato }}">{{ $l->nama_lokasi_tato }}</option>
                        @endforeach
                    </select>
                    <template x-if="errors?.id_lokasi_tato">
                        <p class="text-red-600 text-sm" x-text="errors.id_lokasi_tato"></p>
                    </template>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1 font-semibold">Jadwal Konsultasi</label>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <input type="date" id="edit_jadwal_tanggal" name="jadwal_tanggal"
                                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" x-model="konsultasi.jadwal_tanggal"
                                required>
                            @error('jadwal_tanggal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            @if(isset($konsultasi) && $konsultasi->jadwal_konsultasi)
                            <input type="time" id="edit_jadwal_jam" name="jadwal_jam"
                                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                                x-model="konsultasi.jadwal_jam"
                                :value="'{{ old('jadwal_jam', \Carbon\Carbon::parse($konsultasi->jadwal_konsultasi)->format('H:i')) }}'"
                                required>
                            @endif

                            @error('jadwal_jam')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>


                <!-- Kategori -->
                <div class="flex gap-2">
                    <div>
                        <label class="mb-1">Kategori</label>
                        <select name="id_kategori" class="w-full border rounded px-3 py-2" x-model="konsultasi.id_kategori">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <template x-if="errors?.id_kategori">
                            <p class="text-red-600 text-sm" x-text="errors.id_kategori"></p>
                        </template>
                    </div>
                    <div>
                        <label for="" class="mb-1">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2" x-model="konsultasi.status">
                            <option value="menunggu">Menunggu</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                        <template x-if="errors?.status">
                            <p class="text-red-600 text-sm" x-text="errors.status"></p>
                        </template>
                    </div>
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block mb-1">Gambar</label>
                    <div class="flex items-center space-x-4">
                        <input type="file" name="gambar" class="w-full border rounded px-3 py-2" x-model="konsultasi.gambar">
                    </div>
                    <template x-if="errors?.gambar">
                        <p class="text-red-600 text-sm" x-text="errors.gambar"></p>
                    </template>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>