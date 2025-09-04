@extends('admin.layouts.main.app')

@section('content')

      <div class="card shadow mb-4">
          <div class="card-body">
              <div class="row align-items-center justify-content-between ">
                  <div class="col-md-2 mt-3">
                      <a href="{{ route('show.announcements.form') }}" class="btn btn-dark btn-sm justify-content-center w-80">
                          <span>Tambah</span>
                      </a>
                  </div>
                  <div class="col-md-4">
                      <form action="#">
                        @if (request('admin'))
                            <input type="hidden" name="admin" value="{{ request('admin') }}">
                        @endif
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="cari pengumuman" id="search" name="search" required autocomplete="off">
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
              <h5 class="card-title mb-0">Daftar Pengumuman</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-hover text-center">
                      <thead>
                        @if ($announcements->isNotEmpty())
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 20%">Judul</th>
                                <th style="width: 15%">Gambar</th>
                                <th style="width: 15%">Tgl. Posting</th>
                                <th style="width: 12%">Admin</th>
                                <th style="width: 9%">Aksi</th>
                            </tr>
                        @endif
                      </thead>
                      <tbody>
                            @forelse ($announcements as $index => $announcement)
                            <tr>
                                <td class="align-middle">
                                    {{ $announcements->firstItem() + $index }}
                                </td>
                                <td class="align-middle"><b>{{ $announcement->title }}</b></td>
                                <td class="align-middle">
                                    @if (isset($announcement->image))
                                        <img src="{{ asset('storage/images/publicImg/announcement/announcementImg/' . $announcement->image) }}" alt="pengumuman" title="" class="img-fluid rounded shadow-sm" style="max-width: 100px;">
                                    @else
                                        <span class="text-muted">gambar tidak ditemukan</span>
                                    @endif
                                </td>
                                <td class="align-middle"><?= (new DateTime($announcement->created_at))->format('d F Y'); ?></td>
                                <td class="align-middle">
                                    <a href="/admin/daftar-pengumuman?admin={{ $announcement->author->name }}">
                                        {{ $announcement->author->name }}
                                    </a>
                                </td>
                                <td class="align-middle">
                                      <div class="d-flex justify-content-center align-items-center gap-2">
                                          <a href="{{ route('show.announcement.detail', $announcement->slug) }}" target="_blank" class="btn btn-info btn-sm" title="Lihat Detail" data-bs-toggle="tooltip">
                                              <i class="fas fa-eye"></i>
                                          </a> |
                                          <a href="{{ route('show.announcements.form', $announcement->slug) }}" class="btn btn-warning btn-sm" title="Edit pengumuman" data-bs-toggle="tooltip">
                                              <i class="fas fa-edit"></i>
                                          </a> | 
                                          <form id="form-delete-{{ $announcement->slug }}" 
                                                action="{{ route('announcement.delete', $announcement->slug) }}" 
                                                method="post" 
                                                class="d-inline">
                                                @csrf 
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="btn-delete btn btn-danger btn-sm" data-id="{{ $announcement->slug }}" title="Hapus pengumuman" data-bs-toggle="tooltip">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                          </form>
                                      </div>
                                </td>
                            </tr>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <i class="material-symbols-rounded text-muted mb-3 fs-1">campaign</i>
                                    <p class="mb-0 text-muted">Tidak ada pengumuman ditemukan.</p>
                                </div>
                            @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  
     
      <div class="mt-3">
            {{ $announcements->links() }}
      </div>
@endsection