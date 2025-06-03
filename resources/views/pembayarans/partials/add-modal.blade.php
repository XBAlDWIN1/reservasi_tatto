<div x-show="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl">
        <h3 class="text-lg font-semibold mb-4">Tambah Pembayaran</h3>
        <form method="POST" action="{{ route('pembayarans.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">ID Reservasi</label>
                <select name="id_reservasi" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Reservasi --</option>
                    @foreach($reservasis as $reservasi)
                    <option value="{{ $reservasi->id_reservasi }}" {{ old('id_reservasi') == $reservasi->id_reservasi ? 'selected' : '' }}>
                        {{ $reservasi->id_reservasi }}
                    </option>
                    @endforeach
                </select>
                @error('id_reservasi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">ID Pengguna</label>
                <select name="id_pengguna" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Pengguna --</option>
                    @foreach($penggunas as $pengguna)
                    <option value="{{ $pengguna->id }}" {{ old('id_pengguna') == $pengguna->id ? 'selected' : '' }}>
                        {{ $pengguna->name }}
                    </option>
                    @endforeach
                </select>
                @error('id_pengguna')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="menunggu" {{ old('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diterima" {{ old('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" class="w-full border rounded px-3 py-2">
                @error('bukti_pembayaran')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Catatan</label>
                <textarea name="catatan" class="w-full border rounded px-3 py-2" rows="3">{{ old('catatan') }}</textarea>
                @error('catatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="addModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>