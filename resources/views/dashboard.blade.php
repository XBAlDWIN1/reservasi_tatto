<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <!-- Welcome Card -->
        <div class="bg-[#FFCDB2] rounded-lg p-4 mb-6">
            <h3 class="text-lg font-medium text-center mb-4">Selamat Datang</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-[#FFCDB2] p-4 rounded-lg border border-[#E5B8A1] text-center">
                    <p class="text-sm">Hari ini</p>
                    <h4 class="text-2xl font-bold">Konsultasi</h4>
                    <p class="text-3xl font-bold">20</p>
                </div>

                <div class="bg-[#FFCDB2] p-4 rounded-lg border border-[#E5B8A1] text-center">
                    <p class="text-sm">Hari ini</p>
                    <h4 class="text-2xl font-bold">Reservasi</h4>
                    <p class="text-3xl font-bold">11</p>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-lg p-4 shadow overflow-hidden">
            <div class="w-full overflow-x-auto">
                <div class="min-w-[600px]">
                    <canvas id="monthlyChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('monthlyChart').getContext('2d');

            const monthlyData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                        label: 'Konsultasi',
                        data: [1000, 1500, 2000, 1400, 2600, 1800, 2700, 2000, 1400, 1800, 2800, 3000],
                        borderColor: '#4F46E5',
                        backgroundColor: 'transparent',
                        tension: 0.4
                    },
                    {
                        label: 'Reservasi',
                        data: [800, 1200, 1800, 1200, 2200, 1600, 2400, 1800, 1200, 1600, 2600, 2800],
                        borderColor: '#10B981',
                        backgroundColor: 'transparent',
                        tension: 0.4
                    }
                ]
            };

            new Chart(ctx, {
                type: 'line',
                data: monthlyData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 3500
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
