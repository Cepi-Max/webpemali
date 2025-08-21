@extends('submission-letter.layouts.main.app')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50" style="margin-top: 100px">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Header Section -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-sky-950 rounded-xl blur opacity-20"></div>
                                <div class="relative bg-sky-950 p-3 rounded-xl shadow-lg">
                                    <i class="fas fa-hourglass-half text-white text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                    Antrian Pengajuan Anda
                                </h1>
                                <p class="text-gray-600 mt-1">Pantau status pengajuan Anda</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="bg-white/80 backdrop-blur-sm rounded-lg px-4 py-2 shadow-sm border border-white/20">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                                    <span class="font-medium">Terakhir diperbarui:</span>
                                    <span class="ml-2">{{ now()->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            <button onclick="location.reload()" class="bg-sky-950 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow-sm transition-all duration-200 hover:shadow-md flex items-center gap-2">
                                <i class="fas fa-sync-alt text-sm"></i>
                                <span class="hidden sm:inline">Refresh</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="mb-6">
                    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <form method="GET" action="{{ route('show.mysubmission') }}" class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                            {{-- Search Input --}}
                            <div class="flex-1 max-w-md w-full">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis pelayanan..." 
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-white/80 backdrop-blur-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        @if(request('search'))
                                            <a href="{{ route('show.mysubmission') }}" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Filter Status --}}
                            <div class="flex flex-wrap gap-2">
                                @php $status = request('status'); @endphp

                                <button type="submit" name="status" value=""
                                    class="filter-btn {{ $status == null ? 'active' : '' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 hover:shadow-md border border-gray-200">
                                    <i class="fas fa-list mr-2"></i>Semua
                                    <span class="ml-2 bg-white/60 px-2 py-0.5 rounded-full text-xs font-bold">{{ $countAll }}</span>
                                </button>

                                <button type="submit" name="status" value="pending"
                                    class="filter-btn {{ $status == 'pending' ? 'active' : '' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 hover:shadow-md border border-yellow-200">
                                    <i class="fas fa-clock mr-2"></i>Menunggu
                                    <span class="ml-2 bg-white/60 px-2 py-0.5 rounded-full text-xs font-bold">{{ $countPending }}</span>
                                </button>

                                <button type="submit" name="status" value="diproses"
                                    class="filter-btn {{ $status == 'diproses' ? 'active' : '' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 hover:shadow-md border border-blue-200">
                                    <i class="fas fa-cog mr-2"></i>Diproses
                                    <span class="ml-2 bg-white/60 px-2 py-0.5 rounded-full text-xs font-bold">{{ $countDiproses }}</span>
                                </button>

                                <button type="submit" name="status" value="ditolak"
                                    class="filter-btn {{ $status == 'ditolak' ? 'active' : '' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gradient-to-r from-red-100 to-red-200 text-red-800 hover:shadow-md border border-red-200">
                                    <i class="fas fa-times-circle mr-2"></i>Ditolak
                                    <span class="ml-2 bg-white/60 px-2 py-0.5 rounded-full text-xs font-bold">{{ $countRejected }}</span>
                                </button>
                            </div>
                        </form>

                        <!-- Active Filters Display -->
                        <div id="activeFilters" class="mt-4 hidden">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm text-gray-600">Filter aktif:</span>
                                <div id="filterTags" class="flex gap-2"></div>
                                <button onclick="clearAllFilters()" class="text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                    Hapus semua filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($submission->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-12 text-center">
                        <div class="relative mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full blur opacity-50"></div>
                            <div class="relative inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 text-gray-400">
                                <i class="far fa-folder-open text-3xl"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pengajuan</h3>
                        <p class="text-gray-600 mb-6">Anda belum mengajukan pelayanan apapun disini.</p>
                        <a href="{{ route('show.community-services.dashboard') }}" class="inline-flex items-center gap-2 bg-sky-950 text-white px-6 py-3 rounded-lg font-medium hover:shadow-lg transition-all duration-200 hover:scale-105">
                            <i class="fas fa-plus"></i>
                            Ajukan Pelayanan Baru
                        </a>
                    </div>
                @else
                    <!-- Main Table -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                        <!-- Table Header -->
                        <div class="bg-sky-950 px-6 py-4">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                <i class="fas fa-list"></i>
                                Daftar Pengajuan Pelayanan
                            </h3>
                        </div>

                        <!-- Mobile View -->
                        <div class="block lg:hidden">
                            @foreach ($submission as $i => $item)
                                <div class="border-b border-gray-100 p-6 hover:bg-gray-50/50 transition-colors duration-150">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-sky-950 p-2 rounded-lg">
                                                <i class="far fa-file-alt text-white"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $item->jenisSurat->nama ?? '-' }}</h4>
                                                <p class="text-sm text-gray-500">Kode: {{ $item->jenisSurat->slug ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-500">#{{ $i + 1 }}</span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tanggal</p>
                                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Status</p>
                                            @switch($item->status)
                                                @case('pending')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-200">
                                                        <span class="mr-2 h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                                        Menunggu
                                                    </span>
                                                @break
                                                @case('diproses')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-200">
                                                        <span class="mr-2 h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                                        Diproses
                                                    </span>
                                                @break
                                                @case('ditolak')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-200">
                                                        <span class="mr-2 h-2 w-2 rounded-full bg-red-500"></span>
                                                        Ditolak
                                                    </span>
                                                @break
                                                @default
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-200">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                            @endswitch
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi Mobile -->
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                        <div class="text-xs text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('show.mysubmission.detail', $item->id) }}" 
                                            class="inline-flex items-center gap-2 bg-sky-950 hover:bg-sky-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md">
                                                <i class="fas fa-eye text-xs"></i>
                                                <span>Detail</span>
                                            </a>
                                            {{-- Uncomment jika ada fitur download untuk status selesai
                                            @if($item->status === 'selesai')
                                                <button class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md">
                                                    <i class="fas fa-download text-xs"></i>
                                                    <span>Download</span>
                                                </button>
                                            @endif
                                            --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop View -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Jenis Surat
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Tanggal Pengajuan
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50">
                                    @foreach ($submission as $i => $item)
                                        <tr class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-200 group">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">
                                                {{ $i + 1 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-xl bg-sky-950 text-white group-hover:shadow-lg transition-all duration-200">
                                                        <i class="far fa-file-alt"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900">
                                                            {{ $item->jenisSurat->nama ?? '-' }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md inline-block mt-1">
                                                            Kode: {{ $item->jenisSurat->slug ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($item->status)
                                                    @case('pending')
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-200 shadow-sm">
                                                            <span class="mr-2 h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                                            Menunggu
                                                        </span>
                                                    @break
                                                    @case('diproses')
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-200 shadow-sm">
                                                            <span class="mr-2 h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                                            Diproses
                                                        </span>
                                                    @break
                                                    @case('ditolak')
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-200 shadow-sm">
                                                            <span class="mr-2 h-2 w-2 rounded-full bg-red-500"></span>
                                                            Ditolak
                                                        </span>
                                                    @break
                                                    @default
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-200 shadow-sm">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('show.mysubmission.detail', $item->id) }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-lg transition-all duration-200" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    {{-- @if($item->status === 'selesai')
                                                        <button class="text-green-600 hover:text-green-800 hover:bg-green-50 p-2 rounded-lg transition-all duration-200" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    @endif --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 py-4 px-6">
                            {{ $submission->links() }}
                        </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
        
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection