@extends('admin-submission-letter.layouts.main.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-10"> {{-- Consistent page background and padding --}}
    <div class="container mx-auto px-6">
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-200"> {{-- Consistent card styling for header --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4"> {{-- Added space-x for icon alignment --}}
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm"> {{-- Consistent blue icon background --}}
                        <i class="fas fa-file-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Syarat Dokumen</h2> {{-- Consistent text colors and size --}}
                        <p class="text-gray-500 text-sm mt-1">Kelola syarat dokumen untuk pelayanan surat</p>
                    </div>
                </div>
                {{-- No general action button in this header, as per the previous list page header --}}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200"> {{-- Consistent card styling --}}
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50"> {{-- Consistent table header style --}}
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4"> {{-- Responsive layout for header items --}}
                    <div class="flex items-center space-x-3 w-full md:w-auto justify-center md:justify-start">
                        <i class="fas fa-table text-lg text-gray-600"></i> {{-- Softer icon color --}}
                        <h3 class="text-lg font-semibold text-gray-700">Data Syarat Dokumen</h3> {{-- Consistent text style --}}
                    </div>
                    <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-3 w-full md:w-auto">
                        {{-- <div class="relative w-full md:w-auto">
                            <input type="text"
                                   placeholder="Cari syarat dokumen..."
                                   name=""
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full md:w-64 transition duration-150 ease-in-out"
                                   id="searchInput">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div> --}}
                        {{-- Filter button, if needed, would go here. Removed for simplicity as it's not implemented yet. --}}
                        <a href="{{ route('show.admin.submission_requirements.form') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center space-x-2 w-full md:w-auto justify-center"> {{-- Consistent button styling --}}
                            <i class="fas fa-plus text-sm"></i>
                            <span>Tambah Syarat</span> {{-- Simplified text --}}
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200"> {{-- Consistent divider --}}
                    <thead class="bg-gray-50"> {{-- Consistent table header background --}}
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> {{-- Consistent header text style --}}
                                <div class="flex items-center">
                                    No
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    Nama Syarat Dokumen
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tableBody"> {{-- Consistent body background and divider --}}
                        @forelse ($syaratDokumen as $index => $syarat)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 searchable-row"> {{-- Subtle hover effect --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-7 h-7 bg-blue-100 text-blue-700 rounded-md flex items-center justify-center font-semibold text-sm"> {{-- Consistent number badge style --}}
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-md mr-3 flex items-center justify-center"> {{-- Icon container with consistent styling --}}
                                        <i class="fas fa-file-alt text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 searchable-text">{{ $syarat->nama }}</p>
                                        <p class="text-xs text-gray-500">tipe: {{ $syarat->tipe_input }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('show.admin.submission_requirements.form', $syarat->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow-sm transition-colors duration-200"> {{-- Using yellow for edit, consistent with previous edit buttons --}}
                                        <i class="fas fa-edit text-sm mr-1"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('show.admin.submission_requirements.delete', $syarat->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow-sm transition-colors duration-200"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <i class="fas fa-trash-alt text-sm mr-1"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="3" class="py-12 text-center text-gray-500"> {{-- Adjusted colspan --}}
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 p-4 rounded-full mb-4">
                                        <i class="fas fa-folder-open text-4xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-600 mb-2">Belum Ada Syarat Dokumen</h3>
                                    <p class="text-sm text-gray-500 mb-4">Belum ada syarat dokumen yang ditentukan untuk pelayanan surat.</p>
                                    <a href="{{ route('show.admin.submission_requirements.form') }}"
                                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition-colors duration-200"> {{-- Consistent button style --}}
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Syarat Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Inline styles and scripts are fine for specific page behaviors like search,
     but consider moving custom CSS (like tooltip) to a dedicated stylesheet if it grows. --}}
<style>
    /* Tooltip styles (if you still want them; current buttons don't use the 'tooltip' class) */
    .tooltip {
        position: relative;
        display: inline-block; /* Essential for tooltip to position correctly relative to text */
    }

    .tooltip:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%; /* Position above the element */
        left: 50%;
        transform: translateX(-50%);
        background-color: #333; /* Darker background for readability */
        color: white;
        padding: 6px 10px;
        border-radius: 6px; /* Slightly more rounded */
        font-size: 0.75rem; /* text-xs equivalent */
        white-space: nowrap;
        z-index: 10;
        margin-bottom: 8px; /* Space from element */
        opacity: 0.9; /* Slightly transparent */
    }

    .tooltip:hover::before {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(8px); /* Adjust position for triangle */
        border: 6px solid transparent;
        border-top-color: #333; /* Matches background color */
        z-index: 10;
    }
</style>

@endsection