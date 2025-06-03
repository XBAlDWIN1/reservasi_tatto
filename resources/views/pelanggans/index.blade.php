<x-app-layout>
    <div x-data="pelangganManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old(), 'user_id' => auth()->id()]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Pelanggan</h2>

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('pelanggans.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau telepon..." />
                    <x-primary-button type="submit" class="px-4 py-1 rounded">Cari</x-primary-button>
                </form>
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Pelanggan</x-primary-button>
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
                        <th class="p-2 text-left">Nama Lengkap</th>
                        <th class="p-2 text-left">Telepon</th>
                        <th class="p-2 text-left">Pengguna</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $pelanggan)
                    <tr class="border-t">
                        <td class="p-2">{{ $pelanggan->nama_lengkap }}</td>
                        <td class="p-2">{{ $pelanggan->telepon }}</td>
                        <td class="p-2">{{ $pelanggan->pengguna->name }}</td>
                        <td class="p-2 space-x-2">
                            <button
                                @click='setEdit(@json($pelanggan))'
                                class="text-blue-600">Edit</button>
                            <button
                                @click="confirmDelete({{ $pelanggan->id_pelanggan }})"
                                class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada pelanggan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $pelanggans->appends(['search' => request('search')])->links() }}
            </div>

            @include('pelanggans.partials.add-modal')
            @include('pelanggans.partials.edit-modal')
            @include('pelanggans.partials.delete-modal')
        </div>
    </div>

    <script>
        function pelangganManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                pelanggan: {
                    id_pelanggan: null,
                    id_pengguna: '',
                    nama_lengkap: '',
                    telepon: ''
                },
                pelangganId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_pelanggan) {
                            this.pelanggan = {
                                id_pelanggan: data.old.id_pelanggan,
                                nama_lengkap: data.old.nama_lengkap,
                                telepon: data.old.telepon,
                                id_pengguna: data.old.id_pengguna,
                            };
                            this.editModal = true;
                        } else {
                            this.pelanggan.id_pengguna = data.user_id;
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.pelanggan = {
                        id_pelanggan: data.id_pelanggan,
                        nama_lengkap: data.nama_lengkap,
                        telepon: data.telepon,
                        id_pengguna: data.id_pengguna,
                        pengguna: data.pengguna
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.pelangganId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>