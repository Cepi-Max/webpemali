@extends('admin-submission-letter.layouts.main.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="container mx-auto px-6">
        <form
            action="{{ isset($jenisSurat) ? route('show.admin.submission_option.save', $jenisSurat->id) : route('show.admin.submission_option.save') }}"
            method="POST">
            @csrf

            <div class="max-w-xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
                {{-- Card Header: Now includes the "Atur Syarat Dokumen" button --}}
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ isset($jenisSurat) ? 'Edit Jenis Pelayanan' : 'Tambah Jenis Pelayanan Baru' }}
                    </h2>
                    {{-- "Atur Syarat Dokumen" button moved here --}}
                    <div x-data="{ open: false }"> {{-- Alpine.js state for the modal --}}
                        <button type="button" @click="open = true" class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md flex items-center space-x-2">
                            <i class="fas fa-file-alt text-sm"></i>
                            <span>Atur Syarat</span>
                        </button>

                        {{-- Modal for Document Requirements --}}
                        <div x-show="open"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[999]"
                            style="display: none;">
                            <div @click.away="open = false" class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-lg transform transition-all duration-300">
                                <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-200">
                                    <h2 class="text-2xl font-bold text-gray-800">Atur Syarat</h2>
                                    <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>

                                <div class="max-h-[350px] overflow-y-auto pr-4 -mr-4 mb-6">
                                    @forelse($syaratDokumen as $syarat)
                                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                            <div class="flex items-center">
                                                <input type="checkbox" name="syarat_id[]" value="{{ $syarat->id }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 mr-3"
                                                    {{ (isset($selected) && is_array($selected) && in_array($syarat->id, $selected)) ? 'checked' : '' }}>
                                                <span class="text-gray-700 text-base font-medium">{{ $syarat->nama }}</span>
                                            </div>

                                            <label class="flex items-center text-gray-600 text-sm cursor-pointer">
                                                <input type="checkbox" name="wajib[{{ $syarat->id }}]" value="1"
                                                    class="form-checkbox h-4 w-4 text-orange-500 rounded focus:ring-orange-400 mr-2"
                                                    {{ (isset($wajib) && is_array($wajib) && in_array($syarat->id, $wajib)) ? 'checked' : '' }}>
                                                Wajib
                                            </label>
                                        </div>
                                    @empty
                                        <div class="text-center py-10 text-gray-500">
                                            <i class="fas fa-exclamation-circle text-4xl mb-4"></i>
                                            <p class="text-lg font-semibold">Tidak ada syarat pelayanan ditemukan.</p>
                                            <p class="text-sm mt-1">Silakan tambahkan syarat pelayanan terlebih dahulu.</p>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <button type="button" @click="open = false" class="px-5 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> {{-- End of Alpine.js scope for the modal --}}
                </div>

                <div class="p-6"> {{-- Card body padding --}}
                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-5 border border-green-200">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-check-circle text-lg"></i>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="mb-5">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Jenis Pelayanan</label>
                        <input type="text" name="nama" id="nama"
                            class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-800 px-4 py-2 transition duration-150 ease-in-out"
                            value="{{ old('nama', isset($jenisSurat) ? $jenisSurat->nama : '') }}"
                            placeholder="Cth: Surat Keterangan Usaha"
                            required>
                        @error('nama')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-800 px-4 py-2 resize-y transition duration-150 ease-in-out"
                            placeholder="Jelaskan tujuan dan penggunaan pelayanan ini">{{ old('deskripsi', isset($jenisSurat) ? $jenisSurat->deskripsi : '') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end space-x-3"> {{-- Buttons aligned to the right with spacing --}}
                        <a href="{{ route('show.admin.submission_option') }}" class="px-5 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 border border-gray-300 rounded-lg transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center space-x-2">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($jenisSurat) ? 'Update' : 'Simpan' }} Jenis Pelayanan</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection