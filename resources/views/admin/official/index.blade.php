@extends('admin.layouts.main.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-2 mt-3">
                    <a href="{{ route('show.officials.form') }}" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center w-80">
                        <span>Tambah</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="#">
                        @csrf
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="Cari Aparatur" name="search" required autocomplete="off">
                            <button class="search-button" type="submit">
                                <i class="fas fa-search"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow d-none d-md-block">
        <div class="card-header bg-dark text-white">
            <h5 class="card-title mb-0">Daftar Aparatur Desa</h5>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-5 d-flex justify-content-center">
                @forelse ($officials as $official)
                    <div class="col-lg-3">
                        <div class="card h-100">
                            <img src="{{ asset('storage/images/publicImg/official/officialImg/' . $official->image) }}" class="card-img-top object-fit-cover" alt="{{ $official->name }}">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h6 class="card-title">{{ $official->name }}</h6>
                                <p class="card-text">{{ $official->position }}</p>
                                <a href="{{ route('show.official.detail', $official->slug) }}" class="btn btn-dark mt-auto">Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="material-symbols-rounded text-muted mb-3 fs-1">badge</i>
                        <p class="mb-0 text-muted">Tidak ada data aparatur ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $officials->links() }}
    </div>

    <style>
        .object-fit-cover { object-fit: cover; }
        .transition-300 { transition: all 0.3s ease; }
        .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important; }
    </style>
@endsection
