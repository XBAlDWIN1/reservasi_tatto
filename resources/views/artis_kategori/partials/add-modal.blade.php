<div x-show="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="addModal = false">
        <h3 class="text-xl font-bold mb-4">Tambah Data</h3>

        <form method="POST" action="{{ route('artis-kategori.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Artis Tato</label>
                <select name="id_artis_tato" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Artis --</option>
                    @foreach($artis as $a)
                    <option value="{{ $a->id_artis_tato }}">{{ $a->nama_artis_tato }}</option>
                    @endforeach
                </select>
                @error('id_artis_tato')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Kategori</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($kategoris as $k)
                    <label class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            name="id_kategori[]"
                            value="{{ $k->id_kategori }}"
                            class="text-blue-600 rounded border-gray-300 focus:ring focus:ring-blue-200">
                        <span>{{ $k->nama_kategori }}</span>
                    </label>
                    @endforeach
                </div>
                @error('id_kategori')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <x-primary-button type="button" @click="addModal = false" class="px-4 py-2 bg-gray-300">Batal</x-primary-button>
                <x-primary-button type="submit" class="px-4 py-2">Simpan</x-primary-button>
            </div>
        </form>
    </div>
</div>