<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="importExcelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-light font-weight-bold" id="importExcelLabel">
                    Import file Excel
                </h5>
            </div>
            <form action="{{ route('populations.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group d-flex flex-column">
                        <label for="file" class="font-weight-bold">
                            Pilih file Excel
                        </label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".xls,.xlsx" required>
                        <small class="form-text text-muted">Format yang didukung: .xls, .xlsx</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-upload me-2"></i>Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>