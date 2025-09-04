@extends('admin.layouts.main.app')

@section('content')

    <div class="row">
      <div class="ms-3">
        <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
        <p class="mb-4">
          Selamat Datang {{ Auth::user()->name }}
        </p>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Penduduk</p>
                <h4 class="m-2">{{ $totalPenduduk }} jiwa</h4>
              </div>
              <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                <i class="material-symbols-rounded opacity-10">weekend</i>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm"></p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Kepala Keluarga</p>
                <h4 class="m-2">{{ $totalKepalaKeluarga }} Kepala</h4>
              </div>
              <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                <i class="material-symbols-rounded opacity-10">person</i>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm"></p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Agama</p>
                <h4 class="m-2">{{ $totalAgama }} agama</h4>
              </div>
              <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                <i class="material-symbols-rounded opacity-10">leaderboard</i>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm"></p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Total Pengguna Website</p>
                <h4 class="m-2">{{ $totalPengguna }} akun</h4>
              </div>
              <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                <i class="material-symbols-rounded opacity-10">weekend</i>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm"></p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 mt-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="mb-4">Pendidikan</h6>
            <p class="text-sm "> Jumlah masyarakat berdasarkan pendidikan.</p>
            <div class="w-full md:w-1/3">
              <div class="chart">
                <canvas id="chartPendidikan" class="chart-canvas" height="170"></canvas>
              </div>
            </div>
            <hr class="dark horizontal">
            <div class="d-flex ">
              <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
              <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 mt-4 mb-4">
        <div class="card ">
          <div class="card-body">
            <h6 class="mb-4">Dusun</h6>
            <p class="text-sm "> Jumlah masyarakat berdasarkan dusun.</p>
            <div class="pe-2 d-flex justify-between">
              <div class="chart">
                <canvas id="chartDusun" class="chart-canvas" height="285"></canvas>
              </div>
              <div class="w-full md:w-1/3">
                <p class="text-sm d-flex justify-content-center">Daftar Dusun</p>
                <ul>
                    @php
                        $colors = [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                            '#F67019', '#00A950', '#C9CBCF', '#FF9F40', '#B4FF9F'
                        ];
                    @endphp
                    @foreach ($statistikDusun as $index => $item)
                        <li class="flex items-center gap-2 mb-1">
                            <span style="width: 16px; height: 16px; background-color: {{ $colors[$index % count($colors)] }}; display: inline-block; border-radius: 4px;"></span>
                            <span class="text-sm">{{ $item->dusun }}</span>
                        </li>
                    @endforeach
                </ul>
              </div>
            </div>
            <hr class="dark horizontal">
            <div class="d-flex ">
              <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
              <p class="mb-0 text-sm"> updated 4 min ago </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
        <div class="card ">
          <div class="card-body">
            <h6 class="mb-0 ">Pekerjaan</h6>
            <p class="text-sm "> Jumlah masyarakat berdasarkan pekerjaan.</p>
            <div class="d-flex justify-between w-full">
              <div class="chart pe-4 flex-grow-1">
                <canvas id="chartPekerjaan" class="chart-canvas w-100" height="170"></canvas>
              </div>              
              <div class="overflow-auto" style="max-height: 170px;">
                <p class="text-sm d-flex justify-content-center">Daftar Pekerjaan</p>
                <ul class="list-unstyled">
                  @php
                    $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#F67019', '#00A950', '#C9CBCF', '#FF9F40', '#B4FF9F'];
                  @endphp
                  @foreach ($statistikPekerjaan as $index => $item)
                    <li class="d-flex align-items-center gap-2 mb-1">
                      <span style="width: 16px; height: 16px; background-color: {{ $colors[$index % count($colors)] }}; display: inline-block; border-radius: 4px;"></span>
                      <span class="small">{{ $item->pekerjaan }}</span>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
            
            <hr class="dark horizontal">
            <div class="d-flex ">
              <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
              <p class="mb-0 text-sm"> updated 4 min ago </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
        <div class="card">
          <div class="card-header pb-0">
            <div class="row">
              <div>
                <h6>Usia</h6>
                <p class="text-sm "> Jumlah masyarakat berdasarkan usia.</p>
              </div>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usia</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Laki-laki</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Perempuan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($statistikUsia as $index => $item )  
                  <tr class="text-center ">
                    <td>
                      <h6 class="mb-0 text-sm">{{ $item['usia'] }}</h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold">{{ $item['laki'] }}</span>
                    </td>
                    <td class="align-middle">
                        <span class="text-xs font-weight-bold">{{ $item['perempuan'] }}</span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6  ">
        <div class="card ">
          <div class="card-body">
            <h6 class="mb-0 ">Jenis Kelamin</h6>
            <p class="text-sm "> Jumlah masyarakat berdasarkan jenis kelamin.</p>
            <div class="pe-2">
              <div class="chart">
                <canvas id="chartJenisKelamin" class="chart-canvas" height="170"></canvas>
              </div>
            </div>
            <hr class="dark horizontal">
            <div class="d-flex ">
              <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
              <p class="mb-0 text-sm"> updated 4 min ago </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Bar Chart Pendidikan
      const ctxPendidikan = document.getElementById('chartPendidikan').getContext('2d');

      const pendidikanLabels = {!! json_encode($statistikPendidikan->pluck('pendidikan')) !!};
      const pendidikanData = {!! json_encode($statistikPendidikan->pluck('jumlah')) !!};
      const pendidikanColors = {!! json_encode(array_slice($colors, 0, $statistikPendidikan->count())) !!};

      new Chart(ctxPendidikan, {
          type: 'bar',
          data: {
              labels: pendidikanLabels,
              datasets: [{
                  label: 'Jumlah Penduduk',
                  data: pendidikanData,
                  backgroundColor: pendidikanColors,
                  borderColor: pendidikanColors,
                  borderWidth: 1,
                  borderRadius: 6,
              }]
          },
          options: {
              indexAxis: 'y',
              responsive: true,
              plugins: {
                  legend: {
                      display: true 
                  }
              },
              scales: {
                  x: {
                      beginAtZero: true,
                      ticks: {
                          stepSize: 1
                      }
                  },
                  y: {
                      ticks: {
                          display: true
                      },
                      grid: {
                          display: true 
                      }
                  }
              }
          }
      });
      // Bar Chart Pekerjaan
      const ctxPekerjaan = document.getElementById('chartPekerjaan').getContext('2d');

      const pekerjaanLabels = {!! json_encode($statistikPekerjaan->pluck('pekerjaan')) !!};
      const pekerjaanData = {!! json_encode($statistikPekerjaan->pluck('jumlah')) !!};
      const pekerjaanColors = {!! json_encode(array_slice($colors, 0, $statistikPekerjaan->count())) !!};

      new Chart(ctxPekerjaan, {
          type: 'bar',
          data: {
              labels: pekerjaanLabels,
              datasets: [{
                  label: 'Jumlah Penduduk',
                  data: pekerjaanData,
                  backgroundColor: pekerjaanColors,
                  borderColor: pekerjaanColors,
                  borderWidth: 1,
                  borderRadius: 6,
              }]
          },
          options: {
              indexAxis: 'x',
              responsive: true,
              plugins: {
                  legend: {
                      display: false 
                  }
              },
              scales: {
                  x: {
                      ticks: {
                          display: false
                      },
                      grid: {
                          display: false 
                      }
                  },
                  y: {
                      beginAtZero: true,
                      ticks: {
                          stepSize: 1
                      }
                  }
              }
          }
      });
      // Bar Chart Dusun
      const ctxDusun = document.getElementById('chartDusun').getContext('2d');

      const dusunLabels = {!! json_encode($statistikDusun->pluck('dusun')) !!};
      const dusunData = {!! json_encode($statistikDusun->pluck('jumlah')) !!};
      const dusunColors = {!! json_encode(array_slice($colors, 0, $statistikDusun->count())) !!};

      new Chart(ctxDusun, {
          type: 'bar',
          data: {
              labels: dusunLabels,
              datasets: [{
                  label: 'Jumlah Penduduk',
                  data: dusunData,
                  backgroundColor: dusunColors,
                  borderColor: dusunColors,
                  borderWidth: 1,
                  borderRadius: 6,
              }]
          },
          options: {
              responsive: true,
              plugins: {
                  legend: {
                      display: false // karena kita pakai legend manual
                  }
              },
              scales: {
                  x: {
                      ticks: {
                          display: false
                      },
                      grid: {
                          display: false 
                      }
                  },
                  y: {
                      beginAtZero: true,
                      ticks: {
                          stepSize: 1
                      }
                  }
              }
          }
      });
      // Pie Chart Jenis Kelamin
      const ctx = document.getElementById('chartJenisKelamin').getContext('2d');
  
      const chartJenisKelamin = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: {!! json_encode($statistikJenisKelamin->pluck('jenis_kelamin')) !!},
              datasets: [{
                  label: 'Jumlah',
                  data: {!! json_encode($statistikJenisKelamin->pluck('jumlah')) !!},
                  backgroundColor: [
                      'rgba(54, 162, 235, 0.7)', // biru
                      'rgba(255, 99, 132, 0.7)', // merah muda
                  ],
                  borderColor: [
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 99, 132, 1)',
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              responsive: true,
          }
      });
  </script>
  
@endsection
