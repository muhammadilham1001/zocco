<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">

@include('layouts.HeadAdmin')

{{-- Alpine.js untuk interaktivitas --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
{{-- Chart.js untuk Grafik --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 ease-in-out font-poppins">
    <div class="flex h-screen overflow-hidden">

        @include('layouts.SidebarAdmin')

        <main id="main-content" class="flex-1 p-4 md:p-8 overflow-y-auto">
            <header class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = true"
                        class="p-2 rounded-lg bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-300 lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Dashboard Manajemen</h1>
                </div>

            </header>

            {{-- Stat Cards --}}
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <h3 class="text-lg font-semibold text-gray-500">Total Reservasi</h3>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 mt-2">{{ $totalReservasi }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <h3 class="text-lg font-semibold text-gray-500">Total Outlet</h3>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 mt-2">{{ $totalOutlet }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                    <h3 class="text-lg font-semibold text-gray-500">Total Pelanggan</h3>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 mt-2">
                        {{ number_format($totalUser) }}
                    </p>
                </div>
            </section>

            {{-- Chart Section --}}
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Grafik Reservasi Bulanan</h3>
                <div class="relative h-64 w-full">
                    <canvas id="reservationChart"></canvas>
                </div>
            </section>

            {{-- Data Table --}}
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Reservasi Terbaru</h3>
                    <a href="{{ route('Reservation') }}" class="text-blue-500 hover:underline text-sm">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pelanggan</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentReservations as $res)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $res->customer_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $res->phone_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $res->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($res->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <span class="capitalize">{{ $res->payment_status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data
                                        reservasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    @include('layouts.JsAdmin')

    {{-- Script Inisialisasi Chart --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reservationChart').getContext('2d');

            // Solusi: Gunakan variabel PHP terpisah agar engine Blade tidak bingung dengan tanda kurung array
            @php
                $labels = $chartLabels ?? ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $data = $chartData ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            @endphp

            const labels = @json($labels);
            const dataReservasi = @json($data);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Reservasi',
                        data: dataReservasi,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#9ca3af'
                            },
                            grid: {
                                color: 'rgba(156, 163, 175, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#9ca3af'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
