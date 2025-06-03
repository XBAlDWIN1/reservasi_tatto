<x-app-layout>
    <div x-data="kategoriManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old(), ]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Kategori</h2>

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('kategoris.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama kategori..." />
                    <x-primary-button type="submit" class="px-4 py-1 rounded">Cari</x-primary-button>
                </form>
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Kategori</x-primary-button>
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
                        <th class="p-2 text-left">Nama Kategori</th>
                        <th class="p-2 text-left">Deskripsi</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $kategori)
                    <tr class="border-t">
                        <td class="p-2">{{ $kategori->nama_kategori }}</td>
                        <td class="p-2">{{ $kategori->deskripsi }}</td>
                        <td class="p-2 space-x-2">
                            <button
                                @click='setEdit(@json($kategori))'
                                class="text-blue-600">Edit</button>
                            <button
                                @click="confirmDelete({{ $kategori->id_kategori }})"
                                class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada kategori ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $kategoris->appends(['search' => request('search')])->links() }}
            </div>

            @include('kategoris.partials.add-modal')
            @include('kategoris.partials.edit-modal')
            @include('kategoris.partials.delete-modal')
        </div>
    </div>
    <script>
        function kategoriManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                kategori: {
                    id_kategori: null,
                    nama_kategori: '',
                    deskripsi: ''
                },
                kategoriId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_kategori) {
                            this.kategori = {
                                id_kategori: data.old.id_kategori,
                                nama_kategori: data.old.nama_kategori,
                                deskripsi: data.old.deskripsi
                            };
                            this.editModal = true;
                        } else {
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.kategori = {
                        id_kategori: data.id_kategori,
                        nama_kategori: data.nama_kategori,
                        deskripsi: data.deskripsi
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.kategoriId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>