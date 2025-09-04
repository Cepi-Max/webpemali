@extends('admin.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <span>Form {{ $officialBySlug ? 'Ubah' : 'Tambah' }} Aparatur Desa</span>
    </div>
    <form action="{{ $officialBySlug ? route('official.update', $officialBySlug->slug) : route('official.save')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $officialBySlug->name ?? 'John') }}" placeholder="Masukkan Nama Aparatur" autofocus>   
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" class="form-control input-sm" name="address" placeholder="Masukkan Alamat" value="{{ old('address', $officialBySlug->address ?? 'California') }}">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select name="gender" id="gender" class="form-control custom-select">
                            <option value="Pria" {{ old('gender', $officialBySlug->gender ?? '') == 'Pria' ? 'selected' : '' }} selected>Pria</option>
                            <option value="Wanita" {{ old('gender', $officialBySlug->gender ?? '') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                        @error('gender')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $officialBySlug->place_of_birth ?? 'California') }}" placeholder="Masukkan Tempat Lahir">
                    @error('place_of_birth')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $officialBySlug->date_of_birth ?? date('Y-m-d')) }}" placeholder="Masukkan Tanggal Lahir">
                    @error('date_of_birth')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="position" class="form-label">Jabatan</label>
                    <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $officialBySlug->position ?? 'Kepala Dusun') }}" placeholder="Masukkan Jabatan">
                    @error('position')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="">Foto Aparatur</label>
                    <div class="avatar-upload">
                        <div>
                            <input type="file" class="form-control" id="preview_image" name="image" accept="image/*">
                            <label for="image"></label>
                        </div>
                    </div>
                    @error('image')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $officialBySlug->phone_number ?? '083344') }}" placeholder="Masukkan Nomor Telepon">
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

                @php
                    $imagePath = $officialBySlug && $officialBySlug->image 
                        ? asset('storage/images/publicImg/official/officialImg/' . $officialBySlug->image) 
                        : asset('storage/images/publicImg/official/officialImg/default.png');
                @endphp

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="image-preview text-center" id="imagePreview">
                        <img src="{{ $imagePath }}" alt="Image Preview" id="imagePreviewImg" style="{{ $officialBySlug ? 'display: block;' : 'display: none;' }}">
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('show.officials') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
            </div>
    </form>
</div>

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
    .custom-textarea {
        height: 470px; /* Atur tinggi sesuai kebutuhan */
        min-height: 150px; /* Tinggi minimum */
    }

    .image-preview {
        width: 200px;
        height: 200px;
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
        /* display: none; */
    }
</style>

@endsection