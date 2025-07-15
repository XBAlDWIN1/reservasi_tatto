<div x-show="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="addModal = false" x-data="{ showPassword: false }">
        <h3 class="text-xl font-bold mb-4">Tambah Pengguna</h3>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama" class="w-full border rounded px-3 py-2">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" class="w-full border rounded px-3 py-2">
                @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Password + Show/Hide -->
            <div class="mb-4" x-data="{ show: false }">
                <label class="block mb-1">Password</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" value="{{ old('password') }}" placeholder="Masukkan Password" class="w-full border rounded px-3 py-2 pr-10">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-2 flex items-center text-gray-600 text-sm focus:outline-none">
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.043 10.043 0 012.845-4.419M6.82 6.82A9.99 9.99 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.423 5.568M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Role (tanpa Admin) -->
            <div class="mb-4">
                <label class="block mb-1">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                    @if ($role->name !== 'Admin')
                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
                @error('role') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-2">
                <button type="button" @click="addModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>