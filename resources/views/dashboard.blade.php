<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        <!-- Ringkasan Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Total Pelanggan</p>
                <h2 class="text-3xl font-bold">{{ $totalPelanggan }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Total Konsultasi</p>
                <h2 class="text-3xl font-bold">{{ $totalKonsultasi }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Total Pembayaran (Diterima)</p>
                <h2 class="text-3xl font-bold">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</h2>
            </div>
        </div>

        <!-- Grafik -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Konsultasi per Bulan -->
            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4">Konsultasi per Bulan</h2>
                <canvas id="konsultasiChart" height="200"></canvas>
            </div>

            <!-- Status Reservasi -->
            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4">Status Reservasi</h2>
                <canvas id="statusChart" height="200"></canvas>
            </div>

            <!-- Pembayaran per Bulan -->
            <div class="bg-white p-6 rounded-2xl shadow col-span-1 lg:col-span-2">
                <h2 class="text-lg font-semibold mb-4">Total Pembayaran per Bulan</h2>
                <canvas id="pembayaranChart" height="100"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari Laravel ke JS
        const konsultasiData = @json($konsultasiPerBulan);
        const statusReservasiData = @json($statusReservasi);
        const pembayaranPerBulan = @json($pembayaranPerBulan);

        // Utility bulan
        const bulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        // Grafik Konsultasi per Bulan
        new Chart(document.getElementById('konsultasiChart'), {
            type: 'bar',
            data: {
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
                }
            }
        });

        // Pie Chart Status Reservasi
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

        // Line Chart Pembayaran per Bulan
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
    </script>
    @endpush
</x-app-layout>