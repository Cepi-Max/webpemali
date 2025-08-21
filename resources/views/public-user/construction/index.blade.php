@extends('public-user.layouts.main.app')

@section('content')

<div class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-900 shadow-md border border-gray-200 dark:border-gray-700 rounded-xl mt-[7.5rem] text-sky-950 dark:text-gray-200 transition-all duration-300">
    <span class="text-xl sm:text-2xl lg:text-3xl font-bold">Pembangunan Desa Pemali</span>
  </div>

<main class="mx-auto w-[90%]">
    <div class="max-w-6xl mx-auto mt-6">
        <div class="grid md:grid-cols-4 gap-6">
            <!-- Berita 1 -->
            @foreach ($constructions as $construction)    
            <a href="{{ route('show.construction.detail', $construction->slug) }}">
                <div class="flex flex-col justify-between max-w-sm h-full rounded overflow-hidden bg-white dark:bg-gray-900 p-4 rounded-lg shadow transition-all duration-100 hover:-translate-y-1 hover:shadow-2xl">
                    <img src="{{ asset('storage/images/publicImg/construction/constructionImg/'. $construction->image) }}" alt="Berita 1" class="w-full h-40 object-cover rounded">
                    <h2 class="font-semibold text-lg text-sky-950 dark:text-gray-200">{{ \Illuminate\Support\Str::limit($construction->title, 30) }}</h2>
                    <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($construction->created_at)->translatedFormat('l, d-F-Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="mt-3">
      {{ $constructions->links() }}
    </div>
   @include('public-user.layouts.map.map')
</main>

@endsection