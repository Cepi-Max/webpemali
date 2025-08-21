@extends('public-user.layouts.main.app')

@section('content')
    <!-- <div class="p-[2px] inline-block w-full h-10 mt-2">
        <div class="p-2 bg-[#D98324] w-full h-full flex justify-between items-center">
            <marquee class="text-lg text-sky-950 dark:text-gray-200 font-semibold" direction='left' >Selamat Datang Di Website Resmi Desa Pemali</marquee>
        </div>
    </div> -->
    
    <main class="mx-auto w-[90%] pt-[6.5rem] md:pt-[7rem]">
        <div class="grid grid-cols-1 lg:grid-cols-[70%_30%] gap-5 p-3 w-full mx-auto lg:px-10 lg:py-4 mt-4 shadow-lg bg-white dark:bg-gray-900 rounded-lg">
             <!-- Kolom 1 -->
             <div class="flex flex-col items-center">
                <div class="text-xl md:text-2xl lg:text-4xl mt-10 text-left font-bold text-sky-950 dark:text-gray-300">
                    {{ $dC->title }}
                </div>
                <div class="flex flex-wrap lg:flex-nowrap mt-10">
                    <!-- Informasi Pembangunan -->
                    <div class="w-full p-6 mb-6 rounded-2xl border border-gray-300 bg-white dark:bg-gray-900 shadow-md">
                        <!-- Gambar utama pembangunan -->
                        <div class="w-full h-64 lg:h-80 rounded-2xl overflow-hidden mb-4">
                            <img 
                                src="{{ asset('storage/images/publicImg/construction/constructionImg/'. $dC->image) }}" 
                                alt="pembangunan" 
                                class="w-full h-full object-cover rounded-2xl transition-transform duration-300 hover:scale-105 cursor-pointer"
                                onclick="openModalImage('{{ asset('storage/images/publicImg/construction/constructionImg/'. $dC->image) }}', '{{ $dC->title }}')">
                        </div>
                    
                        @if (!empty($documentations) && $documentations->count())
                        <!-- Label -->
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Dokumentasi Progres Pembangunan</h3>
                    
                        <!-- Scrollable gallery -->
                        <div class="w-full overflow-x-auto">
                            <div class="flex space-x-3 pb-2">
                                    @foreach ($documentations as $doc)
                                        <div class="flex-shrink-0 w-44 h-44 border border-gray-300 rounded-xl overflow-hidden shadow-sm bg-white dark:bg-gray-800 relative hover:shadow-md transition-shadow duration-300 cursor-pointer"
                                            onclick="openModalImage('{{ asset('storage/images/publicImg/construction/documentationImg/' . $doc->image) }}', '{{ $doc->information }}')">
                                            
                                            <img 
                                                src="{{ asset('storage/images/publicImg/construction/documentationImg/' . $doc->image) }}" 
                                                alt="documentation" 
                                                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        
                                            <!-- Keterangan -->
                                            <div class="absolute bottom-1 left-1 right-1 bg-white/70 dark:bg-gray-700/70 rounded-md px-2 py-1 text-xs text-gray-800 dark:text-white shadow backdrop-blur">
                                                {{ $doc->percentage }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @else
                            <p class="text-gray-500">Belum ada dokumentasi untuk pembangunan ini.</p>
                        @endif
                                           
                        <div class="text-sky-950 dark:text-gray-200 dark:bg-gray-800 mt-4">
                            <table class="min-w-full ">
                                <tbody>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Tahun</td>
                                        
                                        <td class="p-2 text-left">: {{ $dC->fiscal_year }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Volume</td>
                                        
                                        <td class="p-2 text-left">: {{ $dC->construction_volume }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Anggaran</td>
                                        
                                        <td class="p-2 text-left">: Rp. {{ number_format($dC->total_budget, 2, ',', '.'); }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Sumber Dana</td>
                                        
                                        <td class="p-2 text-left">: <?= isset($fundSourceCategories[$dC->id]) ? $fundSourceCategories[$dC->id] : 'Sumber tidak ditemukan'; ?></td>
                                    </tr>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Pelaksana</td>
                                        
                                        <td class="p-2 text-left">: {{ $dC->construction_implementer }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Estimasi</td>
                                        
                                        <td class="p-2 text-left">: {{ $dC->construction_time_period }} {{ $dC->period_category }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Lokasi</td>
                                        
                                        <td class="p-2 text-left">: {{ $dC->construction_site }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Manfaat</td>
                                        
                                        <td class="p-2 text-left">: {{ $dC->construction_benefits }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="w-1/3 p-2 font-semibold text-left">Keterangan</td>
                                        <td class="p-2 text-left">: {{ !empty($dC->information) ? $dC->information : '--' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Lokasi Pembangunan -->
                <div class="w-full bg-gray-300 dark:bg-gray-800 rounded-lg mt-4">
                    <div class="text-lg md:text-xl lg:text-2xl text-left p-5 text-sky-950 dark:text-gray-200 font-bold">
                        <i class="fa-solid fa-location-dot"></i> Lokasi Pembangunan
                    </div>
                    @if (!empty($dC->latitude) || !empty($dC->longitude))
                        <div id="map" class="w-full h-96 z-10"></div>
                    @else
                        <div class="flex items-center justify-center text-center h-96 p-5 text-gray-500 text-2xl font-semibold">
                            <h1>Data Lokasi Belum Dimasukkan</h1>
                        </div>
                    @endif
                </div> 
             </div>
             <!-- Kolom 2 -->
            <div class="row">
                <section class="rounded-md mt-3 sticky top-[6.5rem] md:top-[7rem] pb-4 bg-gray-300 dark:bg-gray-800">
                    <div class="p-[2px] inline-block w-full h-10">
                        <div class="md:text-xl lg:text-xl text-left font-bold mb-4 text-sky-950 dark:text-gray-300 p-4">
                            Pembangunan lainnya &gt;
                        </div>
                    </div>
                    <div class="mt-2 space-y-4 lg:px-2 max-h-[70vh] overflow-y-auto">
                        <div class="mt-2 space-y-4 lg:px-2 max-h-[70vh] overflow-y-auto">
                            @foreach ($popularConstructions as $pC)
                            <a href="{{ route('show.construction.detail', $pC->slug) }}" class="block">
                                <div class="group bg-white dark:bg-gray-700 dark:text-gray-300 p-4 shadow-md mt-2 rounded-lg">
                                    <p class="group-hover:text-blue-600">{{ \Illuminate\Support\Str::limit($pC->title, 25) }}</p>
                                    <div class="flex mt-2">
                                        <small class="text-gray-500 ml-2">
                                            {{ \Carbon\Carbon::parse($pC->created_at)->translatedFormat('l, d F Y') }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>           
        </div>
        
        <!-- Modal Gambar -->
        <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-80 flex justify-center items-center">
            <!-- Modal Title -->
            <div class="absolute top-0 w-[97%] bg-black bg-opacity-50 flex justify-center items-center p-4 z-10 rounded-b-xl">
                <p id="modalCaption" class="text-white text:md sm:text-xl truncate"></p>
            </div>
            <div class="relative p-4">
                <button 
                    class="hidden sm:inline absolute top-5 right-7 text-gray-900 hover:text-black bg-white bg-opacity-0 p-2 rounded-md transition-all duration-300"
                    onclick="closeModalImage()">
                    &times;
                </button>
                <img id="modalImage" src="" alt="Detail Gambar" class="max-w-full max-h-[80vh] object-contain rounded-lg">
            </div>
        </div>

        
        @include('public-user.layouts.map.map')     
    </main>
        <script>
            function openModalImage(src, caption) {
                document.getElementById('modalImage').src = src;
                document.getElementById('modalCaption').textContent = caption;
                document.getElementById('imageModal').classList.remove('hidden');
            }
        
            function closeModalImage() {
                document.getElementById('imageModal').classList.add('hidden');
                document.getElementById('modalImage').src = '';
                document.getElementById('modalCaption').textContent = '';
            }
            document.getElementById('imageModal').addEventListener('click', function (event) {
                if (event.target.id === 'imageModal') {
                    closeModalImage();
                }
            });

            // Map Leaflet
            const latitude = {!! json_encode($dC['latitude']);  !!};
            const longitude = {!! json_encode($dC['longitude']);  !!};
            const title = {!! json_encode($dC['title']);  !!};
            
            // Cek apakah latitude dan longitude kosong atau tidak valid
            if (latitude && longitude) {
                // Jika data latitude dan longitude valid, inisialisasi peta
                const map = L.map('map').setView([latitude, longitude], 16);
            
                // Tambahkan tile layer
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            
                // Tambahkan marker
                const marker = L.marker([latitude, longitude]).addTo(map);
            
                // Tambahkan popup pada marker
                marker.bindPopup(`Lokasi: ${title}`).openPopup();
            } else {
                console.log('Data Map Belum Dimasukkan!');
            }

        </script>
        
@endsection