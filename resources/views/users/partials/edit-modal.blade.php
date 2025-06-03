<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="editModal = false">
        <h3 class="text-xl font-bold mb-4">Edit User</h3>

        <form method="POST" :action="'/users/' + user.id">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" :value="user.id">

            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" x-model="user.name" class="w-full border rounded px-3 py-2">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" x-model="user.email" class="w-full border rounded px-3 py-2">
                @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Role</label>
                <select name="role" x-model="user.role" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>
