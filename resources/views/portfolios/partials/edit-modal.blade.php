<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl">
        <h3 class="text-lg font-semibold mb-4">Edit Portfolio</h3>
        <form method="POST" :action="`{{ url('portfolios') }}/` + portfolio.id_portfolio" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Artis Tato</label>
                <select name="id_artis_tato" class="w-full border rounded px-3 py-2" x-model="portfolio.id_artis_tato">
                    <option value="">-- Pilih Artis --</option>
                    @foreach($artisTatos as $a)
                        <option value="{{ $a->id_artis_tato }}">{{ $a->nama_artis_tato }}</option>
                    @endforeach
                </select>
                <template x-if="errors?.id_artis_tato">
                    <p class="text-red-600 text-sm" x-text="errors.id_artis_tato"></p>
                </template>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Judul</label>
                <input type="text" name="judul" class="w-full border rounded px-3 py-2" x-model="portfolio.judul">
                <template x-if="errors?.judul">
                    <p class="text-red-600 text-sm" x-text="errors.judul"></p>
                </template>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full border rounded px-3 py-2" x-model="portfolio.deskripsi"></textarea>
                <template x-if="errors?.deskripsi">
                    <p class="text-red-600 text-sm" x-text="errors.deskripsi"></p>
                </template>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Ganti Gambar (opsional)</label>
                <input type="file" name="gambar" class="w-full border rounded px-3 py-2">
                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>
