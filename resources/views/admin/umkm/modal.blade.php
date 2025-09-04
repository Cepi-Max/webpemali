<!-- Modal Tambah Kategori -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Daftar Kategori Sektor Usaha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Kategori</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($umkmSector as $us)
                        <form id="formUbahKategori" action="{{ route('umkm.sector.update', $us->slug) }}" method="post">
                            @csrf
                            @method('PUT')
                            <tr>
                                <td>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Kategori" value="{{ old('name', $us->name) }}">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-sm" form="formDelete">Hapus</button> | <button type="submit" class="btn btn-dark" form="formUbahKategori">Simpan</button>
                                </td>
                            </tr>
                        </form>
                        @endforeach
                        <form id="formDelete" action="{{ route('umkm.sector.delete', $us->slug) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                        </form>
                    </tbody>
                </table>
            </div>

            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah kategori sektor usaha baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahKategori" action="{{ route('umkm.sector.save') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Kategori" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-dark" form="formTambahKategori">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>