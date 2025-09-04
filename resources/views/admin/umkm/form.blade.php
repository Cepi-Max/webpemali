@extends('admin.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <span>Form {{ $umkmBySlug ? 'Ubah' : 'Tambah' }} UMKM</span>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">Kategori Sektor Usaha</button>
    </div>
    <form id="form-umkm" action="{{ $umkmBySlug ? route('umkm.update', $umkmBySlug->slug) : route('umkm.save')}}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- @if ($umkmBySlug)
            @method('PUT')
        @endif --}}
        
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="umkm_name" class="form-label">Nama Usaha</label>
                <input type="text" class="form-control @error('umkm_name') is-invalid @enderror" id="umkm_name" name="umkm_name" 
                    value="{{ old('umkm_name', $umkmBySlug->umkm_name ?? 'Ai Robot Tech') }}" 
                    placeholder="Masukkan nama usaha" autofocus>
                @error('umkm_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="owner_name" class="form-label">Nama Pemilik</label>
                <input type="text" class="form-control @error('owner_name') is-invalid @enderror" id="owner_name" name="owner_name" 
                    value="{{ old('owner_name', $umkmBySlug->owner_name ?? 'Septiandi Hermawan') }}" 
                    placeholder="Masukkan nama pemilik usaha" autofocus>
                @error('owner_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">    
                <label for="sector_id" class="form-label">Sektor Usaha</label>
                <select name="sector_id" id="sector_id" class="form-control custom-select @error('sector_id') is-invalid @enderror">
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach ($umkmSector as $us)
                        <option value="{{ $us->id }}" 
                            {{ old('sector_id', $umkmBySlug->sector_id ?? '') == $us->id ? 'selected' : '' }}>
                            {{ $us->name }}
                        </option>
                    @endforeach
                </select>
                @error('sector_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="description" class="form-label">Deskripsi Usaha</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $umkmBySlug->description ?? 'Dengan keaslian bahan baku, menghasilkan produk memuaskan.') }}</textarea> 
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror 
            </div>
            <div class="col-md-6">
                <label class="form-label">Sertifikasi yang Dimiliki</label>
                <div class="checkbox d-flex">
                    <div class="form-check">
                        @forelse ($umkmCertificationCategory as $uc) 
                        <input class="form-check-input" type="checkbox" name="certificate_id[]" 
                            value="{{ $uc->id }}" 
                            {{ in_array($uc->id, old('certificate_id', $umkmCertificate ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $uc->name }}</label>
                    @empty
                            <p>Kategori sertifikasi belum didaftarkan</p>
                        @endforelse
                    </div>                                 
                </div>
                @error('certificate_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control custom-select">
                    <option value="Pria" {{ old('gender', $umkmBySlug->gender ?? '') == 'Pria' ? 'selected' : '' }} selected>Pria</option>
                    <option value="Wanita" {{ old('gender', $umkmBySlug->gender ?? '') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                </select>
                @error('gender')
                    <small class="text-danger">{{ $message }}</small>
                @enderror 
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" 
                    value="{{ old('address', $umkmBySlug->address ?? 'Indonesia') }}" 
                    placeholder="Masukkan nama pemilik usaha" autofocus>
                @error('address')
                    <small class="text-danger">{{ $message }}</small>
                @enderror      
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                    value="{{ old('email', $umkmBySlug->email ?? 'cepi@gmail.com') }}" 
                    placeholder="Masukkan nama pemilik usaha" autofocus>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror 
            </div>
            <div class="col-md-6">
                <label for="number_phone" class="form-label">No Telepon/ Wa</label>
                <input type="tel" 
                        class="form-control @error('number_phone') is-invalid @enderror"         
                        id="number_phone" 
                        name="number_phone" 
                        value="{{ old('number_phone', $umkmBySlug->number_phone ?? '0896655') }}" 
                        placeholder="ex: +62896655" 
                        autofocus 
                        inputmode="numeric"
                        pattern="[+, 0-9]*"
                        maxlength="15">
                @error('number_phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror      
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" 
                    value="{{ old('latitude', $umkmBySlug->latitude ?? '') }}" placeholder="Latitude">
            </div>
            <div class="col-md-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" 
                    value="{{ old('longitude', $umkmBySlug->longitude ?? '') }}" placeholder="Longitude">
            </div>
            
            {{-- <div class="col-md-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" 
                    value="{{ old('latitude', $umkmBySlug->latitude ?? '') }}" 
                    placeholder="Latitude">
                @error('latitude')
                    <small class="text-danger">{{ $message }}</small>
                @enderror      
            </div>
            <div class="col-md-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" 
                    value="{{ old('longitude', $umkmBySlug->longitude ?? '') }}" 
                    placeholder="Longitude">
                @error('longitude')
                    <small class="text-danger">{{ $message }}</small>
                @enderror      
            </div> --}}
            <div class="col-md-3">
                @php
                    $imagePath = $umkmBySlug && $umkmBySlug->image 
                        ? asset('storage/images/publicImg/umkm/umkmImg/' . $umkmBySlug->image) 
                        : asset('storage/images/publicImg/umkm/umkmImg/default.png');
                @endphp
                <div class="form-group">
                    <label for="image">Gambar</label>
                    <div class="avatar-upload">
                        <div>
                            <input type="file" class="form-control" id="preview_image" name="image" accept="image/*">
                            <label for="image"></label>
                            @if($umkmBySlug)
                                <input type="hidden" name="oldImage" value="{{ $umkmBySlug->image }}">
                            @endif
                        </div>
                    </div>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <label for="product_price" class="form-label">Harga produk</label>
                <input type="text" 
                    class="form-control @error('product_price') is-invalid @enderror"    
                    id="product_price" 
                    name="product_price_display" 
                    value="{{ old('product_price', $umkmBySlug->product_price ?? '30.000') }}" 
                    placeholder="Masukkan harga produk" autofocus>
                {{-- input nilai asli ke database --}}
                <input type="hidden" name="product_price" id="product_price_raw">
                @error('product_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror     
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                @include('admin.umkm.viewmap')
            </div>
            <div class="image-preview" id="imagePreview">
                <img src="{{ $imagePath }}" alt="Image Preview" id="imagePreviewImg" style="{{ $umkmBySlug ? 'display: block;' : 'display: none;' }}">
            </div>
        </div>

        <div class="row">
            <div class="col d-flex justify-content-between ">
                <a href="{{ route('show.umkm'); }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-dark">Simpan</button> 
            </div>  
        </div>
    </form>
</div>


@include('.admin.umkm.modal')

<script>
    // Select the input and preview elements
    const fileInput = document.getElementById('preview_image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('imagePreviewImg');

    // Add event listener for file input
    fileInput.addEventListener('change', function () {
        const file = this.files[0]; // Get the selected file

        if (file) {
            const reader = new FileReader();

            // Load the file and set the image source
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block'; // Show the image
            };

            reader.readAsDataURL(file); // Read the file as a Data URL
        } else {
            // If no file is selected, hide the image
            previewImg.style.display = 'none';
            previewImg.src = '';
        }
    });

    // Format Rupiah
    const priceInput = document.getElementById('product_price');
    const hiddenInput = document.getElementById('product_price_raw');

    function formatRupiah(angka, prefix = 'Rp. ') {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa  = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix + rupiah;
    }

    priceInput.addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value);
    });

    // Bersihkan format saat form disubmit
    const form = document.getElementById('form-umkm');
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Cegah submit langsung

        const angkaBersih = priceInput.value.replace(/[^0-9]/g, '');
        hiddenInput.value = angkaBersih;

        // Setelah hidden value di-set, baru kirim form
        form.submit();
    });

</script>


<style>
    body {
        background-color: #f8f9fa;
    }
    .form-container {
        max-width: 1500px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .form-title {
        font-size: 24px;
        font-weight: 500;
        margin-bottom: 20px;
    }
    .form-label {
        font-size: 16px;
        margin-bottom: 5px;
    }
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    .custom-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 12px 12px;
        padding-right: 2rem !important;
    }
    .custom-select::-ms-expand {
        display: none;
    }

    .image-preview {
        width: 50%;
        height: 300px;
        border: 2px dashed #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        overflow: hidden;
        background-color: #f9f9f9;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

@endsection