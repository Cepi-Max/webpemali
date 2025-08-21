@extends('admin.layouts.main.app')

@section('content')
@include('admin.population.modal')

    <div class="alert alert-warning shadow p-4 rounded-lg">
            Silahkan perbaiki format untuk data berikut:
    </div>

    @if(count($invalidData) > 0)
    <table class="table align-items-center justify-content-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIK</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Lengkap</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Error</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">No Baris Excel</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invalidData as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row['nik'] ?? '-' }}</td>
                    <td>{{ $row['nama_lengkap'] ?? '-' }}</td>
                    <td>{{ $row['error'] ?? '-' }}</td>
                    <td class="text-center">{{ $row['no'] ?? '-' }}</td>
                </tr>
            @empty     
                <tr>
                    <td colspan="100%" class="text-center">
                    <div class="col-12 text-center py-5">
                        <i class="material-symbols-rounded text-muted mb-3 fs-1">file</i>
                        <p class="mb-0 text-muted">Tidak ada data invalid.</p>
                    </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @endif

@endsection