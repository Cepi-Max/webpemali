<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Wilayah Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet/dist/leaflet.css"
    />
    <style>
        #map {
            height: 500px;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="container mx-auto px-4 py-10">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h1 class="text-3xl font-bold mb-4 text-sky-700">Peta Wilayah Desa Duwet</h1>
            <p class="text-gray-600 mb-6">
                Peta ini menampilkan wilayah Dusun Karangasem di Desa Duwet, Jawa Tengah, dengan batas yang diwarnai untuk memudahkan identifikasi wilayah.
            </p>

            <div id="map" class="rounded-lg shadow-md border border-gray-200"></div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-7.614, 110.560], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Contoh polygon wilayah dusun Karangasem di Desa Duwet (koordinat fiktif)
        const dusunPolygon = L.polygon([
             [-7.6129, 110.5590],
    [-7.6130, 110.5595],
    [-7.6133, 110.5600],
    [-7.6136, 110.5606],
    [-7.6140, 110.5609],
    [-7.6145, 110.5605],
    [-7.6148, 110.5597],
    [-7.6144, 110.5589],
    [-7.6136, 110.5587],
    [-7.6129, 110.5590] 
        ], {
            color: '#16a34a',
            fillColor: '#86efac',
            fillOpacity: 0.6,
        }).addTo(map);

        dusunPolygon.bindPopup('<strong>Dusun Karangasem</strong><br>Desa Duwet, Jawa Tengah');
    </script>
</body>
</html>