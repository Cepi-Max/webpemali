@extends('admin.layouts.main.app')

@section('content')

<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3 text-dark">
        <span>PPID Desa Pemali</span>
    </div>
    
    <form action="{{ $ppid ?  route('ppid.update', $ppid->id) : route('ppid.save') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-12">
            @php
                $imagePath = $ppid &&  $ppid->gambar_depan_ppid 
                    ? asset('storage/images/publicImg/ppid/ppidImg/' . $ppid->gambar_depan_ppid) 
                    : asset('storage/images/publicImg/ppid/ppidImg/default.png');
            @endphp
            <label for="gambar_depan_ppid_input" class="form-label fw-semibold">Gambar Depan Ppid (Gambar)</label><br>
            <input type="file" name="gambar_depan_ppid" id="gambar_depan_ppid_input" class="form-control mb-2 @error('gambar_depan_ppid') is-invalid @enderror" style="display: none;">
            
            {{-- Kontainer pratinjau dengan class 'image-preview-container' --}}
            <div class="image-preview-container position-relative overflow-hidden" 
                style="cursor: pointer; max-width: 400px; border-radius: 0.375rem;"
                onclick="document.getElementById('gambar_depan_ppid_input').click()">
                
                {{-- Gambar pratinjau dengan class 'image-display' --}}
                <img src="{{ $imagePath }}" alt="Gambar_Depan" 
                    class="image-display img-fluid w-100" 
                    style="{{ $ppid ? 'display: block;' : 'display: none;' }}"
                    title="Klik untuk ganti gambar">
                
                {{-- Overlay hover --}}
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center text-white"
                    style="background: rgba(0, 0, 0, 0.6); 
                            border-radius: 0.375rem; 
                            opacity: 0; 
                            transition: opacity 0.3s ease;
                            backdrop-filter: blur(2px);">
                    <i class="material-symbols-rounded mb-2" style="font-size: 3rem;">edit</i>
                    <small class="fw-semibold">Klik untuk ganti gambar</small>
                </div>
            </div>
            @error('gambar_depan_ppid')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label fw-semibold">Profil PPID</label>
            <textarea name="profil" class="visi-misi-sejarah-desa-ppid-summernote form-control" rows="4">{{ old('profil', $ppid->profil) }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label fw-semibold">Visi Ppid</label>
            <textarea name="visi" class="visi-misi-sejarah-desa-ppid-summernote form-control @error('visi') is-invalid @enderror" rows="4">{{ old('visi', $ppid->visi) }}</textarea>
            @error('visi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">Misi Ppid</label>
            <textarea name="misi" class="visi-misi-sejarah-desa-ppid-summernote form-control @error('misi') is-invalid @enderror" rows="4">{{ old('misi', $ppid->misi) }}</textarea>
            @error('misi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            @php
            $imagePath = $ppid && $ppid->gambar_struktur_organisasi
                ? asset('storage/images/publicImg/ppid/ppidImg/' . $ppid->gambar_struktur_organisasi)
                : asset('storage/images/publicImg/ppid/ppidImg/default.png');
            @endphp
            
            <label for="gambar_struktur_organisasi_input" class="form-label fw-semibold">Struktur Organisasi Ppid (Gambar)</label><br>
            
            {{-- Input file dengan class 'image-input' dan id unik --}}
            <input type="file" name="gambar_struktur_organisasi" id="gambar_struktur_organisasi_input" 
                class="image-input form-control mb-2 @error('gambar_struktur_organisasi') is-invalid @enderror" 
                style="display: none;">
            
            {{-- Kontainer pratinjau dengan class 'image-preview-container' --}}
            <div class="image-preview-container position-relative overflow-hidden" 
                style="cursor: pointer; max-width: 400px; border-radius: 0.375rem;"
                onclick="document.getElementById('gambar_struktur_organisasi_input').click()">
                
                {{-- Gambar pratinjau dengan class 'image-display' --}}
                <img src="{{ $imagePath }}" alt="Struktur Organisasi PPID" 
                    class="image-display img-fluid w-100" 
                    style="{{ $ppid ? 'display: block;' : 'display: none;' }}"
                    title="Klik untuk ganti gambar">
                
                {{-- Overlay hover --}}
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center text-white"
                    style="background: rgba(0, 0, 0, 0.6); 
                            border-radius: 0.375rem; 
                            opacity: 0; 
                            transition: opacity 0.3s ease;
                            backdrop-filter: blur(2px);">
                    <i class="material-symbols-rounded mb-2" style="font-size: 3rem;">edit</i>
                    <small class="fw-semibold">Klik untuk ganti gambar</small>
                </div>
            </div>
            
            @error('gambar_struktur_organisasi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label fw-semibold">File Regulasi Ppid (PDF)</label><br>
            @php
                use Illuminate\Support\Facades\Storage;
            
                $filePath = 'pdf/ppid/' . $ppid->file_regulasi;
                $fileExists = Storage::disk('public')->exists($filePath);
            @endphp
            
            @if($fileExists)
                <a href="{{ route('ppid.preview', $ppid->id) }}" target="_blank" class="btn btn-info btn-sm">
                    <i class="bi bi-eye"></i> Preview
                </a>
                <a href="{{ route('ppid.download', $ppid->id) }}" class="btn btn-success btn-sm">
                    <i class="bi bi-download"></i> Download
                </a>
            @else
                {{-- <small>masukkan file!</small> --}}
            @endif
            <input type="file" name="file_regulasi" class="form-control @error('file_regulasi') is-invalid @enderror">
            @error('file_regulasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- <div class="col-12">
            <label class="form-label fw-semibold">Regulasi PPID</label><br>
            <textarea name="regulasi_ppid" class="visi-misi-sejarah-desa-ppid-summernote form-control @error('regulasi_ppid') is-invalid @enderror" rows="4">{{ old('regulasi_ppid', $ppid->regulasi_ppid) }}</textarea>
            @error('regulasi_ppid')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div> --}}

        <div class="col-12">
            <label class="form-label fw-semibold">Maklumat Pelayanan</label>
            <textarea name="maklumat" class="visi-misi-sejarah-desa-ppid-summernote form-control @error('maklumat') is-invalid @enderror" rows="4">{{ old('maklumat', $ppid->maklumat) }}</textarea>
            @error('maklumat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label fw-semibold">Alamat PPID</label>
            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $ppid->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Kontak PPID (wa)</label>
            <input type="text" name="kontak" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak', $ppid->kontak) }}">
            @error('kontak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                <option value="aktif" {{ $ppid->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $ppid->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-dark">Simpan</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('gambar_struktur_organisasi_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector('.image-display');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
    // 1. Ambil semua elemen kontainer pratinjau
    const previewContainers = document.querySelectorAll('.image-preview-container');

    // 2. Lakukan perulangan untuk setiap kontainer
    previewContainers.forEach(container => {
        // 3. Temukan input file dan elemen gambar di DALAM kontainer saat ini
        const fileInput = container.previousElementSibling; // Mengambil <input> tepat sebelum <div>
        const previewImg = container.querySelector('.image-display');

        // 4. Tambahkan event listener untuk memicu klik pada input file
        container.addEventListener('click', function () {
            fileInput.click();
        });

        // 5. Tambahkan event listener untuk perubahan pada input file
        fileInput.addEventListener('change', function () {
            const file = this.files[0]; // Ambil file yang dipilih

            if (file) {
                const reader = new FileReader();

                // Muat file dan atur sumber gambar pratinjau
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block'; // Tampilkan gambar
                };

                reader.readAsDataURL(file); // Baca file sebagai URL Data
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

    /* Hover effect untuk overlay */
.image-preview-container:hover .overlay {
    opacity: 1 !important;
}

/* Efek zoom ringan pada gambar saat hover */
.image-preview-container:hover .image-display {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Reset transform pada gambar */
.image-display {
    transition: transform 0.3s ease;
}

/* Styling untuk icon */
.overlay .material-symbols-rounded {
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .image-preview-container {
        max-width: 100% !important;
    }
}
</style>

@endsection