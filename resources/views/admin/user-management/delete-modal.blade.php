<!-- Modal Konfirmasi -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title text-danger fw-bold" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">
                    Apakah kamu yakin ingin menghapus pengguna ini? Tindakan ini tidak bisa dibatalkan.
                </p>
                
                {{-- action ada di script --}}
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="confirm_delete" id="confirm_delete" required>
                        <label class="form-check-label text-sm text-muted" for="confirm_delete">
                            Saya yakin ingin menghapus pengguna ini
                        </label>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>
                            Hapus Permanen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>