{{-- @extends('admin.layouts.main.app')

@section('content')

<div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Daftar Antrian</h6>
          </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Pengirim</th>
                            <th>Email</th>
                            <th>No. WA/Telepon</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $submissionBySlug->applicant->name }}</td>
                            <td>{{ $submissionBySlug->applicant->email }}</td>
                            <td>{{ $submissionBySlug->applicant->number_phone }}</td>
                            <td>{{ \Carbon\Carbon::parse($submissionBySlug->created_at)->translatedFormat('j/F/Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <form action="{{ route('kartu_keluarga_baru.update', $submissionBySlug->id) }}" method="post" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Surat Pengantar RT</label>
                    <br>
                    @error('status_surat_pengantar_rt')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="ratio ratio-16x9 border rounded">
                        <iframe src="{{ url('/storage/kartu-keluarga/kartu-keluarga-baru/surat-pengantar-rt/', $submissionBySlug->surat_pengantar_rt) }}" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <label class="btn btn-outline-danger">
                            <input type="radio" name="status_surat_pengantar_rt" value="0" {{ old('status_surat_pengantar_rt', $submissionBySlug->status_surat_pengantar_rt) == '0' ? 'checked' : '' }}> Tidak Valid
                        </label>
                        <label class="btn btn-outline-success">
                            <input type="radio" name="status_surat_pengantar_rt" value="1" {{ old('status_surat_pengantar_rt', $submissionBySlug->status_surat_pengantar_rt) == '1' ? 'checked' : '' }}> Valid
                        </label>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Buku Nikah</label>
                    <div class="ratio ratio-16x9 border rounded">
                        <iframe src="{{ url('/storage/kartu-keluarga/kartu-keluarga-baru/buku-nikah/', $submissionBySlug->buku_nikah) }}" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <label class="btn btn-outline-danger">
                            <input type="radio" name="status_buku_nikah" value="0" {{ old('status_buku_nikah', $submissionBySlug->status_buku_nikah) == '0' ? 'checked' : '' }}> Tidak Valid
                        </label>
                        <label class="btn btn-outline-success">
                            <input type="radio" name="status_buku_nikah" value="1" {{ old('status_buku_nikah', $submissionBySlug->status_buku_nikah) == '1' ? 'checked' : '' }}> Valid
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Akta Kelahiran</label>
                    <div class="ratio ratio-16x9 border rounded">
                        <iframe src="{{ url('/storage/kartu-keluarga/kartu-keluarga-baru/akta-kelahiran/', $submissionBySlug->akta_kelahiran) }}" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <label class="btn btn-outline-danger">
                            <input type="radio" name="status_akta_kelahiran" value="0" {{ old('status_akta_kelahiran', $submissionBySlug->status_akta_kelahiran) == '0' ? 'checked' : '' }}> Tidak Valid
                        </label>
                        <label class="btn btn-outline-success">
                            <input type="radio" name="status_akta_kelahiran" value="1" {{ old('status_akta_kelahiran', $submissionBySlug->status_akta_kelahiran) == '1' ? 'checked' : '' }}> Valid
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ijazah Terakhir</label>
                    <div class="ratio ratio-16x9 border rounded">
                        <iframe src="{{ url('/storage/kartu-keluarga/kartu-keluarga-baru/ijazah-terakhir/', $submissionBySlug->ijazah_terakhir) }}" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <label class="btn btn-outline-danger">
                            <input type="radio" name="status_ijazah_terakhir" value="0" {{ old('status_ijazah_terakhir', $submissionBySlug->status_ijazah_terakhir) == '0' ? 'checked' : '' }}> Tidak Valid
                        </label>
                        <label class="btn btn-outline-success">
                            <input type="radio" name="status_ijazah_terakhir" value="1" {{ old('status_ijazah_terakhir', $submissionBySlug->status_ijazah_terakhir) == '1' ? 'checked' : '' }}> Valid
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kartu Keluarga Orang Tua</label>
                    @error('status_kartu_keluarga_orang_tua')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror 
                    <div class="ratio ratio-16x9 border rounded">
                        <iframe src="{{ url('/storage/kartu-keluarga/kartu-keluarga-baru/kartu-keluarga-orang-tua/', $submissionBySlug->kartu_keluarga_orang_tua) }}" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <label class="btn btn-outline-danger">
                            <input type="radio" name="status_kartu_keluarga_orang_tua" value="0" {{ old('status_kartu_keluarga_orang_tua', $submissionBySlug->status_kartu_keluarga_orang_tua) == '0' ? 'checked' : '' }}> Tidak Valid
                        </label>
                        <label class="btn btn-outline-success">
                            <input type="radio" name="status_kartu_keluarga_orang_tua" value="1" {{ old('status_kartu_keluarga_orang_tua', $submissionBySlug->status_kartu_keluarga_orang_tua) == '1' ? 'checked' : '' }}> Valid
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">E-KTP</label>
                    <div class="ratio ratio-16x9 border rounded">
                        <iframe src="{{ url('/storage/kartu-keluarga/kartu-keluarga-baru/e-ktp/', $submissionBySlug->e_ktp) }}" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <label class="btn btn-outline-danger">
                            <input type="radio" name="status_e_ktp" value="0" {{ old('status_e_ktp', $submissionBySlug->status_e_ktp) == '0' ? 'checked' : '' }}> Tidak Valid
                        </label>
                        <label class="btn btn-outline-success">
                            <input type="radio" name="status_e_ktp" value="1" {{ old('status_e_ktp', $submissionBySlug->status_e_ktp) == '1' ? 'checked' : '' }}> Valid
                        </label>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-danger">Batal</button>
                    <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
            </form>
        </div>
       </div>
    </div>
</div>

@endsection --}}