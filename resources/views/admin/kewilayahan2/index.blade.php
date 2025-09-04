@extends('admin.layouts.main.app')

@section('content')

      <div class="card shadow mb-4">
          <div class="card-body">
              <div class="row align-items-center justify-content-between">
                  <div class="col-md-2 mt-3">
                      <a href="{{ route('show.admin.desa-cantik.kewilayahan2.form') }}" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center w-80">
                          <span>Tambah</span>
                      </a>
                  </div>
                  <div class="col-md-4">
                      <form action="#">
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="cari pembagian kewilayahan" id="search" name="search" required autocomplete="off">
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
            <h5 class="card-title mb-0">Daftar Kewilayahan</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead>
                      @if ($kewilayahan2->isNotEmpty())
                          <tr>
                              <th style="width: 5%">No</th>
                              <th style="width: 20%">Label</th>
                              <th style="width: 15%"></th>
                              <th style="width: 9%">Aksi</th>
                          </tr>
                      @endif
                    </thead>
                    <tbody>
                          @forelse ($kewilayahan2 as $index => $item)
                          <tr>
                              <td class="align-middle">
                                  {{ $kewilayahan2->firstItem() + $index }}
                              </td>
                              <td class="align-middle"><b>{{ $item->nama_dusun }}</b></td>
                             <td class="align-middle">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 25px; height: 25px; background-color: {{ $item->warna }}; border: 1px solid #ccc; border-radius: 4px; flex-shrink: 0;"></div>
                                    <span>{{ $item->warna }}</span>
                                </div>
                            </td>
                              <td class="align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('show.admin.desa-cantik.kewilayahan2.form', $item->id) }}" class="btn btn-warning btn-sm" title="Edit Kewilayahan" data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a> |
                                        <form id="form-delete-{{ $item->id }}" action="{{ route('kewilayahan2-desa-cantik.delete', $item->id) }}" method="POST" class="d-inline">
                                              @csrf 
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="button" class="btn-delete btn btn-danger btn-sm" title="Hapus item" data-bs-toggle="tooltip" data-id="{{ $item->id }}">
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
              {{ $kewilayahan2->links() }}
        </div>
@endsection