@extends('public-user.layouts.main.app')

@section('content')
<div class="flex flex-col md:flex-row mx-auto w-[90%] min-h-screen pt-[7rem] md:pt-[8rem] pb-4">
  <aside class="md:w-64 w-full bg-white dark:bg-gray-900 text-sky-950 dark:text-gray-300 rounded-md p-4 shadow-md">
    <h2 class="text-xl font-bold mb-4 border-b pb-2">STATISTIK DATA DESA PEMALI</h2>
    <!-- Enhanced Year Filter Form -->
    <div class="mb-6">
        <form method="GET" class="space-y-3">
            <div class="relative">
                <label for="tahun" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-950 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Filter Tahun
                </label>
                
                <div class="relative">
                    <select 
                        name="tahun" 
                        id="tahun" 
                        onchange="this.form.submit()"
                        class="w-full appearance-none bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 pr-10 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:focus:ring-sky-400 focus:border-sky-500 dark:focus:border-sky-400 transition-all duration-200 shadow-sm hover:shadow-md"
                    >
                        @foreach ($tahunValid as $tahun)
                            <option value="{{ $tahun }}" {{ $tahun == $tahunTerpilih ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Selected year indicator -->
                {{-- <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-md px-3 py-2 border border-gray-200 dark:border-gray-600">
                    <span class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        Data tahun <strong class="text-sky-600 dark:text-sky-400">{{ $tahunTerpilih }}</strong> aktif
                    </span>
                </div> --}}
            </div>
        </form>
    </div>
    <!-- Statistics Menu -->
    <div x-data="{ isOpen: true }" class="w-full mb-6">
        <button
            @click="isOpen = !isOpen"
            class="flex items-center justify-between w-full bg-white dark:bg-gray-700 text-sky-950 dark:text-gray-100 p-3 rounded-lg shadow hover:bg-gray-50 transition-colors duration-500"
        >
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-100 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"></path>
                </svg>
                <span class="font-medium">Pilihan Data</span>
            </div>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 transform transition-transform duration-500"
                :class="{ 'rotate-180': isOpen }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        
        <div
            x-show="isOpen"
            x-collapse
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 max-h-0 overflow-hidden"
            x-transition:enter-end="opacity-100 max-h-96 overflow-visible"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 max-h-96"
            x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
            class="w-full bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 mt-3 overflow-hidden shadow-sm"
        >
        
            @php
            $categories = [
                ['name' => 'Penduduk', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['name' => 'Wilayah', 'icon' => 'M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z'],
                ['name' => 'Usia', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['name' => 'Pendidikan', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['name' => 'Pekerjaan', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V8m8 0V6a2 2 0 00-2-2H10a2 2 0 00-2 2v2'],
                ['name' => 'Agama', 'icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
                ['name' => 'Kewarganegaraan', 'icon' => 'M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5'],
                ['name' => 'Cacat Mental & Fisik', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['name' => 'Tenaga Kerja', 'icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z'],
                ['name' => 'Ekonomi', 'icon' => 'M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            ];
            @endphp
            
            <div id="menuKategori" class="divide-y divide-gray-100 dark:divide-gray-700 max-h-48 overflow-y-auto">


                @foreach($categories as $index => $category)
                    <a
                        href="#{{ $category['name'] }}"
                        class="kategori-link flex items-center gap-3 px-4 py-3 rounded-lg
                            text-gray-700 dark:text-gray-200
                            hover:bg-gray-300 dark:hover:bg-gray-900
                            hover:text-gray-700 dark:hover:text-gray-300
                            transition-all duration-200 group"
                    >
                        <div class="w-8 h-8 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center 
                                    group-hover:bg-gray-100 dark:group-hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-200 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $category['icon'] }}"></path>
                            </svg>
                        </div>
                        <span class="font-medium">{{ $category['name'] }}</span>
                        <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endforeach
            </div>

        </div>
        {{-- <a
        href="{{ route('show.desa-cantik.detail-statistik') }}"
        class="mt-4 inline-block w-full text-center bg-sky-950 dark:bg-blue-800 text-white font-semibold py-2 rounded-xl hover:bg-gray-900 dark:hover:bg-gray-700 transition duration-300"
        >
        Lihat Detail Statistik
        </a> --}}
    </div>
  </aside>
  
    <!-- Main Content Penduduk-->
    <main id="Penduduk" class="flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Jumlah Kepala Keluarga dan Penduduk Berdasarkan Jenis Kelamin di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 mt-4 text-sm">
          <thead class="bg-gray-200 text-gray-800">
              <tr>
                  <th class="border px-4 py-2">No.</th>
                  <th class="border px-4 py-2">Wilayah</th>
                  <th class="border px-4 py-2">Jumlah Kepala Rumah Tangga</th>
                  <th class="border px-4 py-2">Jumlah Penduduk Laki-laki</th>
                  <th class="border px-4 py-2">Jumlah Penduduk Perempuan</th>
                  <th class="border px-4 py-2">Total Penduduk</th>
                  <th class="border px-4 py-2">Periode</th>
              </tr>
          </thead>
          <tbody class="text-center">
              @if($statpenduduk->count() > 0)
                @foreach ($statpenduduk as $index => $data)
                    <tr class="bg-gray-100 font-bold">
                        <td class="border px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2 text-left">{{ $data->wilayah }}</td>
                        <td class="border px-4 py-2">{{ $data->jumlah_kepala_keluarga }}</td>
                        <td class="border px-4 py-2">{{ $data->jumlah_penduduk_laki_laki}}</td>
                        <td class="border px-4 py-2">{{ $data->jumlah_penduduk_perempuan}}</td>
                        <td class="border px-4 py-2">{{ $data->jumlah_penduduk}}</td>
                        <td class="border px-4 py-2">{{ $data->periode}}</td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data Penduduk untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
        </tbody>        
      </table>
      <div>
        <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
      </div>
      </div>
    </main>

    <!-- Main Content Dusun-->
    <main id="Wilayah" class="flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Nama Rukun Tetangga Berdasarkan Dusun di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 mt-4 text-sm">
          <thead class="bg-gray-200 text-gray-800">
              <tr>
                  <th class="border px-4 py-2">No.</th>
                  <th class="border px-4 py-2">Dusun</th>
                  <th class="border px-4 py-2">Rt</th>
                  <th class="border px-4 py-2">Periode</th>
              </tr>
          </thead>
          <tbody class="text-center">
              @if($dataDusun->count() > 0)
                @foreach ($dataDusun as $index => $data)
                    <tr class="bg-gray-100 font-bold">
                        <td class="border px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2 text-left">{{ $data->nama_dusun }}</td>
                        <td class="border px-4 py-2">{{ $data->nama_rukun_tetangga }}</td>
                        <td class="border px-4 py-2">{{ $data->periode}}</td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data wilayah untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
        </tbody>        
      </table>
      <div>
        <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
      </div>
      </div>
    </main>

    {{-- Kewarganegaraan --}}
    <main id="Kewarganegaraan" class="hidden flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Jumlah Penduduk Berdasarkan Kewarganegaraan di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">kewarganegaraan</th>
                    <th class="border px-4 py-2">Laki-laki</th>
                    <th class="border px-4 py-2">Perempuan</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Periode</th>
                </tr>
            </thead>
            <tbody>
                @if($dataKewarganegaraan->count() > 0)
                    @foreach ($dataKewarganegaraan as $index => $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2 text-left">{{ $data->kewarganegaraan }}</td>
                            <td class="border px-4 py-2">{{ $data->laki_laki }}</td>
                            <td class="border px-4 py-2">{{ $data->perempuan }}</td>
                            <td class="border px-4 py-2">{{ $data->jumlah }}</td>
                            <td class="border px-4 py-2">{{ $data->periode }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data kewarganegaraan untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
            <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
        </div>
      </div>
    </main>

    {{-- CacatMentalDanFisik --}}
    <main id="Cacat Mental & Fisik" class="hidden flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Jumlah Penduduk Berdasarkan Cacat Mental dan Fisik di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Jenis Cacat</th>
                    <th class="border px-4 py-2">Laki-laki</th>
                    <th class="border px-4 py-2">Perempuan</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Periode</th>
                </tr>
            </thead>
            <tbody>
                @if($dataJenisCacat->count() > 0)
                    @foreach ($dataJenisCacat as $index => $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2 text-left">{{ $data->jenis_cacat }}</td>
                            <td class="border px-4 py-2">{{ $data->laki_laki }}</td>
                            <td class="border px-4 py-2">{{ $data->perempuan }}</td>
                            <td class="border px-4 py-2">{{ $data->jumlah }}</td>
                            <td class="border px-4 py-2">{{ $data->periode }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data cacat mental dan fisik untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
            <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
        </div>
      </div>
    </main>

    {{-- Tenaga Kerja --}}
    <main id="Tenaga Kerja" class="hidden flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Jumlah Penduduk Berdasarkan Ketenagakerjaan di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Tenaga Kerja</th>
                    <th class="border px-4 py-2">Laki-laki</th>
                    <th class="border px-4 py-2">Perempuan</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Periode</th>
                </tr>
            </thead>
            <tbody>
                @if($dataTenagaKerja->count() > 0)
                    @foreach ($dataTenagaKerja as $index => $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2 text-left">{{ $data->tenaga_kerja }}</td>
                            <td class="border px-4 py-2">{{ $data->laki_laki }}</td>
                            <td class="border px-4 py-2">{{ $data->perempuan }}</td>
                            <td class="border px-4 py-2">{{ $data->jumlah }}</td>
                            <td class="border px-4 py-2">{{ $data->periode }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data Ketenagakerjaan untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
            <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
        </div>
      </div>
    </main>

    {{-- Ekonomi --}}
    <main id="Ekonomi" class="hidden flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Jumlah Penduduk Berdasarkan Jenis Lembaga Ekonomi di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Jenis Lembaga/Industri/Usaha</th>
                    <th class="border px-4 py-2">Jumlah Unit</th>
                    <th class="border px-4 py-2">Periode</th>
                </tr>
            </thead>
            <tbody>
                @if($dataEkonomi->count() > 0)
                    @foreach ($dataEkonomi as $index => $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2 text-left">{{ $data->jenis_lembaga_industri_usaha }}</td>
                            <td class="border px-4 py-2">{{ $data->jumlah_unit }}</td>
                            <td class="border px-4 py-2">{{ $data->periode }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data jenis lembaga ekonomi untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
            <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
        </div>
      </div>
    </main>

    {{-- Agama --}}
    <main id="Agama" class="hidden flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Statistik Penduduk Berdasarkan Agama di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Agama</th>
                    <th class="border px-4 py-2">Laki-laki</th>
                    <th class="border px-4 py-2">Perempuan</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Periode</th>
                </tr>
            </thead>
            <tbody>
                @if($dataAgama->count() > 0)
                    @foreach ($dataAgama as $index => $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2 text-left">{{ $data->agama }}</td>
                            <td class="border px-4 py-2">{{ $data->laki_laki }}</td>
                            <td class="border px-4 py-2">{{ $data->perempuan }}</td>
                            <td class="border px-4 py-2">{{ $data->jumlah }}</td>
                            <td class="border px-4 py-2">{{ $data->periode }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data agama untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
            <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
        </div>
      </div>
    </main>
    
    {{-- Usia --}}
    <main id="Usia" class="hidden flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Statistik Berdasarkan Kelompok Usia di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Usia</th>
                    <th class="border px-4 py-2">Laki-laki</th>
                    <th class="border px-4 py-2">Perempuan</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Periode</th>
                </tr>
            </thead>
            <tbody>
                @if($dataUsia->count() > 0)
                    @foreach ($dataUsia as $i => $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $i + 1 }}</td>
                            <td class="border px-4 py-2">{{ $data->usia }}</td>
                            <td class="border px-4 py-2">{{ $data->laki_laki }}</td>
                            <td class="border px-4 py-2">{{ $data->perempuan }}</td>
                            <td class="border px-4 py-2">{{ $data->jumlah }}</td>
                            <td class="border px-4 py-2">{{ $data->periode }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data usia untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
            <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
        </div>
      </div>
    </main>

    {{-- Pendidikan --}}
    <main id="Pendidikan" class="hidden flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Statistik Berdasarkan Pendidikan di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Tingkat Pendidikan</th>
                    <th class="border px-4 py-2">Laki-laki</th>
                    <th class="border px-4 py-2">Perempuan</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Periode</th>
                </tr>
            </thead>
            <tbody>
                @if($dataPendidikan->count() > 0)
                    @foreach ($dataPendidikan as $i => $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $i + 1 }}</td>
                            <td class="border px-4 py-2 text-left">{{ $data->tingkat_pendidikan }}</td>
                            <td class="border px-4 py-2">{{ $data->laki_laki }}</td>
                            <td class="border px-4 py-2">{{ $data->perempuan }}</td>
                            <td class="border px-4 py-2">{{ $data->jumlah }}</td>
                            <td class="border px-4 py-2">{{ $data->periode }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data pendidikan untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
            <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
        </div>
      </div>
    </main>

    {{-- Pekerjaan --}}
    <main id="Pekerjaan" class="hidden flex-1 bg-white rounded-md shadow-md p-6 mt-4 md:mt-0 md:ml-6">
      <h3 class="text-4xl text-sky-950 font-bold text-center mb-6">
        Statistik Berdasarkan Pekerjaan di Desa Pemali, {{ $tahunTerpilih }}
      </h3>
      <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Pekerjaan</th>
                    <th class="border px-4 py-2">Laki-laki</th>
                    <th class="border px-4 py-2">Perempuan</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Periode</th>
                </tr>
            </thead>
            <tbody>
                @if($dataPekerjaan->count() > 0)
                    @foreach ($dataPekerjaan as $i => $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $i + 1 }}</td>
                            <td class="border px-4 py-2 text-left">{{ $data->jenis_pekerjaan }}</td>
                            <td class="border px-4 py-2">{{ $data->laki_laki }}</td>
                            <td class="border px-4 py-2">{{ $data->perempuan }}</td>
                            <td class="border px-4 py-2">{{ $data->jumlah }}</td>
                            <td class="border px-4 py-2">{{ $data->periode }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="border px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-2">Data Tidak Tersedia</h4>
                                <p class="text-gray-500 text-sm">
                                    Belum ada data pekerjaan untuk tahun {{ $tahunTerpilih }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
            <i><span class="font-bold">Sumber :</span> Profil Desa Pemali, {{ $tahunTerpilih }}</i>
        </div>
      </div>
    </main>
  </div>
    
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('#menuKategori .kategori-link');
        const sections = document.querySelectorAll('main');

        function showSection(id) {
            // Sembunyikan semua section
            sections.forEach(section => section.classList.add('hidden'));

            // Tampilkan section yg dipilih
            const targetSection = document.getElementById(id);
            if (targetSection) {
                targetSection.classList.remove('hidden');
            }

            // Update active link
            links.forEach(l => {
                const lId = l.getAttribute('href').substring(1);
                if (lId === id) {
                    // Tambahkan style aktif
                    l.classList.add(
                        'bg-gray-300',          // background di light mode
                        'dark:bg-gray-800',     // background di dark mode
                        'text-gray-700',        // teks di light mode
                        'dark:text-gray-200',   // teks di dark mode
                        'font-semibold',
                        'shadow-sm',              // sedikit bayangan biar elegan
                        'rounded-lg'
                    );
                } else {
                    // Hapus semua style aktif
                    l.classList.remove(
                        'bg-gray-300',
                        'dark:bg-gray-800',
                        'text-gray-700',
                        'dark:text-gray-200',
                        'font-semibold',
                        'shadow-sm',
                        'rounded-lg'
                    );
                }
            });


            // Simpan ke localStorage
            localStorage.setItem('kategoriAktif', id);
        }

        // Event klik menu
        links.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                showSection(targetId);
            });
        });

        // Saat halaman di-refresh, tampilkan yg terakhir dibuka
        const saved = localStorage.getItem('kategoriAktif') || 'Wilayah';
        showSection(saved);
    });
</script>

@endsection