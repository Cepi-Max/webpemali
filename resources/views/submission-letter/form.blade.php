@extends('submission-letter.layouts.main.app')

@section('content')

<!-- Header Section with Village Theme -->
<div class="min-h-screen bg-gradient-to-br from-green-50 via-blue-50 to-emerald-50 py-40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-600 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pelayanan Administrasi Desa</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Ajukan permohonan pelayanan secara online dengan mudah dan cepat</p>
        </div>

        <!-- Information Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Pelayanan: {{ $jenis->nama }}
                </h2>
            </div>

            <!-- Card Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div>
                                <p class="font-semibold text-gray-700 mb-1">Kode Layanan</p>
                                <p class="text-gray-600 bg-gray-50 px-3 py-2 rounded-lg text-sm font-mono">
                                    {{ $jenis->slug ?? 'Belum Ditentukan' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div>
                                <p class="font-semibold text-gray-700 mb-1">Estimasi Waktu Proses</p>
                                <p class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $jenis->waktu_selesai ?? '1-3 Hari Kerja' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-2 h-2 bg-emerald-500 rounded-full mt-2"></div>
                            <div>
                                <p class="font-semibold text-gray-700 mb-1">Biaya Administrasi</p>
                                <p class="text-gray-600 flex items-center">
                                    @if($jenis->biaya)
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            Rp {{ number_format($jenis->biaya, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Gratis
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-100">
                            <p class="font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Deskripsi Pelayanan
                            </p>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $jenis->deskripsi ?? 'Surat ini digunakan untuk keperluan administratif tertentu sesuai kebutuhan masyarakat.' }}
                            </p>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl">
                            <p class="font-semibold text-amber-800 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Catatan Penting
                            </p>
                            <p class="text-amber-700 text-sm leading-relaxed">
                                Pastikan semua data yang dimasukkan valid. Pengajuan yang tidak valid dapat ditolak oleh pihak desa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Formulir Pengajuan {{ $jenis->nama }}
                </h2>
            </div>

            <div class="p-6">
                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="jenis_surat_id" value="{{ $jenis->id }}">

                    <!-- Documents Upload Section -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Unggah Semua Persyaratan</h3>
                                <p class="text-sm text-gray-600">Silakan masukkan semua persyaratan yang diperlukan pada form berikut:</p>
                            </div>
                        </div>

                        @foreach ($syarat as $index => $s)
                            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start space-x-4 mb-4">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-gray-800 font-semibold text-lg mb-2">
                                            {{ $s->nama }}
                                            @if ($s->pivot->wajib)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Wajib
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 ml-2">
                                                    Opsional
                                                </span>
                                            @endif
                                        </label>
{{-- Dynamic input berdasarkan tipe_input --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:space-x-4 space-y-4 lg:space-y-0 w-full">
    @switch($s->tipe_input)
        @case('file')
            <!-- Dropzone -->
                                            <label
                                                for="dokumen_{{ $s->id }}"
                                                class="dropzone flex-1 flex flex-col items-center justify-center cursor-pointer bg-white border-2 border-dashed border-gray-300 rounded-xl p-8 text-gray-500 transition-all duration-300 hover:border-blue-400 hover:bg-blue-50 group"
                                                ondragover="onDragOver(event)"
                                                ondragleave="onDragLeave(event)"
                                                ondrop="onDrop(event, {{ $s->id }})"
                                                >
                                                <div class="flex flex-col items-center justify-center text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-12 w-12 mb-4 text-gray-400 js-file-icon-{{ $s->id }} group-hover:text-blue-500 transition-colors"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                    </svg>
                                                    <span class="text-sm font-medium js-file-label-{{ $s->id }} group-hover:text-blue-600 transition-colors">
                                                        Klik atau seret file PDF di sini
                                                    </span>
                                                    <p class="text-xs text-gray-400 mt-2">Ukuran maksimal: 2MB</p>
                                                </div>
                                                <input
                                                    id="dokumen_{{ $s->id }}"
                                                    type="file"
                                                    name="dokumen_{{ $s->id }}" 
                                                    accept="application/pdf"
                                                    class="hidden"
                                                    onchange="handleFileChange(event, {{ $s->id }})"
                                                />
                                            </label>

                                            <!-- Preview Button -->
                                            <button
                                                type="button"
                                                id="previewBtn_{{ $s->id }}"
                                                onclick="openModalFromInput({{ $s->id }})"
                                                class="lg:flex-shrink-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 shadow-lg hover:shadow-xl hidden transform hover:scale-105"
                                                disabled
                                            >
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Lihat Dokumen
                                            </button>
            @break

        @case('text')
            <input type="text" name="dokumen_{{ $s->id }}" class="w-full px-4 py-2 border rounded-md shadow-sm" placeholder="Masukkan teks..." value="{{ old('dokumen_'.$s->id) }}">
            @break

        @case('number')
            <input type="number" name="dokumen_{{ $s->id }}" class="w-full px-4 py-2 border rounded-md shadow-sm" placeholder="Masukkan angka..." value="{{ old('dokumen_'.$s->id) }}">
            @break

        @case('date')
            <input type="date" name="dokumen_{{ $s->id }}" class="w-full px-4 py-2 border rounded-md shadow-sm" value="{{ old('dokumen_'.$s->id) }}">
            @break

        @case('textarea')
            <textarea name="dokumen_{{ $s->id }}" rows="4" class="w-full px-4 py-2 border rounded-md shadow-sm" placeholder="Tulis keterangan...">{{ old('dokumen_'.$s->id) }}</textarea>
            @break

        @case('select')
            <select name="dokumen_{{ $s->id }}" class="w-full px-4 py-2 border rounded-md shadow-sm">
                <option value="" disabled selected>-- Pilih --</option>
                @foreach ($s->opsi as $option)
                    <option value="{{ $option->opsi }}" {{ old('dokumen_'.$s->id) == $option->opsi ? 'selected' : '' }}>
                        {{ $option->opsi }}
                    </option>
                @endforeach
            </select>
            @break

        @default
            <p class="text-sm text-red-600">Tipe input tidak dikenali</p>
    @endswitch
</div>


                                        @error('dokumen_' . $s->id)
                                            <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg flex items-center">
                                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-lg font-semibold rounded-xl hover:from-green-700 hover:to-emerald-700 focus:ring-4 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview PDF -->
<div id="pdfModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden p-4">
    <div class="bg-white w-full max-w-5xl h-[90vh] rounded-2xl shadow-2xl overflow-hidden flex flex-col">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b bg-gradient-to-r from-gray-50 to-blue-50">
            <h2 id="pdfTitle" class="text-xl font-semibold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Pratinjau Dokumen
            </h2>
            <button onclick="closeModal()" 
                class="text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full p-2 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Isi Modal -->
        <div class="flex-1 overflow-y-auto p-6">
            <iframe id="pdfViewer" class="w-full h-full rounded-lg shadow-inner" frameborder="0"></iframe>
        </div>
    </div>
</div>


<script>
const pdfFiles = {};

function onDragOver(e) {
    e.preventDefault();
    e.currentTarget.classList.add('border-blue-400', 'bg-blue-50', 'scale-105');
}

function onDragLeave(e) {
    e.currentTarget.classList.remove('border-blue-400', 'bg-blue-50', 'scale-105');
}

function onDrop(e, id) {
    e.preventDefault();
    const files = e.dataTransfer.files;
    if (!files.length) return;
    const input = document.getElementById(`dokumen_${id}`);
    input.files = files;
    handleFileChange({ target: input }, id);
    onDragLeave(e);
}

function handleFileChange(event, id) {
    const file = event.target.files[0];
    const btn = document.getElementById(`previewBtn_${id}`);
    const lbl = document.querySelector(`.js-file-label-${id}`);
    const icon = document.querySelector(`.js-file-icon-${id}`);
    const dropzone = document.querySelector(`label[for="dokumen_${id}"]`);

    if (file && file.type === 'application/pdf') {
        const url = URL.createObjectURL(file);
        pdfFiles[id] = { url, name: file.name };

        // Update appearance for success
        lbl.innerHTML = `<span class="text-green-700 font-semibold">${file.name}</span><br><span class="text-xs text-green-600">File berhasil diunggah</span>`;
        
        icon.classList.remove('text-gray-400', 'group-hover:text-blue-500');
        icon.classList.add('text-green-500');
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>`;

        dropzone.classList.remove('border-gray-300');
        dropzone.classList.add('border-green-300', 'bg-green-50');

        // Show preview button
        btn.disabled = false;
        btn.classList.remove('hidden');
    } else {
        // Error state
        lbl.innerHTML = `<span class="text-red-600 font-semibold">Hanya file PDF yang diperbolehkan</span>`;
        
        dropzone.classList.remove('border-gray-300', 'border-green-300', 'bg-green-50');
        dropzone.classList.add('border-red-300', 'bg-red-50');
        
        icon.classList.remove('text-gray-400', 'text-green-500');
        icon.classList.add('text-red-500');
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>`;

        btn.disabled = true;
        btn.classList.add('hidden');
    }
}

function openModalFromInput(id) {
    if (!pdfFiles[id]) return;
    document.getElementById('pdfTitle').innerHTML = `<svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>Pratinjau: ${pdfFiles[id].name}`;
    document.getElementById('pdfViewer').src = pdfFiles[id].url;
    document.getElementById('pdfModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('pdfViewer').src = '';
    document.getElementById('pdfModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection