@extends('admin.layouts.main.app')

@section('content')
<style>
    .card-shadow {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-shadow-hover:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transition: box-shadow 0.15s ease-in-out;
    }
    .status-badge {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
    .icon-container {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .file-input {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .file-input input[type=file] {
        position: absolute;
        left: -9999px;
    }
    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1050;
    }
    .modal-slide {
        transform: translateX(100%);
        transition: transform 0.5s ease-in-out;
    }
    .modal-slide.show {
        transform: translateX(0);
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .custom-alert {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1060;
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.3s ease-in-out;
    }
    .custom-alert.show {
        transform: translateX(0);
        opacity: 1;
    }
</style>

<div class="min-vh-100 bg-light py-4">
    <div class="container-fluid px-4">
        <!-- Page Header Section -->
        <div class="card card-shadow mb-4 border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-container bg-dark rounded me-3">
                        <i class="fas fa-file-invoice text-white"></i>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold text-dark mb-1">Pengajuan {{ $surat->jenisSurat->nama }}</h2>
                        <p class="text-muted small mb-0">Detail dan pengelolaan pengajuan surat</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-circle me-3"></i>
                    <p class="fw-semibold mb-0">Terjadi kesalahan validasi:</p>
                </div>
                <ul class="list-unstyled ms-4 mb-0">
                @foreach ($errors->all() as $err)
                    <li class="mb-1">• {{ $err }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        {{-- Upload Completed Letter Section --}}
        @if($surat->status === 'diproses')
            <div class="card card-shadow mb-4 border-0">
                <div class="card-body p-4">
                    <h4 class="h5 fw-semibold mb-3 text-dark d-flex align-items-center">
                        <i class="fas fa-upload text-muted me-2"></i>
                        <span>Unggah Surat Selesai Dibuat</span>
                    </h4>
                    <form method="POST" action="{{ route('admin.surat.kirim', $surat->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <input type="file" name="file_surat_jadi" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required 
                                    class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-dark w-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Kirim Surat
                                </button>
                            </div>
                        </div>
                    </form>
                    @if($surat->file_jadi)
                        <div class="mt-3 text-muted d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Surat sudah diunggah:</span>
                            <a href="{{ asset('storage/' . $surat->file_jadi) }}" class="text-decoration-none ms-2" target="_blank">Lihat File</a>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Surat Details Card --}}
        <div class="card card-shadow mb-4 border-0">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Jenis Surat</p>
                        <p class="fw-semibold text-dark mb-0">{{ $surat->jenisSurat->nama }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Pemohon</p>
                        <p class="fw-semibold text-dark mb-0">{{ $surat->pemohon->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Tanggal Pengajuan</p>
                        <p class="fw-semibold text-dark mb-0">
                            {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y, H:i') }}
                            <small class="text-muted">({{ \Carbon\Carbon::parse($surat->created_at)->diffForHumans() }})</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Status</p>
                        @php
                            $statusClasses = [
                                'selesai' => 'bg-success',
                                'ditolak' => 'bg-danger',
                                'diproses' => 'bg-warning',
                                'pending' => 'bg-secondary',
                            ];
                        @endphp
                        <span class="badge status-badge {{ $statusClasses[$surat->status] ?? 'bg-secondary' }}">
                            @if($surat->status === 'selesai')
                                <i class="fas fa-check-circle me-1"></i>
                            @elseif($surat->status === 'ditolak')
                                <i class="fas fa-times-circle me-1"></i>
                            @elseif($surat->status === 'diproses')
                                <i class="fas fa-sync-alt me-1 animate-spin"></i>
                            @else
                                <i class="fas fa-hourglass-half me-1"></i>
                            @endif
                            {{ ucfirst($surat->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Document Requirements Section --}}
        <div class="mb-4">
            <h5 class="h5 fw-semibold mb-3 text-dark d-flex align-items-center">
                <i class="fas fa-clipboard-list text-muted me-2"></i>
                <span>Dokumen Syarat</span>
            </h5>
            <form method="POST" action="{{ route('admin.surat.updateStatus', $surat->id) }}">
                @csrf
                <div class="row g-4">
                    @forelse ($surat->dokumenSurat as $dok)
                        <div class="col-12">
                            <div class="card card-shadow card-shadow-hover border-0">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                        <div class="d-flex align-items-center mb-3 mb-md-0">
                                           
                                            <div>
                                                <p class="h6 fw-semibold text-dark mb-1">{{ $dok->syarat->nama }}</p>
                                                <p id="status-display-{{ $dok->id }}" class="text-muted small mb-0">
                                                    @if ($dok->status === 'valid')
                                                        <span class="text-success fw-semibold">Valid</span>
                                                    @elseif ($dok->status === 'invalid')
                                                        <span class="text-danger fw-semibold">Tidak Valid @if($dok->catatan) – {{ $dok->catatan }}@endif</span>
                                                    @else
                                                        Belum Divalidasi
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <!-- Hidden inputs for status & catatan -->
                                            <input type="hidden" name="validasi[{{ $dok->id }}][status]"  id="status-input-{{ $dok->id }}" value="{{ $dok->status }}">
                                            <input type="hidden" name="validasi[{{ $dok->id }}][catatan]" id="catatan-input-{{ $dok->id }}" value="{{ $dok->catatan }}">

                                            <!-- Preview Button -->
                                            <button
                                                type="button"
                                                class="btn btn-dark preview-btn"
                                                data-file="{{ asset('storage/' . $dok->file_path) }}"
                                                data-title="{{ $dok->syarat->nama }}"
                                                data-id="{{ $dok->id }}"
                                                data-current-status="{{ $dok->status }}"
                                                data-current-note="{{ $dok->catatan }}"
                                            >
                                                <i class="fas fa-eye me-2"></i>
                                                <span>Periksa</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card card-shadow border-0">
                                <div class="card-body p-5 text-center text-muted">
                                    <div class="bg-light p-4 rounded-circle d-inline-flex mb-3">
                                        <i class="fas fa-file-excel display-6 text-muted"></i>
                                    </div>
                                    <h3 class="h5 fw-medium text-muted mb-2">Tidak Ada Dokumen Persyaratan</h3>
                                    <p class="small text-muted mb-0">Pengajuan ini tidak memiliki dokumen persyaratan terlampir.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Final Submit Section -->
                <div class="card card-shadow border-0 mt-4">
                    <div class="card-body p-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label for="status" class="form-label fw-medium text-dark">
                                    Status Akhir Permohonan
                                </label>
                                <select id="status" name="status" class="form-select">
                                    <option value="diproses" {{ $surat->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $surat->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ $surat->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-dark w-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-save me-2"></i>
                                    <span>Simpan Status & Validasi</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- PDF/Image Preview Modal --}}
        <div id="pdfModal" class="position-fixed top-0 start-0 w-100 h-100 modal-overlay d-none">
            <div class="d-flex h-100">
                <div class="flex-grow-1 p-4 d-flex align-items-center justify-content-center">
                    <iframe id="pdfViewer" src="" class="w-100 h-100 bg-white rounded shadow-lg" frameborder="0"></iframe>
                </div>
                <div class="bg-white h-100 modal-slide" style="width: 400px; max-width: 90vw;">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom bg-light">
                        <h2 id="pdfTitle" class="h5 fw-bold text-dark mb-0 text-truncate me-3"></h2>
                        <div class="d-flex align-items-center">
                            <a id="detailPdf" href="{{ route('dokumen.show', basename($surat->file_jadi)) }}" target="_blank" class="btn btn-sm btn-outline-dark me-2" title="Buka dokumen dalam tab baru">
                                <i class="fas fa-expand-alt"></i>
                            </a>
                            <button onclick="closeModal()" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 overflow-auto" style="height: calc(100% - 140px);">
                        <input type="hidden" id="modal-doc-id">
                        
                        <!-- Status Validasi -->
                        <div class="mb-4">
                            <label for="modal-status" class="form-label fw-medium text-dark">
                                Status Validasi Dokumen
                            </label>
                            <select id="modal-status" class="form-select">
                                <option value="" disabled selected>— Pilih Status —</option>
                                <option value="valid">Valid</option>
                                <option value="invalid">Tidak Valid</option>
                            </select>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-4">
                            <label for="modal-catatan" class="form-label fw-medium text-dark">
                                Catatan (Opsional)
                            </label>
                            <textarea id="modal-catatan" rows="3" placeholder="Masukkan catatan jika perlu…" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Footer Button for Modal -->
                    <div class="p-4 bg-light border-top">
                        <button onclick="saveValidation()" class="btn btn-dark w-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-check me-2"></i>
                            <span>Simpan & Tutup</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let currentDocId = null;

    document.querySelectorAll('.preview-btn').forEach(button => {
        button.addEventListener('click', () => {
            const file = button.getAttribute('data-file');
            const title = button.getAttribute('data-title');
            const id = button.getAttribute('data-id');
            const currentStatus = button.getAttribute('data-current-status');
            const currentNote = button.getAttribute('data-current-note');

            currentDocId = id;

            document.getElementById('detailPdf').href = file;
            document.getElementById('pdfViewer').src = file;
            document.getElementById('pdfTitle').innerText = title;
            document.getElementById('modal-doc-id').value = id;

            // Set modal's status and catatan based on current data
            document.getElementById('modal-status').value = currentStatus || '';
            document.getElementById('modal-catatan').value = currentNote || '';

            document.getElementById('pdfModal').classList.remove('d-none');
            setTimeout(() => {
                document.querySelector('.modal-slide').classList.add('show');
            }, 10);
        });
    });

    function closeModal() {
        document.querySelector('.modal-slide').classList.remove('show');
        setTimeout(() => {
            document.getElementById('pdfModal').classList.add('d-none');
            document.getElementById('pdfViewer').src = '';
        }, 500);
    }

    function saveValidation() {
        const id = document.getElementById('modal-doc-id').value;
        const status = document.getElementById('modal-status').value;
        const catatan = document.getElementById('modal-catatan').value;

        if (!status) {
            showCustomAlert('Silahkan pilih status validasi terlebih dulu!', 'warning');
            return;
        }

        // Update hidden inputs for form submission
        document.getElementById(`status-input-${id}`).value = status;
        document.getElementById(`catatan-input-${id}`).value = catatan;

        // Update display on the main list
        const statusDisplayEl = document.getElementById(`status-display-${id}`);
        statusDisplayEl.className = 'text-muted small mb-0';

        if (status === 'valid') {
            statusDisplayEl.innerHTML = '<span class="text-success fw-semibold">Valid</span>';
        } else {
            statusDisplayEl.innerHTML = `<span class="text-danger fw-semibold">Tidak Valid${catatan ? ' – ' + catatan : ''}</span>`;
        }

        closeModal();
    }

    // Custom Alert Function
    function showCustomAlert(message, type = 'info') {
        let alertClass = 'alert-dark';
        let iconClass = 'fas fa-info-circle';

        if (type === 'success') {
            alertClass = 'alert-success';
            iconClass = 'fas fa-check-circle';
        } else if (type === 'error') {
            alertClass = 'alert-danger';
            iconClass = 'fas fa-times-circle';
        } else if (type === 'warning') {
            alertClass = 'alert-warning';
            iconClass = 'fas fa-exclamation-triangle';
        }

        const alertContainer = document.createElement('div');
        alertContainer.className = `alert ${alertClass} custom-alert d-flex align-items-center shadow-lg border-0`;
        alertContainer.innerHTML = `
            <i class="${iconClass} me-3"></i>
            <span class="fw-medium">${message}</span>
        `;
        document.body.appendChild(alertContainer);

        // Animate in
        setTimeout(() => {
            alertContainer.classList.add('show');
        }, 100);

        // Animate out after 4 seconds
        setTimeout(() => {
            alertContainer.classList.remove('show');
            setTimeout(() => alertContainer.remove(), 300);
        }, 4000);
    }

    // Close modal when clicking outside
    document.getElementById('pdfModal').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            closeModal();
        }
    });
</script>
@endsection