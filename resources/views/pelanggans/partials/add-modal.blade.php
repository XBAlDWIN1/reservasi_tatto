<div x-show="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="addModal = false">
        <h3 class="text-xl font-bold mb-4">Tambah Pelanggan</h3>

        <form method="POST" action="{{ route('pelanggans.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border rounded px-3 py-2">
                @error('nama_lengkap') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Telepon</label>
                <input type="text" 
                name="telepon" 
                x-model="pelanggan.telepon"
                class="w-full border rounded px-3 py-2"
                pattern="[0-9]{10,15}"
                title="Nomor telepon harus 10-15 digit angka"
                required value="{{ old('telepon') }}" class="w-full border rounded px-3 py-2">
                @error('telepon') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <input type="hidden" name="id_pengguna" value="{{ Auth::id() }}">

            <div class="flex justify-end space-x-2">
                <button type="button" @click="addModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
