<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-10">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Detail Reservasi</h2>

        <div class="bg-white rounded-xl shadow p-6 space-y-6">
            <dl class="grid grid-cols-2 gap-4 text-gray-700 text-sm">
                <x-detail label="ID Reservasi" :value="$reservasi->id_reservasi" />
                <x-detail label="Nama Pelanggan" :value="$reservasi->pelanggan->nama_lengkap" />

                <x-detail label="Status Reservasi">
                    <span class="inline-block px-3 py-1 text-sm rounded-full
                        {{
                            match($reservasi->status) {
                                'menunggu' => 'bg-yellow-100 text-yellow-700',
                                'selesai' => 'bg-green-100 text-green-700',
                                default => 'bg-gray-100 text-gray-700'
                            }
                        }}">
                        {{ ucfirst($reservasi->status) }}
                    </span>
                </x-detail>

                <x-detail label="Total Pembayaran">
                    <span class="text-indigo-600 font-semibold">
                        Rp {{ number_format($reservasi->total_pembayaran, 0, ',', '.') }}
                    </span>
                </x-detail>

                <x-detail label="Status Pembayaran" :value="ucfirst($reservasi->pembayaran->status ?? 'Belum dibayar')" />

                @if ($reservasi->pembayaran?->status === 'ditolak' && $reservasi->pembayaran->catatan)
                <x-detail label="Catatan Penolakan" class="col-span-2">
                    <p class="text-red-700 text-sm">{{ $reservasi->pembayaran->catatan }}</p>
                </x-detail>
                @endif
            </dl>

            @if ($reservasi->pembayaran?->status === 'diterima')
            <div class="text-center">
                <a href="{{ route('user.reservasi.invoice', $reservasi->id_reservasi) }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                    🧾 Cetak Kwitansi
                </a>
            </div>
            @endif

            @auth
            @if ($reservasi->pembayaran?->status === 'ditolak')
            <div class="mt-6 pt-4 border-t">
                <h4 class="text-lg font-semibold text-red-600 mb-3">Unggah Ulang Bukti Pembayaran</h4>

                <form action="{{ route('user.reservasi.pembayaran.update', $reservasi->id_reservasi) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <x-input-file label="Unggah Bukti Pembayaran Baru" name="bukti_pembayaran" accept="image/*" required />

                    <x-primary-button>Kirim Ulang Bukti</x-primary-button>
                </form>
            </div>
            @endif
            @endauth

            <div class="text-right pt-6">
                <a href="{{ route('user.reservasi.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke daftar</a>
            </div>
        </div>
    </div>
</x-app-layout>