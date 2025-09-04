@extends('admin.layouts.main.app')

@section('content')

      <div class="card shadow mb-4">
          <div class="card-body">
              <div class="row align-items-center justify-content-between">
                  <div class="col-md-2 mt-3">
                      <a href="{{ route('show.constructions.documentation.form', $construction->slug) }}" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center w-80">
                          <span>Tambah</span>
                      </a>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Tabel Desktop -->
      <div class="card shadow d-none d-md-block">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">Dokumentasi {{ $construction->title }}</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-hover text-center">
                      <thead>
                        @if ($documentations->isNotEmpty())
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 25%">Foto Dokumentasi</th>
                                <th style="width: 15%">Persentase %</th>
                                <th style="width: 15%">Keterangan</th>
                                <th style="width: 15%">Admin</th>
                                <th style="width: 25%">Aksi</th>
                            </tr>
                        @endif
                      </thead>
                      <tbody>
                          <?php $i = 1 ; ?>
                          @forelse ($documentations as $CD)
                              <tr>
                                  <td class="align-middle"><?= $i++; ?></td>
                                  <td class="align-middle">
                                    @if (isset($CD->image))
                                        <img src="{{ asset('storage/images/publicImg/construction/documentationImg/' . $CD->image) }}" loading="lazy" alt="pembangunan" title="" class="img-fluid rounded shadow-sm" style="max-width: 100px;">
                                    @else
                                        <span class="text-muted">Gambar tidak ditemukan</span>
                                    @endif
                                  </td>
                                  <td class="align-middle"><b>{{ $CD->percentage }}</b></td>
                                  <td class="align-middle">{{ $CD->information }}</td>
                                  <td class="align-middle">{{ $CD->author->name }}</td>
                                  <td class="align-middle">
                                      <div class="d-flex justify-content-center align-items-center gap-2">
                                          <a href="{{ route('show.constructions.documentation.form', ['slug' => $construction->slug, 'id' => $CD->id]) }}" class="btn btn-warning btn-sm" title="Edit Dokumentasi" data-bs-toggle="tooltip">
                                              <i class="fas fa-edit"></i>
                                          </a> | <form id="form-delete-{{ $CD->id }}" action="{{ route('construction.documentation.delete', $CD->id) }}" method="POST" class="d-inline">
                                                @csrf 
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="btn-delete btn btn-danger btn-sm" data-id="{{ $CD->id }}" title="Hapus Pembangunan" data-bs-toggle="tooltip">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                          </form>
                                      </div>
                                  </td>
                              </tr>
                              @empty
                                <div class="col-12 text-center py-5">
                                    <i class="material-symbols-rounded text-muted mb-3 fs-1">description</i>
                                    <p class="mb-0 text-muted">Belum ada dokumentasi untuk pembangunan ini.</p>
                                </div>
                              @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  
     
      <div class="mt-3">
            {{-- {{ $constructions->links() }} --}}
      </div>

@endsection