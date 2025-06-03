<div x-show="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl">
        <h3 class="text-lg font-semibold mb-4">Tambah Portfolio</h3>
        <form method="POST" action="{{ route('portfolios.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Artis Tato</label>
                <select name="id_artis_tato" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Artis --</option>
                    @foreach($artisTatos as $a)
                        <option value="{{ $a->id_artis_tato }}" {{ old('id_artis_tato') == $a->id_artis_tato ? 'selected' : '' }}>
                            {{ $a->nama_artis_tato }}
                        </option>
                    @endforeach
                </select>
                @error('id_artis_tato')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Judul</label>
                <input type="text" name="judul" class="w-full border rounded px-3 py-2" value="{{ old('judul') }}">
                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border rounded px-3 py-2" rows="3">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Gambar</label>
                <input type="file" name="gambar" class="w-full border rounded px-3 py-2">
                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="addModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
