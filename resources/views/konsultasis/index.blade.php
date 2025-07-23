<x-app-layout>
    <div x-data="konsultasiManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old(), 'user_id' => auth()->id()]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Konsultasi</h2>

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('konsultasis.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau telepon..." />
                    <x-primary-button type="submit" class="px-4 py-1 rounded">Cari</x-primary-button>
                </form>
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Konsultasi</x-primary-button>
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('konsultasis.index', ['search' => request('search'), 'sort_by' => 'nama', 'order' => request('sort_by') === 'nama' && request('order') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                                <span>Nama</span>
                                @if(request('sort_by') === 'nama')
                                <ion-icon name="{{ request('order') === 'asc' ? 'caret-up-outline' : 'caret-down-outline' }}"></ion-icon>
                                @else
                                <ion-icon name="swap-vertical-outline"></ion-icon> {{-- Icon default sort --}}
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('konsultasis.index', ['search' => request('search'), 'sort_by' => 'artis', 'order' => request('sort_by') === 'artis' && request('order') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                                <span>Artis</span>
                                @if(request('sort_by') === 'artis')
                                <ion-icon name="{{ request('order') === 'asc' ? 'caret-up-outline' : 'caret-down-outline' }}"></ion-icon>
                                @else
                                <ion-icon name="swap-vertical-outline"></ion-icon>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span>Ukuran</span> {{-- Tidak dapat diurutkan --}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('konsultasis.index', ['search' => request('search'), 'sort_by' => 'lokasi', 'order' => request('sort_by') === 'lokasi' && request('order') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                                <span>Lokasi</span>
                                @if(request('sort_by') === 'lokasi')
                                <ion-icon name="{{ request('order') === 'asc' ? 'caret-up-outline' : 'caret-down-outline' }}"></ion-icon>
                                @else
                                <ion-icon name="swap-vertical-outline"></ion-icon>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('konsultasis.index', ['search' => request('search'), 'sort_by' => 'kategori', 'order' => request('sort_by') === 'kategori' && request('order') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                                <span>Kategori</span>
                                @if(request('sort_by') === 'kategori')
                                <ion-icon name="{{ request('order') === 'asc' ? 'caret-up-outline' : 'caret-down-outline' }}"></ion-icon>
                                @else
                                <ion-icon name="swap-vertical-outline"></ion-icon>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('konsultasis.index', ['search' => request('search'), 'sort_by' => 'tanggal', 'order' => request('sort_by') === 'tanggal' && request('order') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                                <span>Tanggal</span>
                                @if(request('sort_by') === 'tanggal')
                                <ion-icon name="{{ request('order') === 'asc' ? 'caret-up-outline' : 'caret-down-outline' }}"></ion-icon>
                                @else
                                <ion-icon name="swap-vertical-outline"></ion-icon>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('konsultasis.index', ['search' => request('search'), 'sort_by' => 'status', 'order' => request('sort_by') === 'status' && request('order') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                                <span>Status</span>
                                @if(request('sort_by') === 'status')
                                <ion-icon name="{{ request('order') === 'asc' ? 'caret-up-outline' : 'caret-down-outline' }}"></ion-icon>
                                @else
                                <ion-icon name="swap-vertical-outline"></ion-icon>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referensi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konsultasis as $konsultasi)
                    <tr class="border-t">
                        <td class="p-2">{{ $konsultasi->pengguna->name }}</td>
                        <td class="p-2">
                            {{ optional($konsultasi->artisTato)->nama_artis_tato ?? 'Belum ditentukan' }}
                        </td>
                        <td class="p-2">{{ $konsultasi->panjang }} x {{$konsultasi->lebar}}</td>
                        <td class="p-2">{{ $konsultasi->lokasiTato->nama_lokasi_tato }}</td>
                        <td class="p-2">{{ $konsultasi->kategori->nama_kategori }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($konsultasi->jadwal_konsultasi)->format('d-m-Y H:i') }}</td>
                        <td class="p-2">
                            <span class="text-sm px-3 py-1 rounded-full 
                            {{ 
                                $konsultasi->status === 'diterima' ? 'bg-green-100 text-green-700' : 
                                ($konsultasi->status === 'ditolak' ? 'bg-red-100 text-red-700' : 
                                'bg-yellow-100 text-yellow-700') 
                            }}">
                                {{ ucfirst($konsultasi->status) }}
                            </span>
                        </td>
                        <td class="p-2">
                            <img src="{{ asset('storage/' . $konsultasi->gambar) }}" alt="gambar" class="rounded w-32">
                        </td>
                        <td class="p-2 space-x-2">
                            <button
                                @click='setEdit(@json($konsultasi))'
                                class="text-blue-600">Edit</button>
                            <button
                                @click="confirmDelete({{ $konsultasi->id_konsultasi }})"
                                class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-4 text-center text-gray-500">Tidak ada konsultasi ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $konsultasis->appends(request()->only(['search', 'sort_by', 'order']))->links() }}
            </div>


            @include('konsultasis.partials.add-modal')
            @include('konsultasis.partials.edit-modal')
            @include('konsultasis.partials.delete-modal')
        </div>
    </div>

    <script>
        function konsultasiManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                konsultasi: {
                    id_konsultasi: null,
                    id_pengguna: '',
                    id_artis_tato: '',
                    id_lokasi_tato: '',
                    id_kategori: '',
                    panjang: '',
                    lebar: '',
                    jadwal_konsultasi: '',
                    jadwal_tanggal: '', // 👈 TAMBAH ini
                    jadwal_jam: '', // 👈 TAMBAH ini
                    gambar: null,
                    status: 'Menunggu',
                },
                konsultasiId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id_konsultasi) {
                            this.konsultasi = {
                                id_konsultasi: data.old.id_konsultasi,
                                id_pengguna: data.old.id_pengguna,
                                id_artis_tato: data.old.id_artis_tato,
                                id_lokasi_tato: data.old.id_lokasi_tato,
                                id_kategori: data.old.id_kategori,
                                panjang: data.old.panjang,
                                lebar: data.old.lebar,
                                jadwal_konsultasi: data.old.jadwal_konsultasi,
                                gambar: null,
                                status: data.old.status,
                                jadwal_tanggal: data.old.jadwal_tanggal ?? '', // opsional
                                jadwal_jam: data.old.jadwal_jam ?? '', // opsional
                            };
                            this.editModal = true;
                        } else {
                            this.konsultasi.id_pengguna = data.user_id;
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    let [tanggal, jam] = data.jadwal_konsultasi.split(' ');
                    // format jam HH:MM:SS menjadi HH:MM
                    jam = jam.split(':').slice(0, 2).join(':');
                    this.konsultasi = {
                        id_konsultasi: data.id_konsultasi,
                        id_pengguna: data.id_pengguna,
                        id_artis_tato: data.id_artis_tato,
                        id_lokasi_tato: data.id_lokasi_tato,
                        id_kategori: data.id_kategori,
                        panjang: data.panjang,
                        lebar: data.lebar,
                        jadwal_konsultasi: data.jadwal_konsultasi,
                        jadwal_tanggal: tanggal,
                        jadwal_jam: jam,
                        gambar: null,
                        status: data.status,
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.konsultasiId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>