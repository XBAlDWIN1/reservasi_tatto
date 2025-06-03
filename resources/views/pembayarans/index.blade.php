<x-app-layout>
    <div x-data="pembayaranManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old()]) }})">
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Pembayaran</h2>

            <div class="mb-4">
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Pembayaran</x-primary-button>
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
                        <th class="p-2 text-left">ID Reservasi</th>
                        <th class="p-2 text-left">ID Pengguna</th>
                        <th class="p-2 text-left">Status</th>
                        <th class="p-2 text-left">Bukti Pembayaran</th>
                        <th class="p-2 text-left">Catatan</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $pembayaran)
                    <tr class="border-t">
                        <td class="p-2">{{ $pembayaran->reservasi->id_reservasi ?? 'N/A' }}</td>
                        <td class="p-2">{{ $pembayaran->pengguna->name ?? 'N/A' }}</td>
                        <td class="p-2" capitalize>
                            <span class="text-sm px-3 py-1 rounded-full 
                            {{ 
                                $pembayaran->status === 'diterima' ? 'bg-green-100 text-green-700' : 
                                ($pembayaran->status === 'ditolak' ? 'bg-red-100 text-red-700' : 
                                'bg-yellow-100 text-yellow-700') 
                            }}">
                                {{ ucfirst($pembayaran->status) }}
                            </span>
                        </td>
                        <td class="p-2">
                            @if($pembayaran->bukti_pembayaran)
                            <a href="{{ asset('storage/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a>
                            @else
                            Belum Ada
                            @endif
                        </td>
                        <td class="p-2">{{ $pembayaran->catatan }}</td>
                        <td class="p-2 space-x-2">
                            <button @click="setEdit({{ json_encode($pembayaran) }})" class="text-blue-600">Edit</button>
                            <button @click="confirmDelete({{ $pembayaran->id_pembayaran }})" class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-2 text-center">Tidak ada data pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $pembayarans->links() }}
            </div>

            @include('pembayarans.partials.add-modal', ['reservasis' => $reservasis, 'penggunas' => $penggunas])
            @include('pembayarans.partials.edit-modal', ['reservasis' => $reservasis, 'penggunas' => $penggunas])
            @include('pembayarans.partials.delete-modal')

        </div>
    </div>

    <script>
        function pembayaranManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                pembayaranId: null,
                pembayaran: {
                    id_pembayaran: '',
                    id_reservasi: '',
                    id_pengguna: '',
                    status: '',
                    bukti_pembayaran: '',
                    catatan: ''
                },

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_pembayaran) {
                            this.pembayaran = {
                                id_pembayaran: data.old.id_pembayaran,
                                id_reservasi: data.old.id_reservasi,
                                id_pengguna: data.old.id_pengguna,
                                status: data.old.status,
                                bukti_pembayaran: '',
                                catatan: data.old.catatan
                            };
                            this.editModal = true;
                        } else {
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.pembayaran = {
                        id_pembayaran: data.id_pembayaran,
                        id_reservasi: data.id_reservasi,
                        id_pengguna: data.id_pengguna,
                        status: data.status,
                        bukti_pembayaran: '',
                        catatan: data.catatan
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.pembayaranId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>