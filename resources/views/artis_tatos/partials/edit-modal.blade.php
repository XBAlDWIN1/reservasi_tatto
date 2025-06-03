<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="editModal = false">
        <h3 class="text-xl font-bold mb-4">Edit Artis</h3>

        <form method="POST" :action="`{{ url('artis_tatos') }}/` + artis.id_artis_tato" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Nama Artis</label>
                <input
                    type="text"
                    name="nama_artis_tato"
                    x-model="artis.nama_artis_tato"
                    class="w-full border rounded px-3 py-2">
                @error('nama_artis_tato')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Tahun Menato</label>
                <input
                    type="text"
                    name="tahun_menato"
                    x-model="artis.tahun_menato"
                    class="w-full border rounded px-3 py-2">
                @error('tahun_menato')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Instagram</label>
                <input
                    type="text"
                    name="instagram"
                    x-model="artis.instagram"
                    class="w-full border rounded px-3 py-2">
                @error('instagram')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Tiktok</label>
                <input
                    type="text"
                    name="tiktok"
                    x-model="artis.tiktok"
                    class="w-full border rounded px-3 py-2">
                @error('tiktok')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Gambar</label>
                <input
                    type="file"
                    name="gambar"
                    accept="image/*"
                    class="w-full border rounded px-3 py-2">
                @error('gambar')
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