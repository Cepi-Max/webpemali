@extends('admin.layouts.main.app')

@section('content')
<div class="container mt-4 p-4 bg-white shadow rounded-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-semibold text-secondary">Daftar Syarat Dokumen</h2>
        <a href="{{ route('show.admin.submission_requirements.form') }}" class="btn btn-dark">
            + Tambah Syarat Dokumen
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-sm align-middle">
            <thead class="table-light text-uppercase small fw-semibold">
                <tr>
                    <th scope="col" class="small">No</th>
                    <th scope="col" class="small text-start">Nama Syarat</th>
                    <th scope="col" class="small text-start">Status</th>
                    <th scope="col" class="small">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($syaratDokumen as $index => $syarat)
                <tr>
                    <td class="text-muted small text-center">{{ $index + 1 }}</td>
                    <td class="fw-medium">{{ $syarat->nama }}</td>
                    <td>
                        <span class="badge rounded-pill 
                            {{ $syarat->wajib ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">
                            {{ $syarat->wajib ? 'Wajib' : 'Opsional' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('show.admin.submission_requirements.form', $syarat->id) }}" class="btn btn-sm btn-dark me-1">
                            Edit
                        </a>
                        <form action="{{ route('show.admin.submission_requirements.delete', $syarat->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Belum ada syarat dokumen yang ditentukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Paksa border bawah pada semua baris */
    table tbody tr {
        border-bottom: 1px solid #dee2e6;
    }

    /* Khusus terakhir, pastikan tidak hilang */
    table tbody tr:last-child {
        border-bottom: 1px solid #dee2e6 !important;
    }
</style>

@endsection
