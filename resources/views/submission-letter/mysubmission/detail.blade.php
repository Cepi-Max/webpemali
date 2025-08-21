@extends('submission-letter.layouts.main.app')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50" style="margin-top: 100px">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="absolute inset-0 bg-sky-950 rounded-xl blur opacity-20"></div>
                            <div class="relative bg-sky-950 p-3 rounded-xl shadow-lg">
                                <i class="fas fa-file-alt text-white text-2xl"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                {{ $title }}
                            </h1>
                            <p class="text-gray-600 mt-1">Detail pengajuan surat #{{ $ds->id }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('show.mysubmission') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow-sm transition-all duration-200 hover:shadow-md flex items-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="space-y-6">
                <!-- Top Row - Status Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="bg-sky-950 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Status Pengajuan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-gray-600">Status saat ini:</span>
                                    @switch($ds->status)
                                        @case('selesai')
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-200 shadow-sm">
                                                <span class="mr-2 h-2 w-2 rounded-full bg-green-500"></span>
                                                Selesai
                                            </span>
                                        @break
                                        @case('diproses')
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-200 shadow-sm">
                                                <span class="mr-2 h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                                Diproses
                                            </span>
                                        @break
                                        @case('ditolak')
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-200 shadow-sm">
                                                <span class="mr-2 h-2 w-2 rounded-full bg-red-500"></span>
                                                Ditolak
                                            </span>
                                        @break
                                        @default
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-200 shadow-sm">
                                                <span class="mr-2 h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                                {{ $ds->status }}
                                            </span>
                                    @endswitch
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="mt-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span>Progress</span>
                                        <span>
                                            @if($ds->status == 'selesai') 100%
                                            @elseif($ds->status == 'diproses') 70%
                                            @elseif($ds->status == 'ditolak') 0%
                                            @else 30%
                                            @endif
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500 
                                            @if($ds->status == 'selesai') bg-gradient-to-r from-green-500 to-green-600 w-full
                                            @elseif($ds->status == 'diproses') bg-gradient-to-r from-blue-500 to-blue-600 w-3/4
                                            @elseif($ds->status == 'ditolak') bg-gradient-to-r from-red-500 to-red-600 w-0
                                            @else bg-gradient-to-r from-yellow-500 to-yellow-600 w-1/3
                                            @endif
                                        "></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Timeline in Status Card -->
                            <div class="md:col-span-1">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Timeline</h4>
                                <div class="space-y-3">
                                    <div class="flex items-start gap-2">
                                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-plus text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-900">Pengajuan Dibuat</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ds->created_at)->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($ds->status !== 'pending')
                                    <div class="flex items-start gap-2">
                                        <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-cog text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-900">Diperiksa</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ds->updated_at)->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($ds->status == 'selesai')
                                    <div class="flex items-start gap-2">
                                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-900">Selesai</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ds->updated_at)->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($ds->status == 'ditolak')
                                    <div class="flex items-start gap-2">
                                        <div class="flex-shrink-0 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-times text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-900">Ditolak</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ds->updated_at)->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Third Row - Documents Section -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="bg-sky-950 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-paperclip"></i>
                            Dokumen Terlampir
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($ds->dokumenSurat && $ds->dokumenSurat->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($ds->dokumenSurat as $dokumen)
                                <div class="h-full">
                                    <div class="h-full flex flex-col bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-sky-100 overflow-hidden group">
                                        <!-- Header Card dengan Status -->
                                        <div class="bg-gradient-to-r from-sky-950 to-sky-100 px-6 py-4 border-b border-sky-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-8 h-8 bg-sky-950 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-file-pdf text-white text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs font-medium text-sky-700 uppercase tracking-wide">Dokumen Dikumpul</span>
                                                        {{-- <div class="flex items-center mt-1">
                                                            @if($dokumen->status_validasi == 'valid')
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-sky-950">
                                                                    <i class="fas fa-check-circle mr-1"></i>
                                                                    {{ $dokumen->status_validasi }}
                                                                </span>
                                                            @elseif ($dokumen->status_validasi == 'invalid')
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                    <i class="fas fa-times-circle mr-1"></i>
                                                                    {{ $dokumen->status_validasi }}
                                                                </span>
                                                            @else 
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                    <i class="fa-solid fa-clock mr-1"></i>
                                                                    belum divalidasi
                                                                </span>
                                                            @endif
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Content Card -->
                                        <div class="p-6 flex flex-col justify-between flex-1 overflow-hidden">
                                            <!-- Document Icon -->
                                            <div class="flex justify-center mb-4">
                                                <div class="w-16 h-16 bg-sky-950 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                                    <i class="fas fa-file-pdf text-white text-2xl"></i>
                                                </div>
                                            </div>

                                            <!-- Document Info -->
                                            <div class="text-center mb-6">
                                                <h4 class="font-bold text-sky-900 text-lg mb-2 leading-tight truncate">
                                                    {{ $dokumen->syarat->nama ?? 'Dokumen Tambahan' }}
                                                </h4>
                                                @if($dokumen->keterangan)
                                                <p class="text-sm text-sky-600 leading-relaxed break-words">
                                                    {{ $dokumen->keterangan }}
                                                </p>
                                                @endif
                                            </div>

                                            <!-- Action Button -->
                                            <div class="mt-auto">
                                                <a href="{{ route('dokumen.surat.show', ['filename' => basename($dokumen->file_path)]) }}" target="_blank"
                                                class="w-full bg-sky-950 hover:bg-sky-900 text-white px-4 py-3 rounded-xl shadow-md transition-all duration-300 hover:shadow-lg flex items-center justify-center gap-3 text-sm font-medium group/btn">
                                                    <i class="fas fa-eye text-base group-hover/btn:scale-110 transition-transform duration-200"></i>
                                                    <span>Lihat Dokumen</span>
                                                    <i class="fas fa-external-link-alt text-xs opacity-70"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="relative mb-4">
                                    <div class="absolute inset-0 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full blur opacity-50"></div>
                                    <div class="relative inline-flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 text-gray-400">
                                        <i class="fas fa-file-times text-2xl"></i>
                                    </div>
                                </div>
                                <p class="text-gray-600">Tidak ada dokumen yang dilampirkan untuk pengajuan ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                @if ($ds->pesan)
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                        <div class="bg-sky-950 px-6 py-4">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                <i class="fas fa-paperclip"></i>
                                Catatan
                            </h3>
                        </div>
                        <div class="p-6">
                                <div class="bg-gray-100 rounded-xl p-4 shadow-inner">
                                    <p class="text-sm text-red-600 leading-relaxed break-words">* {{ $ds->pesan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Tampilan ketika catatan tidak ada -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                        <div class="bg-sky-950 px-6 py-4">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                <i class="fas fa-paperclip"></i>
                                Catatan
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="bg-gray-50 rounded-xl p-8 shadow-inner text-center">
                                <div class="mb-4">
                                    <i class="fas fa-sticky-note text-4xl text-gray-300"></i>
                                </div>
                                <p class="text-gray-500 text-sm mb-2">Belum ada catatan tersedia</p>
                                <p class="text-gray-400 text-xs">Catatan akan muncul di sini ketika sudah ditambahkan</p>
                            </div>
                        </div>
                    </div>
                @endif
        </div>
    </div> 

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .bg-gradient-to-br { background: white !important; }
            .backdrop-blur-sm { backdrop-filter: none !important; }
            .shadow-xl { box-shadow: none !important; }
            .border { border: 1px solid #e5e7eb !important; }
        }
    </style>
@endsection