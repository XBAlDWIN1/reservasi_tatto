<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="editModal = false">
        <h3 class="text-xl font-bold mb-4">Edit Kategori</h3>

        <form method="POST" :action="`{{ url('kategoris') }}/` + kategori.id_kategori">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Nama Kategori</label>
                <input
                    type="text"
                    name="nama_kategori"
                    x-model="kategori.nama_kategori"
                    class="w-full border rounded px-3 py-2"
                >
                @error('nama_kategori')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <input
                    type="text"
                    name="deskripsi"
                    x-model="kategori.deskripsi"
                    class="w-full border rounded px-3 py-2"
                >
                @error('deskripsi')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>
