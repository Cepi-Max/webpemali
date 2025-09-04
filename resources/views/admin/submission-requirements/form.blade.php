@extends('admin.layouts.main.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h2 class="h4 fw-semibold text-secondary mb-4">
                {{ isset($syaratDokumen) ? 'Edit' : 'Tambah' }} Syarat Dokumen
            </h2>

            <form action="{{ isset($syaratDokumen) ? route('show.admin.submission_requirements.save', $syaratDokumen->id) : route('show.admin.submission_requirements.save') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label fw-medium">Nama Dokumen</label>
                    <input type="text" name="nama" id="nama"
                           value="{{ old('nama', $syaratDokumen->nama ?? '') }}"
                           class="form-control @error('nama') is-invalid @enderror"
                           style="border: 1px solid #ced4da;" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('show.admin.submission_requirements') }}"
                       class="btn btn-outline-secondary me-2">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-dark">
                        {{ isset($syaratDokumen) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
