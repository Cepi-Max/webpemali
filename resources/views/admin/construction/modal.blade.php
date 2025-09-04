<!-- Modal Tambah SumberDana -->
<div class="modal fade" id="tambahSumberDanaModal" tabindex="-1" aria-labelledby="tambahSumberDanaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="tambahSumberDanaModalLabel">Daftar Sumber Dana</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sumber Dana</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fundSourceCategories as $fund_source)
                            <tr>
                                <td>{{ $fund_source->name }}</td>
                                <td>
                                    <form action="{{ route('construction.fund_source.delete', $fund_source->slug) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sumber dana ini?');">
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
                <h5 class="modal-title" id="tambahSumberDanaModalLabel">Tambah sumber dana baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahSumberDana" action="{{ route('construction.fund_source.save') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Sumber Dana</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama sumber dana" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-dark" form="formTambahSumberDana">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>