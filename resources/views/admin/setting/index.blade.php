@extends('admin.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

<div class="card shadow mb-2">
    <div class="card-body">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-2 mt-3">
                <a href="{{ route('show.settingBanner.form') }}" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center w-80">
                    <span>Tambah</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="form-container container">  
  <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                @if ($bannerImg->isNotEmpty())
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 40%">gambar</th>
                        {{-- <th style="width: 35%">link</th> --}}
                        <th style="width: 10%">Aksi</th>
                    </tr>
                @endif
                </thead>
                <tbody>
                        @forelse ($bannerImg as $index => $banner)
                        <tr>
                        <td class="align-middle">
                            {{ $index + 1 }}
                            </td>
                            <td class="align-middle">
                                <img src="{{ asset('storage/images/general/bannerImg/' . $banner->bannerImg) }}">
                            </td>
                            {{-- <td class="align-middle">
                                {{ $banner->link }}
                            </td> --}}
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a href="{{ route('show.settingBanner.form', $banner->id) }}" class="btn btn-warning btn-sm" title="Edit Banner" data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a> | 
                                    <form id="form-delete-{{ $banner->id }}" 
                                          action="{{ route('banner.delete', $banner->id) }}" 
                                          method="post" 
                                          class="d-inline">
                                          @csrf 
                                          <input type="hidden" name="_method" value="DELETE">
                                          <button type="button" class="btn-delete btn btn-danger btn-sm" data-id="{{ $banner->id }}" title="Hapus Banner" data-bs-toggle="tooltip">
                                              <i class="fas fa-trash-alt"></i>
                                          </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="material-symbols-rounded text-muted mb-3 fs-1">add</i>
                            <p class="mb-0 text-muted">Tidak ada spanduk ditemukan.</p>
                        </div>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('input[type="file"]').forEach(function (input) {
        input.addEventListener('change', function () {
            const file = this.files[0];
            const imgPreview = document.getElementById(
                'imagePreviewImg' + this.id.replace('preview_image', '')
            );

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imgPreview.style.display = 'none';
                imgPreview.src = '';
            }
        });
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