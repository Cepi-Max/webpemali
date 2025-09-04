@extends('admin.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

<div class="form-container">
    <div class="form-header">
        <h4 class="form-title">{{ $infografisById ? 'Ubah' : 'Tambah' }} Infografis Desa Cantik</h4>
        <p class="form-subtitle">Silakan lengkapi informasi di bawah ini</p>
    </div>
    
    <form action="{{ $infografisById ? route('publikasi-desa-cantik.update', $infografisById->id) : route('publikasi-desa-cantik.save')}}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                <div class="form-card">
                    <div class="form-group mb-4">
                        <label for="judul" class="form-label">Judul Infografis</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" 
                            value="{{ old('judul', $infografisById->judul ?? '') }}" 
                            placeholder="Masukkan judul infografis" autofocus>
                        @error('judul')
                            <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="4" placeholder="Masukkan deskripsi infografis">{{ old('deskripsi', $infografisById->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-card">
                    <div class="form-group mb-4">
                        <label for="preview_image" class="form-label">Unggah File Publikasi</label>
                        
                        <div class="file-upload-container">
                            <div class="upload-area" id="uploadArea">
                                <div class="file-upload-box">
                                    <input type="file" id="preview_image" name="file_publikasi" accept=".pdf,.jpg,.jpeg,.png" class="file-input" {{ $infografisById ? '' : 'required' }}>
                                    <label for="preview_image" class="file-label">
                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="upload-text">
                                            <span class="primary-text">Pilih file atau seret ke sini</span>
                                            <span class="secondary-text">PDF, JPG, JPEG, atau PNG</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="image-preview-container">
                                <div class="image-preview" id="imagePreview">
                                    @php
                                        $imagePath = $infografisById && $infografisById->file_publikasi 
                                            ? asset('storage/images/publicImg/infografis/' . $infografisById->file_publikasi) 
                                            : asset('storage/images/publicImg/infografis/default.pdf');
                                        
                                        $extension = $infografisById && $infografisById->file_publikasi 
                                            ? pathinfo($infografisById->file_publikasi, PATHINFO_EXTENSION) 
                                            : 'pdf';
                                    @endphp
                                    
                                    @if($infografisById && $infografisById->file_publikasi)
                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                            <img src="{{ $imagePath }}" alt="Image Preview" id="imagePreviewImg">
                                        @else
                                            <div class="pdf-preview" id="pdfPreview">
                                                <i class="far fa-file-pdf"></i>
                                                <span>{{ $infografisById->file_publikasi }}</span>
                                            </div>
                                        @endif
                                        <div class="file-name" id="fileName">{{ $infografisById->file_publikasi }}</div>
                                    @else
                                        <div class="no-preview" id="noPreview">
                                            <span>Belum ada file yang dipilih</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @error('file_publikasi')
                                <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="{{ route('show.publikasi-desa-cantik') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('preview_image');
        const imagePreview = document.getElementById('imagePreview');
        const uploadArea = document.getElementById('uploadArea');
        
        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            uploadArea.classList.add('highlight');
        }
        
        function unhighlight() {
            uploadArea.classList.remove('highlight');
        }
        
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                fileInput.files = files;
                handleFiles(files);
            }
        }
        
        fileInput.addEventListener('change', function() {
            if (this.files.length) {
                handleFiles(this.files);
            }
        });
        
        function handleFiles(files) {
            const file = files[0];
            updateFilePreview(file);
        }
        
        function updateFilePreview(file) {
            if (!file) return;
            
            // Clear previous preview
            imagePreview.innerHTML = '';
            
            const fileName = document.createElement('div');
            fileName.className = 'file-name';
            fileName.id = 'fileName';
            fileName.textContent = file.name;
            
            const fileType = file.type.split('/')[0];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (fileType === 'image' || ['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.id = 'imagePreviewImg';
                    img.src = e.target.result;
                    img.alt = 'Image Preview';
                    
                    imagePreview.appendChild(img);
                    imagePreview.appendChild(fileName);
                };
                reader.readAsDataURL(file);
            } else if (fileExtension === 'pdf') {
                const pdfPreview = document.createElement('div');
                pdfPreview.className = 'pdf-preview';
                pdfPreview.id = 'pdfPreview';
                
                const icon = document.createElement('i');
                icon.className = 'far fa-file-pdf';
                
                const span = document.createElement('span');
                span.textContent = 'PDF Document';
                
                pdfPreview.appendChild(icon);
                pdfPreview.appendChild(span);
                
                imagePreview.appendChild(pdfPreview);
                imagePreview.appendChild(fileName);
            } else {
                const filePreview = document.createElement('div');
                filePreview.className = 'file-preview';
                
                const icon = document.createElement('i');
                icon.className = 'far fa-file';
                
                const span = document.createElement('span');
                span.textContent = 'Unknown File Type';
                
                filePreview.appendChild(icon);
                filePreview.appendChild(span);
                
                imagePreview.appendChild(filePreview);
                imagePreview.appendChild(fileName);
            }
        }
    });
