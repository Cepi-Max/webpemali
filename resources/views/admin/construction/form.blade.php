@extends('admin.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

<div class="form-container">
        <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <span>Form {{ $constructionBySlug ? 'Ubah' : 'Tambah' }} Pembangunan</span>
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#tambahSumberDanaModal">Sumber Dana</button>
        </div>
        <form action="{{ $constructionBySlug ? route('construction.update', $constructionBySlug->slug) : route('construction.save')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($constructionBySlug)
                    @method('PUT')
                @endif
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $constructionBySlug->title ?? 'Pembuatan Jalan Ke Kebun') }}" autofocus>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="construction_implementer" class="form-label">Pelaksana</label>
                            <input type="text" class="form-control @error('construction_implementer') is-invalid @enderror" id="construction_implementer" name="construction_implementer" value="{{ old('construction_implementer', $constructionBySlug->construction_implementer ?? 'Sopian') }}" >
                            @error('construction_implementer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="construction_volume" class="form-label">Volume Pembangunan</label>
                            <input type="text" class="form-control @error('construction_volume') is-invalid @enderror" id="construction_volume" name="construction_volume" value="{{ old('construction_volume', $constructionBySlug->construction_volume ?? '1 Paket') }}" >
                            @error('construction_volume')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="construction_benefits" class="form-label">Manfaat</label>
                                <input type="text" class="form-control @error('construction_benefits') is-invalid @enderror" id="construction_benefits" name="construction_benefits" value="{{ old('construction_benefits', $constructionBySlug->construction_benefits ?? 'Memperbaiki jalur transportasi') }}">
                                @error('construction_benefits')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="construction_time_period" class="form-label">Estimasi Pengerjaan</label>
                            <input type="number" class="form-control @error('construction_time_period') is-invalid @enderror" id="construction_time_period" name="construction_time_period" value="{{ old('construction_time_period', $constructionBySlug->construction_time_period ?? 2) }}">
                            @error('construction_time_period')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="period_category" class="form-label">Kategori Waktu</label>
                                <select name="period_category" id="period_category" class="form-control custom-select">
                                    <option value="Hari" {{ old('period_category', $constructionBySlug->period_category ?? '') == 'Hari' ? 'selected' : '';  }} selected>Hari</option>
                                    <option value="Bulan" {{ old('period_category', $constructionBySlug->period_category ?? '') == 'Bulan' ? 'selected' : '';  }}>Bulan</option>
                                    <option value="Tahun" {{ old('period_category', $constructionBySlug->period_category ?? '') == 'Tahun' ? 'selected' : '';  }}>Tahun</option>
                                </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fund_source_id" class="form-label">Sumber Dana</label>
                                <select name="fund_source_id" id="fund_source_id" class="form-control custom-select">
                                    <option value="{{ old('fund_source_id') ? '' : 'selected' }}" disabled >Pilih Sumber Dana</option>
                                    <?php foreach ($fundSourceCategories as $fund_source): ?>
                                        <option value="{{ $fund_source->id }}" {{ (old('fund_source_id', $constructionBySlug->fund_source_id ?? '') == $fund_source->id) ? 'selected' : ''; }}>
                                            {{ $fund_source->name }}
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                @error('fund_source_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="construction_site" class="form-label">Tempat / Dusun</label>
                            <input type="text" class="form-control @error('construction_site') is-invalid @enderror" id="construction_site" name="construction_site" value="{{ old('construction_site', $constructionBySlug->construction_site ?? 'Gemilang') }}">
                            @error('construction_site')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fiscal_year" class="form-label">Tahun Anggaran</label>
                            <select name="fiscal_year" id="fiscal_year" class="form-control custom-select @error('fiscal_year') is-invalid  @enderror">
                                <option style="font-weight:bold;" value="2024" selected>2024</option>
                            
                                @for ($year = 2015; $year <= 2050; $year++)
                                    <option value="{{ $year }}" {{ old('fiscal_year', $constructionBySlug->fiscal_year ?? '') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            @error('fiscal_year')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror                            
                        </div>
                        <div class="col-md-6">
                            <label for="total_budget" class="form-label">Total Anggaran</label>
                            <input type="text" class="form-control  @error('total_budget') is-invalid @enderror" id="total_budget" name="total_budget" value="{{ old('total_budget', $constructionBySlug->total_budget ?? 20000) }}"
                            {{-- value="{{ isset($_POST['total_budget']) ? $_POST['total_budget'] : ''; }}"  --}}
                            readonly>
                            @error('total_budget')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="government_cost" class="form-label">Sumber Biaya Pemerintah</label>
                                <input type="number" class="form-control biaya-input" id="government_cost" name="government_cost" value="{{ old('government_cost', $constructionBySlug->government_cost ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="district_cost" class="form-label">Sumber Biaya Kabupaten</label>
                                <input type="number" class="form-control biaya-input" id="district_cost" name="district_cost" value="{{ old('district_cost', $constructionBySlug->district_cost ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="province_cost" class="form-label">Sumber Biaya Provinsi</label>
                                <input type="numbsifer" class="form-control biaya-input" id="province_cost" name="province_cost" value="{{ old('province_cost', $constructionBySlug->province_cost ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="self_cost" class="form-label">Sumber Biaya Swadya</label>
                                <input type="number" class="form-control biaya-input" id="self_cost" name="self_cost" value="{{ old('self_cost', $constructionBySlug->self_cost ?? '') }}">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="construction_traits" class="form-label">Sifat Proyek</label>
                                <select name="construction_traits" id="construction_traits" class="form-control custom-select">
                                    <option value="" disabled>Pilih Sifat Proyek</option>
                                    <option value="Baru" {{ old('construction_traits', $constructionBySlug->construction_traits ?? '') == 'Baru' ? 'selected' : ''}} selected>Baru</option>
                                    <option value="Lanjutan" {{ old('construction_traits', $constructionBySlug->construction_traits ?? '') == 'Lanjutan' ? 'selected' : ''}}>Lanjutan</option>
                                </select>      
                        </div>
                        <div class="col-md-6">
                            <label for="information" class="form-label">Keterangan</label>
                            <input type="text" class="form-control @error('information') is-invalid @enderror" id="information" name="information" value="{{ old('information', $constructionBySlug->information ?? 'Sukses') }}">
                            @error('information')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $constructionBySlug->latitude ?? '34234343') }}" readonly>
                                @error('latitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $constructionBySlug->longitude ?? '34234343') }}" readonly>
                            @error('longitude')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                        @php
                            $imagePath = $constructionBySlug && $constructionBySlug->image 
                                ? asset('storage/images/publicImg/construction/constructionImg/' . $constructionBySlug->image) 
                                : asset('storage/images/publicImg/construction/constructionImg/default.png');
                        @endphp
                            <label for="image" class="form-label">Input Gambar Utama</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="preview_image" name="image" onchange="previewImg() {{ $constructionBySlug ? '' : 'required' }}">
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{-- Viewmap --}}
                            @include('admin.construction.viewmap')
                        </div>
                        <div class="image-preview" id="imagePreview">
                            <img src="{{ $imagePath }}" alt="Image Preview" id="imagePreviewImg" style="{{ $constructionBySlug ? 'display: block;' : 'display: none;' }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        
                        
                    </div>
            <div class="row">
                <div class="col d-flex justify-content-between ">
                    <a href="{{ route('show.constructions'); }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-dark">Simpan</button> 
                </div>  
            </div>
        </form>
    </div>
    
    {{-- modal --}}
    @include('/admin/construction/modal')

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
        .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 5px;
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
                // previewImg.style.display = 'none';
                previewImg.src = '';
            }
        });




        document.querySelectorAll('.biaya-input').forEach(input => {
            input.addEventListener('input', calculatetotal_budget);
        });

        function calculatetotal_budget() {
            let total_budget = 0;
            document.querySelectorAll('.biaya-input').forEach(input => {
                let value = parseFloat(input.value.replace(/[^0-9.]/g, '')) || 0; // Hapus format sebelum parse
                total_budget += value;
            });
            document.getElementById('total_budget').value = formatRupiah(total_budget);
        }

        function formatRupiah(angka) {
            return 'Rp. ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
            // let number_string = angka.toString(),
            //     sisa = number_string.length % 3,
            //     rupiah = number_string.substr(0, sisa),
            //     ribuan = number_string.substr(sisa).match(/\d{3}/g);
                
            // if (ribuan) {
            //     let separator = sisa ? '.' : '';
            //     rupiah += separator + ribuan.join('.');
            // }
            
            // return 'Rp. ' + rupiah;
            // }

            document.querySelector('form').addEventListener('submit', function() {
                let totalAnggaranInput = document.getElementById('total_budget');
                totalAnggaranInput.value = totalAnggaranInput.value.replace(/[^0-9]/g, ''); // Hapus semua karakter non-digit
        });
    </script>


@endsection