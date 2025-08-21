@extends('public-user.layouts.main.app')

@section('content')
    <!-- <div class="p-[2px] inline-block w-full h-10 mt-2">
        <div class="p-2 bg-[#D98324] w-full h-full flex justify-between items-center">
            <marquee class="text-lg text-sky-950 font-semibold" direction='left' >Selamat Datang Di Website Resmi Desa Pemali</marquee>
        </div>
    </div> -->
    <main class="mx-auto w-[90%] pt-[6.5rem] md:pt-[7rem]">
        <div class="grid grid-cols-1 lg:grid-cols-[70%_30%] gap-5 p-3 w-full mx-auto lg:px-10 lg:py-4 mt-4 shadow-lg bg-white dark:bg-gray-900 rounded-lg">
            <!-- Kolom 1: Kiri -->
            <div class="row">
                <div class="relative w-full overflow-hidden rounded-lg shadow-lg bg-white dark:bg-gray-700 h-64">
                    <div id="carousel-container" class="relative overflow-hidden w-full h-64">
                      <div id="carousel" class="flex transition-transform duration-1000 ease-in-out w-full h-full">
                        @forelse ($bannerImg as $banner)
                          <!-- Setiap item carousel harus memiliki lebar 100% dari container -->
                          <div class="w-full flex-shrink-0 h-full">
                            @if ($banner->link)
                              <a href="{{ $banner->link }}" class="block w-full h-full">
                                <img src="{{ asset('storage/images/general/bannerImg/' . $banner->bannerImg) }}" 
                                     class="w-full h-full object-cover" alt="gambar banner">
                              </a>
                            @else
                              <img src="{{ asset('storage/images/general/bannerImg/' . $banner->bannerImg) }}" 
                                   class="w-full h-full object-cover" alt="gambar banner">
                            @endif
                          </div>
                        @empty
                          <div class="w-full flex-shrink-0 h-full">
                            <img src="storage/images/general/bannerImg/default.jpg" 
                                 class="w-full h-full object-cover" alt="gambar banner">
                          </div>
                        @endforelse
                      </div>
                    </div>
                    
                    <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-opacity-30 bg-gray-600 text-white p-2 rounded-full shadow-lg hover:bg-gray-900 hover:bg-opacity-90 transition">&#10094;</button>
                    <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-opacity-30 bg-gray-600 text-white p-2 rounded-full shadow-lg hover:bg-gray-900 hover:bg-opacity-90 transition">&#10095;</button>
                    
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                      @foreach ($bannerImg as $index => $banner)
                        <span class="dot w-2 h-2 rounded-full bg-opacity-50 cursor-pointer {{ $index === 0 ? 'bg-gray-800' : 'bg-gray-300' }}"></span>
                      @endforeach
                    </div>
                </div>

                <div class="my-3">
                    <div class="inline lg:hidden flex flex-col justify-between rounded-md p-3">
                        {{-- <a class="border-[1px] border-[#2B4F60] bg-[#2B4F60] hover:bg-cyan-800 text-[#FAF3E0] text-center text-xs py-4 font-bold py-2 px-4 rounded mx-[20%] rounded-lg" href="#">Permintaan Pin <i class="fa-solid fa-phone"></i></a> --}}
                        <a class="border-[1px] border-[#2B4F60] bg-[#2B4F60] hover:bg-cyan-800 text-[#FAF3E0] text-center text-xs py-4 font-bold py-2 px-4 rounded mt-2 mx-[20%] rounded-lg" href="{{ route('show.community-services.dashboard') }}">Pelayanan Mandiri <i class="fa-solid fa-arrow-right font-bold"></i></a>
                    </div>
                </div>

                <div class="mt-2 md:mt-6 sm:mt-6">
                    <div class="p-[2px] inline-block w-full h-10">
                        <div class="p-2 bg-sky-950 dark:bg-gray-700 w-full h-full flex justify-between items-center rounded-md">
                            <h2 class="text-lg text-white dark:text-gray-200 font-bold">Produk UMKM &gt;</h2>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                    @foreach ($latestUmkm as $lu)  
                    <a href="{{ route('show.umkm.details', $lu->slug) }}" class="block">
                        <div class="flex flex-col justify-between max-w-sm h-full rounded overflow-hidden bg-white dark:bg-gray-800 rounded-md shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                            <img class="w-full object-cover h-40 md:h-40 lg:h-48" src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $lu->image) }}" alt="Sunset in the mountains">
                            <div class="px-2 py-3">
                                <div class="font-bold text-l mb-2 dark:text-gray-200">{{ \Illuminate\Support\Str::limit($lu->umkm_name, 21) }}</div>
                            </div>
                            <div class="sm:flex justify-between mb-2 text-gray-700 dark:text-gray-300 p-1">
                                <div class="flex mt-1 text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01z"/>
                                    </svg>
                                </div>
                                <div class="flex justify-end">
                                    <p>{{ rupiah($lu->product_price) }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    </div>
                </div>
                <div class="mt-6">
                    <div class="p-[2px] inline-block w-full h-10 mb-4">
                        <div class="p-2 bg-sky-950 dark:bg-gray-700  w-full h-full flex justify-between items-center rounded-md">
                            <h2 class="text-lg text-white dark:text-gray-200 font-bold">Artikel Terpopuler &gt;</h2>
                        </div>
                    </div>
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 w-full flex justify-center md:justify-between lg:justify-between overflow-hidden">
                    @foreach ($popularArticle as $article)
                    <a href="{{ route('show.article.detail', $article->slug) }}">
                    <div class="relative w-full h-52 rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('storage/images/publicImg/article/articleImg/'. $article->image) }}" alt="Article Image" class="w-full flex-shrink-0 object-cover h-64">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-end p-4">
                          <h2 class="text-white dark:text-gray-300 text-xl font-bold">{{  $article->title }}</h2>
                          <p class="text-white dark:text-gray-300 text-sm">{{ $article->created_at }}</p>
                        </div>
                    </div>
                    </a>
                    @endforeach
                    </div>
                </div>
                <div class="carousel-wrap mt-6">
                    <div class="p-[2px] inline-block w-full h-10 mb-4">
                      <div class="p-2 bg-sky-950 dark:bg-gray-700 w-full h-full flex justify-between items-center rounded-md">
                        <h2 class="text-lg text-white dark:text-gray-200 font-bold">Aparatur Desa &gt;</h2>
                      </div>
                    </div>

                    <div class="relative w-full flex items-center justify-center">
                        <!-- Tombol Kiri -->
                        <button id="prevBtn" class="absolute left-0 z-10 dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3" class="size-5 md:size-6 pr-0.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        </button>
                      
                        <!-- Carousel Container -->
                        <div id="cCarousel-wrapper" class="overflow-hidden w-[90%]">
                          <div id="cCarousel-inner"
                            class="flex gap-4 overflow-x-hidden scroll-smooth snap-x snap-mandatory items-center w-full px-10 scrollbar-hide touch-pan-x">
                            
                            @foreach($officials as $ap)
                            <article class="cCarousel-item w-[220px] h-[330px] border-4 border-sky-950 dark:border-gray-800 rounded-xl overflow-hidden flex flex-col snap-center shrink-0 transition-transform bg-white">
                              <img src="{{ asset('storage/images/publicImg/official/officialImg/' . $ap->image) }}" 
                                alt="Foto aparatur desa"
                                class="w-full object-cover min-h-[246px] text-white dark:text-gray-300" />
                              <div class="h-full flex flex-col items-center justify-around bg-[#2B4F60] dark:bg-gray-700 text-white dark:text-gray-300 shadow-md p-2.5 text-center">
                                <h3 class="border-b border-white/50">{{ $ap->name }}</h3>
                                <h4>{{ $ap->position }}</h4>
                                <h4>{{ $ap->number_phone }}</h4>
                              </div>
                            </article>
                            @endforeach
                      
                          </div>
                        </div>
                      
                        <!-- Tombol Kanan -->
                        <button id="nextBtn" class="absolute right-0 z-10 dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3" class="size-5 md:size-6 pl-0.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                      
                </div>
            </div>

            <!-- Kolom 2: kanan-->
            <div class="row h-full">
                <div class="hidden lg:flex flex-col justify-between rounded-md p-3">
                    {{-- <a class="border-[1px] border-[#2B4F60] bg-[#2B4F60] hover:bg-cyan-800 text-[#FAF3E0] text-center font-bold py-2 px-4 rounded mx-6 rounded-lg" href="#">Permintaan Pin <i class="fa-solid fa-phone"></i></a> --}}
                    <a class="border-[1px] border-[#2B4F60] bg-[#2B4F60] hover:bg-cyan-800 text-[#FAF3E0] text-center font-bold py-2 px-4 rounded mt-2 mx-6 rounded-lg" href="{{ route('show.community-services.dashboard') }}">Pelayanan Mandiri <i class="fa-solid fa-arrow-right font-bold"></i></a>
                </div>
                <div class="sticky top-[7rem]">
                    <section class="rounded-md mt-3 pb-8 bg-gray-300 dark:bg-gray-800">
                        <div class="p-[2px] inline-block w-full h-10">
                            <div class="p-2 bg-sky-950 dark:bg-gray-900 w-full h-full flex justify-between items-center rounded-md shadow-lg">
                                <h2 class="text-lg text-white dark:text-gray-200 font-bold">Informasi Terkini &gt;</h2>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            {{-- Sub pengumuman --}}
                            <div class="space-y-4 px-6 lg:px-2">
                                <h3 class="text-l font-semibold text-sky-950 dark:text-gray-300 border-b-2 border-sky-950 dark:border-gray-300 pb-2">Pengumuman</h3>
                            </div>
                            <div class="space-y-4 px-6 lg:px-2 max-h-[50vh] overflow-y-auto">
                                @foreach ($latestAnnouncements as $la)
                                <a href="{{ route('show.announcement.detail', $la->slug) }}">
                                    <div class="group bg-white dark:bg-gray-700 p-2 shadow-md mt-2 rounded-lg">
                                        <p class="hover:text-blue-600 dark:text-gray-200">{{ \Illuminate\Support\Str::limit($la->title, 30) }}</p>
                                        <div class="flex">
                                            <small class="text-gray-500 ml-2 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($la->created_at)->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>

                            {{-- Sub artikel --}}
                            <div class="space-y-4 px-6 lg:px-2 mt-8">
                                <h3 class="text-l font-semibold text-sky-950 dark:text-gray-300 border-b-2 border-sky-950 dark:border-gray-300 pb-2">Artikel & Berita</h3>
                            </div>
                            <div class="space-y-4 px-6 lg:px-2 max-h-[70vh] overflow-y-auto">
                                @foreach ($latestArticles as $la)
                                <a href="{{ route('show.article.detail', $la->slug) }}">
                                    <div class="group bg-white dark:bg-gray-700 p-2 shadow-md mt-2 rounded-lg">
                                        <p class="hover:text-blue-600 dark:text-gray-200">{{ \Illuminate\Support\Str::limit($la->title, 30) }}</p>
                                        <div class="flex">
                                            <small class="text-gray-500 dark:text-gray-300 ml-2">
                                                {{ \Carbon\Carbon::parse($la->created_at)->diffForHumans() }}
                                                {{-- {{ \Carbon\Carbon::parse($la->created_at)->translatedFormat('l, d F Y') }} --}}
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
        </div>   
       
        @include('public-user.layouts.map.batasdesa')
        @include('public-user.layouts.map.map')
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
        // Carousel
        document.addEventListener("DOMContentLoaded", function () {
            // Seleksi elemen carousel dan semua slide (div yang menjadi parent dari img atau a)
            const carousel = document.getElementById("carousel");
            const slideElements = carousel.querySelectorAll("div.w-full.flex-shrink-0");
            const totalSlides = slideElements.length;
            
            const prev = document.getElementById("prev");
            const next = document.getElementById("next");
            const dots = document.querySelectorAll(".dot");
            
            let slideIndex = 0;
            
            // Log untuk debugging
            //   console.log("Total slides detected:", totalSlides);
            //   slideElements.forEach((el, i) => {
            //     console.log(`Slide ${i}:`, el.innerHTML.substring(0, 50) + "...");
            //   });

            // Fungsi untuk memperbarui tampilan carousel
            function updateCarousel() {
                carousel.style.transform = `translateX(-${slideIndex * 100}%)`;
                
                // Update dots indicator
                dots.forEach((dot, i) => {
                dot.classList.toggle("bg-gray-800", i === slideIndex);
                dot.classList.toggle("bg-gray-300", i !== slideIndex);
                });
                
                console.log("Current slide:", slideIndex);
            }

            // Event listener untuk tombol navigasi
            next?.addEventListener("click", () => {
                slideIndex = (slideIndex + 1) % totalSlides;
                updateCarousel();
            });

            prev?.addEventListener("click", () => {
                slideIndex = (slideIndex - 1 + totalSlides) % totalSlides;  
                updateCarousel();
            });

            // Event listener untuk dot indicators
            dots.forEach((dot, index) => {
                dot.addEventListener("click", () => {
                slideIndex = index;
                updateCarousel();
                });
            });

            // Fungsi untuk slideshow otomatis
            function autoSlide() {
                slideIndex = (slideIndex + 1) % totalSlides;
                updateCarousel();
            }

            // Mulai slideshow otomatis jika ada lebih dari 1 slide
            let slideInterval;
            if (totalSlides > 1) {
                slideInterval = setInterval(autoSlide, 5000);
                
                // Pause slideshow saat hover pada carousel
                carousel.parentElement.addEventListener("mouseenter", () => {
                clearInterval(slideInterval);
                });
                
                carousel.parentElement.addEventListener("mouseleave", () => {
                slideInterval = setInterval(autoSlide, 5000);
                });
            }

            // Set posisi awal
            updateCarousel();
        });
        
        // Officer
        document.addEventListener("DOMContentLoaded", function () {
            const carousel = document.getElementById("cCarousel-inner");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");
            const items = document.querySelectorAll(".cCarousel-item");

            if (items.length === 0) return;

            let currentIndex = 0; 
            let itemWidth = items[0].offsetWidth + 16; 
            let startX = 0;
            let scrollLeft = 0;

            // Scroll ke tengah
            function scrollToMiddle() {
            carousel.scrollLeft = (currentIndex * itemWidth) - (carousel.clientWidth / 2) + (itemWidth / 2);
            }

            // Tombol Prev
            prevBtn.addEventListener("click", function () {
            currentIndex = Math.max(0, currentIndex - 1);
            scrollToMiddle();
            });

            // Tombol Next
            nextBtn.addEventListener("click", function () {
            currentIndex = Math.min(items.length - 1, currentIndex + 1);
            scrollToMiddle();
            });

            // Swipe gesture
            carousel.addEventListener("touchstart", (e) => {
            startX = e.touches[0].pageX;
            scrollLeft = carousel.scrollLeft;
            });

            carousel.addEventListener("touchmove", (e) => {
            const x = e.touches[0].pageX;
            const walk = (x - startX) * 2;
            carousel.scrollLeft = scrollLeft - walk;
            });
        });
    </script>

@endsection