@extends('admin.layouts.main.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-auto mt-3">
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle d-flex align-items-center gap-2" 
                            type="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                        <i class="fas fa-cog"></i>
                        <span class="fw-medium">Aksi</span>
                    </button>
                    <ul class="dropdown-menu shadow">
                        <li><h6 class="dropdown-header">Manajemen Galeri</h6></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('show.galleries.create') }}">
                                <i class="fas fa-plus-circle text-gray-400"></i>
                                <span>Tambah Foto</span>
                            </a>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center gap-2" id="selectAllPhotos">
                                <i class="fas fa-check-square text-gray-400"></i>
                                <span>Pilih Semua Foto</span>
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-danger" id="deleteSelected">
                                <i class="fas fa-trash-alt text-danger"></i>
                                <span>Hapus Terpilih</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0">Daftar Galeri</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('gallery.delete') }}" method="post" id="form-delete">
        @csrf
        <div class="row g-4">
            @forelse ($galleries['data'] as $gallery)
            <div class="col-12 col-sm-6 col-lg-2" style="padding: 10px;">
                <div class="card h-100 shadow-sm">
                    <div class="position-relative">
                        <div class="position-absolute top-0 start-0 m-2 z-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input checkItem" name="delete_ids[]" value="{{ $gallery['id'] }}">
                            </div>
                        </div>
                        <div class="ratio ratio-4x3 card-img-top overflow-hidden">
                            <img src="{{ asset('storage/images/publicImg/gallery/galleryImg/' . $gallery['image']) }}" alt="{{ $gallery['title'] }}" class="object-fit-cover w-100 h-100 modal-trigger" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{ asset('storage/images/publicImg/gallery/galleryImg/' . $gallery['image']) }}">
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title text-truncate mb-1">{{ $gallery['title'] }}</h6>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="material-symbols-rounded text-muted mb-3 fs-1">image</i>
                    <p class="mb-0 text-muted">Tidak ada galeri ditemukan.</p>
                </div>
            @endforelse
        </div>
        </form>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Preview Gambar">
            </div>
        </div>
    </div>
</div>

@include('admin.gallery.modal')

<style>
.form-check-input {
    position: relative !important;
    z-index: 2 !important;
    width: 1.2rem !important;
    height: 1.2rem !important;
    opacity: 1 !important;
    visibility: visible !important;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Modal Image Preview
    const modalImage = document.getElementById('modalImage');
    if (modalImage) {
        document.querySelectorAll('.modal-trigger').forEach(img => {
            img.addEventListener('click', function () {
                modalImage.src = this.getAttribute('data-src');
            });
        });
    }

    // Fungsi Select All Photos
    const selectAllBtn = document.getElementById('selectAllPhotos');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.checkItem');
            const isAllChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            checkboxes.forEach(checkbox => {
                checkbox.checked = !isAllChecked;
            });
        });
    }

    // Fungsi Hapus Terpilih
    const deleteSelectedBtn = document.getElementById('deleteSelected');
    const alertMessage = document.getElementById('alertMessage');

    if (deleteSelectedBtn) {
        deleteSelectedBtn.addEventListener('click', function() {
            console.log("Tombol deleteSelected diklik!");

            const checkedBoxes = document.querySelectorAll('.checkItem:checked');
            console.log("Jumlah foto yang dipilih:", checkedBoxes.length);

            if (checkedBoxes.length === 0) {
                console.log("Tidak ada foto yang dipilih, menampilkan alert!");
                alertMessage.style.opacity = '1';
                alertMessage.style.transition = 'opacity 0.4s ease-out, transform 0.4s ease-out';
                alertMessage.style.transform = 'translate(-50%, 0)';

                setTimeout(() => {
                    alertMessage.style.opacity = '0';
                    alertMessage.style.transform = 'translate(-50%, -20px)';
                }, 1000);

                return;
            }

            console.log("Menampilkan modal konfirmasi hapus.");
            const modalElement = document.getElementById('deleteConfirmationModal');
            const selectedCountElement = document.getElementById('selectedCount');

            if (modalElement && selectedCountElement) {
                const modal = new bootstrap.Modal(modalElement);
                selectedCountElement.textContent = checkedBoxes.length;
                modal.show();
            }
        });
    }

    // Konfirmasi Hapus
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            const formDelete = document.getElementById('form-delete');
            if (formDelete) {
                formDelete.submit();
            }
        });
    }
});

</script>
@endsection
