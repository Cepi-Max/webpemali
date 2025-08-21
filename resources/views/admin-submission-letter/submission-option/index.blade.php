@extends('admin-submission-letter.layouts.main.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-10"> {{-- Softer background color and more vertical padding --}}
    <div class="container mx-auto px-6">
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-200"> {{-- Softer background, shadow, and added a subtle border --}}
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm"> {{-- Smaller, less intense icon background --}}
                        <i class="fas fa-file-alt text-white text-lg"></i> {{-- Smaller icon --}}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Daftar Pelayanan</h2> {{-- Softer text color --}}
                        <p class="text-gray-500 text-sm mt-1">Manajemen jenis Pelayanan yang tersedia</p> {{-- Softer text color --}}
                    </div>
                </div>
                <a href="{{ route('show.admin.submission_option.form') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition-all duration-200 flex items-center space-x-2"> {{-- Softer button styles --}}
                    <i class="fas fa-plus text-sm"></i>
                    <span>Tambah Pelayanan</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200"> {{-- Softer card styling --}}
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50"> {{-- Simple header with light background --}}
                <div class="flex items-center space-x-3">
                    <i class="fas fa-list text-gray-600 text-lg"></i> {{-- Softer icon color --}}
                    <h3 class="text-lg font-semibold text-gray-700">Daftar Jenis Pelayanan</h3> {{-- Softer text color and slightly smaller font --}}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200"> {{-- Consistent divider --}}
                    <thead class="bg-gray-50"> {{-- Simple, light header background --}}
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> {{-- Softer text colors, less bold --}}
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-hashtag text-gray-400"></i> {{-- Softer icon color --}}
                                    <span>No</span>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-file-signature text-gray-400"></i>
                                    <span>Jenis Pelayanan</span>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-info-circle text-gray-400"></i>
                                    <span>Deskripsi</span>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-cogs text-gray-400"></i>
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200"> {{-- Simple white background for body --}}
                        @forelse ($jenisSurat as $js)
                        <tr class="hover:bg-gray-50 transition-colors duration-150"> {{-- Subtle hover effect --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-7 h-7 bg-blue-100 text-blue-700 rounded-md flex items-center justify-center font-semibold text-sm"> {{-- Softer number badge --}}
                                    {{ $loop->iteration }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div> {{-- Softer color dot --}}
                                    <span class="font-medium text-gray-800">{{ $js->nama }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600"> {{-- Standard text color --}}
                                <p class="leading-relaxed truncate max-w-sm">{{ $js->deskripsi }}</p> {{-- Added truncate for long descriptions --}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('show.admin.submission_option.form', $js->id) }}"
                                   class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow-sm transition-all duration-200"> {{-- Softer button styles --}}
                                    <i class="fas fa-edit text-sm"></i>
                                    <span>Edit</span>
                                </a>
                                {{-- Optional: Add a delete button --}}
                                
                                <form action="{{ route('show.admin.submission_option.delete', $js->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center space-x-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md shadow-sm transition-all duration-200"
                                            onclick="return confirm('Are you sure you want to delete this item?');">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                               
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-inbox text-2xl text-gray-400"></i>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-lg font-semibold text-gray-600 mb-1">Belum Ada Data</p>
                                        <p class="text-gray-500">Belum ada pilihan pelayanan yang tersedia.</p>
                                    </div>
                                    <a href="{{ route('show.admin.submission_option.form') }}"
                                       class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-md shadow-sm transition-all duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Pelayanan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white rounded-xl p-5 text-gray-800 shadow-md border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Jenis Surat</p>
                        <p class="text-2xl font-bold mt-1">{{ $jenisSurat->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 text-gray-800 shadow-md border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Surat Aktif</p>
                        <p class="text-2xl font-bold mt-1">{{ $jenisSurat->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 text-gray-800 shadow-md border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Status Sistem</p>
                        <p class="text-xl font-semibold mt-1">Aktif</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-server text-lg"></i>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection