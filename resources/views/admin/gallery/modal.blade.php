<!-- Modal untuk Peringatan tidak ada foto terpilih -->
<div id="alertMessage" class="alert alert-danger position-fixed" 
     style="top: 10px; left: 50%; transform: translate(-50%, -20px); opacity: 0; transition: opacity 0.4s ease-out, transform 0.4s ease-out;">
    Tidak ada foto yang dipilih!
</div>

<!-- Modal untuk Konfirmasi Hapus -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apa Anda yakin ingin menghapus <span id="selectedCount"></span> foto?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button id="confirmDelete" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>
