@extends('admin.layouts.main.app')

@section('content')

<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <span>Form {{ $infografisById ? 'Ubah' : 'Tambah' }} Infografis Desa Cantik</span>
    </div>
    <form action="{{ $infografisById ? route('infografis-desa-cantik.update', $infografisById->id) : route('infografis-desa-cantik.save')}}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- @if ($infografisById)
            @method('PUT')
        @endif --}}
        
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" 
                        value="{{ old('judul', $infografisById->judul ?? '') }}" 
                        placeholder="Masukkan judul" autofocus>
                    @error('judul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control input-sm @error('deskripsi') is-invalid @enderror" name="deskripsi" value="{{ old('deskripsi', $infografisById->deskripsi ?? '') }}" placeholder="Masukkan deskripsi">
                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                @php
                    $imagePath = $infografisById && $infografisById->file_infografis 
                        ? asset('storage/images/publicImg/infografis/' . $infografisById->file_infografis) 
                        : asset('storage/images/publicImg/infografis/default.pdf');
                @endphp
                <div class="form-group">
                    <label for="file_infografis"></label>
                    <div class="avatar-upload">
                        <div>
                            <input type="file" id="preview_image" name="file_infografis" {{ $infografisById ? '' : 'required' }}>
                            <label for="image"></label>
                        </div>
                    </div>
                    @error('file_infografis')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="image-preview" id="imagePreview">
                        <img src="{{ $imagePath }}" alt="Image Preview" id="imagePreviewImg" style="{{ $infografisById ? 'display: block;' : 'display: none;' }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('show.admin.desa-cantik.infografis') }}" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-dark">Simpan</button>
        </div>
    </form>
</div>

{{-- @include('/admin/publikasi-desa-cantik/modal') --}}

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
    }
</style>

@endsection