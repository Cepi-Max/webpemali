@extends('admin.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <span>Form {{ $articleBySlug ? 'Ubah' : 'Tambah' }} Artikel</span>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">Kategori Artikel</button>
    </div>
    <form action="{{ $articleBySlug ? route('article.update', $articleBySlug->slug) : route('article.save')}}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- @if ($articleBySlug)
            @method('PUT')
        @endif --}}
        
        <div class="row mb-3">
            <div class="col-md-8">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" 
                    value="{{ old('title', $articleBySlug->title ?? '') }}" 
                    placeholder="Masukkan Judul Artikel" autofocus>
            
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="created_at" class="form-label">Tanggal</label>
                    <input type="date" class="form-control input-sm" name="created_at" value="{{ date('Y-m-d') }}" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="body" class="form-label">Isi Artikel</label>
                    <textarea class="summernote form-control input-sm custom-textarea @error('body') is-invalid @enderror" name="body" id="body" rows="15" placeholder="Isi artikel disini...">{{ old('body', $articleBySlug->body ?? ''); }}</textarea>
                </div>

                @error('body')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="inovator" class="form-label">Nama Penulis</label>
                    <input type="text" class="form-control @error('inovator') is-invalid @enderror" id="inovator" name="inovator" value="{{ old('inovator', $articleBySlug->inovator ?? '') }} " placeholder="Masukkan Nama Penulis">
                </div>
                @error('inovator')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select name="category" id="category" class="form-control custom-select @error('category') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                {{ old('category', $articleBySlug->article_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- <div class="mb-3">
                    <label for="image" class="form-label">Input Gambar</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImg()" placeholder="Masukkan Gambar Artikel">
                </div>
                <div class="col-sm-12"> <!-- Ubah ukuran menjadi col-sm-12 untuk mengisi seluruh lebar -->
                    <img src="/img/article_img/default.png" class="img-thumbnail img-preview img-preview-full" alt="">
                </div> --}}

                @php
                    $imagePath = $articleBySlug && $articleBySlug->image 
                        ? asset('storage/images/publicImg/article/articleImg/' . $articleBySlug->image) 
                        : asset('storage/images/publicImg/article/articleImg/default.png');
                @endphp

                <div class="form-group col-md-12 mb-5">
                    <label for="image">Gambar</label>
                    <div class="avatar-upload">
                        <div>
                            <input type="file" id="preview_image" name="image" accept="image/*" {{ $articleBySlug ? '' : 'required' }}>
                            <label for="image"></label>
                            @if($articleBySlug)
                                <input type="hidden" name="oldImage" value="{{ $articleBySlug->image }}">
                            @endif
                        </div>
                        <div class="image-preview" id="imagePreview">
                            <img src="{{ $imagePath }}" alt="Image Preview" id="imagePreviewImg" style="{{ $articleBySlug ? 'display: block;' : 'display: none;' }}">
                        </div>
                    </div>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="/admin/daftar-artikel" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-dark">Simpan</button>
        </div>
    </form>
</div>


@include('/admin/article/modal')

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