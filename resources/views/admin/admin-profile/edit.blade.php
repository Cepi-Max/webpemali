@extends('admin.layouts.main.app')

@section('content')

<main class="container py-5 mt-5">
    {{-- Ubah Profil --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark">
            <h5 class="mb-0 text-light font-weight-bold">Ubah Profil Anda</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('profile-admin.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                    <x-input-error class="text-danger mt-1" :messages="$errors->get('name')" />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    <x-input-error class="text-danger mt-1" :messages="$errors->get('email')" />
                </div>

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-dark">
                    Alamat email Anda belum diverifikasi.
                    <button type="submit" form="send-verification" class="btn btn-sm btn-outline-secondary mt-2">Kirim ulang email verifikasi</button>
                </div>
                @endif

                <button type="submit" class="btn btn-dark">Simpan</button>
                @if (session('status') === 'profile-updated')
                <span class="text-success ms-3">Tersimpan.</span>
                @endif
            </form>
        </div>
    </div>

    {{-- Ubah Password --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark">
            <h5 class="mb-0 text-light font-weight-bold">Ubah Kata Sandi Anda</h5>
        </div>
        <div class="card-body">
            <form class="formPassword" method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-3 position-relative">
                    <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                    <div class="input-group">
                        <input type="password" name="current_password" id="current_password" class="form-control" autocomplete="current-password">
                        <span class="input-group-text pe-2 ps-2" onclick="togglePassword(this, 'current_password')">
                            <span class="material-symbols-rounded">visibility_off</span>
                        </span>
                    </div>
                    <x-input-error class="text-danger mt-1" :messages="$errors->updatePassword->get('current_password')" />
                </div>
                
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Kata Sandi Baru</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
                        <span class="input-group-text pe-2 ps-2" onclick="togglePassword(this, 'password')">
                            <span class="material-symbols-rounded">visibility_off</span>
                        </span>
                    </div>
                    <x-input-error class="text-danger mt-1" :messages="$errors->updatePassword->get('password')" />
                </div>
                
                <div class="mb-3 position-relative">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                        <span class="input-group-text pe-2 ps-2" onclick="togglePassword(this, 'password_confirmation')">
                            <span class="material-symbols-rounded">visibility_off</span>
                        </span>
                    </div>
                    <x-input-error class="text-danger mt-1" :messages="$errors->updatePassword->get('password_confirmation')" />
                </div>                

                <button type="submit" class="btn btn-dark text-white">Simpan</button>
                @if (session('status') === 'password-updated')
                <span class="text-success ms-3">Tersimpan.</span>
                @endif
            </form>
        </div>
    </div>

    {{-- Hapus Akun --}}
    <div class="card shadow-sm mb-4 border border-danger">
        <div class="card-header bg-dark border border-danger">
            <h5 class="mb-0 text-light font-weight-bold">Hapus Akun Anda</h5>
        </div>
        <div class="card-body">
            <p>Setelah akun Anda dihapus, seluruh data akan hilang secara permanen. Pastikan Anda sudah menyimpan data penting.</p>

            <button class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                Hapus Akun
            </button>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('profile-admin.destroy') }}" class="modal-content">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.</p>
                    <div class="mb-3">
                        <label for="password" class="form-label">Masukkan Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <x-input-error class="text-danger mt-1" :messages="$errors->userDeletion->get('password')" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</main>

<style>
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    .input-group-text {
        cursor: pointer;
        background-color: transparent;
        border-left: none;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .form-control:focus {
        z-index: 2;
    }

    .material-symbols-rounded {
        font-size: 1.3rem;
        color: #6c757d;
    }
</style>

<script>
    function togglePassword(el, targetId) {
        const input = document.getElementById(targetId);
        const icon = el.querySelector('.material-symbols-rounded');
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "visibility";
        } else {
            input.type = "password";
            icon.textContent = "visibility_off";
        }
    }
</script>

@endsection
