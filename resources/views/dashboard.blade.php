<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        {{-- Filter Section --}}
        <div class="bg-white p-6 rounded-2xl shadow mb-6">
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-end gap-4">
                {{-- Monthly Filters --}}
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700">Month:</label>
                    <select name="month" id="month" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ $month == sprintf('%02d', $i) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                            @endfor
                    </select>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Year:</label>
                    <input type="number" name="year" id="year" value="{{ $year }}" class="mt-1 block w-full pl-3 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Apply Filter
                </button>
            </form>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Total Pelanggan Bulan Ini</p> {{-- Label disesuaikan --}}
                <h2 class="text-3xl font-bold">{{ $totalPelanggan }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Total Konsultasi Bulan Ini</p>
                <h2 class="text-3xl font-bold">{{ $totalKonsultasi }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Total Pembayaran (Diterima) Bulan Ini</p>
                <h2 class="text-3xl font-bold">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4">Konsultasi Bulan {{ date('F', mktime(0, 0, 0, $month, 10)) }} {{ $year }}</h2> {{-- Judul chart disesuaikan --}}
                <canvas id="konsultasiChart" height="200"></canvas>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4">Status Reservasi Bulan Ini</h2>
                <canvas id="statusChart" height="200"></canvas>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow col-span-1 lg:col-span-2">
                <h2 class="text-lg font-semibold mb-4">Total Pembayaran per Bulan (Tahun {{ $year }})</h2>
                <canvas id="pembayaranChart" height="100"></canvas>
            </div>

            {{-- Recent Reservations (always show, but filtered) --}}
            <div class="bg-white p-6 rounded-2xl shadow col-span-1 lg:col-span-2">
                <h2 class="text-lg font-semibold mb-4">5 Reservasi Terbaru Bulan Ini</h2>
                @if ($recentReservasi->isEmpty())
                <p class="text-gray-600">No recent reservations for the selected month.</p>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Reservasi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pelanggan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Konsultasi ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Pembayaran
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recentReservasi as $reservasi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $reservasi->id_reservasi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $reservasi->pelanggan->nama_lengkap ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $reservasi->konsultasi->id_konsultasi ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($reservasi->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $reservasi->status }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($reservasi->total_pembayaran, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const konsultasiData = @json($konsultasiPerBulan);
        const statusReservasiData = @json($statusReservasi);
        const pembayaranPerBulan = @json($pembayaranPerBulan);

        const bulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        // Konsultasi Chart
        if (konsultasiData.length > 0) {
            new Chart(document.getElementById('konsultasiChart'), {
                type: 'bar',
                data: {
                    // Karena data konsultasiPerBulan hanya berisi satu entri untuk bulan yang dipilih,
                    // labelnya akan menjadi nama bulan tersebut.
                    labels: konsultasiData.map(item => bulan[item.bulan - 1]),
                    datasets: [{
                        label: 'Jumlah Konsultasi',
                        backgroundColor: '#3b82f6',
                        data: konsultasiData.map(item => item.total),
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            // Opsional: set max value jika Anda ingin konsisten dengan 1 bar
                            // max: Math.max(...konsultasiData.map(item => item.total)) + 2, // Contoh: +2 agar tidak terlalu mepet
                        }
                    }
                }
            });
        } else {
            // Jika tidak ada data konsultasi untuk bulan yang dipilih, tampilkan pesan atau chart kosong
            const ctx = document.getElementById('konsultasiChart').getContext('2d');
            ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
            ctx.font = '16px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('No Konsultasi Data for This Month', ctx.canvas.width / 2, ctx.canvas.height / 2);
        }


        // Status Reservasi Chart
        if (statusReservasiData.length > 0) {
            new Chart(document.getElementById('statusChart'), {
                type: 'pie',
                data: {
                    labels: statusReservasiData.map(item => item.status),
                    datasets: [{
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6366f1'],
                        data: statusReservasiData.map(item => item.total),
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }

        // Pembayaran Chart
        if (pembayaranPerBulan.length > 0) {
            new Chart(document.getElementById('pembayaranChart'), {
                type: 'line',
                data: {
                    labels: pembayaranPerBulan.map(item => bulan[item.bulan - 1]),
                    datasets: [{
                        label: 'Total Pembayaran',
                        backgroundColor: '#6366f1',
                        borderColor: '#6366f1',
                        data: pembayaranPerBulan.map(item => item.total),
                        tension: 0.3,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });
        }
    </script>
    @endpush
</x-app-layout>