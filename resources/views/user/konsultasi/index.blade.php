<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Konsultasi Saya</h2>

        @if($konsultasis->count())
        <div class="grid grid-cols-1 gap-6">
            @foreach($konsultasis as $konsultasi)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-5 flex flex-col md:flex-row gap-6">

                <!-- Gambar -->
                <div class="w-full md:w-1/3">
                    @if($konsultasi->gambar)
                    <img src="{{ asset('storage/' . $konsultasi->gambar) }}" alt="Gambar Konsultasi" class="object-cover w-full h-48 rounded-lg">
                    @else
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded-lg text-gray-500">
                        Tidak ada gambar
                    </div>
                    @endif
                </div>

                <!-- Informasi Konsultasi -->
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $konsultasi->artisTato->nama_artis_tato ?? 'Belum Ditentukan' }}
                        </h3>
                        <span class="text-sm px-3 py-1 rounded-full 
                                    {{ 
                                        $konsultasi->status === 'diterima' ? 'bg-green-100 text-green-700' : 
                                        ($konsultasi->status === 'ditolak' ? 'bg-red-100 text-red-700' : 
                                        'bg-yellow-100 text-yellow-700') 
                                    }}">
                            {{ ucfirst($konsultasi->status ?? 'menunggu') }}
                        </span>
                    </div>

                    <ul class="text-sm text-gray-700 space-y-1 mb-3">
                        <li><span class="font-medium">Ukuran:</span> {{ $konsultasi->panjang ?? '-' }} x {{ $konsultasi->lebar ?? '-' }} cm</li>
                        <li><span class="font-medium">Luas:</span> {{ ($konsultasi->panjang * $konsultasi->lebar) ?? '-' }} cm²</li>
                        <li><span class="font-medium">Lokasi:</span> {{ $konsultasi->lokasiTato->nama_lokasi_tato ?? '-' }}</li>
                        <li><span class="font-medium">Kategori:</span> {{ $konsultasi->kategori->nama_kategori ?? '-' }}</li>
                        <li><span class="font-medium">Kompleksitas:</span> {{ $konsultasi->kompleksitas ?? '-' }}</li>
                        <li><span class="font-medium">Durasi Estimasi:</span> {{ $konsultasi->durasi_estimasi ?? '-' }}</li>
                        <li><span class="font-medium">Jadwal Konsultasi:</span> {{ \Carbon\Carbon::parse($konsultasi->jadwal_konsultasi)->format('d-m-Y H:i') }}</li>
                    </ul>

                    <!-- Rincian Biaya -->
                    <div class="mt-4 space-y-1 text-sm text-gray-800">
                        <div class="flex justify-between">
                            <span>Biaya Dasar:</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($konsultasi->biaya_dasar ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Tambahan:</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($konsultasi->biaya_tambahan ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2">
                            <span class="font-semibold">Total Biaya:</span>
                            <span class="font-bold text-indigo-600">Rp {{ number_format($konsultasi->total_biaya ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Tombol Buat Reservasi -->
                    @if ($konsultasi->status === 'diterima' && !$konsultasi->reservasi)
                    <div class="mt-4 text-right">
                        <a href="{{ route('user.reservasi.create', ['id_konsultasi' => $konsultasi->id_konsultasi]) }}"
                            class="inline-flex items-center px-4 py-3 bg-orange-500 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition ease-in-out duration-150">
                            Buat Reservasi
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $konsultasis->links() }}
        </div>
        @else
        <div class="text-center text-gray-500">
            Belum ada konsultasi.
        </div>
        @endif
    </div>
</x-app-layout>