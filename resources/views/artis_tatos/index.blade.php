<x-app-layout>
    <div x-data="artisManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old(), ]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Artis Tato</h2>

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('artis_tatos.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama artis tato..." />
                    <x-primary-button type="submit" class="px-4 py-1 rounded">Cari</x-primary-button>
                </form>
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Artis</x-primary-button>
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
                        <th class="p-2 text-left">Tahun Menato</th>
                        <th class="p-2 text-left">Instagram</th>
                        <th class="p-2 text-left">Tiktok</th>
                        <th class="p-2 text-left">Gambar</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artis_tatos as $artis_tato)
                    <tr class="border-t">
                        <td class="p-2">{{ $artis_tato->nama_artis_tato }}</td>
                        <td class="p-2">{{ $artis_tato->tahun_menato }}</td>
                        <td class="p-2">{{ $artis_tato->instagram }}</td>
                        <td class="p-2">{{ $artis_tato->tiktok }}</td>
                        <td class="p-2">
                            <img src="{{ asset('storage/' . $artis_tato->gambar) }}" alt="Gambar Artis Tato" class="w-16 h-16 object-cover">
                        </td>
                        <td class="p-2 space-x-2">
                            <button
                                @click='setEdit(@json($artis_tato))'
                                class="text-blue-600">Edit</button>
                            <button
                                @click="confirmDelete({{ $artis_tato->id_artis_tato }})"
                                class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada artis ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $artis_tatos->appends(['search' => request('search')])->links() }}
            </div>

            @include('artis_tatos.partials.add-modal')
            @include('artis_tatos.partials.edit-modal')
            @include('artis_tatos.partials.delete-modal')
        </div>
    </div>
    <script>
        function artisManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                artis: {
                    id_artis_tato: null,
                    nama_artis_tato: '',
                    tahun_menato: '',
                    instagram: '',
                    tiktok: '',
                    gambar: '',
                },
                artisId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_artis_tato) {
                            this.kategori = {
                                id_artis_tato: data.old.id_artis_tato,
                                nama_artis_tato: data.old.nama_artis_tato,
                                tahun_menato: data.old.tahun_menato,
                                instagram: data.old.instagram,
                                tiktok: data.old.tiktok,
                                gambar: data.old.gambar
                            };
                            this.editModal = true;
                        } else {
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.artis = {
                        id_artis_tato: data.id_artis_tato,
                        nama_artis_tato: data.nama_artis_tato,
                        tahun_menato: data.tahun_menato,
                        instagram: data.instagram,
                        tiktok: data.tiktok,
                        gambar: data.gambar
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.artisId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>