<div class="row">
    <div class="col">
        <div id="map" style="width: 100%; height: 300px;"></div>
    </div>
</div>
<script>
    // Map Lokasi Pembangunan
    const latitude = <?= isset($constructionBySlug['latitude']) && !empty($constructionBySlug['latitude']) ? $constructionBySlug['latitude'] : '-1.8878440320941845'; ?>;
    const longitude = <?= isset($constructionBySlug['longitude']) && !empty($constructionBySlug['longitude']) ? $constructionBySlug['longitude'] : '106.05312480668209'; ?>;

    // Inisialisasi peta
    const map = L.map('map').setView([latitude, longitude], 16);

    // Tambahkan tile layer
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Tambahkan marker dengan opsi draggable
    const marker = L.marker([latitude, longitude], {
        draggable: true // Marker bisa digeser
    }).addTo(map);

    // Tambahkan popup awal pada marker
    marker.bindPopup("Geser marker untuk mengubah lokasi").openPopup();

    // Dapatkan elemen input untuk latitude dan longitude
    const latInput = document.querySelector("[name='latitude']");
    const lngInput = document.querySelector("[name='longitude']");

    // Update input form saat marker digeser
    marker.on('dragend', function (event) {
        const position = marker.getLatLng(); // Ambil posisi terbaru
        latInput.value = position.lat.toFixed(6); // Update latitude
        lngInput.value = position.lng.toFixed(6); // Update longitude

        // Update popup pada marker (opsional)
        marker.bindPopup(`Koordinat: ${position.lat.toFixed(6)}, ${position.lng.toFixed(6)}`).openPopup();
    });

    // Update marker lokasi saat peta diklik (opsional)
    map.on("click", function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        // Pindahkan marker ke lokasi yang diklik
        marker.setLatLng(e.latlng);

        // Update input form
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);

        // Update popup pada marker (opsional)
        marker.bindPopup(`Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`).openPopup();
    }); 
    
    // const map = L.map('map').setView([-1.8878440320941845, 106.05312480668209], 16);
    // const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    // }).addTo(map);

    // // Get coordinate
    // var latInput = document.querySelector("[name=latitude]");
    // var lngInput = document.querySelector("[name=longitude]");
    // var lokasiInput = document.querySelector("[name=lokasi]");

    // var curLocation = [-1.8878440320941845, 106.05312480668209];

    // map.attributionControl.setPrefix(false);

    // var marker = new L.marker(curLocation, {
    //     draggable: 'true',
    // });

    // marker.on('dragend', function(event){
    //     var position = marker.getLatLng();
    //     marker.setLatLng(position, {
    //         draggable: 'true',
    //     }).bindPopup(position).update();
    //      // Update input values using vanilla JavaScript
    //     latInput.value = position.lat;
    //     lngInput.value = position.lng;
    //     lokasiInput.value = position.lat + "," + position.lng;
    // });
    // map.addLayer(marker);

    // map.on("click", function(e){
    //     var lat = e.latlng.lat;
    //     var lng = e.latlng.lng;
    //     if(!marker) {
    //         marker = L.marker(e.latlng).addTo(map);
    //     }else{
    //         marker.setLatLng(e.latlng);
    //     }
    //     latInput.value = lat;
    //     lngInput.value = lng;
    //     lokasiInput.value = lat + "," + lng;
    // });
</script>