<div x-show="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="addModal = false">
        <h3 class="text-xl font-bold mb-4">Tambah Lokasi Tato</h3>

        <form method="POST" action="{{ route('lokasi_tatos.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Nama Lokasi Tato</label>
                <input type="text" name="nama_lokasi_tato" value="{{ old('nama_lokasi_tato') }}" class="w-full border rounded px-3 py-2">
                @error('nama_lokasi_tato') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="addModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>