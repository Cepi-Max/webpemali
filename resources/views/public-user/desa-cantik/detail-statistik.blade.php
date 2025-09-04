@extends('public-user.layouts.main.app')

@section('content')
    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8 pt-[7rem] md:pt-[8rem] pb-4">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Statistik Kependudukan</h1>
            <p class="text-gray-600">Data kependudukan Desa Pemali berdasarkan tahun yang dipilih</p>
        </div>

        <!-- Professional Year Filter Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Filter Data</h3>
                        {{-- <p class="text-sm text-gray-500">Pilih tahun untuk melihat data statistik</p> --}}
                    </div>
                </div>
                
                <form method="GET" class="flex items-center gap-3">
                    <label for="tahun" class="text-sm font-medium text-gray-700 whitespace-nowrap">Tahun Data:</label>
                    <select 
                        name="tahun" 
                        id="tahun"
                        onchange="this.form.submit()" 
                        class="bg-white border border-gray-300 rounded-lg px-7 py-2.5 text-sm font-medium text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md min-w-[120px]"
                    >
                        @foreach($tahunValid as $tahun)
                            <option value="{{ $tahun }}" {{ $tahun == $tahunTerpilih ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                    <div class="hidden">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-600">Total KK</h3>
                        <p class="text-3xl font-bold text-gray-900" id="totalKK">{{ $totalKepalaKeluarga }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-600">Total Jiwa</h3>
                        <p class="text-3xl font-bold text-gray-900" id="totalJiwa">{{ $totalPenduduk }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-600">Laki-laki</h3>
                        <p class="text-3xl font-bold text-gray-900" id="totalLaki">{{ $statistikJenisKelamin->total_laki }}</p>
                        <p class="text-sm text-purple-600 font-medium" id="persenLaki">{{ $statistikJenisKelamin->persentase_laki }} %</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-pink-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-600">Perempuan</h3>
                        <p class="text-3xl font-bold text-gray-900" id="totalPerempuan">{{ $statistikJenisKelamin->total_perempuan }}</p>
                        <p class="text-sm text-pink-600 font-medium" id="persenPerempuan">{{ $statistikJenisKelamin->persentase_perempuan }} %</p>
                    </div>
                    <div class="bg-pink-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-6 mb-8">
            <!-- Gender Distribution -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Distribusi Berdasarkan Jenis Kelamin</h3>
                    <button  onclick="downloadChartImage('genderChart', 'genderChart.png')" class="download-btn bg-white bg-opacity-60 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 hover:bg-opacity-80 shadow-sm text-sm font-medium flex items-center gap-2">
                        <svg class="download-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                </div>
                <div class="relative h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                     <canvas id="genderChart"></canvas>
                </div>
            </div>

            <!-- Age Distribution -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Distribusi Berdasarkan Rentang Usia</h3>
                    <button onclick="downloadChartImage('ageChart', 'ageChart.png')" class="download-btn bg-white bg-opacity-60 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 hover:bg-opacity-80 shadow-sm text-sm font-medium flex items-center gap-2">
                        <svg class="download-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                </div>
                <div class="relative h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                     <canvas id="ageChart"></canvas>
                </div>
            </div>

            <!-- Religion Distribution -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Distribusi Berdasarkan Agama</h3>
                    <button onclick="downloadChartImage('religionChart', 'religionChart.png')" class="download-btn bg-white bg-opacity-60 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 hover:bg-opacity-80 shadow-sm text-sm font-medium flex items-center gap-2">
                        <svg class="download-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                </div>
                <div class="relative h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                     <canvas id="religionChart"></canvas>
                </div>
            </div>

            <!-- Marital Status -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Status Pernikahan</h3>
                    <button onclick="downloadChartImage('maritalChart', 'maritalChart.png')" class="download-btn bg-white bg-opacity-60 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 hover:bg-opacity-80 shadow-sm text-sm font-medium flex items-center gap-2">
                        <svg class="download-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                </div>
                <div class="relative h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                     <canvas id="maritalChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Education & Occupation Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Education -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Tingkat Pendidikan</h3>
                    <button onclick="downloadChartImage('educationChart', 'educationChart.png')" class="download-btn bg-white bg-opacity-60 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 hover:bg-opacity-80 shadow-sm text-sm font-medium flex items-center gap-2">
                        <svg class="download-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                </div>
                <div class="relative h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                     <canvas id="educationChart"></canvas>
                </div>
            </div>

            <!-- Occupation -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Jenis Pekerjaan</h3>
                    <button onclick="downloadChartImage('occupationChart', 'occupationChart.png')" class="download-btn bg-white bg-opacity-60 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 hover:bg-opacity-80 shadow-sm text-sm font-medium flex items-center gap-2">
                        <svg class="download-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                </div>
                <div class="relative h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                     <canvas id="occupationChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Regional Distribution -->
        {{-- <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Distribusi Penduduk Per Dusun</h3>
            <div class="relative h-96">
                <canvas id="regionalChart"></canvas>
            </div>
        </div> --}}

        <!-- Original Table -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-20">
            <h3 class="text-2xl font-bold text-sky-950 text-center mb-6">
                Jumlah dan Persentase Penduduk Berdasarkan Wilayah RT di Desa Pemali, 2025
            </h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-300 mt-4 text-sm">
                    <thead class="bg-gray-200 text-gray-800">
                        <tr>
                            <th class="border px-4 py-2">No.</th>
                            <th class="border px-4 py-2">Wilayah</th>
                            <th class="border px-4 py-2">KK</th>
                            <th class="border px-4 py-2">Jiwa</th>
                            <th class="border px-4 py-2">Laki-Laki (Jiwa)</th>
                            <th class="border px-4 py-2">Perempuan (Jiwa)</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($rekap as $dusun)
                            <tr class="bg-purple-100 font-bold">
                                <td class="border px-4 py-2">{{ $dusun['no'] }}</td>
                                <td class="border px-4 py-2 text-left">{{ $dusun['dusun'] }}</td>
                                <td class="border px-4 py-2">{{ $dusun['total_kk'] }}</td>
                                <td class="border px-4 py-2">{{ number_format($dusun['total_jiwa']) }}</td>
                                <td class="border px-4 py-2">{{ $dusun['laki'] }}</td>
                                <td class="border px-4 py-2">{{ $dusun['perempuan'] }}</td>
                            </tr>
                            @foreach ($dusun['rts'] as $rt)
                                <tr>
                                    <td class="border px-4 py-2"></td>
                                    <td class="border px-4 py-2 text-left">Rt. {{ $rt['rt'] }}</td>
                                    <td class="border px-4 py-2">{{ $rt['kk'] }}</td>
                                    <td class="border px-4 py-2">{{ $rt['jiwa'] }}</td>
                                    <td class="border px-4 py-2">{{ $rt['laki'] }}</td>
                                    <td class="border px-4 py-2">{{ $rt['perempuan'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    
                        @php
                            $grand_total_kk = array_sum(array_column($rekap, 'total_kk'));
                            $grand_total_jiwa = array_sum(array_column($rekap, 'total_jiwa'));
                            $grand_total_laki = array_sum(array_column($rekap, 'laki'));
                            $grand_total_perempuan = array_sum(array_column($rekap, 'perempuan'));
                        @endphp
                    
                        <tr class="bg-purple-200 font-bold">
                            <td class="border px-4 py-2 text-center" colspan="2">Total</td>
                            <td class="border px-4 py-2">{{ $grand_total_kk }}</td>
                            <td class="border px-4 py-2">{{ number_format($grand_total_jiwa) }}</td>
                            <td class="border px-4 py-2">{{ $grand_total_laki }}</td>
                            <td class="border px-4 py-2">{{ $grand_total_perempuan }}</td>
                        </tr>
                    </tbody>   
                </table>
            </div>
        </div>
    </main>

    <script>
        function downloadChartImage(canvasId, fileName) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) {
                alert("Canvas tidak ditemukan: " + canvasId);
                return;
            }

            // Buat canvas sementara
            const tempCanvas = document.createElement('canvas');
            const ctx = tempCanvas.getContext('2d');

            tempCanvas.width = canvas.width;
            tempCanvas.height = canvas.height;

            // Isi background putih
            ctx.fillStyle = '#FFFFFF';
            ctx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);

            // Gambar isi chart dari canvas asli ke canvas sementara
            ctx.drawImage(canvas, 0, 0);

            // Konversi dan download
            const link = document.createElement('a');
            link.href = tempCanvas.toDataURL('image/png');
            link.download = fileName;
            link.click();
        }

        // Jenis Kelamin
        const dataJenisKelamin = @json($statistikJenisKelamin);
        const labelJenisKelamin = ['Laki-Laki', 'Perempuan'];
        const totalJenisKelamin = [@json($statistikJenisKelamin->total_laki), @json($statistikJenisKelamin->total_perempuan)];
        const ctxJenisKelamin = document.getElementById('genderChart').getContext('2d');
        new Chart(ctxJenisKelamin, {
            type: 'doughnut',
            data: {
                labels: labelJenisKelamin,
                datasets: [{
                    label: 'Jumlah',
                    data: totalJenisKelamin,
                    backgroundColor: ['#3B82F6', '#F472B6'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    datalabels: {
                        color: '#fff',
                        formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = (value / total * 100).toFixed(1) + '%';
                            return percentage;
                        },
                        font: {
                            weight: 'bold',
                            size: 14,
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Aktifkan plugin datalabels
        });

        // Usia
        const rawDataUsia = @json($statistikUsia); 
        const dataUsia = Object.values(rawDataUsia); 
        const ctxUsia = document.getElementById('ageChart').getContext('2d');
        new Chart(ctxUsia, {
            type: 'bar',
            data: {
                labels: dataUsia.map(item => item.rentang_usia),
                datasets: [
                    {
                        label: 'Laki-laki',
                        data: dataUsia.map(item => item.total_laki),
                        backgroundColor: '#3B82F6',
                        borderRadius: 4
                    },
                    {
                        label: 'Perempuan',
                        data: dataUsia.map(item => item.total_perempuan),
                        backgroundColor: '#EC4899',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 30 // ⬅️ Tambahkan padding atas
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#111827',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value, context) => {
                            // Total dari semua dataset pada index yang sama
                            const index = context.dataIndex;
                            const totalLaki = dataUsia[index].total_laki;
                            const totalPerempuan = dataUsia[index].total_perempuan;
                            const total = totalLaki + totalPerempuan;

                            const percentage = (value / total * 100).toFixed(1);
                            return `${percentage}%`;
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            color: '#E5E7EB'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Tambahkan plugin ini
        });


        // Agama
        const dataAgamaRaw = @json($statistikAgama); 
        const ctxReligion = document.getElementById('religionChart').getContext('2d');
       new Chart(ctxReligion, {
            type: 'pie',
            data: {
                labels: dataAgamaRaw.map(item => item.agama),
                datasets: [{
                    data: dataAgamaRaw.map(item => item.total),
                    backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            font: {
                                size: 13,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                return `${label}: ${value} orang`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percentage = (value / total * 100).toFixed(1);
                            return `${percentage}%`;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // ⬅️ Aktifkan plugin-nya di sini
        });


        // Pernikahan
        const dataPernikahan = {
            marital: @json($statistikPernikahan)
        };
        const ctxMarital = document.getElementById('maritalChart').getContext('2d');
        new Chart(ctxMarital, {
            type: 'bar',
            data: {
                labels: dataPernikahan.marital.map(item => item.status_pernikahan),
                datasets: [{
                    label: 'Jumlah',
                    data: dataPernikahan.marital.map(item => item.total),
                    backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444'],
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 30 
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'start', // posisi di atas batang
                        offset: -6,     // naikkan sedikit
                        color: '#111827',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percentage = (value / total * 100).toFixed(1);
                            return `${percentage}%`;
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            color: '#E5E7EB'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // ⬅️ Jangan lupa aktifkan plugin-nya
        });

        // Pendidikan
        const dataPendidikan = {
            education: @json($statistikPendidikan)
        };

        const ctxEducation = document.getElementById('educationChart').getContext('2d');

        new Chart(ctxEducation, {
            type: 'bar',
            data: {
                labels: dataPendidikan.education.map(item => item.pendidikan),
                datasets: [{
                    label: 'Jumlah',
                    data: dataPendidikan.education.map(item => item.total),
                    backgroundColor: '#8B5CF6',
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y', // ⬅️ Chart horizontal
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        right: 40 // ⬅️ Tambahin padding kanan, bisa diubah sesuai kebutuhan
                    }
                },

                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'right', // Posisi persentase di ujung kanan batang
                        offset: 4,
                        color: '#111827',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percentage = (value / total * 100).toFixed(1);
                            return `${percentage}%`;
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            color: '#E5E7EB'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // ⬅️ Aktifkan plugin
        });

        // Pekerjaan
        const dataPekerjaan = @json($statistikPekerjaan);
        const ctxOccupation = document.getElementById('occupationChart').getContext('2d');

        new Chart(ctxOccupation, {
            type: 'bar',
            data: {
                labels: dataPekerjaan.map(item => item.pekerjaan),
                datasets: [
                    {
                        label: 'Laki-laki',
                        data: dataPekerjaan.map(item => item.total_laki),
                        backgroundColor: '#3B82F6',
                        borderRadius: 4
                    },
                    {
                        label: 'Perempuan',
                        data: dataPekerjaan.map(item => item.total_perempuan),
                        backgroundColor: '#EC4899',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        right: 40 // ➕ Supaya label nggak ketiban batas kanan
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        offset: 4,
                        color: '#111827',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value, context) => {
                            const index = context.dataIndex;
                            const datasetIndex = context.datasetIndex;

                            const totalLaki = dataPekerjaan[index].total_laki;
                            const totalPerempuan = dataPekerjaan[index].total_perempuan;
                            const total = totalLaki + totalPerempuan;

                            const percentage = (value / total * 100).toFixed(1);
                            return `${percentage}%`;
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            color: '#E5E7EB'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>

    {{-- <script>
        // Sample data - replace with actual data from your controller

        // Update summary cards
        const totalKK = sampleData.regional.reduce((sum, dusun) => sum + dusun.total_kk, 0);
        const totalJiwa = sampleData.regional.reduce((sum, dusun) => sum + dusun.total_jiwa, 0);
        const totalLaki = sampleData.regional.reduce((sum, dusun) => sum + dusun.laki, 0);
        const totalPerempuan = sampleData.regional.reduce((sum, dusun) => sum + dusun.perempuan, 0);

        document.getElementById('totalKK').textContent = totalKK.toLocaleString();
        document.getElementById('totalJiwa').textContent = totalJiwa.toLocaleString();
        document.getElementById('totalLaki').textContent = totalLaki.toLocaleString();
        document.getElementById('totalPerempuan').textContent = totalPerempuan.toLocaleString();
        document.getElementById('persenLaki').textContent = ((totalLaki / totalJiwa) * 100).toFixed(1) + '%';
        document.getElementById('persenPerempuan').textContent = ((totalPerempuan / totalJiwa) * 100).toFixed(1) + '%';

        // Chart configurations
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            }
        };

        // Gender Chart
        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: sampleData.gender.map(item => item.jenis_kelamin),
                datasets: [{
                    data: sampleData.gender.map(item => item.total),
                    backgroundColor: ['#3B82F6', '#EC4899'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    ...chartOptions.plugins,
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return `${context.label}: ${context.parsed.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Age Chart
        new Chart(document.getElementById('ageChart'), {
            type: 'bar',
            data: {
                labels: sampleData.age.map(item => item.rentang_usia),
                datasets: [
                    {
                        label: 'Laki-laki',
                        data: sampleData.age.map(item => item.total_laki),
                        backgroundColor: '#3B82F6',
                        borderRadius: 4
                    },
                    {
                        label: 'Perempuan',
                        data: sampleData.age.map(item => item.total_perempuan),
                        backgroundColor: '#EC4899',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                ...chartOptions,
                scales: {
                    x: {
                        stacked: false,
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true
                    }
                }
            }
        });

        // Religion Chart
        new Chart(document.getElementById('religionChart'), {
            type: 'pie',
            data: {
                labels: sampleData.religion.map(item => item.agama),
                datasets: [{
                    data: sampleData.religion.map(item => item.total),
                    backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: chartOptions
        });

        // Marital Status Chart
        new Chart(document.getElementById('maritalChart'), {
            type: 'bar',
            data: {
                labels: sampleData.marital.map(item => item.status_pernikahan),
                datasets: [{
                    label: 'Jumlah',
                    data: sampleData.marital.map(item => item.total),
                    backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444'],
                    borderRadius: 4
                }]
            },
            options: {
                ...chartOptions,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Education Chart
        new Chart(document.getElementById('educationChart'), {
            type: 'horizontalBar',
            data: {
                labels: sampleData.education.map(item => item.pendidikan),
                datasets: [{
                    label: 'Jumlah',
                    data: sampleData.education.map(item => item.total),
                    backgroundColor: '#8B5CF6',
                    borderRadius: 4
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Occupation Chart
        new Chart(document.getElementById('occupationChart'), {
            type: 'horizontalBar',
            data: {
                labels: sampleData.occupation.map(item => item.pekerjaan),
                datasets: [{
                    label: 'Jumlah',
                    data: sampleData.occupation.map(item => item.total),
                    backgroundColor: '#06B6D4',
                    borderRadius: 4
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Regional Chart
        new Chart(document.getElementById('regionalChart'), {
            type: 'bar',
            data: {
                labels: sampleData.regional.map(item => item.dusun),
                datasets: [
                    {
                        label: 'KK',
                        data: sampleData.regional.map(item => item.total_kk),
                        backgroundColor: '#10B981',
                        yAxisID: 'y',
                        borderRadius: 4
                    },
                    {
                        label: 'Total Jiwa',
                        data: sampleData.regional.map(item => item.total_jiwa),
                        backgroundColor: '#3B82F6',
                        yAxisID: 'y1',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                ...chartOptions,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah KK'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Jiwa'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });

        // Populate table
        function populateTable() {
            const tableBody = document.getElementById('tableBody');
            let html = '';
            let no = 1;

            sampleData.regional.forEach(dusun => {
                // Dusun row
                html += `
                    <tr class="bg-purple-100 font-bold">
                        <td class="border px-4 py-2">${no}</td>
                        <td class="border px-4 py-2 text-left">${dusun.dusun}</td>
                        <td class="border px-4 py-2">${dusun.total_kk}</td>
                        <td class="border px-4 py-2">${dusun.total_jiwa.toLocaleString()}</td>
                        <td class="border px-4 py-2">${dusun.laki}</td>
                        <td class="border px-4 py-2">${dusun.perempuan}</td>
                    </tr>
                `;

                // RT rows
                dusun.rts.forEach(rt => {
                    html += `
                        <tr>
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2 text-left">RT. ${rt.rt}</td>
                            <td class="border px-4 py-2">${rt.kk}</td>
                            <td class="border px-4 py-2">${rt.jiwa}</td>
                            <td class="border px-4 py-2">${rt.laki}</td>
                            <td class="border px-4 py-2">${rt.perempuan}</td>
                        </tr>
                    `;
                });

                no++;
            });

            // Total row
            html += `
                <tr class="bg-purple-200 font-bold">
                    <td class="border px-4 py-2 text-center" colspan="2">Total</td>
                    <td class="border px-4 py-2">${totalKK}</td>
                    <td class="border px-4 py-2">${totalJiwa.toLocaleString()}</td>
                    <td class="border px-4 py-2">${totalLaki}</td>
                    <td class="border px-4 py-2">${totalPerempuan}</td>
                </tr>
            `;

            tableBody.innerHTML = html;
        }

        // Initialize table
        populateTable();
    </script> --}}

@endsection