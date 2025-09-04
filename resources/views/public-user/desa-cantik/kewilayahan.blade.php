<!-- resources/views/kewilayahan/index.blade.php -->
@extends('public-user.layouts.main.app')

@section('content')
<div class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-900 shadow-md border border-gray-200 dark:border-gray-700 rounded-xl mt-[7.5rem] text-sky-950 dark:text-gray-200 transition-all duration-300">
    <span class="text-xl sm:text-2xl lg:text-3xl font-bold">Kewilayahan Desa</span>
</div>

@php
    // Prepare points for the map
    $points = $kewilayahan->map(function($d) {
        return [
            'lat' => (float) $d->latitude,
            'lng' => (float) $d->longitude,
            'label' => $d->nama_fasilitas,
            'kategori' => $d->kewilayahan_kategori->nama_kategori,
        ];
    });
@endphp

<div class="container mx-auto px-4 py-8">

    <!-- Filter Form -->
    <form method="GET" action="{{ route('show.desa-cantik.kewilayahan') }}" class="mb-6 relative flex flex-wrap items-center gap-4" autocomplete="off">
        <div class="w-full sm:w-auto">
            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori:</label>
            <select name="kategori" id="kategori" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $cat)
                    <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full sm:w-64 relative">
            <label for="search" class="block text-sm font-medium text-gray-700">Cari Fasilitas:</label>
            <input
                type="text"
                name="search"
                id="search"
                value="{{ request('search') }}"
                placeholder="Nama fasilitas..."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            />
            <!-- Autocomplete suggestions -->
            <ul id="suggestions" class="absolute z-20 w-full bg-white border border-gray-200 rounded-md mt-1 max-h-48 overflow-auto hidden"></ul>
        </div>
        <div class="flex items-end">
            <button type="submit" class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Filter</button>
        </div>
    </form>

    @if($points->isEmpty())
        <div class="text-center text-gray-500 py-20">
            <p class="text-lg font-medium">Fasilitas tidak ditemukan.</p>
        </div>
    @else
        <!-- Map Container -->
        <div id="map" class="rounded-lg shadow-lg mb-8 z-10" style="height: 500px;"></div>
    @endif
    
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // default coords if no markers
        const defaultLat = -1.886996;
        const defaultLng = 106.053916;

        // initialize map with default view
        const map = L.map('map').setView([defaultLat, defaultLng], 12);
        L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            {
                attribution: 'Tiles © Esri — Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, etc.'
            }
        ).addTo(map);

        // data from server
        const fasilitas = @json($points);
        const markers = [];
        fasilitas.forEach((item, idx) => {
            const marker = L.marker([item.lat, item.lng]).addTo(map);
            marker.bindPopup(`<strong>${item.label}</strong><br /><em>${item.kategori}</em>`);
            markers.push(marker);
        });


        const wilayah = @json($kewilayahan2);

        // Loop setiap wilayah dan tampilkan sebagai polygon
        wilayah.forEach(item => {
            let coords = [];

            try {
                coords = JSON.parse(item.koordinat);
            } catch (e) {
                console.warn('Gagal parse koordinat untuk wilayah:', item.nama_dusun, e);
                return;
            }

            // Pastikan bentuk koordinatnya valid (array of lat-lng pairs)
            if (Array.isArray(coords) && coords.length > 2) {
                const polygon = L.polygon(coords, {
                    color: item.warna || '#0d9488',
                    fillOpacity: 0.4,
                    weight: 2
                }).addTo(map);

                polygon.bindPopup(`<strong>${item.nama_dusun}</strong>`);
            }
        });

        // Auto focus
        if (markers.length > 0) {
            const group = L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.2));
            markers[0].openPopup();
        }

        // Autocomplete functionality
        const searchInput = document.getElementById('search');
        const suggestionsBox = document.getElementById('suggestions');

        let controller;
        searchInput.addEventListener('input', async function () {
            const query = this.value.trim();
            if (query.length < 2) {
                suggestionsBox.innerHTML = '';
                suggestionsBox.classList.add('hidden');
                return;
            }
            // Cancel previous request
            if (controller) controller.abort();
            controller = new AbortController();

            try {
                const res = await fetch(`{{ route('kewilayahan.autocomplete') }}?search=${encodeURIComponent(query)}`, { signal: controller.signal });
                const data = await res.json();
                if (!Array.isArray(data) || data.length === 0) {
                    suggestionsBox.innerHTML = '';
                    suggestionsBox.classList.add('hidden');
                    return;
                }
                // Populate suggestions
                suggestionsBox.innerHTML = data.map(item =>
                    `<li class="px-4 py-2 hover:bg-indigo-100 cursor-pointer" data-value="${item}">${item}</li>`
                ).join('');
                suggestionsBox.classList.remove('hidden');
            } catch (e) {
                console.error('Autocomplete error', e);
            }
        });

        // Click suggestion
        suggestionsBox.addEventListener('click', function (e) {
            if (e.target.tagName.toLowerCase() === 'li') {
                searchInput.value = e.target.getAttribute('data-value');
                suggestionsBox.innerHTML = '';
                suggestionsBox.classList.add('hidden');
            }
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.add('hidden');
            }
        });
    });
</script>
@endsection
