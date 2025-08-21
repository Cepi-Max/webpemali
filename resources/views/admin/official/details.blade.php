@extends('admin.layouts.main.app')

@section('content')
<div class="card user-card-full">
    <div class="row m-l-0 m-r-0">
        <div class="col-sm-4 bg-c-lite-green user-profile bg-dark">
            <div class="card-block text-center text-white">
                <div class="m-b-25">
                    <img 
                    src="{{ asset('storage/images/publicImg/official/officialImg/' . $official->image) }}" 
                    alt="Foto Aparat" 
                    class="rounded-circle" 
                    style="width: 150px; height: 150px; object-fit: cover;">

                </div>
                <h6 class="f-w-600 mt-3 text-light">{{ $official->name }}</h6>
                <p>{{ $official->position }}</p>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card-block">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Media Sosial</h6>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">No Hp</p>
                        <h6 class="text-muted f-w-400">{{ $official->phone_number }}</h6>
                    </div>
                    <div class="col-sm-6">
                        
                    </div>
                </div>
                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Biodata</h6>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Alamat</p>
                        <h6 class="text-muted f-w-400">{{ $official->address }}</h6>
                    </div>
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Tempat, Tanggal Lahir</p>
                        <h6 class="text-muted f-w-400">{{ $official->place_of_birth . ', ' . \Carbon\Carbon::parse($official->date_of_birth)->translatedFormat('d F Y')  }}</h6>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <a href="{{ route('show.officials.form', $official->slug) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                    <form id="form-delete-{{ $official->slug }}" action="{{ route('official.delete', $official->slug) }}" method="post" class="d-inline">
                        @csrf 
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn-delete btn btn-danger" data-id="{{ $official->slug }}" title="Hapus Aparatur" data-bs-toggle="tooltip">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    <a href="{{ route('show.officials') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f9f9fa;
    }

    .padding {
        padding: 3rem !important;
    }

    .user-card-full {
        overflow: hidden;
    }

    .card {
        border-radius: 5px;
        box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
        border: none;
        margin-bottom: 30px;
    }

    .m-r-0 {
        margin-right: 0px;
    }

    .m-l-0 {
        margin-left: 0px;
    }

    .user-card-full .user-profile {
        border-radius: 5px 0 0 5px;
    }

    .user-profile {
        padding: 20px 0;
    }

    .card-block {
        padding: 1.25rem;
    }

    h6 {
        font-size: 14px;
    }

    .card .card-block p {
        line-height: 25px;
    }

    @media only screen and (min-width: 1400px) {
        p {
            font-size: 14px;
        }
    }

    .b-b-default {
        border-bottom: 1px solid #e0e0e0;
    }

    .text-muted {
        color: #919aa3 !important;
    }

    .f-w-600 {
        font-weight: 600;
    }

    .user-card-full .social-link li {
        display: inline-block;
    }

    .user-card-full .social-link li a {
        font-size: 20px;
        margin: 0 10px 0 0;
        transition: all 0.3s ease-in-out;
    }
</style>
@endsection