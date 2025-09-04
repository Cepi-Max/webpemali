@extends('admin.layouts.main.app')

@section('content')

      <div class="card shadow mb-4">
          <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-2 mt-3">
                        <a href="{{ route('show.constructions.form') }}" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center w-80">
                            <span>Tambah</span>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <form action="#">
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="cari pembangunan" id="search" name="search" required autocomplete="off">
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
  
      <!-- Tabel Desktop -->
      <div class="card shadow d-none d-md-block">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">Daftar Pembangunan</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-hover text-center">
                      <thead>
                            @if ($constructions->isNotEmpty())
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 20%">Nama Kegiatan</th>
                                <th style="width: 10%">Volume</th>
                                <th style="width: 17%">Total Anggaran</th>
                                <th style="width: 8%">Tahun</th>
                                <th style="width: 15%">Pelaksana</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                            @endif
                      </thead>
                      <tbody>
                              @forelse ($constructions as $index => $construction)
                              <tr>
                                  <td class="align-middle">
                                    {{ $constructions->firstItem() + $index }}
                                  </td>
                                  <td class="align-middle"><b>{{ \Illuminate\Support\Str::limit($construction->title, 30) }}</b></td>
                                  <td class="align-middle">{{ $construction->construction_volume }}</td>
                                  <td class="align-middle">Rp. {{ number_format($construction->total_budget, 2, ',', '.') }}</td>
                                  <td class="align-middle">{{ $construction->fiscal_year }}</td>
                                  <td class="align-middle">{{ $construction->construction_implementer }}</td>
                                  <td class="align-middle">
                                      <div class="d-flex justify-content-center align-items-center gap-2">
                                          <a href="{{ route('show.constructions.documentation', $construction->slug) }}" class="btn btn-success btn-sm" title="Lihat Dokumentasi" data-bs-toggle="tooltip">
                                              <i class="fa-solid fa-file"></i>
                                          </a> |<a href="{{ route('show.construction.detail', $construction->slug) }}" target="_blank" class="btn btn-info btn-sm" title="Lihat Detail" data-bs-toggle="tooltip">
                                              <i class="fas fa-eye"></i>
                                          </a> | <a href="{{ route('show.constructions.form', $construction->slug) }}" class="btn btn-warning btn-sm" title="Edit Pembangunan" data-bs-toggle="tooltip">
                                              <i class="fas fa-edit"></i>
                                          </a> | <form id="form-delete-{{ $construction->slug }}" action="{{ route('construction.delete', $construction->slug) }}" method="POST" class="d-inline">
                                                @csrf 
                                              <input type="hidden" name="_method" value="DELETE">
                                              <button type="button" class="btn-delete btn btn-danger btn-sm" data-id="{{ $construction->slug }}" title="Hapus Pembangunan" data-bs-toggle="tooltip">
                                                  <i class="fas fa-trash-alt"></i>
                                              </button>
                                          </form>
                                      </div>
                                  </td>
                              </tr>
                              @empty
                                <div class="col-12 text-center py-5">
                                    <i class="material-symbols-rounded text-muted mb-3 fs-1">domain</i>
                                    <p class="mb-0 text-muted">Tidak ada pembangunan ditemukan.</p>
                                </div>
                              @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  
     
      <div class="mt-3">
            {{ $constructions->links() }}
      </div>

@endsection