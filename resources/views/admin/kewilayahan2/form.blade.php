@extends('admin.layouts.main.app')

@section('title', 'Form Kewilayahan')

@section('content')
<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <span>Form {{ $kewilayahanById ? 'Ubah' : 'Tambah' }} Kewilayahan</span>
    </div>

    <form action="{{ route('kewilayahan2-desa-cantik.saveOrUpdate') }}" method="POST">
        @csrf
        @if(isset($kewilayahanById->id))
            <input type="hidden" name="id" value="{{ $kewilayahanById->id }}">
        @endif

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="nama_dusun" class="form-label">Nama Dusun</label>
                <input type="text" class="form-control @error('nama_dusun') is-invalid @enderror" id="nama_dusun" name="nama_dusun" 
                    value="{{ old('nama_dusun', $kewilayahanById->nama_dusun ?? '') }}" 
                    placeholder="Masukkan nama dusun" autofocus>
                @error('nama_dusun')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="warna" class="form-label">Warna</label>
                <input type="color" class="form-control @error('warna') is-invalid @enderror" id="warna" name="warna" 
                    value="{{ old('warna', $kewilayahanById->warna ?? '#0d9488') }}">
                @error('warna')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Input hidden untuk menyimpan koordinat polygon --}}
        <input type="hidden" name="koordinat" id="koordinat" value='{{ old("koordinat", json_encode($kewilayahanById->koordinat ?? [])) }}'>

        <div class="row mb-4">
            <div class="col-md-12">
                <label class="form-label">Gambarkan Wilayah Dusun</label>
                <div id="map" style="height: 400px; border-radius: 8px; border: 1px solid #ccc;"></div>
                @error('koordinat')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col d-flex justify-content-between">
                <a href="{{ route('show.admin.desa-cantik.pembagian-kewilayahan') }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-dark">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection

{{-- Style --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
<style>
    .form-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 25px;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }
    .form-title {
        font-size: 22px;
        font-weight: 600;
    }
</style>
@endpush

{{-- Scripts --}}
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map').setView([-1.886996, 106.053916], 15);

    // Tile
    L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        {
            attribution: 'Tiles © Esri — Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, etc.'
        }
    ).addTo(map);

    const drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Control
    const drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false,
                showArea: true,
                shapeOptions: {
                    color: document.getElementById('warna').value || '#0d9488',
                    weight: 2
                }
            },
            polyline: false,
            rectangle: false,
            circle: false,
            marker: false,
            circlemarker: false,
        },
        edit: {
            featureGroup: drawnItems,
        }
    });
    map.addControl(drawControl);

    // Ambil dan render polygon lama (mode edit)
    let oldCoordsRaw = {!! json_encode(old('koordinat', $kewilayahanById->koordinat ?? null)) !!};
    let oldCoords = [];

    if (typeof oldCoordsRaw === 'string') {
        try {
            oldCoords = JSON.parse(oldCoordsRaw);
        } catch (e) {
            console.warn('Gagal parsing koordinat lama:', e);
        }
    } else if (Array.isArray(oldCoordsRaw)) {
        oldCoords = oldCoordsRaw;
    }

    if (Array.isArray(oldCoords) && oldCoords.length > 0 && Array.isArray(oldCoords[0])) {
        const polygon = L.polygon(oldCoords, {
            color: document.getElementById('warna').value || '#0d9488',
            weight: 2
        }).addTo(drawnItems);
        map.fitBounds(polygon.getBounds());
    }

    // Buat polygon baru
    map.on(L.Draw.Event.CREATED, function (e) {
        drawnItems.clearLayers();
        const layer = e.layer;
        drawnItems.addLayer(layer);

        const coords = layer.getLatLngs()[0].map(p => [p.lat, p.lng]);
        document.getElementById('koordinat').value = JSON.stringify(coords);
    });

    // Edit polygon
    map.on(L.Draw.Event.EDITED, function () {
    const layers = drawnItems.getLayers();
    if (layers.length > 0) {
        const coords = layers[0].getLatLngs()[0].map(p => [p.lat, p.lng]);
        document.getElementById('koordinat').value = JSON.stringify(coords);
    }
});

});
</script>
@endpush
