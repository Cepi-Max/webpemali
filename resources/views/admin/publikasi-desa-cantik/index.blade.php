@extends('admin.layouts.main.app')

@section('content')

      <div class="card shadow mb-4">
          <div class="card-body">
              <div class="row align-items-center justify-content-between">
                  <div class="col-md-2 mt-3">
                      <a href="{{ route('show.admin.desa-cantik.publikasi.form') }}" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center w-80">
                          <span>Tambah</span>
                      </a>
                  </div>
                  <div class="col-md-4">
                      <form action="#">
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="cari data publikasi" id="search" name="search" required autocomplete="off">
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
              <h5 class="card-title mb-0">Daftar Publikasi Desa Pemali</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-hover text-center">
                      <thead>
                        @if ($publikasiDesaCantiks->isNotEmpty())
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 25%">Judul</th>
                                <th style="width: 12%">Cover</th>
                                <th style="width: 12%">Jadwal Rilis</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 15%">link</th>
                                <th style="width: 16%">Aksi</th>
                            </tr>
                        @endif
                      </thead>
                      <tbody>
                              @forelse ($publikasiDesaCantiks as $index => $pdc)
                              <tr>
                                 <td class="align-middle">
                                    {{ $publikasiDesaCantiks->firstItem() + $index }}
                                  </td>
                                  <td class="align-middle"><b>{{ \Illuminate\Support\Str::limit($pdc->judul, 30) }}</b></td>
                                  <td class="align-middle">
                                    @if ($pdc->cover)
                                        <img src="{{ asset('storage/pdf/desa-cantik/thumbnails/' . $pdc->cover) }}" alt="Cover PDF" class="img-fluid">
                                    @else
                                        <p>Belum ada cover.</p>
                                    @endif
                                </td>
                                  <td class="align-middle"><?= (new DateTime($pdc->jadwal_rilis))->format('d F Y'); ?></td>
                                  <td class="align-middle"><b>{{ $pdc->status_rilis }}</b></td>
                                  <td class="align-middle"><a href="{{ asset('storage/pdf/desa-cantik/' . $pdc->file_publikasi) }}" target="_blank">pdf</a></td>
                                  <td class="align-middle">
                                      <div class="d-flex justify-content-center align-items-center gap-2">
                                         <a href="{{ route('show.admin.desa-cantik.publikasi.form', $pdc->slug) }}" class="btn btn-warning btn-sm" title="Edit Publikasi" data-bs-toggle="tooltip">
                                              <i class="fas fa-edit"></i>
                                          </a> | <form id="form-delete-{{ $pdc->slug }}" action="{{ route('publikasi-desa-cantik.delete', $pdc->slug) }}" method="POST" class="d-inline">
                                                @csrf 
                                              <input type="hidden" name="_method" value="DELETE">
                                              <button type="button" class="btn-delete btn btn-danger btn-sm" title="Hapus Publikasi" data-bs-toggle="tooltip" data-id="{{ $pdc->slug }}">
                                                  <i class="fas fa-trash-alt"></i>
                                              </button>
                                          </form>
                                      </div>
                                  </td>
                              </tr>
                              @empty
                                <div class="col-12 text-center py-5">
                                    <i class="material-symbols-rounded text-muted mb-3 fs-1">article</i>
                                    <p class="mb-0 text-muted">Tidak ada data ditemukan.</p>
                                </div>
                              @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  
     
      <div class="mt-3">
            {{ $publikasiDesaCantiks->links() }}
      </div>
@endsection