@extends('admin.layouts.main.app')

@section('content')
<div class="container" style="max-width: 720px;">
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-edit me-2"></i>
                Edit Data Pengguna: {{ $user->name }}
            </h5>
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-circle text-danger me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                    </div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-medium">
                            <i class="fas fa-user me-1 text-muted"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="form-control" 
                               required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-medium">
                            <i class="fas fa-envelope me-1 text-muted"></i>
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="form-control" 
                               required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="number_phone" class="form-label fw-medium">
                            <i class="fas fa-phone me-1 text-muted"></i>
                            No. HP
                        </label>
                        <input type="text" 
                               name="number_phone" 
                               id="number_phone" 
                               value="{{ old('number_phone', $user->number_phone) }}"
                               class="form-control" 
                               required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label fw-medium">
                        <i class="fas fa-user-tag me-1 text-muted"></i>
                        Role
                    </label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="citizen" {{ old('role', $user->role) == 'citizen' ? 'selected' : '' }}>Masyarakat</option>
                    </select>
                </div>

                {{--
                <div class="mb-4">
                    <label for="status" class="form-label fw-medium">
                        <i class="fas fa-toggle-on me-1 text-muted"></i>
                        Status
                    </label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                --}}

                <div class="border-top pt-4">
                    <div class="form-check mb-4">
                        <input type="checkbox" 
                               name="confirm_update" 
                               id="confirm_update" 
                               class="form-check-input" 
                               {{ old('confirm_update') ? 'checked' : '' }}
                               required>
                        <label for="confirm_update" class="form-check-label">
                            {{-- <i class="fas fa-check-circle text-success me-1"></i> --}}
                            Saya yakin ingin memperbarui data ini
                        </label>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.pengguna') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-dark flex-fill">
                            <i class="fas fa-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-control{
    border-color: #495057;
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.25);
}

.form-control:focus,
.form-select:focus {
    border-color: #495057;
    box-shadow: 0 0 0 0.2rem rgba(107, 107, 107, 0.25);
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.form-check-input:focus {
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.alert {
    border-radius: 0.5rem;
}

.card {
    border-radius: 0.5rem;
    border: none;
}

.card-header {
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.btn {
    border-radius: 0.375rem;
}
</style>
@endsection