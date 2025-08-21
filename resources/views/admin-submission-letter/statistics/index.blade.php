@extends('admin-submission-letter.layouts.main.app')

@section('title', 'Halaman Utama')

@section('content')

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i><span>Data Agama</span>
                        </button>
                        <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" data-target="agama"><i class="fas fa-pray me-2"></i>Data Agama</a></li>
                            <li><a class="dropdown-item" href="#" data-target="umur"><i class="fas fa-users me-2"></i>Rentang Umur</a></li>
                            <li><a class="dropdown-item" href="#" data-target="dusun"><i class="fas fa-home me-2"></i>Data Dusun</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">

            <div id="tabel-umur" class="data-section card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Data Rentang Umur</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>Rentang Umur</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Jumlah per Range</th>
                            </tr>
                            
                                    <tr>
                                        <td>tahun</td>
                                        <td></td>
                                        <td></td>
                                        <td></strong></td>
                                    </tr>
                             
                            <tr>
                                <td><strong>Total Keseluruhan</strong></td>
                                <td><strong></strong></td>
                                <td><strong></strong></td>
                                <td><strong></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

      @endsection  