@extends('admin.layouts.main.app')

@section('content')
<div>
    <form 
        action="{{ isset($jenisSurat) ? route('show.admin.submission_option.save', $jenisSurat->id) : route('show.admin.submission_option.save') }}" 
        method="POST">
        @csrf

        <!-- Tombol Buka Modal -->
        <div class="container my-3 text-center">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#syaratModal">
                Atur Syarat Dokumen
            </button>
        </div>

        <!-- Modal Bootstrap dengan Tabel -->
        <div class="modal fade" id="syaratModal" tabindex="-1" aria-labelledby="syaratModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="syaratModalLabel">Atur Syarat Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 60px;">Pilih</th>
                                        <th>Nama Syarat</th>
                                        <th style="width: 80px;">Wajib</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($syaratDokumen as $syarat)
                                        <tr>
                                            <!-- Kolom Centang -->
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="syarat_id[]" value="{{ $syarat->id }}"
                                                        id="syarat_{{ $syarat->id }}"
                                                        {{ isset($selected) && in_array($syarat->id, $selected) ? 'checked' : '' }}>
                                                </div>
                                            </td>

                                            <!-- Kolom Nama Syarat -->
                                            <td>
                                                <label for="syarat_{{ $syarat->id }}" class="mb-0 fw-medium" style="cursor: pointer;">
                                                    {{ $syarat->nama }}
                                                </label>
                                            </td>

                                            <!-- Kolom Wajib -->
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="wajib[]" value="{{ $syarat->id }}"
                                                        id="wajib_{{ $syarat->id }}"
                                                        {{ isset($wajib) && in_array($syarat->id, $wajib) ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Input Jenis Surat -->
        <div class="container">
            <div class="card shadow rounded-4 mx-auto mb-5" style="max-width: 600px;">
                <div class="card-body">
                    <h2 class="h5 fw-semibold mb-4">
                        {{ isset($jenisSurat) ? 'Edit Jenis Surat' : 'Tambah Jenis Surat' }}
                    </h2>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-medium">Nama Jenis Surat</label>
                        <input type="text" name="nama" id="nama"
                            class="form-control"
                            style="border: 1px solid #ced4da;"
                            value="{{ old('nama', isset($jenisSurat) ? $jenisSurat->nama : '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-medium">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="form-control"
                            style="border: 1px solid #ced4da;">{{ old('deskripsi', isset($jenisSurat) ? $jenisSurat->deskripsi : '') }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-dark">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Paksa semua checkbox tampil standar dan pakai warna dark */
    input[type="checkbox"].form-check-input {
        accent-color: #212529 !important;
        appearance: auto !important;
        -webkit-appearance: checkbox !important;
    }
</style>

@endsection
