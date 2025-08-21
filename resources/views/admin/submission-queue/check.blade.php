@extends('admin.layouts.main.app')

@section('content')
<div class="container py-5"> {{-- Consistent Bootstrap container with vertical padding --}}

    <!-- Page Header Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-file-alt text-white fs-5"></i> {{-- Icon for document details --}}
                </div>
            </div>
            <div>
                <h2 class="card-title h4 text-dark mb-0">Pengajuan {{ $surat->jenisSurat->nama }}</h2>
                <p class="card-subtitle text-muted small">Detail permohonan Kartu Keluarga Baru</p> {{-- More descriptive subtitle --}}
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-warning fade show d-flex align-items-start" role="alert">
            <i class="fas fa-exclamation-circle me-2 mt-1"></i>
            <div>
                <p class="fw-bold mb-1">Terjadi kesalahan validasi:</p>
                <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Applicant Details Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light d-flex align-items-center">
            <i class="fas fa-user text-secondary me-2"></i>
            <h5 class="card-title h6 text-dark mb-0">Informasi Pemohon</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-borderless mb-0"> {{-- Simpler table --}}
                    <tbody>
                        <tr>
                            <td class="fw-semibold text-dark ps-0" style="width: 150px;">Nama Pengirim</td>
                            <td class="text-dark">: {{ $submissionBySlug->applicant->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-dark ps-0">Email</td>
                            <td class="text-dark">: {{ $submissionBySlug->applicant->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-dark ps-0">No. WA/Telepon</td>
                            <td class="text-dark">: {{ $submissionBySlug->applicant->number_phone }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-dark ps-0">Tanggal Pengajuan</td>
                            <td class="text-dark">: {{ \Carbon\Carbon::parse($submissionBySlug->created_at)->translatedFormat('d M Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Document Validation Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light d-flex align-items-center">
            <i class="fas fa-file-check text-secondary me-2"></i>
            <h5 class="card-title h6 text-dark mb-0">Validasi Dokumen Syarat</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kartu_keluarga_baru.update', $submissionBySlug->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Use PUT method for update --}}

                {{-- Document Items --}}
                @php
                    $documents = [
                        'surat_pengantar_rt' => ['label' => 'Surat Pengantar RT', 'path_prefix' => 'kartu-keluarga/kartu-keluarga-baru/surat-pengantar-rt/'],
                        'buku_nikah' => ['label' => 'Buku Nikah', 'path_prefix' => 'kartu-keluarga/kartu-keluarga-baru/buku-nikah/'],
                        'akta_kelahiran' => ['label' => 'Akta Kelahiran', 'path_prefix' => 'kartu-keluarga/kartu-keluarga-baru/akta-kelahiran/'],
                        'ijazah_terakhir' => ['label' => 'Ijazah Terakhir', 'path_prefix' => 'kartu-keluarga/kartu-keluarga-baru/ijazah-terakhir/'],
                        'kartu_keluarga_orang_tua' => ['label' => 'Kartu Keluarga Orang Tua', 'path_prefix' => 'kartu-keluarga/kartu-keluarga-baru/kartu-keluarga-orang-tua/'],
                        'e_ktp' => ['label' => 'E-KTP', 'path_prefix' => 'kartu-keluarga/kartu-keluarga-baru/e-ktp/'],
                    ];
                @endphp

                @foreach ($documents as $field => $docInfo)
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-flex align-items-center">
                            <i class="fas fa-file-alt text-muted me-2"></i>
                            {{ $docInfo['label'] }}
                        </label>
                        @error('status_' . $field)
                            <small class="text-danger d-block mb-2">{{ $message }}</small>
                        @enderror
                        <div class="ratio ratio-16x9 border rounded mb-2">
                            @php
                                $filePath = asset('storage/' . $docInfo['path_prefix'] . $submissionBySlug->$field);
                                $fileExtension = pathinfo($submissionBySlug->$field, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                            @endphp
                            @if($isImage)
                                <img src="{{ $filePath }}" class="img-fluid" alt="{{ $docInfo['label'] }} Preview">
                            @else
                                <iframe src="{{ $filePath }}" allowfullscreen></iframe>
                            @endif
                        </div>
                        <div class="d-flex justify-content-center mt-3 gap-3">
                            <div>
                                <input type="radio" class="btn-check" name="status_{{ $field }}" id="status-{{ $field }}-invalid" value="0" {{ old('status_' . $field, $submissionBySlug->{'status_' . $field}) == '0' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger rounded-pill" for="status-{{ $field }}-invalid">
                                    <i class="fas fa-times-circle me-1"></i> Tidak Valid
                                </label>
                            </div>
                            <div>
                                <input type="radio" class="btn-check" name="status_{{ $field }}" id="status-{{ $field }}-valid" value="1" {{ old('status_' . $field, $submissionBySlug->{'status_' . $field}) == '1' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success rounded-pill" for="status-{{ $field }}-valid">
                                    <i class="fas fa-check-circle me-1"></i> Valid
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach

                <hr class="my-4">

                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-pill px-4 fw-semibold">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                        <i class="fas fa-save me-2"></i> Simpan Validasi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection