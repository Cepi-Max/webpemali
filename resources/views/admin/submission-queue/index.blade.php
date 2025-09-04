@extends('admin.layouts.main.app')

@section('content')

{{-- Pastikan Anda menyertakan file modal di sini jika diperlukan,
     misalnya @include('admin.population.modal') --}}

<div class="container py-5"> {{-- Container utama dengan padding atas dan bawah --}}

    <div class="card shadow-sm mb-4"> {{-- Menggunakan card Bootstrap untuk header --}}
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-list-ol text-white fs-5"></i>
                </div>
            </div>
            <div>
                <h2 class="card-title h4 text-dark mb-0">Antrian Pembuatan Surat</h2>
                <p class="card-subtitle text-muted small">Daftar pengajuan surat yang menunggu diproses</p>
            </div>
        </div>
    </div>

    {{-- Contoh Alert (jika ada) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0"> {{-- Menggunakan card Bootstrap untuk tabel --}}
        <div class="table-responsive">
            <table class="table table-hover table-borderless mb-0"> {{-- table-borderless untuk mengurangi garis --}}
                <thead class="bg-light">
                    <tr>
                        <th scope="col" class="py-3 px-4 text-start text-muted text-uppercase small">#</th>
                        <th scope="col" class="py-3 px-4 text-start text-muted text-uppercase small">Jenis Surat</th>
                        <th scope="col" class="py-3 px-4 text-start text-muted text-uppercase small">Pemohon</th>
                        <th scope="col" class="py-3 px-4 text-start text-muted text-uppercase small">Status</th>
                        <th scope="col" class="py-3 px-4 text-start text-muted text-uppercase small">Tanggal</th>
                        <th scope="col" class="py-3 px-4 text-center text-muted text-uppercase small">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($surats as $surat)
                    <tr>
                        <td class="py-3 px-4">
                            <div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center fw-bold small" style="width: 35px; height: 35px;">
                                {{ $loop->iteration }}
                            </div>
                        </td>
                        <td class="py-3 px-4 fw-medium text-dark">{{ $surat->jenisSurat->nama }}</td>
                        <td class="py-3 px-4 text-secondary">{{ $surat->pemohon->name }}</td>
                        <td class="py-3 px-4">
                            @php
                                $statusClasses = match ($surat->status) {
                                    'selesai' => 'bg-success-subtle text-success',
                                    'ditolak' => 'bg-danger-subtle text-danger',
                                    'diproses' => 'bg-warning-subtle text-warning',
                                    'pending' => 'bg-info-subtle text-info',
                                    default => 'bg-secondary-subtle text-secondary',
                                };
                            @endphp
                            <span class="badge {{ $statusClasses }} px-2 py-1 rounded-pill small">
                                @if($surat->status === 'selesai')
                                    <i class="fas fa-check-circle me-1"></i>
                                @elseif($surat->status === 'ditolak')
                                    <i class="fas fa-times-circle me-1"></i>
                                @elseif($surat->status === 'diproses')
                                    <i class="fas fa-sync-alt me-1 fa-spin"></i>
                                @else
                                    <i class="fas fa-hourglass-half me-1"></i>
                                @endif
                                {{ ucfirst($surat->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-muted small">
                            {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('admin.surat.show', $surat->id) }}"
                               class="btn btn-primary btn-sm rounded-pill px-3 py-2 fw-semibold">
                                <i class="fas fa-eye me-1"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <div class="bg-light p-3 rounded-circle mb-3">
                                    <i class="fas fa-hourglass-start text-secondary fs-3"></i>
                                </div>
                                <h3 class="h6 text-dark mb-2">Tidak Ada Antrian Surat</h3>
                                <p class="small text-muted mb-3">Semua pengajuan surat telah selesai diproses atau belum ada pengajuan baru.</p>
                                {{-- Jika ada, tambahkan tautan untuk melihat semua pengajuan --}}
                                {{--
                                <a href="{{ route('admin.some_other_page') }}"
                                   class="btn btn-outline-primary btn-sm rounded-pill">
                                    <i class="fas fa-search me-2"></i>
                                    Lihat Semua Pengajuan
                                </a>
                                --}}
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($surats->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3">
            {{ $surats->links('pagination::bootstrap-5') }} {{-- Pastikan Anda menggunakan view pagination Bootstrap 5 --}}
        </div>
        @endif
    </div>
</div>
@endsection