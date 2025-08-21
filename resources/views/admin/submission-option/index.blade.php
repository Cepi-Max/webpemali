@extends('admin.layouts.main.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 fw-semibold">Tambah</h2>
        <a href="{{ route('show.admin.submission_option.form') }}"
           class="btn btn-dark">
            Tambah
        </a>
    </div>

    <div class="table-responsive bg-white rounded shadow-sm p-3">
        <table class="table table-hover table-sm align-middle">
            <thead class="table-light text-uppercase small fw-semibold">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Jenis Surat</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jenisSurat as $js)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $js->nama }}</td>
                        <td>{{ $js->deskripsi }}</td>
                        <td>
                            <a href="{{ route('show.admin.submission_option.form', $js->id) }}"
                               class="btn btn-sm btn-dark">
                                Edit
                            </a>
                            <form action="{{ route('show.admin.submission_option.delete', $js->id) }}" method="POST" class="d-inline">
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
                        <td colspan="4" class="text-center text-muted py-3">
                            Belum ada pilihan surat yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
