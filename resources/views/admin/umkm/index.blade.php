@extends('admin.layouts.main.app')

@section('content')

      <div class="card shadow mb-4">
          <div class="card-body">
              <div class="row align-items-center justify-content-between">
                  <div class="col-md-2 mt-3">
                      <a href="{{ route('show.umkm.form') }}" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center w-80">
                          <span>Tambah</span>
                      </a>
                  </div>
                  <div class="col-md-4">
                      <form action="#">
                        @if (request('umkm_sector'))
                            <input type="hidden" name="umkm_sector" value="{{ request('umkm_sector') }}">
                        @endif
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="cari umkm" id="search" name="search" required autocomplete="off">
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
      <div class="card shadow">
          <div class="card-header bg-dark text-white">
            <h5 class="card-title mb-0">Daftar UMKM</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead>
                      @if ($umkm_umkm->isNotEmpty())
                          <tr>
                              <th style="width: 5%">No</th>
                              <th style="width: 20%">Nama Usaha</th>
                              <th style="width: 15%">Gambar</th>
                              <th style="width: 15%">Pemilik</th>
                              <th style="width: 12%">Tanggal Daftar</th>
                              <th style="width: 9%">Aksi</th>
                          </tr>
                      @endif
                    </thead>
                    <tbody>
                          @forelse ($umkm_umkm as $index => $umkm)
                          <tr>
                              <td class="align-middle">
                                  {{ $umkm_umkm->firstItem() + $index }}
                              </td>
                              <td class="align-middle"><b>{{ $umkm->umkm_name }}</b></td>
                              <td class="align-middle">
                                  @if (isset($umkm->image))
                                      <img src="{{ asset('storage/images/publicImg/umkm/umkmImg/' . $umkm->image) }}" alt="umkm image" title="" class="img-fluid rounded shadow-sm" style="max-width: 100px;">
                                  @else
                                      <span class="text-muted">gambar tidak ditemukan</span>
                                  @endif
                              </td>
                              <td class="align-middle"><?= (new DateTime($umkm->created_at))->format('d F Y'); ?></td>
                              <td class="align-middle">{{ $umkm->owner_name }}</td>
                              <td class="align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('show.umkm.details', $umkm->slug) }}" target="_blank" class="btn btn-info btn-sm" title="Lihat Detail" data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a> |
                                        <a href="{{ route('show.umkm.form', $umkm->slug) }}" class="btn btn-warning btn-sm" title="Edit Umkm" data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a> |
                                        <form id="form-delete-{{ $umkm->slug }}" action="{{ route('umkm.delete', $umkm->slug) }}" method="POST" class="d-inline">
                                              @csrf 
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="button" class="btn-delete btn btn-danger btn-sm" title="Hapus Umkm" data-bs-toggle="tooltip" data-id="{{ $umkm->slug }}">
                                              <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form> 
                                    </div>
                              </td>
                          </tr>
                          @empty
                              <div class="col-12 text-center py-5">
                                  <i class="material-symbols-rounded text-muted mb-3 fs-1">campaign</i>
                                  <p class="mb-0 text-muted">Tidak ada data ditemukan.</p>
                              </div>
                          @endforelse
                    </tbody>
                </table>
            </div>
        </div>
      </div>
        
        <div class="mt-3">
              {{ $umkm_umkm->links() }}
        </div>
@endsection