<div class="row">
    <div class="col">
        <div id="map" style="width: 100%; height: 300px;"></div>
    </div>
</div>

<script>
    @php
        $lat = !empty($umkmBySlug->latitude) ? $umkmBySlug->latitude : -1.886996;
        $lng = !empty($umkmBySlug->longitude) ? $umkmBySlug->longitude : 106.053916;
    @endphp

    const latitude = {{ $lat }};
    const longitude = {{ $lng }};

    // Inisialisasi peta
    const map = L.map('map').setView([latitude, longitude], 16);

    // Tambahkan tile layer
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Tambahkan marker dengan opsi draggable
    const marker = L.marker([latitude, longitude], {
        draggable: true
    }).addTo(map);

    marker.bindPopup("Geser marker untuk mengubah lokasi").openPopup();

    // Ambil elemen input berdasarkan ID
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    // Update input form saat marker digeser
    marker.on('dragend', function (event) {
        const position = marker.getLatLng();
        latInput.value = position.lat.toFixed(6);
        lngInput.value = position.lng.toFixed(6);
        marker.bindPopup(`Koordinat: ${position.lat.toFixed(6)}, ${position.lng.toFixed(6)}`).openPopup();
    });

    // Update marker saat peta diklik
    map.on("click", function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        marker.setLatLng(e.latlng);
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
        marker.bindPopup(`Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`).openPopup();
    });
</script>
