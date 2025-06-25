<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Reservasi Saya</h2>

        @if ($reservasi->isEmpty())
        <p class="text-gray-500 text-center">Belum ada reservasi yang tercatat.</p>
        @else
        <div class="space-y-6">
            @foreach ($reservasi as $item)
            @php
            $pelanggan = $item->pelanggan;
            $konsultasi = $item->konsultasi;
            $kategori = $konsultasi->kategori ?? null;
            $pembayaran = $item->pembayaran->first() ?? null;
            @endphp

            <div class="bg-white border rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">
                        Reservasi #{{ $item->id_reservasi }}
                    </h3>
                    <span class="text-sm px-3 py-1 rounded-full 
                                {{ $item->status === 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

                <div class="space-y-1 text-sm text-gray-700">
                    <p><span class="font-medium">Nama Pelanggan:</span> {{ $pelanggan->nama_lengkap ?? '-' }}</p>
                    <p><span class="font-medium">Telepon:</span> {{ $pelanggan->telepon ?? '-' }}</p>

                    <div class="mt-3">
                        <p class="font-medium mb-1">Detail Konsultasi:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Ukuran: {{ $konsultasi->panjang ?? '?' }} x {{ $konsultasi->lebar ?? '?' }} cm</li>
                            <li>Kategori: {{ $kategori->nama_kategori ?? '-' }}</li>
                        </ul>
                    </div>

                    <div class="mt-3">
                        <p><span class="font-medium">Biaya Dasar:</span> Rp{{ number_format($item->biaya_dasar, 0, ',', '.') }}</p>
                        <p><span class="font-medium">Biaya Tambahan:</span> Rp{{ number_format($item->biaya_tambahan, 0, ',', '.') }}</p>
                        <p><span class="font-medium">Total Pembayaran:</span> Rp{{ number_format($item->total_biaya, 0, ',', '.') }}</p>
                        <p><span class="font-medium">Status Pembayaran:</span>
                            {{ ucfirst($pembayaran->status ?? 'Belum Dibayar') }}
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('user.reservasi.show', $item->id_reservasi) }}"
                        class="text-blue-600 text-sm hover:underline">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-6">
            {{ $reservasi->links() }}
        </div>
    </div>
</x-app-layout>