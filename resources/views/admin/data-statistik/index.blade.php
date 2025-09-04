@extends('admin.layouts.main.app')

@section('content')

<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom mb-3">
        <h3 class="text-bold">Data Statistik Desa Pemali</h3>
    </div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">1. Import Data Penduduk</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-penduduk.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  {{-- <label for="judul" class="form-label mt-4">Judul</label>
                  <input class="form-control" type="text" name="judul" placeholder="masukkan judul data" required>
                  @error('judul')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror

                  <label for="sumber" class="form-label mt-4">Sumber</label>
                  <input class="form-control" type="text" name="sumber" placeholder="masukkan sumber data" required>
                  @error('sumber')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror --}}

                  <label for="dataPenduduk" class="form-label mt-4">File Data Penduduk</label>
                  <input class="form-control" type="file" name="dataPenduduk" accept=".xlsx,.xls" required>
                  @error('dataPenduduk')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">2. Import Data Wilayah</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-dusun.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataDusun" class="form-label mt-4">File Data Wilayah</label>
                  <input class="form-control" type="file" name="dataDusun" accept=".xlsx,.xls" required>
                  @error('dataDusun')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">3. Import Data Usia</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-usia.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataUsia" class="form-label mt-4">File Data Usia</label>
                  <input class="form-control" type="file" name="dataUsia" accept=".xlsx,.xls" required>
                  @error('dataUsia')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">4. Import Data Pendidikan</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-pendidikan.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataPendidikan" class="form-label mt-4">File Data Pendidikan</label>
                  <input class="form-control" type="file" name="dataPendidikan" accept=".xlsx,.xls" required>
                  @error('dataPendidikan')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">5. Import Data Pekerjaan</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-pekerjaan.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataPekerjaan" class="form-label mt-4">File Data Pekerjaan</label>
                  <input class="form-control" type="file" name="dataPekerjaan" accept=".xlsx,.xls" required>
                  @error('dataPekerjaan')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">6. Import Data Agama</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-agama.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataAgama" class="form-label mt-4">File Data Agama</label>
                  <input class="form-control" type="file" name="dataAgama" accept=".xlsx,.xls" required>
                  @error('dataAgama')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">7. Import Data Kewarganegaraan</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-kewarganegaraan.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataKewarganegaraan" class="form-label mt-4">File Data Kewarganegaraan</label>
                  <input class="form-control" type="file" name="dataKewarganegaraan" accept=".xlsx,.xls" required>
                  @error('dataKewarganegaraan')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">8. Import Data Cacat Mental Dan Fisik</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-jenis-cacat.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataJenisCacat" class="form-label mt-4">File Data Cacat Mental Dan Fisik</label>
                  <input class="form-control" type="file" name="dataJenisCacat" accept=".xlsx,.xls" required>
                  @error('dataJenisCacat')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">9. Import Data Tenaga Kerja</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-tenaga-kerja.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataTenagaKerja" class="form-label mt-4">File Data Tenaga Kerja</label>
                  <input class="form-control" type="file" name="dataTenagaKerja" accept=".xlsx,.xls" required>
                  @error('dataTenagaKerja')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

    <div class="card shadow mb-4">
          <div class="card-header bg-dark text-white">
              <h5 class="card-title mb-0">10. Import Data Ekonomi</h5>
          </div>
          <div class="card-body">
              <form action="{{ route('data-ekonomi.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                 
                  <label for="dataEkonomi" class="form-label mt-4">File Data Ekonomi</label>
                  <input class="form-control" type="file" name="dataEkonomi" accept=".xlsx,.xls" required>
                  @error('dataEkonomi')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                  <div class="d-flex justify-content-between mt-5">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
              </form>
          </div>
    </div>

</div>

@endsection