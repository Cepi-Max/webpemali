@extends('public-user.layouts.main.app')

@section('content')

<div class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-900 shadow-md border border-gray-200 dark:border-gray-700 rounded-xl mt-[7.5rem] text-sky-950 dark:text-gray-200 transition-all duration-300">
  <span class="text-xl sm:text-2xl lg:text-3xl font-bold">Pengumuman Desa Pemali</span>
</div>


<main class="mx-auto w-[90%]">

    {{-- <div class="">
        <!-- Penngumuman Besar -->
        <div class="md:col-span-2 h-48 rounded-lg bg-black bg-opacity-50">
          <img src="{{ asset('storage/images/publicImg/announcement/announcementImg/default.png') }}" alt="Penngumuman Besar" class="w-20 h-20 object-cover">
          <div class="inset-0 flex flex-col justify-end p-6">
            <span class="bg-green-700 text-white text-xs font-bold px-2 py-1 rounded">Penngumuman</span>
            <h2 class="text-white text-2xl font-bold mt-2">IRONI MAHASISWA SAAT INI, KRITIS DAN IDEALIS DI MEDIA SOSIAL TAPI NYATANYA APATIS!</h2>
            <p class="text-white text-sm">BY ADMIN ● JANUARI 29, 2025</p>
          </div>
        </div>
      
        <!-- Penngumuman Kecil Bawah Kiri -->
        <div class="w-[50%] h-40 rounded-lg bg-black bg-opacity-50 mt-3">
          <img src="{{ asset('storage/images/publicImg/announcement/announcementImg/default.png') }}" alt="Penngumuman Kecil" class="w-20 h-20 object-cover">
          <div class="inset-0 flex flex-col justify-end p-4">
            <span class="bg-green-700 text-white text-xs font-bold px-2 py-1 rounded">Penngumuman</span>
            <h3 class="text-white text-lg font-semibold">Kunjungan Kerja Mendidkasmen dan Milad Muhammadiyah ke-112 di Bangka Belitung</h3>
          </div>
        </div>
    </div> --}}
      
    <div class="max-w-6xl mx-auto mt-6">
        <div class="grid md:grid-cols-4 gap-6">
            <!-- Berita 1 -->
            @foreach ($announcements as $announcement)    
            <a href="{{ route('show.announcement.detail', $announcement->slug) }}">
                <div class="flex flex-col justify-between max-w-sm h-full rounded overflow-hidden bg-white dark:bg-gray-900 p-4 rounded-lg shadow transition-all duration-100 hover:-translate-y-1 hover:shadow-2xl">
                    <img src="{{ asset('storage/images/publicImg/announcement/announcementImg/'. $announcement->image) }}" alt="Berita 1" class="w-full h-40 object-cover rounded">
                    <h2 class="font-semibold text-lg text-sky-950 dark:text-gray-200">{{ \Illuminate\Support\Str::limit($announcement->title, 30) }}</h2>
                    <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($announcement->created_at)->translatedFormat('l, d-F-Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="mt-3">
      {{ $announcements->links() }}
    </div>
   @include('public-user.layouts.map.map')
</main>

@endsection