</script>

<style>
    /* Global Styles */
    body {
        background-color: #f5f7fa;
        color: #495057;
        font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif;
    }
    
    /* Form Container */
    .form-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 0;
        background-color: transparent;
        border: none;
    }
    
    /* Form Header */
    .form-header {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .form-title {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .form-subtitle {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
    }
    
    /* Form Card */
    .form-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 25px;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }
    
    .form-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Form Controls */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        border: 1px solid #dce0e3;
        border-radius: 6px;
        padding: 10px 15px;
        font-size: 15px;
        transition: all 0.2s ease;
    }
    
    .form-control:focus {
        border-color: #5b86e5;
        box-shadow: 0 0 0 3px rgba(91, 134, 229, 0.15);
    }
    
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    
    /* File Upload Area */
    .file-upload-container {
        margin-top: 10px;
    }
    
    .upload-area {
        position: relative;
        border: 2px dashed #dce0e3;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .upload-area.highlight {
        border-color: #5b86e5;
        background-color: rgba(91, 134, 229, 0.05);
    }
    
    .file-upload-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 120px;
    }
    
    .file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }
    
    .file-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        width: 100%;
    }
    
    .upload-icon {
        font-size: 36px;
        color: #6c8cd0;
        margin-bottom: 15px;
    }
    
    .upload-text .primary-text {
        display: block;
        color: #495057;
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .upload-text .secondary-text {
        display: block;
        color: #8a94a6;
        font-size: 13px;
    }
    
    /* Image Preview Container */
    .image-preview-container {
        margin-top: 20px;
    }
    
    .image-preview {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    #imagePreviewImg {
        max-width: 100%;
        max-height: 250px;
        object-fit: contain;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    
    .file-name {
        font-size: 14px;
        color: #495057;
        margin-top: 10px;
        text-align: center;
        word-break: break-all;
    }
    
    .pdf-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .pdf-preview i {
        font-size: 50px;
        color: #e74c3c;
        margin-bottom: 10px;
    }
    
    .pdf-preview span {
        color: #495057;
    }
    
    .no-preview {
        color: #8a94a6;
        font-style: italic;
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-light {
        background-color: #f8f9fa;
        border: 1px solid #dce0e3;
        color: #495057;
    }
    
    .btn-light:hover {
        background-color: #e9ecef;
    }
    
    .btn-primary {
        background-color: #5b86e5;
        border: 1px solid #5b86e5;
        color: #fff;
    }
    
    .btn-primary:hover {
        background-color: #4a75d4;
        border-color: #4a75d4;
    }
    
    /* Error Messages */
    .text-danger {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
        display: flex;
        align-items: center;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
        border-color: #dc3545;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .form-card {
            padding: 20px;
        }
        
        .form-actions {
            flex-direction: column-reverse;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>

@endsection