<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Detail Reservasi</h2>

        <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">ID Reservasi:</span>
                <span class="text-gray-900">{{ $reservasi->id_reservasi }}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Nama Pelanggan:</span>
                <span class="text-gray-900">{{ $reservasi->pelanggan->nama_lengkap }}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Status:</span>
                <span class="text-sm px-3 py-1 rounded-full 
                    {{ 
                        $reservasi->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' : 
                        ($reservasi->status === 'selesai' ? 'bg-green-100 text-green-700' : 
                        'bg-gray-100 text-gray-700') 
                    }}">
                    {{ ucfirst($reservasi->status) }}
                </span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Total Pembayaran:</span>
                <span class="text-indigo-600 font-semibold">Rp {{ number_format($reservasi->total_pembayaran, 0, ',', '.') }}</span>
            </div>
            @if ($reservasi->pembayaran && $reservasi->pembayaran->status === 'diterima')
            <div class="mt-6">
                <a href="{{ route('user.reservasi.invoice', $reservasi->id_reservasi) }}"
                    target="_blank"
                    class="inline-block bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition duration-300">
                    🧾 Cetak Kwitansi
                </a>
            </div>
            @endif



            <div class="mt-6 text-right">
                <a href="{{ route('user.reservasi.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke daftar</a>
            </div>
        </div>
    </div>
</x-app-layout>