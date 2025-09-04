@extends('public-user.layouts.main.app')

@section('content') 
    <main class="mx-auto w-[90%] pt-[6.5rem] md:pt-[7rem]">
        <div class="grid grid-cols-1 md:grid-cols-[60%_40%] gap-4 p-4 md:px-10 md:py-6 mt-4 shadow-xl bg-gray-100 dark:bg-gray-900 rounded-lg">
            <div class="p-4 text-sky-950 dark:text-gray-200">
                <h2 class="text-2xl font-bold">{{ $detailumkm->umkm_name }}</h2>
                <p class="text-sm mt-2">
                    {{ $detailumkm->description }}
                    {{-- Nasi lemak Kak Ros cocok disajikan untuk sarapan dan makan siang bergizi, lezat, dan mengenyangkan. --}}
                </p>
                
                <div class="flex items-stretch items-end gap-4 mt-4 text-sm">
                    <span class="font-bold">Kategori : {{ $detailumkm->umkm_sector->name }}</span> | 
                    <span class="font-bold">Ulasan ({{ $totalComments }})</span> 
                    |<span class="font-bold"></span>
                </div>
                
                <div class="flex items-center mt-3 text-yellow-400 text-lg">⭐⭐⭐⭐⭐</div>
                
                <div class="flex justify-between items-center mt-4">
                    <a href=" https://wa.me/{{ $detailumkm->number_phone }}" target="_blank" class="bg-sky-950 text-white px-2 lg:px-4 text-sm py-2 rounded hover:bg-[#5A4A20] transition-all">
                        Hubungi Penjual
                    </a>
                    <h2 class="font-bold text-2xl">{{ rupiah($detailumkm->product_price) }}</h2>
                </div>
            </div>
            <div class="relative w-full h-64 rounded-md overflow-hidden shadow-lg">
                <img src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $detailumkm->image) }}" alt="Gambar UMKM" class="w-full h-full object-cover">
            </div>
        </div>
        <h2 class="text-sky-950 dark:text-gray-200 text-2xl font-bold mb-4 mt-6">Ulasan</h2>
        <div class="p-6 rounded-lg shadow-lg bg-gray-100 dark:bg-gray-900">
            <ul class="space-y-4">
                @forelse ($previewComments as $comment)
                <li>
                    <div class="flex px-2 py-1">
                        {{-- <div>
                          <img src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $detailumkm->image) }}" class="w-8 h-8 rounded-full me-3" alt="xd">
                        </div> --}}
                        <div>
                            <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-lg max-w-64 p-2"> 
                                <div class="flex flex-col justify-center ml-3">
                                  <h6 class="mb-0 text-sm font-semibold">{{ $comment->user->name }}</h6>
                                  <p class="text-sm text-sky-950 dark:text-gray-200">{{ $comment->content }}</p>
                                </div>
                            </div>
                            <div class="flex gap-4 ml-3">
                                <p class="text-sm text-sky-950 dark:text-gray-200">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>               
                  </li>
                @empty
                    <p class="text-gray-500">Belum ada komentar.</p>
                @endforelse
                {{-- Tombol Lihat Semua --}}
                @if($allComments->count() > 3)
                <button onclick="document.getElementById('modalKomentar').classList.remove('hidden')" 
                        class="text-sm text-blue-600 hover:underline">
                    Lihat semua komentar ({{ $allComments->count() }})
                </button>
                @endif
              <hr class="text-sky-950 dark:text-gray-200 font-semibold">
            </ul>
            @auth
                <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="umkm_id" value="{{ $detailumkm->id }}">
                    <textarea name="content" id="content" rows="3"
                    class="w-full bg-gray-200 dark:bg-gray-700 border border-gray-400 dark:border-gray-500 text-gray-900 dark:text-gray-100 text-sm rounded-xl p-3 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 resize-none"
                    placeholder="Tulis komentar..."></textarea>
                    <button type="submit" class="mt-2 bg-sky-950 hover:bg-sky-900 text-white px-4 py-2 rounded">Kirim</button>
                </form>
            @endauth
        </div>
       <div class="mt-6">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
            @foreach ($umkms as $lu)  
            <a href="{{ route('show.umkm.details', $lu->slug) }}" class="block">
                <div class="flex flex-col justify-between max-w-sm h-full rounded overflow-hidden bg-white dark:bg-gray-900 rounded-md shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                    <img class="w-full object-cover h-40 md:h-48 lg:h-48" src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $lu->image) }}" alt="Sunset in the mountains">
                    <div class="px-2 py-4">
                        <div class="font-bold text-dark dark:text-gray-200 text-l mb-2">{{ \Illuminate\Support\Str::limit($lu->umkm_name, 21) }}</div>
                    </div>
                    <div class="sm:flex justify-between mb-2 text-gray-700 p-1">
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
                        <div class="flex justify-end dark:text-gray-200">
                            <p>Rp. {{ $lu->product_price }}</p>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            </div>
        </div>
        @include('public-user.layouts.map.map')     
    </main>

    @include('public-user.umkm.modal')




    {{-- <main class="mx-auto w-[90%] max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-[60%_40%] gap-4 p-4 md:px-10 md:py-6 mt-4 shadow-xl bg-gray-100 dark:bg-gray-900 rounded-lg">
            <div class="p-4 text-sky-950 dark:text-gray-200">
                <h2 class="text-2xl font-bold">Nasi Lemak Kak Ros</h2>
                <p class="text-sm mt-2">
                    Nasi lemak Kak Ros cocok disajikan untuk sarapan dan makan siang bergizi, lezat, dan mengenyangkan.
                </p>
                
                <div class="flex items-center justify-between mt-4 text-sm">
                    <span class="font-bold">Kategori</span> | 
                    <span class="font-bold">Ulasan (0)</span> | 
                    <span class="font-bold">👍</span>
                </div>
                
                <div class="flex items-center mt-3 text-yellow-400 text-lg">⭐⭐⭐⭐⭐</div>
                
                <div class="flex justify-between items-center mt-4">
                    <button class="bg-sky-950 text-white px-4 py-2 rounded hover:bg-[#5A4A20] transition-all">
                        Hubungi Penjual
                    </button>
                    <h2 class="font-bold text-2xl">Rp. {{ $detailumkm->product_price }}</h2>
                </div>
            </div>
            <div class="relative w-full h-64 rounded-md overflow-hidden shadow-lg">
                <img src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $detailumkm->image) }}" alt="Gambar UMKM" class="w-full h-full object-cover">
            </div>
        </div>
        
        <h2 class="text-sky-950 dark:text-gray-200 text-2xl font-bold mb-4 mt-6">Ulasan</h2>
        <div class="p-6 rounded-lg shadow-lg bg-gray-100 dark:bg-gray-900">
            <ol class="space-y-4">
                @foreach ($reviews as $review)
                <li>
                    <div class="flex px-2 py-1">
                        <img src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $review->user_image) }}" class="w-8 h-8 rounded-full me-3" alt="User">
                        <div>
                            <div class="bg-white dark:bg-gray-900 rounded-lg p-2 shadow">
                                <h6 class="mb-0 text-sm font-semibold">{{ $review->user_name }}</h6>
                                <p class="text-sm">{{ $review->comment }}</p>
                            </div>
                            <div class="flex gap-4 ml-3 text-xs text-gray-600">
                                <p>{{ $review->created_at->diffForHumans() }}</p>
                                <p>Like</p>
                            </div>
                        </div>
                    </div>  
                </li>
                <hr>
                @endforeach
            </ol>
        </div>
        
        <div class="mt-6">
            <div class="p-2 bg-sky-950 text-white rounded-md text-center">
                <h2 class="text-lg font-bold">UMKM Lainnya &gt;</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                @foreach ($umkms as $umkm)
                <a href="#" class="block">
                    <div class="flex flex-col rounded-md shadow-md bg-white dark:bg-gray-900 hover:-translate-y-2 transition-all overflow-hidden">
                        <img class="w-full object-cover h-40" src="{{ asset('storage/images/publicImg/umkm/umkmImg/'. $umkm->image) }}" alt="{{ $umkm->umkm_name }}">
                        <div class="p-2">
                            <div class="font-bold text-lg">{{ \Illuminate\Support\Str::limit($umkm->umkm_name, 21) }}</div>
                            <div class="flex justify-between items-center text-gray-700 text-sm">
                                <div class="flex text-yellow-400">⭐⭐⭐⭐⭐</div>
                                <p>Rp. {{ $umkm->product_price }}</p>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        
        @include('public-user.layouts.map.map')     
    </main> --}}
    

@endsection