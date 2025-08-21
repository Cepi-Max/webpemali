@extends('admin.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <span>Form {{ $kewilayahanById ? 'Ubah' : 'Tambah' }} Fasilitas</span>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">Kategori Fasilitas</button>
    </div>
    <form id="form-kewilayahan-desa-cantik" action="{{ $kewilayahanById ? route('kewilayahan-desa-cantik.update', $kewilayahanById->id) : route('kewilayahan-desa-cantik.save')}}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- @if ($kewilayahanById)
            @method('PUT')
        @endif --}}
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nama_fasilitas" class="form-label">Nama Fasilitas</label>
                <input type="text" class="form-control @error('nama_fasilitas') is-invalid @enderror" id="nama_fasilitas" name="nama_fasilitas" 
                    value="{{ old('nama_fasilitas', $kewilayahanById->nama_fasilitas ?? '') }}" 
                    placeholder="Masukkan nama usaha" autofocus>
                @error('nama_fasilitas')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="kewilayahan_kategori_id" class="form-label">Kategori</label>
                <select name="kewilayahan_kategori_id" id="kewilayahan_kategori_id" class="form-control custom-select @error('kewilayahan_kategori_id') is-invalid @enderror">
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach ($kewilayahan_kategori as $kat)
                        <option value="{{ $kat->id }}" 
                            {{ old('kewilayahan_kategori_id', $kewilayahanById->kewilayahan_kategori_id ?? '') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kewilayahan_kategori_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" 
                    value="{{ old('latitude', $kewilayahanById->latitude ?? '') }}" placeholder="Latitude">
            </div>
            <div class="col-md-6">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" 
                    value="{{ old('longitude', $kewilayahanById->longitude ?? '') }}" placeholder="Longitude">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                @include('admin.kewilayahan-desa-cantik.viewmap')
            </div>
        </div>

        <div class="row">
            <div class="col d-flex justify-content-between ">
                <a href="{{ route('show.admin.desa-cantik.kewilayahan'); }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-dark">Simpan</button> 
            </div>  
        </div>
    </form>
</div>


@include('admin.kewilayahan-desa-cantik.modal')


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