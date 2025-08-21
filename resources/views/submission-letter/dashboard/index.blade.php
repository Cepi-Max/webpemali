@extends('submission-letter.layouts.main.app')

@section('content')
    <main class="mx-auto w-full">
        <div class="border-b-4 border-sky-900">
            <div class="relative w-full overflow-hidden shadow-lg bg-white dark:bg-gray-700 h-screen">
              <div id="carousel-container" class="relative overflow-hidden w-full">
                  <div id="carousel" class="flex transition-transform duration-1000 ease-in-out">
                    @foreach ($bannerImg as $banner)
                        <img src="{{ asset('storage/images/general/bannerImg/' . $banner->bannerImg) }}" class="w-full flex-shrink-0 object-cover h-screen" alt="Slide">  
                    @endforeach
                  </div>
              </div>
              
              <!-- Overlay gelap transparan tanpa blur -->
              <div class="absolute inset-0 bg-black/60 z-10"></div>

              <!-- Konten teks & search form -->
              <div class="absolute inset-0 flex items-center justify-center z-20 px-4">
                  <div class="text-center p-6 rounded-xl max-w-xl w-full">
                      <h1 class="text-2xl md:text-4xl font-bold text-white mb-4">
                          Ajukan pelayanan yang kamu butuhkan hari ini!
                      </h1>
                      <form action="{{ route('show.community-services.result') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                        <input 
                            type="text" 
                            name="query" 
                            placeholder="Cari formulir surat dan layanan lainnya.." 
                            value="{{ request('query') }}"
                            class="w-full sm:flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:bg-gray-800 bg-white text-gray-900 dark:text-white dark:border-gray-600"
                        >
                        <button 
                            type="submit" 
                            class="w-full sm:w-auto px-6 py-2 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 transition duration-300"
                        >
                            Cari
                        </button>
                     </form>
                    </div>
                  </div>

                  <!-- Scroll Indicator -->
                  <div class="relative bottom-32 mx-auto transform -translate-x-1/2 flex flex-col items-center animate-bounce text-gray-300 text-sm md:text-base z-30">
                      <span class="mb-1">Scroll ke bawah untuk lihat lebih banyak</span>
                      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                      </svg>
                  </div>

              <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-opacity-30 bg-gray-600 text-white p-2 rounded-full shadow-lg hover:bg-gray-900 hover:bg-opacity-90 transition z-30">&#10094;</button>
              <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-opacity-30 bg-gray-600 text-white p-2 rounded-full shadow-lg hover:bg-gray-900 hover:bg-opacity-90 transition z-30">&#10095;</button>
              
              <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex flex-wrap justify-center gap-2 z-30 w-full max-w-xs px-4">
                    @foreach ($bannerImg as $index => $banner)
                        <span class="dot w-2 h-2 rounded-full bg-opacity-50 cursor-pointer {{ $index === 0 ? 'bg-gray-800' : 'bg-gray-300' }}"></span>
                    @endforeach
                </div>
            </div>
        </div> 

        <!-- Services Section -->
        <section class="py-16 bg-gradient-to-br from-gray-50 to-sky-50 dark:from-gray-800 dark:to-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center justify-center p-2 bg-sky-100 dark:bg-sky-900 rounded-full mb-4">
                        <svg class="w-6 h-6 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                        Pusat Pelayanan Digital Desa Pemali
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                        Nikmati kemudahan dalam mengurus berbagai keperluan administratif dengan layanan digital yang cepat, mudah, dan terpercaya. Semua kebutuhan administrasi Anda dapat diproses dalam hitungan menit.
                    </p>
                    <div class="mt-8 flex flex-wrap justify-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Proses Cepat</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Online</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Terjamin Aman</span>
                        </div>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($jenisSurat as $index => $js)   
                        <a href="{{ route('pengajuan.form', $js->slug) }}" 
                           class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-sky-200 dark:hover:border-sky-600 transform hover:-translate-y-1">
                            
                            <!-- Card Header dengan Gradient -->
                            <div class="bg-gradient-to-r from-sky-500 to-blue-600 h-20 relative overflow-hidden">
                                <div class="absolute inset-0 bg-black/10"></div>
                                <div class="absolute -top-6 -right-6 w-20 h-20 bg-white/20 rounded-full"></div>
                                <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-white/10 rounded-full"></div>
                            </div>
                            
                            <!-- Icon -->
                            <div class="relative -mt-8 flex justify-center">
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-full shadow-lg border-4 border-sky-100 dark:border-sky-900 group-hover:scale-110 transition-transform duration-300">
                                    @php
                                        $icons = [
                                            'fa-solid fa-user-check',
                                            'fa-solid fa-home',
                                            'fa-solid fa-id-card',
                                            'fa-solid fa-file-contract',
                                            'fa-solid fa-people-roof',
                                            'fa-solid fa-briefcase',
                                            'fa-solid fa-graduation-cap',
                                            'fa-solid fa-heart',
                                            'fa-solid fa-car',
                                            'fa-solid fa-building',
                                            'fa-solid fa-users',
                                            'fa-solid fa-certificate'
                                        ];
                                        $iconClass = $icons[$index % count($icons)];
                                    @endphp
                                    <i class="{{ $iconClass }} text-2xl text-sky-600 dark:text-sky-400"></i>
                                </div>
                            </div>
                            @php
                                $rating = round($ratingPerJenis[$js->id] ?? 0); // default 0 kalau tidak ada
                            @endphp
                            <!-- Content -->
                            <div class="px-6 py-6 text-center">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors duration-300">
                                    {{ $js->nama }}
                                </h3>
                                <div class="flex justify-center items-center mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star text-yellow-400"></i>
                                    @endfor
                                    @if ($ratingPerJenis[$js->id] ?? false)
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">
                                            {{ number_format($ratingPerJenis[$js->id], 1) }}
                                        </span>
                                    @endif
                                </div>
                                <div class=" hidden md:block">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                        Ajukan {{ strtolower($js->nama) }} secara online dengan mudah dan cepat
                                    </p>
                                    
                                    <!-- CTA Button -->
                                    <div class="inline-flex items-center text-sky-600 dark:text-sky-400 font-medium text-sm group-hover:text-sky-700 dark:group-hover:text-sky-300 transition-colors duration-300">
                                        <span>Ajukan Sekarang</span>
                                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hover Effect Border -->
                            <div class="absolute inset-0 border-2 border-transparent group-hover:border-sky-300 dark:group-hover:border-sky-500 rounded-2xl transition-colors duration-300 pointer-events-none"></div>
                        </a>
                    @endforeach
                </div>

                <!-- Bottom CTA Section -->
                {{-- <div class="mt-16 text-center">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 max-w-2xl mx-auto border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-center mb-4">
                            <div class="bg-sky-100 dark:bg-sky-900 p-3 rounded-full">
                                <svg class="w-8 h-8 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Butuh Bantuan?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Tim customer service kami siap membantu Anda 24/7 untuk menjawab pertanyaan seputar layanan surat desa.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="#" class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700 transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Hubungi Kami
                            </a>
                            <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-sky-600 text-sky-600 dark:text-sky-400 font-medium rounded-lg hover:bg-sky-50 dark:hover:bg-sky-900/20 transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Panduan Lengkap
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
    </main>

    <style>
        @media (max-width: 768px) {
          .relative.overflow-hidden.mx-auto.w-\[80%\] {
            width: 240px;
            height: 372px;
          }
          .w-\[200px\] {
            width: 230px;
            height: 350px;
          }
        }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const carousel = document.getElementById("carousel");
        // Periksa apakah elemen carousel ada sebelum melanjutkan
        if (!carousel) return; 

        const images = carousel.querySelectorAll("img");
        const prevButton = document.getElementById("prev");
        const nextButton = document.getElementById("next");
        const dots = document.querySelectorAll(".dot");
        
        // Jika tidak ada gambar, hentikan eksekusi script
        if (images.length === 0) return;

        let slideIndex = 0;
        const totalSlides = images.length;

        // Satu fungsi untuk mengurus semua pembaruan tampilan
        function updateCarousel() {
            // Geser slide
            carousel.style.transform = `translateX(-${slideIndex * 100}%)`;
            
            // Perbarui dot yang aktif
            dots.forEach((dot, index) => {
                if (index === slideIndex) {
                    dot.classList.add("bg-gray-800");
                    dot.classList.remove("bg-gray-300");
                } else {
                    dot.classList.remove("bg-gray-800");
                    dot.classList.add("bg-gray-300");
                }
            });
        }

        // Fungsi untuk slide berikutnya
        function showNextSlide() {
            slideIndex = (slideIndex + 1) % totalSlides;
            updateCarousel();
        }
        
        // Fungsi untuk slide sebelumnya
        function showPrevSlide() {
            slideIndex = (slideIndex - 1 + totalSlides) % totalSlides;
            updateCarousel();
        }

        // Event listener untuk tombol next dan prev
        if (nextButton) {
            nextButton.addEventListener("click", showNextSlide);
        }
        if (prevButton) {
            prevButton.addEventListener("click", showPrevSlide);
        }

        // Mulai slideshow otomatis setiap 10 detik
        setInterval(showNextSlide, 10000);

        // Inisialisasi tampilan awal
        updateCarousel();
    });
    </script>

@endsection