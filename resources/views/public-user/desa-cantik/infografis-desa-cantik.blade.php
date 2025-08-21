@extends('public-user.layouts.main.app')

@section('content')

<div class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-900 shadow-md border border-gray-200 dark:border-gray-700 rounded-xl mt-[7.5rem] text-sky-950 dark:text-gray-200 transition-all duration-300">
    <span class="text-xl sm:text-2xl lg:text-3xl font-bold">Infografis Desa Cantik</span>
</div>  

<div x-data="gallery()" @keydown.escape.window="closeModal()" class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      @forelse ($infografis as $index => $ig)
      <div
        class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 cursor-pointer"
        @click="openModal({{ $index }})"
      >
        <img src="{{ asset('storage/images/publicImg/infografis/' . $ig->file_infografis) }}" alt="{{ $ig->judul }}" class="w-full h-80 object-cover">
        <div class="p-6">
          <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ $ig->judul }}</h2>
          <p class="text-gray-600 truncate">{{ $ig->deskripsi }}</p>
        </div>
      </div>
      @empty
      <p class="col-span-4 text-center text-gray-500">Tidak ada infografis tersedia.</p>
      @endforelse
    </div>

    <!-- Fullscreen Modal Overlay -->
    <div
      x-show="isOpen"
      x-transition.opacity
      class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
      style="display: none;"
    >
      <!-- Inner Modal Container (stop click propagation) -->
      <div @click.stop class="relative w-full h-full flex items-center justify-center">
        <!-- Close Button -->
        <button
          @click="closeModal()"
          class="absolute top-4 right-4 z-30 p-2 bg-gray-700 bg-opacity-50 rounded-full hover:bg-opacity-75 text-white focus:outline-none focus:ring-2 focus:ring-white"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <!-- Image & Controls Fullscreen -->
        <div class="absolute inset-0 overflow-hidden bg-black flex items-center justify-center">
          <!-- Navigation Controls Overlay -->
          <div class="absolute inset-y-0 left-0 flex items-center px-4 z-20">
            <button @click="prev()" class="p-2 bg-gray-700 bg-opacity-50 rounded-full hover:bg-opacity-75 text-white focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
          </div>
          <div class="absolute inset-y-0 right-0 flex items-center px-4 z-20">
            <button @click="next()" class="p-2 bg-gray-700 bg-opacity-50 rounded-full hover:bg-opacity-75 text-white focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
          <!-- Zoom Controls Overlay -->
          <div class="absolute bottom-6 right-6 flex items-center z-20 space-x-2">
            <button @click="zoomOut()" class="p-2 bg-gray-700 bg-opacity-50 rounded-full hover:bg-opacity-75 text-white focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
              </svg>
            </button>
            <span class="text-white font-medium bg-gray-700 bg-opacity-50 px-2 py-1 rounded" x-text="Math.round(zoom * 100) + '%'">100%</span>
            <button @click="zoomIn()" class="p-2 bg-gray-700 bg-opacity-50 rounded-full hover:bg-opacity-75 text-white focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
              </svg>
            </button>
          </div>
          <!-- Fullscreen Image -->
          <img
            :src="images[current].src"
            :alt="images[current].judul"
            :style="`transform: scale(${zoom}) translate(${panX}px, ${panY}px)`"
            class="object-contain w-full h-full cursor-grab relative z-10"
            @mousedown="startDrag($event)"
            @mouseup="stopDrag()"
            @mousemove="onDrag($event)"
            @wheel.prevent="onWheel($event)"
          />
        </div>
      </div>
    </div>
  </div>

  <script>
    function gallery() {
      return {
        isOpen: false,
        current: 0,
        zoom: 1,
        panX: 0,
        panY: 0,
        dragStartX: 0,
        dragStartY: 0,
        isDragging: false,
        images: @json($infografis->map(fn($ig) => [
          'src' => asset('storage/images/publicImg/infografis/' . $ig->file_infografis),
          'judul' => $ig->judul,
          'deskripsi' => $ig->deskripsi
        ])),
        openModal(idx) {
          this.current = idx;
          this.zoom = 1;
          this.panX = 0;
          this.panY = 0;
          this.isOpen = true;
        },
        closeModal() {
          this.isOpen = false;
        },
        prev() {
          this.current = this.current > 0 ? this.current - 1 : this.images.length - 1;
          this.resetView();
        },
        next() {
          this.current = this.current < this.images.length - 1 ? this.current + 1 : 0;
          this.resetView();
        },
        zoomIn() {
          this.zoom = Math.min(this.zoom + 0.2, 5);
        },
        zoomOut() {
          this.zoom = Math.max(this.zoom - 0.2, 1);
          this.panX = 0;
          this.panY = 0;
        },
        onWheel(event) {
          this.zoom += event.deltaY < 0 ? 0.1 : -0.1;
          this.zoom = Math.max(1, Math.min(this.zoom, 5));
        },
        startDrag(event) {
          this.isDragging = true;
          this.dragStartX = event.clientX - this.panX;
          this.dragStartY = event.clientY - this.panY;
        },
        onDrag(event) {
          if (!this.isDragging) return;
          this.panX = event.clientX - this.dragStartX;
          this.panY = event.clientY - this.dragStartY;
        },
        stopDrag() {
          this.isDragging = false;
        },
        resetView() {
          this.zoom = 1;
          this.panX = 0;
          this.panY = 0;
        }
      }
    }
  </script>

@endsection