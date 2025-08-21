@extends('public-user.layouts.main.app')

@section('content')

<main class="mx-auto w-[90%] pt-[6.5rem] md:pt-[7rem]">
    @forelse ($villageProfile as $vp)
    <div id="visi-misi" class="w-full mx-auto lg:px-60 mt-4">
        <!-- Visi -->
        <div class="bg-gray-200 rounded-lg p-6 mb-6 bg-white dark:bg-gray-900 shadow-lg">
            <h1 class="text-4xl font-bold text-sky-950 dark:text-gray-200 text-center">Visi</h1>
            <div class="text-center font-bold mt-6 text-sky-950 dark:text-gray-200">
                {!! $vp->visi !!}
            </div>
        </div>
        
        <!-- Misi -->
        <div class="bg-gray-200 rounded-lg p-6 mb-6 bg-white dark:bg-gray-900 shadow-lg">
            <h1 class="text-4xl font-bold text-sky-950 dark:text-gray-200 text-center">Misi</h1>
            <div class="text-justify font-bold mt-6 text-sky-950 dark:text-gray-200">
                {!! $vp->misi !!}
            </div>
        </div>
    </div>
    
        @if (isset($vp->sejarah))     
        <!-- Sejarah Desa--> 
        <div id="sejarah" class="w-full bg-white dark:bg-gray-900 mx-auto lg:px-10 lg:py-4 mt-6 mb-6 shadow-lg rounded-lg">
            <div class="flex gap-2">
                <i class="fa-solid fa-book text-sky-950 dark:text-gray-200 mb-4 text-xl font-bold"></i>
                <h1 class="mb-4 text-xl font-bold text-sky-950 dark:text-gray-200 text-left">Sejarah Desa Pemali</h1>
            </div>
            <div class="flex border-2 border-sky-950 rounded-lg gap-2 h-96 w-[100%] text-sky-950 dark:text-gray-200">
                <div class="p-3 w-[40%]">
                    <img class="w-full h-full rounded-lg" src="{{ asset('storage/images/publicImg/villageProfile/villageProfileImg/'. $vp->sejarah_image) }}" alt="gambar sejarah belum dimasukkan">
                </div>
                <div class="p-3 w-[60%]">
                    <div class="w-full h-full overflow-auto">{!! $vp->sejarah !!}</div>
                </div>
            </div>
        </div>
        @endif
    @empty
    @endforelse
    
    {{-- Profil Aparatur --}}
    <div id="profil-aparatur" class="w-full mx-auto lg:px-10 lg:py-10 shadow-lg bg-white dark:bg-gray-900 rounded-lg">
        <div class="flex gap-2">
            <i class="fa-solid fa-users-line text-sky-950 dark:text-gray-200 mb-4 text-xl font-bold"></i>
            <h1 class="mb-4 text-xl font-bold text-sky-950 dark:text-gray-200 text-left">Perangkat Desa & Struktur Organisasi</h1>
        </div>
        
        <div class="w-full p-4 border-2 border-sky-950 rounded-lg">
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
    
    @include('public-user/layouts/map/batasdesa')
    @include('public-user.layouts.map.map')
</main>

<script>
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