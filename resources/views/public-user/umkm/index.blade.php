@extends('public-user.layouts.main.app')

@section('content')

<div class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-900 shadow-md border border-gray-200 dark:border-gray-700 rounded-xl mt-[7.5rem] text-sky-950 dark:text-gray-200 transition-all duration-300">
    <span class="text-xl sm:text-2xl lg:text-3xl font-bold">UMKM Desa Pemali</span>
</div>  

<main class="mx-auto w-[90%]">
  <div class="grid grid-cols-2 lg:grid-cols-3 md:grid-cols-2 gap-6 mt-6">
      @foreach ($umkms as $umkm)
        <a href="{{ route('show.umkm.details', $umkm->slug) }}" class="block">
            <div class="flex flex-col justify-between h-full max-w-sm rounded overflow-hidden bg-white dark:bg-gray-900 rounded-md shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                <img src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $umkm->image) }}" class="w-full object-cover h-40 md:h-48 lg:h-64" alt="gambar umkm">
                <div class="px-2 py-4">
                    <div class="font-bold text-l mb-2 text-black dark:text-gray-200">{{ \Illuminate\Support\Str::limit($umkm->umkm_name, 21) }}</div>
                </div>
                <div class="flex justify-between mb-2 text-gray-700 dark:text-gray-300 p-1">
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
                    <div>
                        <p class="text-black dark:text-gray-200">{{ rupiah($umkm->product_price) }}</p>
                    </div>
                </div>
            </div>
        </a>
      @endforeach
  </div>
  <div class="mt-3">
    {{ $umkms->links() }}
  </div>
  @include('public-user.layouts.map.umkmMap')    
  {{-- @include('public-user.layouts.map.map')     --}}
</main>

@endsection
