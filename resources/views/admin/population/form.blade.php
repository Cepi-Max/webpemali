@extends('admin.layouts.main.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header text-center">
            <h4 class="card-title">Form Data Masyarakat</h4>
        </div>
        <div class="card-body">
            <form action="/admin/orang/save" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <!-- No KK & NIK -->
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="no_kk" class="form-label"><b>No KK</b></label>
                                    <input type="number" class="form-control @error('no_kk') is-invalid @enderror" id="no_kk" name="no_kk"
                                        value="{{ old('no_kk', $dataMasyarakat->no_kk ?? '') }}" placeholder="No KK">
                                    @error('no_kk')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="no_nik" class="form-label"><b>No NIK</b></label>
                                    <input type="number" class="form-control @error('no_nik') is-invalid @enderror" id="no_nik" name="no_nik"
                                        value="{{ old('no_nik', $dataMasyarakat->no_nik ?? '') }}" placeholder="No NIK">
                                    @error('no_nik')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
            
                        <!-- Nama & Agama -->
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label"><b>Nama Lengkap</b></label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap"
                                        value="{{ old('nama_lengkap', $dataMasyarakat->nama_lengkap ?? '') }}" placeholder="Masukkan nama lengkap">
                                    @error('nama_lengkap')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="agama" class="form-label"><b>Agama</b></label>
                                    <select name="agama" class="form-select @error('agama') is-invalid @enderror" id="agama">
                                        <option value="" disabled selected>Pilih Agama</option>
                                        @foreach (['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                            <option value="{{ $agama }}" {{ old('agama', $dataMasyarakat->agama ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                        @endforeach
                                    </select>
                                    @error('agama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
            
                        <!-- Tempat Tanggal Lahir -->
                        <div class="mb-3">
                            <label class="form-label"><b>Tempat, Tanggal Lahir</b></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $dataMasyarakat->tempat_lahir ?? '') }}" placeholder="Tempat Lahir">
                                    @error('tempat_lahir')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('ttl') is-invalid @enderror" id="ttl" name="ttl"
                                        value="{{ old('ttl', $dataMasyarakat->ttl ?? '') }}">
                                    @error('ttl')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
            
                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label"><b>Alamat</b></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('dusun') is-invalid @enderror" id="dusun" name="dusun"
                                        value="{{ old('dusun', $dataMasyarakat->dusun ?? '') }}" placeholder="Dusun">
                                    @error('dusun')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt"
                                        value="{{ old('rt', $dataMasyarakat->rt ?? '') }}" placeholder="RT">
                                    @error('rt')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        {{-- <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="ayah" class="form-label"><b>Ayah</b></label>
                                    <input type="text" class="form-control @error('ayah') is-invalid @enderror" id="ayah" name="ayah"
                                        value="{{ old('ayah', $dataMasyarakat->ayah ?? '') }}" placeholder="Nama Ayah">
                                    @error('ayah')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="ibu" class="form-label"><b>Ibu</b></label>
                                    <input type="text" class="form-control @error('ibu') is-invalid @enderror" id="ibu" name="ibu"
                                        value="{{ old('ibu', $dataMasyarakat->ibu ?? '') }}" placeholder="Nama Ibu">
                                    @error('ibu')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
            
                        <!-- Pekerjaan -->
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label"><b>Pekerjaan</b></label>
                            <select name="pekerjaan" class="form-select @error('pekerjaan') is-invalid @enderror" id="pekerjaan">
                                <option value="" disabled selected>Pilih Pekerjaan</option>
                                <option value="" disabled selected>Pilih pekerjaan Terakhir</option>
                                    @php
                                        $pekerjaan_options = [
                                                'Belum/Tidak Bekerja', 
                                                'Mengurus Rumah Tangga', 
                                                'Pelajar/Mahasiswa', 
                                                'Pensiunan', 
                                                'Pegawai Negeri Sipil (PNS)', 
                                                'Tentara Nasional Indonesia (TNI)', 
                                                'Kepolisian RI (POLRI)', 
                                                'Perdagangan', 
                                                'Petani/Pekebun', 
                                                'Peternak', 
                                                'Nelayan/Perikanan', 
                                                'Industri', 
                                                'Konstruksi', 
                                                'Transportasi', 
                                                'Karyawan Swasta', 
                                                'Karyawan BUMN', 
                                                'Karyawan BUMD', 
                                                'Karyawan Honorer', 
                                                'Buruh Harian Lepas', 
                                                'Buruh Tani/Perkebunan', 
                                                'Buruh Nelayan/Perikanan', 
                                                'Buruh Peternakan', 
                                                'Pembantu Rumah Tangga', 
                                                'Tukang Cukur', 
                                                'Tukang Listrik', 
                                                'Tukang Batu', 
                                                'Tukang Kayu', 
                                                'Tukang Sol Sepatu', 
                                                'Tukang Las/Pandai Besi', 
                                                'Tukang Jahit', 
                                                'Tukang Gigi', 
                                                'Penata Rias', 
                                                'Penata Busana', 
                                                'Penata Rambut', 
                                                'Mekanik', 
                                                'Seniman', 
                                                'Tabib', 
                                                'Paraji', 
                                                'Perancang Busana', 
                                                'Penterjemah', 
                                                'Imam Masjid', 
                                                'Pendeta', 
                                                'Pastor', 
                                                'Wartawan', 
                                                'Ustadz/Mubaligh', 
                                                'Juru Masak', 
                                                'Promotor Acara', 
                                                'Anggota DPR-RI', 
                                                'Anggota DPD', 
                                                'Anggota BPK', 
                                                'Presiden', 
                                                'Wakil Presiden', 
                                                'Anggota Mahkamah Konstitusi', 
                                                'Anggota Kabinet Kementerian', 
                                                'Duta Besar', 
                                                'Gubernur', 
                                                'Wakil Gubernur', 
                                                'Bupati', 
                                                'Wakil Bupati', 
                                                'Walikota', 
                                                'Wakil Walikota', 
                                                'Anggota DPRD Provinsi', 
                                                'Anggota DPRD Kabupaten/Kota', 
                                                'Dosen', 
                                                'Guru', 
                                                'Pilot', 
                                                'Pengacara', 
                                                'Notaris', 
                                                'Arsitek', 
                                                'Akuntan', 
                                                'Konsultan', 
                                                'Dokter', 
                                                'Bidan', 
                                                'Perawat', 
                                                'Apoteker', 
                                                'Psikiater/Psikolog', 
                                                'Penyiar Televisi', 
                                                'Penyiar Radio', 
                                                'Pelaut', 
                                                'Peneliti', 
                                                'Sopir', 
                                                'Pialang', 
                                                'Paranormal', 
                                                'Pedagang', 
                                                'Perangkat Desa', 
                                                'Kepala Desa', 
                                                'Biarawati', 
                                                'Wiraswasta', 
                                                'Lainnya'
                                            ];
                                    @endphp
                                @foreach ($pekerjaan_options as $option)
                                    <option value="{{ $option }}" {{ old('pekerjaan', $dataMasyarakat->pekerjaan ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('pekerjaan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
            
                        <!-- Pendidikan -->
                        <div class="mb-3">
                            <label for="pendidikan" class="form-label"><b>Pendidikan Terakhir</b></label>
                            <select name="pendidikan" class="form-select @error('pendidikan') is-invalid @enderror" id="pendidikan">
                                <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                @php
                                    $pendidikan_options = [
                                            'Tidak/Belum Sekolah', 
                                            'Belum Tamat SD/Sederajat', 
                                            'Tamat SD/Sederajat', 
                                            'SLTP/Sederajat', 
                                            'SLTA/Sederajat', 
                                            'Diploma I/II', 
                                            'Akademi/Diploma III/S. Muda', 
                                            'Diploma IV/Strata I', 
                                            'Strata II', 
                                            'Strata III'
                                        ];
                                @endphp
                                @foreach ($pendidikan_options as $option)
                                    <option value="{{ $option }}" {{ old('pendidikan', $dataMasyarakat->pendidikan ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('pendidikan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
            
                        <!-- Jenis Kelamin dan Status Kawin -->
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="j_kelamin" class="form-label"><b>Jenis Kelamin</b></label>
                                    <select name="j_kelamin" class="form-select @error('j_kelamin') is-invalid @enderror" id="j_kelamin">
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki" {{ old('j_kelamin', $dataMasyarakat->j_kelamin ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ old('j_kelamin', $dataMasyarakat->j_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('j_kelamin')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="stat_kawin" class="form-label"><b>Status Perkawinan</b></label>
                                    <select name="stat_kawin" class="form-select @error('stat_kawin') is-invalid @enderror" id="stat_kawin">
                                        <option value="" disabled selected>Pilih Status</option>
                                        @php
                                            $stat_kawin_options = [
                                           'Belum Kawin', 
                                            'Kawin', 
                                            'Cerai Hidup', 
                                            'Cerai Mati' 
                                        ];
                                        @endphp
                                        @foreach ($stat_kawin_options as $option)
                                            <option value="{{ $option }}" {{ old('stat_kawin', $dataMasyarakat->stat_kawin ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('stat_kawin')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
            
                        <!-- Kewarganegaraan & Status Dalam Rumah Tangga -->
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="kewarganegaraan" class="form-label"><b>Kewarganegaraan</b></label>
                                    <select name="kewarganegaraan" class="form-select @error('kewarganegaraan') is-invalid @enderror" id="kewarganegaraan">
                                        <option value="" disabled selected>Pilih Kewarganegaraan</option>
                                        @php
                                            $kewarganegaraan_options = [
                                            'WNI', 
                                            'WNA', 
                                            'Dua Kewarganegaraan'
                                        ];
                                        @endphp
                                        @foreach ($kewarganegaraan_options as $option)
                                            <option value="{{ $option }}" {{ old('kewarganegaraan', $dataMasyarakat->kewarganegaraan ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('kewarganegaraan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="stat_dlm_rt" class="form-label"><b>Status Dalam Rumah Tangga</b></label>
                                    <select name="stat_dlm_rt" class="form-select @error('stat_dlm_rt') is-invalid @enderror" id="stat_dlm_rt">
                                        <option value="" disabled selected>Pilih Status</option>
                                        @php
                                            $stat_dlm_rt_options = [
                                            'Suami', 
                                            'Istri', 
                                            'Anak', 
                                            'Menantu', 
                                            'Cucu', 
                                            'Orangtua', 
                                            'Mertua', 
                                            'Famili Lain', 
                                            'Pembantu', 
                                            'Lainnya'
                                        ];
                                        @endphp
                                        @foreach ($stat_dlm_rt_options as $option)
                                            <option value="{{ $option }}" {{ old('stat_dlm_rt', $dataMasyarakat->stat_dlm_rt ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('stat_dlm_rt')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Tombol -->
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('show.populations') }}" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }
    .form-container {
        max-width: 1500px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .form-title {
        font-size: 24px;
        font-weight: 500;
        margin-bottom: 20px;
    }
    .form-label {
        font-size: 16px;
        margin-bottom: 5px;
    }
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    .custom-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 12px 12px;
        padding-right: 2rem !important;
    }
    .custom-select::-ms-expand {
        display: none;
    }
    .custom-textarea {
        height: 470px; /* Atur tinggi sesuai kebutuhan */
        min-height: 150px; /* Tinggi minimum */
    }

    .image-preview {
        width: 200px;
        height: 200px;
        border: 2px dashed #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        overflow: hidden;
        background-color: #f9f9f9;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

@endsection