<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="editModal = false">
        <h3 class="text-xl font-bold mb-4">Edit Pelanggan</h3>

        <form method="POST" :action="`/pelanggans/${pelanggan.id_pelanggan}`">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" x-model="pelanggan.nama_lengkap" class="w-full border rounded px-3 py-2">
                <template x-if="errors?.nama_lengkap">
                    <p class="text-red-600 text-sm" x-text="errors.nama_lengkap"></p>
                </template>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Telepon</label>
                <input type="text"
                    name="telepon"
                    x-model="pelanggan.telepon"
                    class="w-full border rounded px-3 py-2"
                    pattern="[0-9]{10,15}"
                    title="Nomor telepon harus 10-15 digit angka"
                    required class="w-full border rounded px-3 py-2">
                <template x-if="errors?.telepon">
                    <p class="text-red-600 text-sm" x-text="errors.telepon"></p>
                </template>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Pengguna</label>
                <input type="text" :value="pelanggan.pengguna?.name" class="w-full border rounded px-3 py-2 bg-gray-100" disabled>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>