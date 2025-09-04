<div class="w-full mx-auto lg:px-10 lg:py-4 mt-6 mb-6 shadow-lg bg-white rounded-lg p-6 dark:bg-gray-900">
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-location-dot text-sky-950 dark:text-gray-300 text-2xl"></i>
        <h1 class="text-2xl font-bold text-sky-950 dark:text-gray-300">Titik UMKM Di Desa Pemali</h1>
    </div>
    <div class="flex border-4 border-sky-950 rounded-lg gap-2 h-[460px] w-[100%] mb-6">
        <div id="map" style="width: 100%; height: 450px; z-index: 1;"></div> <!-- Menambahkan z-index rendah jika diperlukan -->
    </div>    
</div>
<script>
    window.onload = function () {
        const map = L.map('map').setView([-1.886996, 106.053916], 13);
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const markersData = <?= json_encode(collect($markerUmkm)->map->only(['latitude', 'longitude', 'umkm_name'])->toArray()); ?>;

        const bounds = [];

        markersData.forEach(data => {
            if (data.latitude && data.longitude && !isNaN(data.latitude) && !isNaN(data.longitude)) {
                const latLng = [parseFloat(data.latitude), parseFloat(data.longitude)];
                L.marker(latLng)
                    .addTo(map)
                    .bindPopup(data.umkm_name);
                bounds.push(latLng);
            }
        });

        if (bounds.length) {
            map.fitBounds(bounds); // Auto zoom ke semua marker
        }

    }
</script>
