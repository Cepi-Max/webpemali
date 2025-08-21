@extends('admin.layouts.main.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Data {{ $details->nama_lengkap }}</h5>
                </div>
                <div class="card-body">
                    <div>
                        {{-- <div class="d-flex justify-content-center">
                            <img src="{{ asset('storage/images/publicImg/population/populationImg/default.png') }}" width="130" height="200" alt="foto {{ $details->nama_lengkap }}">
                        </div> --}}
                        <table class="table table-hover text-dark">
                            <tbody>
                                <tr>
                                    <th style="width: 40%;">No KK</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->no_kk }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">No NIK</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->nik }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">Nama</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">Tempat/Tgl Lahir</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->tempat_lahir }} / {{ $details->tanggal_lahir }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">Alamat</th>
                                    <th style="width: 1%;">:</th>
                                    <td>
                                        <div>Dusun : <b>{{ $details->dusun }}</b></div>
                                        <div>RT : <b>{{ $details->rt }}</b></div>
                                        <div><b>{{ $details->alamat }}</b></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">Agama</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->agama }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">Status Perkawinan</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->status_pernikahan }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">Pekerjaan</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->pekerjaan }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">Jenis Kelamin</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 40%;">Pendidikan</th>
                                    <th style="width: 1%;">:</th>
                                    <td>{{ $details->pendidikan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
   
            <div class="mt-3 ms-4 d-flex justify-content-between">
                <a href="{{ route('show.populations') }}" class="btn btn-dark">
                    <i class="fas fa-chevron-left fa-sm fa-fw me-2 text-gray-400"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection