@extends('admin.layouts.main.app')

@section('content')
@include('admin.population.modal')
<div class="row">
  <div class="col-12">
    <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mb-2 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between">
          <h6 class="text-white text-capitalize ps-3">{{ request('status') == 'trashed' ? 'Data Sampah' : 'Tabel Masyarakat' }}
          </h6>
        </div>
      </div>

      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <div class="ps-3 pe-3 d-flex justify-content-between mb-3">
            @if(request('status') == 'trashed')
              <a href="{{ route('show.populations') }}" class="btn btn-dark btn-md">
                <i class="fas fa-chevron-left fa-sm fa-fw me-2 text-gray-400"></i>Kembali
              </a>
              <form action="#">
                  @csrf
                  <div class="search-container">
                      <input type="hidden" name="status" value="{{ request('status') }}">
                      <input type="text" class="search-input bg-light" placeholder="cari nama" name="searchTrashed" required autocomplete="off">
                      <button class="search-button" type="submit">
                          <i class="fas fa-search"></i>
                          <span>Cari</span>
                      </button>
                  </div>
              </form>
            @else
              <div class="dropdown">
                <button class="btn btn-dark btn-md dropdown-toggle me-4" 
                        type="button" 
                        id="dropdownMenuButton" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false">
                        <i class="material-symbols-rounded me-1 fs-6">settings</i>Pilihan
                </button>
              
                <div class="dropdown-menu dropdown-menu-start shadow animated--fade-in border" aria-labelledby="dropdownMenuButton">
                    <div class="dropdown-header">Opsi Manajemen:</div>
                    <a href="{{ route('populations.downloadtemplate') }}" class="dropdown-item">
                        <i class="fas fa-download me-2"></i>Download Template Excel
                    </a>
                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#importExcel">
                        <i class="fas fa-file-import fa-sm fa-fw me-2 text-gray-400"></i>Import
                    </button>
                    <a href="{{ route('populations.export') }}" class="dropdown-item">
                        <i class="fas fa-file-export fa-sm fa-fw me-2 text-gray-400"></i>Export
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="GET" action="{{ route('show.populations') }}">
                        <input type="hidden" name="status" value="trashed">
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-solid fa-recycle fa-sm fa-fw me-2 text-gray-400"></i>Data Sampah
                        </button>
                    </form>
                    <form id="form-truncate" 
                      action="{{ route('populations.truncate') }}" 
                      method="POST" 
                      style="display: inline;">
                      @csrf
                      <button type="button" class="btn-truncate dropdown-item">
                          <i class="fas fa-ban fa-sm fa-fw me-2 text-gray-400"></i>Hapus semua data masyarakat
                      </button>
                    </form>
                </div>
              </div>
              <form action="#">
                  @csrf
                  <div class="search-container">
                      <input type="text" class="search-input bg-light" placeholder="cari nama" name="search" required autocomplete="off">
                      <button class="search-button" type="submit">
                          <i class="fas fa-search"></i>
                          <span>Cari</span>
                      </button>
                  </div>
              </form>
            @endif
          </div>
          <table class="table align-items-center justify-content-center mb-0">
            <thead class="border-top">
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIK</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Kelamin</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alamat</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataKependudukan as $dK)  
                <tr>
                  <td>
                    <h6 class="mb-0 text-sm">{{ $dK->nik }}</h6>
                  </td>
                  <td>
                    <p class="text-sm font-weight-bold mb-0">{{ $dK->nama_lengkap }}</p>
                  </td>
                  <td>
                    <span class="text-xs font-weight-bold">{{ $dK->jenis_kelamin }}</span>
                  </td>
                  <td>
                    <span class="text-xs font-weight-bold">{{ $dK->alamat }}</span>
                  </td>
                  <td class="text-center">
                      @if(request('status') == 'trashed')
                          <!-- Tombol Restore -->
                          <form id="form-restore-{{ $dK->nik }}" action="{{ route('populations.restore', $dK->nik) }}" method="POST" class="d-inline">
                              @csrf
                              @method('PUT')
                              <button type="button" class="btn-restore btn btn-sm btn-success" data-id="{{ $dK->nik }}">
                                <i class="fas fa-solid fa-recycle"></i>
                              </button>
                          </form>
                  
                          <!-- Tombol Hapus Permanen -->
                          <form id="form-forcedelete-{{ $dK->nik }}" action="{{ route('populations.forceDelete', $dK->nik) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn-forcedelete btn btn-sm btn-danger" data-id="{{ $dK->nik }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                          </form>
                      @else
                          <a href="{{ route('show.populations.details', $dK->nik) }}" class="btn btn-sm btn-info">
                              <i class="fas fa-eye"></i>
                          </a>
                          <form id="form-delete-{{ $dK->nik }}" 
                              action="{{ route('populations.destroy', $dK->nik) }}" 
                              method="POST" 
                              style="display: inline;">
                            @csrf
                            <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="{{ $dK->nik }}">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                  
                      @endif
                  </td>
                  
                </tr>
              @empty
                <tr>
                  <td colspan="100%" class="text-center">
                    <div class="col-12 text-center py-5">
                        <i class="material-symbols-rounded text-muted mb-3 fs-1">groups</i>
                        <p class="mb-0 text-muted">Tidak ada data masyarakat ditemukan.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mt-3">
  {{ $dataKependudukan->links() }}
</div>

<script>
  document.addEventListener('click', function(e) {
      if (e.target.classList.contains('btn-delete')) {
          const nik = e.target.dataset.id;
          Swal.fire({
            title: 'Apakah Anda yakin?',
                  text: 'Data akan dipindahkan ke sampah!',
                  showCancelButton: true,
                  confirmButtonText: 'Hapus',
                  cancelButtonText: 'Batal',
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#6c757d'
              }).then((result) => {
                  if (result.isConfirmed) {
                      document.getElementById('form-delete-' + nik).submit();
                  }
          });
      }
      if (e.target.classList.contains('btn-forcedelete')) {
          const nik = e.target.dataset.id;
          Swal.fire({
            icon: 'warning',
                  title: 'Perhatian!',
                  html: '<p class="mb-2">Data akan dihapus secara permanen!</p><p>Apakah Anda yakin?</p>',
                  showCancelButton: true,
                  confirmButtonText: 'Hapus',
                  cancelButtonText: 'Batal',
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#6c757d'
              }).then((result) => {
                  if (result.isConfirmed) {
                      document.getElementById('form-forcedelete-' + nik).submit();
                  }
          });
      }
      if (e.target.classList.contains('btn-restore')) {
          const nik = e.target.dataset.id;
          Swal.fire({
            text: 'Pulihkan Data?',
                  showCancelButton: true,
                  confirmButtonText: 'Pulihkan',
                  cancelButtonText: 'Batal',
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#6c757d'
              }).then((result) => {
                  if (result.isConfirmed) {
                      document.getElementById('form-restore-' + nik).submit();
                  }
          });
      }
      if (e.target.classList.contains('btn-truncate')) {
          const nik = e.target.dataset.id;
          Swal.fire({
                  icon: 'warning',
                  title: 'Perhatian!',
                  html: '<p class="mb-2">Aksi ini akan menghapus seluruh data masyarakat secara permanen!</p><p>Apakah Anda yakin?</p>',
                  showCancelButton: true,
                  confirmButtonText: 'Hapus',
                  cancelButtonText: 'Batal',
                  confirmButtonColor: '#d33',  
                  cancelButtonColor: '#6c757d' 
              }).then((result) => {
                  if (result.isConfirmed) {
                      document.getElementById('form-truncate').submit();
                  }
          });
      }
  });
</script>

@endsection