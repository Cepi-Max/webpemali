@extends('admin.layouts.main.app')

@section('content')

<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3 text-dark">
        <span>Profil Desa</span>
    </div>
        <form action="{{ $villageProfiles ?  route('profile_village.update', $villageProfiles->id) : route('profile_village.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Desa</label>
                <input type="text" class="form-control" name="nama_desa" value="{{ $villageProfiles->nama_desa ?? '' }}" placeholder="Nama desa belum dimasukkan." required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Visi</label>
                <textarea class="visi-misi-sejarah-desa-ppid-summernote form-control" name="visi" rows="3" placeholder="Visi desa belum dimasukkan." data-height="100" required>{{ $villageProfiles->visi ?? '' }}</textarea>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Misi</label>
                <textarea class="visi-misi-sejarah-desa-ppid-summernote form-control" name="misi" rows="3" placeholder="Misi desa belum dimasukkan." data-height="100" required>{{ $villageProfiles->misi ?? '' }}</textarea>
            </div>
    
            <div class="row mb-3">
                <div class="col-md-9">
                    <label class="form-label">Sejarah</label>
                    <textarea class="visi-misi-sejarah-desa-ppid-summernote form-control" name="sejarah" rows="4" placeholder="Sejarah desa belum dimasukkan.">{{ $villageProfiles->sejarah ?? '' }}</textarea>
                </div>
                {{-- <div class="col-md-3">
                    
                    
                    <div class="avatar-upload">
                        <div>
                           

                            <label for="image"></label>
                           
                        </div>
                    </div>
                    
                </div> --}}
                <div class="col-md-3">
                    @php
                        $imagePath = $villageProfiles &&  $villageProfiles->sejarah_image 
                            ? asset('storage/images/publicImg/villageProfile/villageProfileImg/' . $villageProfiles->sejarah_image) 
                            : asset('storage/images/publicImg/villageProfile/villageProfileImg/default.png');
                    @endphp
                     <input type="file" id="preview_image" name="sejarah_image" accept="image/*" style="display: none;">
                     @if($villageProfiles)
                        <input type="hidden" name="oldImage" value="{{ $villageProfiles->image }}">
                    @endif

                    <div class="position-relative image-preview" style="cursor: pointer;" id="imagePreview">
                        <img src="{{ $imagePath }}"
                             class="w-100"
                             alt="belum ada gambar"
                             id="imagePreviewImg"
                             title="Klik untuk ganti gambar"
                             style="{{ $villageProfiles ? 'display: block;' : 'display: none;' }}">
                      
                        <!-- Overlay -->
                        <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center bg-dark bg-opacity-50 text-white opacity-0"
                             style="border-radius: 0.375rem; transition: 0.3s;">
                             <i class="material-symbols-rounded text-muted mb-3 fs-1">edit</i></i>
                          <small>Klik untuk ganti gambar sejarah</small>
                        </div>
                    </div>
                    @error('sejarah_image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>                  
            </div>
    
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Luas Desa (km²)</label>
                    <input type="number" step="0.01" class="form-control" name="luas_desa" value="{{ $villageProfiles->luas_desa ?? '' }}" placeholder="Luas desa belum dimasukkan." required>
                </div>
    
                <div class="col-md-4">
                    <label class="form-label">Kode Pos</label>
                    <input type="number" class="form-control" name="kode_pos" value="{{ $villageProfiles->kode_pos ?? '' }}" placeholder="Kode pos desa belum dimasukkan." required>
                </div>
            </div>
    
            <h5 class="mt-4">Batas Wilayah</h5>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Utara</label>
                    <input type="text" class="form-control" name="batas_utara" value="{{ $villageProfiles->batas_utara ?? '' }}" placeholder="Batas utara desa belum dimasukkan." required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Selatan</label>
                    <input type="text" class="form-control" name="batas_selatan" value="{{ $villageProfiles->batas_selatan ?? '' }}" placeholder="Batas selatan desa belum dimasukkan." required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Timur</label>
                    <input type="text" class="form-control" name="batas_timur" value="{{ $villageProfiles->batas_timur ?? '' }}" placeholder="Batas timur desa belum dimasukkan." required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Barat</label>
                    <input type="text" class="form-control" name="batas_barat" value="{{ $villageProfiles->batas_barat ?? '' }}" placeholder="Batas barat desa belum dimasukkan." required>
                </div>
            </div>
    
            <div class="mb-3 mt-3">
                <label class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" rows="2" placeholder="Alamat desa belum dimasukkan." required>{{ $villageProfiles->alamat ?? '' }}</textarea>
            </div>
    
            <button type="submit" class="btn btn-dark">Simpan</button>
        </form>
    </div>
</div>


<script>
    // Select the input and preview elements
    const fileInput = document.getElementById('preview_image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('imagePreviewImg');

    // Triger input gambar-sejarah
    document.getElementById('imagePreview').addEventListener('click', function () {
        document.getElementById('preview_image').click();
    });

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
        border-radius: 0.375rem;
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
        display: none;
    }
    input::placeholder {
        font-style: italic;
    }
    textarea::placeholder {
        font-style: italic;
    }

    .image-preview:hover .overlay {
    opacity: 1 !important;
  }

</style>

@endsection