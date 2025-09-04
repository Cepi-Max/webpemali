@extends('admin.layouts.main.app')

@section('content')

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-12">
                <form method="GET" action="{{ route('admin.pengguna') }}">
                    @csrf
                    <div class="app-search-container d-flex flex-wrap gap-2">
                        <input
                            type="text"
                            class="app-search-input form-control flex-grow-1"
                            placeholder="Cari nama pengguna"
                            name="search"
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                        <select name="role" class="form-select flex-shrink-0">
                            <option value="">-- Semua Role --</option>
                            <option value="admin" @if(request('role') == 'admin') selected @endif>Admin</option>
                            <option value="operator" @if(request('role') == 'operator') selected @endif>Operator</option>
                            <option value="citizen" @if(request('role') == 'citizen') selected @endif>Masyarakat</option>
                        </select>
                        <button class="app-search-button btn btn-primary flex-shrink-0" type="submit">
                            <i class="fas fa-search"></i>
                            <span class="d-none d-sm-inline">Cari</span>
                        </button>
                        <a href="{{ route('admin.pengguna') }}" class="btn btn-outline-secondary flex-shrink-0">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card shadow d-none d-md-block">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0">Daftar Pengguna</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                      <th scope="col">No</th>
                        <th scope="col" class="ps-3">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td class="align-middle">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="ps-3 fw-medium">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-capitalize">@switch($user->role)
                                    @case('admin')
                                        Admin
                                        @break
                                    @case('operator')
                                        Operator
                                        @break
                                    @case('citizen')
                                        Masyarakat
                                        @break
                                @endswitch
                            </td>
                            {{-- <td>
                                @if ($user->status === 'aktif')
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Nonaktif</span>
                                @endif
                            </td> --}}
                            <td class="text-center">
                                <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="btn btn-sm btn-dark">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-user-id="{{ $user->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="material-symbols-rounded text-muted mb-3 fs-1">person</i>
                                <p class="mb-0 text-muted">Tidak ada data pengguna yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $users->links() }}
</div>


@include('admin.user-management.delete-modal')

<style>
    /* Custom styles for search form responsiveness */
    .app-search-container {
        /* d-flex dan flex-wrap sudah ada di HTML */
    }

    .app-search-input {
        border: 1px solid #ced4da; /* seperti default Bootstrap */
        border-radius: 0.375rem;   /* rounded default */
        padding: 0.375rem 0.75rem;
    }

    .form-select {
        /* flex-shrink-0 dan width: auto; sudah ada di HTML */
        min-width: 120px; /* Lebar minimum untuk select box */
    }

    .app-search-button{
      color: rgb(255, 255, 255);
      background-color: black;
    }

    .app-search-button,
    .btn.btn-outline-secondary {
        /* flex-shrink-0 sudah ada di HTML */
        white-space: nowrap; /* Mencegah teks tombol pecah ke baris baru */
    }

    /* Media queries for smaller screens */
    @media (max-width: 576px) {
        .app-search-container {
            flex-direction: column; /* Stack items vertically on very small screens */
            align-items: stretch; /* Make items take full width */
        }

        .app-search-input,
        .form-select,
        .app-search-button,
        .btn.btn-outline-secondary {
            width: 100%; /* Full width for all items on small screens */
            margin-bottom: 8px; /* Add some space between stacked items */
        }

        .app-search-button span {
            display: inline; /* Tampilkan teks "Cari" pada tombol di layar kecil */
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        // Event listener ini akan berjalan setiap kali modal akan ditampilkan
        deleteModal.addEventListener('show.bs.modal', function (event) {
            // Dapatkan tombol yang memicu modal
            const button = event.relatedTarget;

            // Ekstrak ID pengguna dari atribut data-*
            const userId = button.getAttribute('data-user-id');

            // Dapatkan form di dalam modal
            const form = document.getElementById('deleteForm');

            // Buat URL action untuk form delete
            const routeTemplate = `{{ route('admin.pengguna.destroy', ':id') }}`;
            const actionUrl = routeTemplate.replace(':id', userId);

            // Setel atribut action pada form
            form.action = actionUrl;
        });

        // Event listener ini akan berjalan setelah modal tertutup
        deleteModal.addEventListener('hidden.bs.modal', function () {
            // Opsional: Reset checkbox konfirmasi jika ada
            const confirmCheckbox = document.getElementById('confirm_delete');
            if (confirmCheckbox) {
                confirmCheckbox.checked = false;
            }
        });
    }
});
</script>

@endsection