@extends('admin.layouts.main.app')

@section('content')
<div x-data="{ open: false }">
    <!-- Tombol tetap di sini juga bisa, kalau ingin di dalam x-data -->
    <div class="max-w-xl mx-auto p-4">
        <button @click="open = true" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Atur Syarat Dokumen
        </button>
    </div>

    <!-- Modal -->
    <div x-show="open"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         style="display: none;">
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
            <h2 class="text-xl font-semibold mb-4">Atur Syarat Dokumen - {{ $jenisSurat->nama }}</h2>

            <form action="{{ route('show.admin.jenis-surat.syarat.store', $jenisSurat->id) }}" method="POST">
                @csrf
                <div class="max-h-[300px] overflow-y-auto mb-4">
                    @foreach($syaratDokumen as $syarat)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="syarat_id[]" value="{{ $syarat->id }}" class="mr-2"
                                {{ in_array($syarat->id, $selected) ? 'checked' : '' }}>
                            <span>{{ $syarat->nama }}</span>

                            <label class="ml-4 text-sm">
                               <input type="checkbox" name="wajib[]" value="{{ $syarat->id }}"
                                {{ in_array($syarat->id, $wajib) ? 'checked' : '' }}>
                                Wajib
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Simpan Syarat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="max-w-xl mx-auto p-4 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Edit Jenis Surat</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('show.admin.submission_option.update', $jenisSurat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama" class="block font-medium">Nama Jenis Surat</label>
            <input type="text" name="nama" id="nama" class="w-full border rounded px-3 py-2" value="{{ old('nama', $jenisSurat->nama) }}" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block font-medium">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full border rounded px-3 py-2">{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Perbarui
        </button>
    </form>
</div>
@endsection
