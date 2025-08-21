@extends('admin-submission-letter.layouts.main.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8"> {{-- Added min-h-screen and more padding --}}
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden"> {{-- Changed shadow and rounded-xl to rounded-lg overflow-hidden --}}
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50"> {{-- Added a header section for better visual separation --}}
            <h2 class="text-2xl font-bold text-gray-800">
                {{ isset($syaratDokumen) ? 'Edit Syarat' : 'Tambah Syarat Baru' }} {{-- More descriptive title --}}
            </h2>
        </div>

        <form action="{{ isset($syaratDokumen) ? route('show.admin.submission_requirements.save', $syaratDokumen->id) : route('show.admin.submission_requirements.save') }}" method="POST" class="p-6">
            @csrf

            {{-- Input Nama Dokumen --}}
            <div class="mb-5">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Syarat</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $syaratDokumen->nama ?? '') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                    placeholder="Contoh: Kartu Keluarga, KTP"
                    required>
                @error('nama')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Tipe Input --}}
            <div class="mb-5">
                <label for="tipe_input" class="block text-sm font-medium text-gray-700 mb-2">Tipe Input</label>
                <select name="tipe_input" id="tipe_input"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                        required onchange="handleTipeChange()">
                    @php
                        $tipeInputOptions = ['file', 'text', 'number', 'date', 'textarea', 'select'];
                        $selected = old('tipe_input', $syaratDokumen->tipe_input ?? '');
                    @endphp

                    <option value="" disabled {{ $selected == '' ? 'selected' : '' }}>-- Pilih Tipe Input --</option>
                    @foreach ($tipeInputOptions as $option)
                        <option value="{{ $option }}" {{ $selected == $option ? 'selected' : '' }}>
                            {{ ucfirst($option) }}
                        </option>
                    @endforeach
                </select>
                @error('tipe_input')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Opsi (jika select) --}}
            <div class="mb-5" id="opsi-container" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Pilihan</label>
                <div id="opsi-list">
                    <div id="opsi-list">
                        @if (old('tipe_input', $syaratDokumen->tipe_input ?? '') === 'select')
                            @php
                                $opsiTersimpan = old('opsi', isset($syaratDokumen) ? $syaratDokumen->opsi->pluck('opsi')->toArray() : []);
                            @endphp

                            @foreach ($opsiTersimpan as $opsi)
                                <div class="flex items-center mb-2 gap-2">
                                    <input type="text" name="opsi[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-md sm:text-sm"
                                        value="{{ $opsi }}" required placeholder="Nama opsi">
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <button type="button" onclick="tambahOpsi()" class="mt-2 inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm bg-white hover:bg-gray-100 text-gray-700">
                    + Tambah Opsi
                </button>
            </div>

            {{-- Tombol Aksi --}}
            <div class="border-t border-gray-200 pt-6 mt-6 flex justify-end space-x-3">
                <a href="{{ route('show.admin.submission_requirements') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    {{ isset($syaratDokumen) ? 'Update Data' : 'Simpan Syarat' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleTipeChange() {
        const tipe = document.getElementById('tipe_input').value;
        const opsiContainer = document.getElementById('opsi-container');
        if (tipe === 'select') {
            opsiContainer.style.display = 'block';
        } else {
            opsiContainer.style.display = 'none';
        }
    }

    function tambahOpsi() {
        const list = document.getElementById('opsi-list');
        const index = list.children.length;

        const div = document.createElement('div');
        div.classList.add('flex', 'items-center', 'mb-2', 'gap-2');
        div.innerHTML = `
            <input type="text" name="opsi[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-md sm:text-sm" placeholder="Nama opsi" required>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
        `;
        list.appendChild(div);
    }

    // Auto-show if editing existing 'select'
    window.onload = function () {
        handleTipeChange();
    }
</script>

@endsection