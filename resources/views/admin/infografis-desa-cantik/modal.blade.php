<!-- Modal Tambah Kategori -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Daftar Kategori</h5>
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
                        @foreach ($categories as $cat)
                            <tr>
                                <td><p class="rounded p-2 m-auto text-dark" style="background-color: {{ $cat['color']; }};">{{ $cat['name'] }}</p></td>
                                <td>
                                    <form action="{{ route('article.category.delete', $cat->slug) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah kategori baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahKategori" action="{{ route('article.category.save') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Warna</label>
                        <select name="color" id="color" class="form-control custom-select">
                            <option value="" disabled selected> pilih warna kategori</option>
                            <option value="#B3E5FC">Biru Muda</option>
                            <option value="#A8E6CF">Hijau Mint</option>
                            <option value="#FFD3B6">Peach</option>
                            <option value="#FF9800">Jingga</option>
                            <option value="#2196F3">Biru</option>
                            <option value="#FFEB3B">Kuning</option>
                            <option value="#795548">Coklat</option>
                            <option value="#4CAF50">Hijau</option>
                            <option value="#9C27B0">Ungu</option>
                        </select>
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