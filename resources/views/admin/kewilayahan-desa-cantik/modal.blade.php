<!-- Modal Tambah Kategori -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Daftar Kategori Fasilitas</h5>
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
                        @foreach ($kewilayahan_kategori as $kat)
                        <form id="formUbahKategori" action="{{ route('kategori-kewilayahan-desa-cantik.update', $kat->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <tr>
                                <td>
                                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Nama Kategori" value="{{ old('nama_kategori', $kat->nama_kategori) }}">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-sm" form="formDelete">Hapus</button> | <button type="submit" class="btn btn-dark" form="formUbahKategori">Simpan</button>
                                </td>
                            </tr>
                        </form>
                        <form id="formDelete" action="{{ route('kategori-kewilayahan-desa-cantik.delete', $kat->id) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah kategori fasilitas baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahKategori" action="{{ route('kategori-kewilayahan-desa-cantik.save') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Nama Kategori" required>
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