@extends('admin-submission-letter.layouts.main.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Hari Ini -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pengajuan Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalHariIni">15</p>
                    </div>
                </div>
            </div>

            <!-- Total Bulan Ini -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pengajuan Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalBulanIni">247</p>
                    </div>
                </div>
            </div>

            <!-- Total Selesai -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-emerald-100 mr-4">
                        <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Surat Selesai</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalSelesai">189</p>
                    </div>
                </div>
            </div>

            <!-- Total Proses -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dalam Proses</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalProses">58</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pengajuan Per Hari (7 Hari Terakhir) -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Pengajuan 7 Hari Terakhir</h3>
                    <i class="fas fa-chart-line text-blue-500"></i>
                </div>
                <div class="h-80">
                    <canvas id="pengajuanPerHariChart"></canvas>
                </div>
            </div>

            <!-- Surat Tersering -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">5 Jenis Surat Tersering</h3>
                    <i class="fas fa-chart-pie text-green-500"></i>
                </div>
                <div class="h-80">
                    <canvas id="suratTerseringChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Rating Tertinggi -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">5 Layanan Rating Tertinggi</h3>
                    <i class="fas fa-star text-yellow-500"></i>
                </div>
                <div class="h-80">
                    <canvas id="ratingTertinggiChart"></canvas>
                </div>
            </div>

            <!-- Summary Box -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Sistem</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-3"></i>
                            <span class="text-sm font-medium text-gray-700">Total Rating</span>
                        </div>
                        <span class="text-lg font-bold text-blue-600" id="totalRating">143</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-percentage text-green-500 mr-3"></i>
                            <span class="text-sm font-medium text-gray-700">Tingkat Penyelesaian</span>
                        </div>
                        <span class="text-lg font-bold text-green-600" id="persentaseSelesai">76.5%</span>
                    </div>

                    {{-- <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-chart-bar text-purple-500 mr-3"></i>
                            <span class="text-sm font-medium text-gray-700">Rata-rata Harian</span>
                        </div>
                        <span class="text-lg font-bold text-purple-600" id="rataHarian">12.4</span>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample data - dalam implementasi nyata, data ini akan diambil dari backend
        const dashboardData = {
            totalHariIni: {{ $totalHariIni }},
            totalBulanIni: {{ $totalBulanIni }},
            totalSelesai: {{ $totalSelesai }},
            totalProses: {{ $totalProses }},
            totalSemua: {{ $totalSemua }},
            totalRating: {{ $totalRating }},
            pengajuanPerHari: {!! json_encode($pengajuanPerHari) !!},
            suratTersering: {!! json_encode($suratTersering) !!},
            ratingTertinggi: {!! json_encode($ratingTertinggi) !!}
        };

        // Update stats
        function updateStats() {
            document.getElementById('totalHariIni').textContent = dashboardData.totalHariIni;
            document.getElementById('totalBulanIni').textContent = dashboardData.totalBulanIni;
            document.getElementById('totalSelesai').textContent = dashboardData.totalSelesai;
            document.getElementById('totalProses').textContent = dashboardData.totalProses;
            document.getElementById('totalRating').textContent = dashboardData.totalRating;
            
            // Calculate percentage and average
            const total = dashboardData.totalSemua;
            const percentage = total > 0 
                ? ((dashboardData.totalSelesai / total) * 100).toFixed(1)
                : '0.0';

            document.getElementById('persentaseSelesai').textContent = percentage + '%';

            
            // const avgDaily = (dashboardData.totalBulanIni / 30).toFixed(1);
            // document.getElementById('rataHarian').textContent = avgDaily;
        }

        // Chart 1: Pengajuan Per Hari (Line Chart)
        function createPengajuanPerHariChart() {
            const ctx = document.getElementById('pengajuanPerHariChart').getContext('2d');
            const labels = dashboardData.pengajuanPerHari.map(item => {
                const date = new Date(item.tanggal);
                return date.toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
            });
            const data = dashboardData.pengajuanPerHari.map(item => item.total);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pengajuan',
                        data: data,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            },
                            ticks: {
                                color: '#6b7280'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280'
                            }
                        }
                    }
                }
            });
        }

        // Chart 2: Surat Tersering (Doughnut Chart)
        function createSuratTerseringChart() {
            const ctx = document.getElementById('suratTerseringChart').getContext('2d');
            const labels = dashboardData.suratTersering.map(item => item.jenis_surat.nama);
            const data = dashboardData.suratTersering.map(item => item.total);
            const colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 0,
                        hoverBorderWidth: 2,
                        hoverBorderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        // Chart 3: Rating Tertinggi (Horizontal Bar Chart)
        function createRatingTertinggiChart() {
            const ctx = document.getElementById('ratingTertinggiChart').getContext('2d');
            const labels = dashboardData.ratingTertinggi.map(item => item.nama_jenis_surat);
            const data = dashboardData.ratingTertinggi.map(item => parseFloat(item.rata_rating));

            // Hitung total rating untuk persentase
            const total = data.reduce((acc, val) => acc + val, 0);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Rating (dari 5)',
                        data: data,
                        backgroundColor: ['#FBBF24', '#F59E0B', '#D97706', '#B45309', '#92400E'],
                        borderColor: ['#F59E0B', '#D97706', '#B45309', '#92400E', '#78350F'],
                        borderWidth: 1
                    }]
                },
                options: {
                    layout: {
                        padding: {
                            right: 80
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'right',
                            color: '#374151',
                            font: {
                                weight: 'bold'
                            },
                            formatter: (value) => {
                                const percent = ((value / 5) * 100).toFixed(1);
                                return `${value} ⭐ (${percent}%)`;
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 5,
                            grid: {
                                color: '#f3f4f6'
                            },
                            ticks: {
                                color: '#6b7280'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels] // Aktifkan plugin di sini
            });
        }


        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            createPengajuanPerHariChart();
            createSuratTerseringChart();
            createRatingTertinggiChart();
        });
    </script>
@endsection