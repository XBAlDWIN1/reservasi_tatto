<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Reservasi Saya</h2>

        @if ($reservasi->isEmpty())
        <p class="text-gray-500 text-center">Belum ada reservasi yang tercatat.</p>
        @else
        <div class="space-y-4">
            @foreach ($reservasi as $item)
            @php
            $pelangganData = $pelanggan->firstWhere('id_pelanggan', $item->id_pelanggan);
            $konsultasiData = $konsultasi->firstWhere('id_konsultasi', $item->id_konsultasi);
            $pembayaranData = $pembayaran->firstWhere('id_reservasi', $item->id_reservasi);
            @endphp

            <div class="bg-white shadow rounded-lg p-4 border">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold">Reservasi #{{ $item->id_reservasi }}</h3>
                    <span class="text-sm px-2 py-1 rounded-full {{ $item->status === 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

                <p><span class="font-medium">Nama Pelanggan:</span> {{ $pelangganData->nama_lengkap ?? '-' }}</p>
                <p><span class="font-medium">Telepon:</span> {{ $pelangganData->telepon ?? '-' }}</p>

                <div class="mt-2">
                    <p class="font-medium">Detail Konsultasi:</p>
                    <ul class="text-sm list-disc list-inside text-gray-700">
                        <li>Ukuran: {{ $konsultasiData->panjang ?? '?' }} x {{ $konsultasiData->lebar ?? '?' }} cm</li>
                        <li>Kategori: {{ $konsultasiData->kategori->nama_kategori ?? '-' }}</li>
                    </ul>
                </div>

                <div class="mt-2">
                    <p><span class="font-medium">Total Pembayaran:</span> Rp{{ number_format($item->total_pembayaran, 0, ',', '.') }}</p>
                    <p><span class="font-medium">Status Pembayaran:</span> {{ ucfirst($pembayaranData->status ?? 'belum dibayar') }}</p>
                </div>

                <div class="mt-3">
                    <a href="{{ route('user.reservasi.show', ['id_reservasi' => $item->id_reservasi]) }}" class="text-blue-600 text-sm hover:underline">Lihat Detail</a>
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