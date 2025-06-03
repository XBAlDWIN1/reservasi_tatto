<div x-show="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div @click.away="addModal = false" class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4">Tambah Reservasi</h2>
        <form method="POST" action="{{ route('reservasis.store') }}">
            @csrf

            <!-- Pengguna -->
            <div class="mb-4">
                <label for="id_pengguna" class="block text-sm font-medium text-gray-700">Pengguna</label>
                <select name="id_pengguna" id="id_pengguna" class="w-full border rounded px-3 py-2">
                    @foreach ($penggunas as $user)
                    <option value="{{ $user->id }}" {{ old('id_pengguna') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
                @error('id_pengguna')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pelanggan -->
            <div class="mb-4">
                <label for="id_pelanggan" class="block text-sm font-medium text-gray-700">Pelanggan</label>
                <select name="id_pelanggan" id="id_pelanggan" class="w-full border rounded px-3 py-2">
                    @foreach ($pelanggans as $p)
                    <option value="{{ $p->id_pelanggan }}" {{ old('id_pelanggan') == $p->id_pelanggan ? 'selected' : '' }}>
                        {{ $p->nama_lengkap }}
                    </option>
                    @endforeach
                </select>
                @error('id_pelanggan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konsultasi -->
            <div class="mb-4">
                <label for="id_konsultasi" class="block text-sm font-medium text-gray-700">Jadwal Konsultasi</label>
                <select name="id_konsultasi" id="id_konsultasi" class="w-full border rounded px-3 py-2">
                    @foreach ($konsultasis as $k)
                    <option value="{{ $k->id_konsultasi }}" {{ old('id_konsultasi') == $k->id_konsultasi ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($k->jadwal_konsultasi)->format('d-m-Y H:i') }}
                    </option>
                    @endforeach
                </select>
                @error('id_konsultasi')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="w-full border rounded px-3 py-2">
                    <option value="menunggu" {{ old('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diterima" {{ old('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <x-secondary-button type="button" @click="addModal = false">Batal</x-secondary-button>
                <x-primary-button type="submit">Simpan</x-primary-button>
            </div>
        </form>
    </div>
</div>