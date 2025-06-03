<x-app-layout>
    <div x-data="userManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old()]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Pengguna</h2>
            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('users.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email..." />
                    <x-primary-button type="submit" class="px-4 py-1 rounded">Cari</x-primary-button>
                </form>

                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">
                    {{ __('Tambah Pengguna') }}
                </x-primary-button>
            </div>

            <!-- success or error message -->
            @if (session('success'))
            <x-alert type="success" class="mb-4">
                {{ session('success') }}
            </x-alert>
            @endif
            @if (session('error'))
            <x-alert type="error" class="mb-4">
                {{ session('error') }}
            </x-alert>
            @endif

            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Nama</th>
                        <th class="p-2 text-left">Email</th>
                        <th class="p-2 text-left">Role</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-t">
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">{{ $user->roles->pluck('name')->first() }}</td>
                        <td class="p-2 space-x-2">
                            <button
                                @click='setEdit(@json($user))'
                                class="text-blue-600">Edit</button>
                            <button
                                @click="confirmDelete({{ $user->id }})"
                                class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada user ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->appends(['search' => request('search')])->links() }}
            </div>

            @include('users.partials.add-modal')
            @include('users.partials.edit-modal')
            @include('users.partials.delete-modal')
        </div>
    </div>

    <script>
        function userManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                user: {
                    id: null,
                    name: '',
                    email: '',
                    role: ''
                },
                userId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id) {
                            this.user = {
                                id: data.old.id,
                                name: data.old.name,
                                email: data.old.email,
                                role: data.old.role,
                            };
                            this.editModal = true;
                        } else {
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.user = {
                        id: data.id,
                        name: data.name,
                        email: data.email,
                        role: data.roles.length > 0 ? data.roles[0].name : '',
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.userId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>