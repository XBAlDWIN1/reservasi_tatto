<x-app-layout>
    <div x-data="portfolioManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old()]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Portofolio</h2>

            <div class="mb-4">
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Portfolio</x-primary-button>
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
                        <th class="p-2 text-left">Artis Tato</th>
                        <th class="p-2 text-left">Judul</th>
                        <th class="p-2 text-left">Deskripsi</th>
                        <th class="p-2 text-left">Gambar</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($portfolios as $portfolio)
                    <tr class="border-t">
                        <td class="p-2">{{ $portfolio->artisTato->nama_artis_tato }}</td>
                        <td class="p-2">{{ $portfolio->judul }}</td>
                        <td class="p-2">{{ $portfolio->deskripsi }}</td>
                        <td class="p-2">
                            <img src="{{ asset('storage/' . $portfolio->gambar) }}" alt="gambar" class="rounded w-32">
                        </td>
                        <td class="p-2 space-x-2">
                            <button @click='setEdit(@json($portfolio))' class="text-blue-600">Edit</button>
                            <button @click="confirmDelete({{ $portfolio->id_portfolio }})" class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Tidak ada portofolio ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @include('portfolios.partials.add-modal')
            @include('portfolios.partials.edit-modal')
            @include('portfolios.partials.delete-modal')
        </div>
    </div>

    <script>
        function portfolioManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                portfolioId: null,
                portfolio: {
                    id_portfolio: null,
                    id_artis_tato: '',
                    judul: '',
                    deskripsi: '',
                    gambar: ''
                },

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_portfolio) {
                            this.portfolio = {
                                id_portfolio: data.old.id_portfolio,
                                id_artis_tato: data.old.id_artis_tato,
                                judul: data.old.judul,
                                deskripsi: data.old.deskripsi,
                                gambar: ''
                            };
                            this.editModal = true;
                        } else {
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.portfolio = {
                        id_portfolio: data.id_portfolio,
                        id_artis_tato: data.id_artis_tato,
                        judul: data.judul,
                        deskripsi: data.deskripsi,
                        gambar: ''
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.portfolioId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>