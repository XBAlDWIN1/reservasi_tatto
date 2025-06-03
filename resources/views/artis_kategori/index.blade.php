<x-app-layout>
    <div x-data="artisKategoriManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old(), ]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4"> Manajemen Artis Kategori</h2>

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('artis-kategori.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama kategori..." />
                    <x-primary-button type="submit" class="px-4 py-1 rounded">Cari</x-primary-button>
                </form>
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Data</x-primary-button>
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
                        <th class="p-2 text-left">Nama Artis Tato</th>
                        <th class="p-2 text-left">Kategori</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artisKategoris as $relasi)
                    <tr class="border-t">
                        <td class="p-2">{{ $relasi->artisTato->nama_artis_tato }}</td>
                        <td class="p-2">{{ $relasi->kategori->nama_kategori }}</td>
                        <td class="p-2 space-x-2">
                            <button
                                @click='setEdit(@json($relasi))'
                                class="text-blue-600">Edit</button>
                            <button
                                @click="confirmDelete({{ $relasi->id_artis_kategori }})"
                                class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">Tidak ada artis kategori ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $artisKategoris->appends(['search' => request('search')])->links() }}
            </div>

            @include('artis_kategori.partials.add-modal')
            @include('artis_kategori.partials.edit-modal')
            @include('artis_kategori.partials.delete-modal')
        </div>
    </div>
    <script>
        function artisKategoriManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                artisKategori: {
                    id_artis_kategori: null,
                    id_artis_tato: '',
                    id_kategori: ''
                },
                artisKategoriId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_artis_kategori) {
                            this.artisKategori = {
                                id_artis_kategori: data.old.id_artis_kategori,
                                id_artis_tato: data.old.id_artis_tato,
                                id_kategori: data.old.id_kategori
                            };
                            this.editModal = true;
                        } else {
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.artisKategori = {
                        id_artis_kategori: data.id_artis_kategori,
                        id_artis_tato: data.id_artis_tato,
                        id_kategori: data.kategoris
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.artisKategoriId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>