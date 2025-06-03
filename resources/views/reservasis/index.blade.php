<x-app-layout>
    <div x-data="reservasiManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old(), 'user_id' => auth()->id()]) }})" x-cloak>
        <di class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-6">Manajemen Reservasi</h2>

            <!-- Search & Add Button -->
            <div class="flex justify-between items-center mb-6">
                <form method="GET" action="{{ route('reservasis.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari pengguna atau pelanggan..." />
                    <x-primary-button type="submit" class="px-4 py-2 rounded-full">Cari</x-primary-button>
                </form>
                <x-primary-button @click="addModal = true" class="px-6 py-2 rounded-full">Tambah Reservasi</x-primary-button>
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

            <!-- Table -->
            <div class="overflow-x-auto rounded shadow">
                <table class="min-w-full text-sm border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left font-medium text-gray-700">Pengguna</th>
                            <th class="p-3 text-left font-medium text-gray-700">Pelanggan</th>
                            <th class="p-3 text-left font-medium text-gray-700">Jadwal Konsultasi</th>
                            <th class="p-3 text-left font-medium text-gray-700">Total Harga</th>
                            <th class="p-3 text-left font-medium text-gray-700">Status</th>
                            <th class="p-3 text-left font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservasis as $reservasi)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3">{{ $reservasi->pengguna->name ?? '-' }}</td>
                            <td class="p-3">{{ $reservasi->pelanggan->nama_lengkap ?? '-' }}</td>
                            <td class="p-3">
                                @if($reservasi->konsultasi)
                                {{ \Carbon\Carbon::parse($reservasi->konsultasi->jadwal_konsultasi)->format('d-m-Y H:i') }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="p-3">Rp {{ number_format($reservasi->total_pembayaran, 0, ',', '.') }}</td>
                            <td class="p-3 capitalize">
                                <span class="text-sm px-3 py-1 rounded-full 
                                {{ 
                                    $reservasi->status === 'diterima' ? 'bg-green-100 text-green-700' : 
                                    ($reservasi->status === 'ditolak' ? 'bg-red-100 text-red-700' : 
                                    'bg-yellow-100 text-yellow-700') 
                                }}">
                                    {{ ucfirst($reservasi->status) }}
                                </span>
                            </td>
                            <td class="p-3 space-x-2">
                                <button
                                    @click='setEdit(@json($reservasi))'
                                    class="text-blue-600 hover:underline">Edit</button>
                                <button @click="confirmDelete({{ $reservasi->id_reservasi }})" class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">Tidak ada reservasi ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $reservasis->appends(['search' => request('search')])->links() }}
            </div>

            <!-- Modal Partial -->
            @include('reservasis.partials.add-modal')
            @include('reservasis.partials.edit-modal')
            @include('reservasis.partials.delete-modal')
    </div>
    </div>

    <script>
        function reservasiManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                reservasi: {
                    id_reservasi: null,
                    id_pengguna: '',
                    id_pelanggan: '',
                    id_konsultasi: null,
                    total_pembayaran: null,
                    status: 'Menunggu',
                },
                reservasiId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_reservasi) {
                            this.reservasi = {
                                id_reservasi: data.old.id_reservasi,
                                id_konsultasi: data.old.id_konsultasi,
                                id_pengguna: data.old.id_pengguna,
                                id_pelanggan: data.old.id_pelanggan,
                                total_pembayaran: data.old.total_pembayaran,
                                status: data.old.status,
                            };
                            this.editModal = true;
                        } else {
                            this.reservasi.id_pengguna = data.user_id;
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.reservasi = {
                        id_reservasi: data.id_reservasi,
                        id_konsultasi: data.id_konsultasi,
                        id_pengguna: data.id_pengguna,
                        id_pelanggan: data.id_pelanggan,
                        total_pembayaran: data.total_pembayaran,
                        status: data.status,
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.reservasiId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>