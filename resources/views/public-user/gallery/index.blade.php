@extends('public-user.layouts.main.app')

@section('content')

@php
    $imageUrls = $galleries->map(fn($g) => asset('storage/images/publicImg/gallery/galleryImg/' . $g['image']))->toArray();
    $imageJudul = $galleries->map(fn($g) => $g['title'])->toArray();
@endphp

<div class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-900 shadow-md border border-gray-200 dark:border-gray-700 rounded-xl mt-[7.5rem] text-sky-950 dark:text-gray-200 transition-all duration-300">
  <span class="text-xl sm:text-2xl lg:text-3xl font-bold">Galeri Desa Pemali</span>
</div>

<main class="mx-auto w-[90%]">
  <div class="container mx-auto py-10 px-5 h-full">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          @foreach ($galleries as $index => $g)
            <div class="overflow-hidden rounded-2xl shadow-lg transform hover:scale-105 transition duration-300">
                <img src="{{ asset('storage/images/publicImg/gallery/galleryImg/' . $g->image) }}" alt="{{ $g->title }}" 
                    class="w-full h-60 object-cover"
                    onclick="openImageByIndex({{ $index }})">
            </div>
          @endforeach
      </div>
  </div>
  <div class="mt-3">
    {{ $galleries->links() }}
  </div>
@include('public-user.layouts.map.map')
</main>



<!-- Modal -->
<div id="imageModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-98 z-50">
  <!-- Modal Title -->
    <div class="absolute top-0 left-0 w-full bg-black bg-opacity-100 flex justify-between items-center p-4 z-40 rounded-t-lg">
      <p id="imageTitle" class="text-white text-xl ml-20 truncate"></p>
      <button class="text-white text-xl mr-4 bg-white bg-opacity-20 p-2 rounded-lg w-10 h-10 flex justify-center items-center hover:bg-red-500 transition-all duration-300" onclick="closeImage()">
        <span class="text-2xl">&times;</span>
      </button>
    </div>
  <!-- Modal Content -->
  <div class="relative">
    
    <!-- Modal Image -->
    <div class="p-4">
      <img id="modalImage" class="max-w-full max-h-[80vh] object-contain rounded-lg" src="" alt="Detail Image">
    </div>
    {{-- Thumbnails Below Prevesos Image --}}
    {{-- <div class="p-4 grid grid-cols-3 gap-4 max-w-[100%]">
      <div class="flex justify-center">
        <img id="prevThumbnail" class="h-[60px] w-[60px] object-cover rounded-lg cursor-pointer hover:opacity-75 transition-all duration-300" src="" alt="" onclick="changeMainImagePrev()">
      </div>
      <div class="flex justify-center">
        <img id="nextThumbnail" class="h-[60px] w-[60px] object-cover rounded-lg cursor-pointer hover:opacity-75 transition-all duration-300" src="" alt="" onclick="changeMainImageNext()">
      </div>
    </div> --}}
  </div>
   <!-- Thumbnail Navigation (Before and After) -->
    <div class="absolute top-1/2 left-0 w-full flex justify-between p-4 z-40">
      <button class="text-white text-xl p-2 rounded-lg w-10 hover:bg-white hover:bg-opacity-20 transition-all duration-300" onclick="showPreviousImage()">&#9664;</button>
      <button class="text-white text-xl p-2 rounded-lg w-10 hover:bg-white hover:bg-opacity-20 transition-all duration-300" onclick="showNextImage()">&#9654;</button>
    </div>
</div>

<script>
    const imageUrls = {!! json_encode($imageUrls) !!};
    const imageJudul = {!! json_encode($imageJudul) !!};
    let currentIndex = 0;

    function openImageByIndex(index) {
      currentIndex = index;
      document.getElementById('modalImage').src = imageUrls[currentIndex];
      document.getElementById('imageTitle').textContent = imageJudul[currentIndex];
      document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImage() {
      document.getElementById('imageModal').classList.add('hidden');
    }

    function showPreviousImage() {
      currentIndex = (currentIndex - 1 + imageUrls.length) % imageUrls.length;
      document.getElementById('modalImage').src = imageUrls[currentIndex];
      document.getElementById('imageTitle').textContent = imageJudul[currentIndex];
    }

    function showNextImage() {
      currentIndex = (currentIndex + 1) % imageUrls.length;
      document.getElementById('modalImage').src = imageUrls[currentIndex];
      document.getElementById('imageTitle').textContent = imageJudul[currentIndex];
    }
    document.getElementById('imageModal').addEventListener('click', function (event) { 
            if (event.target.id === 'imageModal') {
              closeImage();
        }
     });
</script>

@endsection
