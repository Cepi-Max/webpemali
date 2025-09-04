@extends('admin.layouts.main.app')

@section('content')
<div class="form-container">
    <div class="form-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3 text-dark">
        <span>Profil Sosial Media</span>
    </div>
    @php
        $existing = \App\Models\SocialMediaProfile::first();
    @endphp

    <form action="{{ route('social-media.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="facebook">Facebook URL</label>
            <input type="url" name="facebook" id="facebook"
                value="{{ old('facebook', $existing->facebook ?? '') }}"
                class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="x">X / Twitter URL</label>
            <input type="url" name="x" id="x"
                value="{{ old('x', $existing->x ?? '') }}"
                class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="instagram">Instagram URL</label>
            <input type="url" name="instagram" id="instagram"
                value="{{ old('instagram', $existing->instagram ?? '') }}"
                class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="whatsapp">WhatsApp Link</label>
            <input type="url" name="whatsapp" id="whatsapp"
                value="{{ old('whatsapp', $existing->whatsapp ?? '') }}"
                class="form-control">
        </div>

        <button type="submit" class="btn btn-dark">Simpan</button>
    </form>
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
</style>
@endsection
