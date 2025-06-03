<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl">
        <h3 class="text-lg font-semibold mb-4">Edit Pembayaran</h3>
        <form method="POST" :action="`{{ url('pembayarans') }}/` + pembayaran.id_pembayaran" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">ID Reservasi</label>
                <select name="id_reservasi" class="w-full border rounded px-3 py-2" x-model="pembayaran.id_reservasi">
                    <option value="">-- Pilih Reservasi --</option>
                    @foreach($reservasis as $reservasi)
                    <option :value="{{ $reservasi->id_reservasi }}">{{ $reservasi->id_reservasi }}</option>
                    @endforeach
                </select>
                <template x-if="errors?.id_reservasi">
                    <p class="text-red-600 text-sm" x-text="errors.id_reservasi"></p>
                </template>
            </div>

            <div class="mb-4">
                <label class="block mb-1">ID Pengguna</label>
                <select name="id_pengguna" class="w-full border rounded px-3 py-2" x-model="pembayaran.id_pengguna">
                    <option value="">-- Pilih Pengguna --</option>
                    @foreach($penggunas as $pengguna)
                    <option :value="{{ $pengguna->id }}">{{ $pengguna->name }}</option>
                    @endforeach
                </select>
                <template x-if="errors?.id_pengguna">
                    <p class="text-red-600 text-sm" x-text="errors.id_pengguna"></p>
                </template>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" x-model="pembayaran.status">
                    <option value="menunggu">Menunggu</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <template x-if="errors?.status">
                    <p class="text-red-600 text-sm" x-text="errors.status"></p>
                </template>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Bukti Pembayaran (opsional)</label>
                <input type="file" name="bukti_pembayaran" class="w-full border rounded px-3 py-2">
                @error('bukti_pembayaran')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Catatan</label>
                <textarea name="catatan" rows="3" class="w-full border rounded px-3 py-2" x-model="pembayaran.catatan"></textarea>
                <template x-if="errors?.catatan">
                    <p class="text-red-600 text-sm" x-text="errors.catatan"></p>
                </template>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>