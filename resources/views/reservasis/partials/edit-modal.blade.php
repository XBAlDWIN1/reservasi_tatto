<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-4xl" @click.away="editModal = false">
        <h3 class="text-xl font-bold mb-4">Edit Reservasi</h3>

        <form method="POST" :action="`{{ url('reservasis') }}/` + reservasi.id_reservasi">
            @csrf
            @method('PUT')
            <!-- <input type="hidden" name="id_reservasi" x-model="reservasi.id_reservasi">
            <input type="hidden" name="id_pengguna" x-model="reservasi.id_pengguna">
            <input type="hidden" name="id_pelanggan" x-model="reservasi.id_pelanggan">
            <input type="hidden" name="id_konsultasi" x-model="reservasi.id_konsultasi">
            <input type="hidden" name="total_pembayaran" x-model="reservasi.total_pembayaran">
            <input type="hidden" name="status" x-model="reservasi.status"> -->

            <div class="mb-4">
                <label for="id_pengguna" class="block text-gray-700">Pengguna</label>
                <select name="id_pengguna" id="id_pengguna" x-model="reservasi.id_pengguna" class="w-full border rounded px-3 py-2">
                    @foreach($penggunas as $pengguna)
                    <option :value="{{ $pengguna->id }}" x-text="'{{ $pengguna->name }}'"></option>
                    @endforeach
                </select>
                <template x-if="errors?.id_pengguna">
                    <p class="text-red-600 text-sm" x-text="errors.id_pengguna"></p>
                </template>
            </div>

            <div class="mb-4">
                <label for="id_pelanggan" class="block text-gray-700">Pelanggan</label>
                <select name="id_pelanggan" id="id_pelanggan" x-model="reservasi.id_pelanggan" class="w-full border rounded px-3 py-2">
                    @foreach($pelanggans as $pelanggan)
                    <option :value="{{ $pelanggan->id_pelanggan }}" x-text="'{{ $pelanggan->nama_lengkap }}'"></option>
                    @endforeach
                </select>
                <template x-if="errors?.id_pelanggan">
                    <p class="text-red-600 text-sm" x-text="errors.id_pelanggan"></p>
                </template>
            </div>

            <div class="mb-4">
                <label for="id_konsultasi" class="block text-gray-700">Jadwal Konsultasi</label>
                <select name="id_konsultasi" id="id_konsultasi" x-model="reservasi.id_konsultasi" class="w-full border rounded px-3 py-2">
                    @foreach($konsultasis as $konsultasi)
                    <option :value="{{ $konsultasi->id_konsultasi }}" x-text="'{{ \Carbon\Carbon::parse($konsultasi->jadwal_konsultasi)->format('d-m-Y H:i') }}'"></option>
                    @endforeach
                </select>
                <template x-if="errors?.id_konsultasi">
                    <p class="text-red-600 text-sm" x-text="errors.id_konsultasi"></p>
                </template>
            </div>

            <div class="mb-4">
                <label for="total_pembayaran" class="block text-gray-700">Total Pembayaran</label>
                <input type="number" name="total_pembayaran" id="total_pembayaran" x-model="reservasi.total_pembayaran" class="w-full border rounded px-3 py-2">
                <template x-if="errors?.total_pembayaran">
                    <p class="text-red-600 text-sm" x-text="errors.total_pembayaran"></p>
                </template>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700">Status</label>
                <select name="status" id="status" x-model="reservasi.status" class="w-full border rounded px-3 py-2">
                    <option value="menunggu">Menunggu</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <template x-if="errors?.status">
                    <p class="text-red-600 text-sm" x-text="errors.status"></p>
                </template>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>