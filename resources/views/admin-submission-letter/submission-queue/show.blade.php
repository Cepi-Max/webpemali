@extends('admin-submission-letter.layouts.main.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10"> {{-- Consistent page background and padding --}}
    <div class="container mx-auto px-6">
        <!-- Page Header Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-200">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                    <i class="fas fa-file-invoice text-white text-lg"></i> {{-- Icon changed for detail view --}}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pengajuan {{ $surat->jenisSurat->nama }}</h2>
                    <p class="text-gray-500 text-sm mt-1">Detail dan pengelolaan pengajuan pelayanan</p>
                </div>
            </div>
        </div>
        
        @if ($errors->any())
            <div class="mb-6 p-4 bg-orange-100 border border-orange-200 text-orange-700 rounded-lg shadow-sm">
                <div class="flex items-center space-x-3 mb-2">
                    <i class="fas fa-exclamation-circle text-lg"></i>
                    <p class="font-semibold">Terjadi kesalahan validasi:</p>
                </div>
                <ul class="list-disc list-inside space-y-1 ml-6">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        {{-- Upload Completed Letter Section --}}
        @if($surat->status === 'diproses')
            <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 mb-8">
                <h4 class="text-lg font-semibold mb-4 text-gray-800 flex items-center space-x-2">
                    <i class="fas fa-upload text-gray-600"></i>
                    <span>Unggah Hasil</span>
                </h4>
                <form method="POST" action="{{ route('admin.surat.kirim', $surat->id) }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4">
                    @csrf
                    <input type="file" name="file_surat_jadi" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required
                        class="block flex-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out
                               file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim
                    </button>
                </form>
                @if($surat->file_jadi)
                    <div class="mt-4 text-gray-700 flex items-center space-x-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span>Hasil sudah diunggah:</span>
                        <a href="{{ asset('storage/' . $surat->file_jadi) }}" class="underline text-blue-600 hover:text-blue-800" target="_blank">Lihat File</a>
                    </div>
                @endif
            </div>
        @endif

        {{-- Surat Details Card --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-6 pb-3 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Detail Pengajuan</h3>
                </div>
                <span class="text-sm text-gray-500">ID: #{{ $surat->id }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Jenis Pelayanan</p>
                    <p class="mt-1 font-semibold text-gray-800">{{ $surat->jenisSurat->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pemohon</p>
                    <p class="mt-1 font-semibold text-gray-800">{{ $surat->pemohon->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pengajuan</p>
                    <p class="mt-1 font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y, H:i') }}
                        <span class="text-xs text-gray-400">({{ \Carbon\Carbon::parse($surat->created_at)->diffForHumans() }})</span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    @php
                        $statusClasses = [
                            'selesai' => 'bg-green-100 text-green-700',
                            'ditolak' => 'bg-red-100 text-red-700',
                            'diproses' => 'bg-yellow-100 text-yellow-700',
                            'pending' => 'bg-orange-100 text-orange-700',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $statusClasses[$surat->status] ?? 'bg-gray-100 text-gray-700' }}">
                        @if($surat->status === 'selesai')
                            <i class="fas fa-check-circle h-4 w-4 mr-1"></i>
                        @elseif($surat->status === 'ditolak')
                            <i class="fas fa-times-circle h-4 w-4 mr-1"></i>
                        @elseif($surat->status === 'diproses')
                            <i class="fas fa-sync-alt h-4 w-4 mr-1 animate-spin"></i>
                        @else
                            <i class="fas fa-hourglass-half h-4 w-4 mr-1"></i>
                        @endif
                        {{ ucfirst($surat->status) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Document Requirements Section --}}
        <div class="mb-6">
            <h5 class="text-lg font-semibold mb-4 text-gray-800 flex items-center space-x-2">
                <i class="fas fa-clipboard-list text-gray-600"></i>
                <span>Dokumen Syarat</span>
            </h5>
            <form method="POST" action="{{ route('admin.surat.updateStatus', $surat->id) }}">
                @csrf
                <ul class="space-y-4">
                    @forelse ($surat->dokumenSurat as $index => $dok)
                        <li class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-white border border-gray-200 rounded-xl shadow-md p-4 hover:shadow-lg transition">
                            <div class="flex items-center space-x-4 rounded-xl mb-3 sm:mb-0">
                                <div class="p-3 bg-gray-100 text-blue-600 rounded-full flex-shrink-0">
                                    <p class="text-lg font-semibold text-gray-800">{{ $index+1 }}</p>
                                </div>
                                <div>
                                        @if ($dok->file_path)
                                            <p class="text-lg font-semibold text-gray-800">{{ $dok->syarat->nama }}</p>
                                            <p id="status-display-{{ $dok->id }}" class="text-sm text-gray-500 italic">
                                            {{-- Initial display logic based on current doc status or default --}}
                                            {{-- @if ($dok->status_validasi === 'valid')
                                                <span class="text-green-600 font-semibold">Valid</span>
                                            @elseif ($dok->status_validasi === 'invalid')
                                                <span class="text-red-600 font-semibold">Tidak Valid @if($dok->catatan) – {{ $dok->catatan }}@endif</span>
                                            @else
                                                Belum Divalidasi
                                            @endif --}}
                                        @else
                                            <p class="text-base text-gray-800">{{ $dok->syarat->nama }} : {{ $dok->keterangan }}</p>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 w-full sm:w-auto justify-end sm:justify-start">
                                <!-- Hidden inputs for status & catatan -->
                                <input type="hidden" name="validasi[{{ $dok->id }}][status]"  id="status-input-{{ $dok->id }}" value="{{ $dok->status }}">
                                <input type="hidden" name="validasi[{{ $dok->id }}][catatan]" id="catatan-input-{{ $dok->id }}" value="{{ $dok->catatan }}">

                                @if ($dok->file_path)
                                    @if (!$dok->status_validasi)
                                        <button
                                            type="button"
                                            class="preview-btn inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                                            data-file="{{ route('dokumen.surat.show', ['filename' => basename($dok->file_path)]) }}"
                                            data-title="{{ $dok->syarat->nama }}"
                                            data-id="{{ $dok->id }}"
                                            data-current-status="{{ $dok->status_validasi }}"
                                            data-current-note="{{ $dok->keterangan }}"
                                        >
                                            <i class="fas fa-eye mr-2"></i>
                                            <span>Periksa</span>
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            class="preview-btn inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200"
                                            data-file="{{ route('dokumen.surat.show', ['filename' => basename($dok->file_path)]) }}"
                                            data-title="{{ $dok->syarat->nama }}"
                                            data-id="{{ $dok->id }}"
                                            data-current-status="{{ $dok->status_validasi }}"
                                            data-current-note="{{ $dok->keterangan }}"
                                        >
                                            <i class="fas fa-eye mr-2"></i>
                                            <span>Periksa</span>
                                        </button>
                                    @endif
                                @else
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-4 py-2 bg-gray-400 text-white font-semibold rounded-lg shadow-md cursor-not-allowed"
                                        disabled
                                        title="Tidak ada file terlampir"
                                    >
                                        <i class="fas fa-eye-slash mr-2"></i>
                                        <span>Tidak Ada File</span>
                                    </button>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="bg-white border border-gray-200 rounded-xl shadow-md p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gray-100 p-4 rounded-full mb-4">
                                    <i class="fas fa-file-excel text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-600 mb-2">Tidak Ada Dokumen Persyaratan</h3>
                                <p class="text-sm text-gray-500">Pengajuan ini tidak memiliki dokumen persyaratan terlampir.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>

               <!-- Final Submit Section -->
                @if ($surat->status == 'pending')
                    <div class="mt-8 bg-white border border-gray-200 rounded-xl shadow-md p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div class="flex w-full gap-4">
                    <div class="flex-shrink-0">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status Akhir Permohonan
                    </label>
                    <select
                    id="status"
                    name="status"
                    class="block w-full sm:w-64 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                    >
                    <option value="disetujui" {{ $surat->status == 'disetujui' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ $surat->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    </div>
                    <div class="flex-1">
                    <label for="pesan" class="block text-sm font-medium text-gray-700 mb-2">
                    Pesan Opsional
                    </label>
                    <textarea
                    id="pesan"
                    name="pesan"
                    rows="4"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out resize-none"
                    placeholder="Tambahkan pesan atau catatan tambahan (opsional)..."
                    >{{ old('pesan', $surat->pesan ?? '') }}</textarea>
                    </div>
                    </div>
                    <button
                    type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                    >
                    <i class="fas fa-save mr-2"></i>
                    <span>Simpan</span>
                    </button>
                    </div>
                @endif
            </form>
        </div>
        {{-- PDF Preview Modal --}}
        <div id="pdfModal" class="opacity-0 pointer-events-none fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[999] transition-opacity duration-300 ease-in-out">
            <div class="relative w-full h-full max-w-6xl max-h-[90vh] m-4 bg-white rounded-lg shadow-xl overflow-hidden">
                {{-- Header --}}
                <div class="flex justify-between items-center p-4 border-b border-gray-200 bg-gray-50">
                    <h2 id="pdfTitle" class="text-xl font-bold text-gray-800 truncate pr-4"></h2>
                    <div class="flex items-center space-x-2">
                        <a
                            id="detailPdf"
                            href="#"
                            target="_blank"
                            class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 hover:text-blue-800 focus:outline-none focus:underline transition"
                            title="Buka dokumen dalam tab baru"
                        >
                            <i class="fas fa-expand-alt mr-1"></i>
                            Buka di Tab Baru
                        </a>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                {{-- PDF Viewer --}}
                <div class="h-full pb-16">
                    <iframe id="pdfViewer" src="" class="w-full h-full" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.preview-btn').forEach(button => {
        button.addEventListener('click', () => {
            const file = button.getAttribute('data-file');
            const title = button.getAttribute('data-title');
            
            // buka modal seperti biasa
            document.getElementById('detailPdf').href = file;
            document.getElementById('pdfViewer').src = file;
            document.getElementById('pdfTitle').innerText = title;
            document.getElementById('pdfModal').classList.remove('opacity-0', 'pointer-events-none');

            // ubah tombol jadi hijau (tanda sudah dilihat)
            button.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'focus:ring-blue-500');
            button.classList.add('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-500');
        });
    });

    function closeModal() {
        document.getElementById('pdfModal').classList.add('opacity-0', 'pointer-events-none');
        document.getElementById('pdfViewer').src = ''; // Clear iframe content
    }

    // Close modal when clicking outside
    document.getElementById('pdfModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('pdfModal')) {
            closeModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !document.getElementById('pdfModal').classList.contains('opacity-0')) {
            closeModal();
        }
    });

    const statusSelect = document.getElementById('status');
    const pesanContainer = document.querySelector('#pesan').closest('.flex-1');
    const pesanTextarea = document.getElementById('pesan');
    
    // Fungsi untuk toggle visibility pesan
    function togglePesanVisibility() {
        if (statusSelect.value === 'disetujui') {
            pesanContainer.style.display = 'none';
            pesanTextarea.value = '';
        } else {
            pesanContainer.style.display = 'block';
        }
    }
    
    togglePesanVisibility();
    statusSelect.addEventListener('change', togglePesanVisibility);
</script>

@endsection