@extends('admin.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

    <div class="form-container">
        <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <span>Form {{ $CDById ? 'Ubah' : 'Tambah' }} Dokumentasi Pembangunan</span>
        </div>
        <form action="{{ $CDById ? route('construction.documentation.update', $CDById->id) : route('construction.documentation.save', $construction->slug)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="percentage" class="form-label">Persentase</label>
                            <input type="text" class="form-control @error('percentage') is-invalid @enderror" id="percentage" name="percentage" value="{{ old('percentage', $CDById->percentage ?? '') }}" autofocus>
                            @error('percentage')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
    
                        <div class="mb-3">
                            <label for="information" class="form-label">Keterangan</label>
                            <input type="text" class="form-control @error('information') is-invalid @enderror" id="information" name="information" value="{{ old('information', $CDById->information ?? '') }}" autofocus>
                            @error('information')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        @php
                            $imagePath = $CDById && $CDById->image 
                                ? asset('storage/images/publicImg/construction/documentationImg/' . $CDById->image) 
                                : asset('storage/images/publicImg/construction/documentationImg/default.svg');
                        @endphp
    
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Dokumentasi</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="preview_image" name="image">
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="image-preview" id="imagePreview">
                        <img src="{{ $imagePath }}" alt="Image Preview" id="imagePreviewImg" style="{{ $CDById ? 'display: block;' : 'display: none;' }}"> 
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('show.constructions.documentation', $construction->slug) }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
        </form>
    </div>

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
                previewImg.style.display = 'none';
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