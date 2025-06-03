<x-app-layout>
    <div x-data="lokasiManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old(), ]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Lokasi Tato</h2>

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('lokasi_tatos.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama lokasi..." />
                    <x-primary-button type="submit" class="px-4 py-1 rounded">Cari</x-primary-button>
                </form>
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Lokasi</x-primary-button>
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
                        <th class="p-2 text-left">Nama Lokasi</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lokasi_tatos as $lokasi)
                    <tr class="border-t">
                        <td class="p-2">{{ $lokasi->nama_lokasi_tato }}</td>
                        <td class="p-2 space-x-2">
                            <button
                                @click='setEdit(@json($lokasi))'
                                class="text-blue-600">Edit</button>
                            <button
                                @click="confirmDelete({{ $lokasi->id_lokasi_tato }})"
                                class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada lokasi ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $lokasi_tatos->appends(['search' => request('search')])->links() }}
            </div>

            @include('lokasi_tatos.partials.add-modal')
            @include('lokasi_tatos.partials.edit-modal')
            @include('lokasi_tatos.partials.delete-modal')
        </div>
    </div>
    <script>
        function lokasiManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                lokasi: {
                    id_lokasi_tato: null,
                    nama_lokasi_tato: '',
                },
                lokasiId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_lokasi_tato) {
                            this.lokasi = {
                                id_lokasi_tato: data.old.id_lokasi_tato,
                                nama_lokasi_tato: data.old.nama_lokasi_tato,
                            };
                            this.editModal = true;
                        } else {
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.lokasi = {
                        id_lokasi_tato: data.id_lokasi_tato,
                        nama_lokasi_tato: data.nama_lokasi_tato,
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.lokasiId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>