@extends('admin-submission-letter.layouts.main.app')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="container mx-auto px-6">
        <!-- Header Section -->
        {{-- <div class="ml-3 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $title }}</h3>
                    <p class="text-gray-600 text-lg">
                        Kelola semua notifikasi sistem
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Mark All as Read Button -->
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="material-symbols-rounded text-sm">mark_email_read</i>
                        <span class="text-sm font-medium">Tandai Semua Dibaca</span>
                    </button>
                    
                    <!-- Filter Button -->
                    <button class="bg-white border border-gray-300 hover:border-gray-400 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="material-symbols-rounded text-sm">filter_list</i>
                        <span class="text-sm font-medium">Filter</span>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Stats Cards -->
        {{-- <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <!-- Total Notifikasi -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Notifikasi</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $notifikasi->count() }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center shadow-md">
                        <i class="material-symbols-rounded text-2xl">notifications</i>
                    </div>
                </div>
            </div>

            <!-- Belum Dibaca -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Belum Dibaca</p>
                        <h4 class="text-2xl font-bold text-red-600">{{ $notifikasi->where('dibaca', 0)->count() }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-red-600 text-white rounded-lg flex items-center justify-center shadow-md">
                        <i class="material-symbols-rounded text-2xl">mark_email_unread</i>
                    </div>
                </div>
            </div>

            <!-- Sudah Dibaca -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Sudah Dibaca</p>
                        <h4 class="text-2xl font-bold text-green-600">{{ $notifikasi->where('dibaca', 1)->count() }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-green-600 text-white rounded-lg flex items-center justify-center shadow-md">
                        <i class="material-symbols-rounded text-2xl">mark_email_read</i>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Notifikasi List -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h6 class="text-lg font-semibold text-gray-800">Daftar Notifikasi</h6>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="material-symbols-rounded text-base">schedule</i>
                        <span>Diurutkan berdasarkan terbaru</span>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse ($notifikasi as $item)
                <a href="{{ route('admin.surat.index', $item->id) }}">
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-150 {{ $item->dibaca == 0 ? 'bg-blue-50 border-l-4 border-l-blue-500' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4 flex-1">
                                <!-- Icon -->
                                <div class="w-12 h-12 {{ $item->dibaca == 0 ? 'bg-blue-600' : 'bg-gray-400' }} text-white rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                                    <i class="material-symbols-rounded text-xl">
                                        {{ $item->dibaca == 0 ? 'notifications_active' : 'notifications' }}
                                    </i>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h5 class="text-base font-semibold text-gray-800 truncate">
                                            Notifikasi Pengajuan Surat
                                        </h5>
                                        @if($item->dibaca == 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Baru
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ $item->pesan }}
                                    </p>

                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <div class="flex items-center gap-1">
                                            <i class="material-symbols-rounded text-sm">person</i>
                                            <span>ID Pengaju: {{ $item->pengaju_id }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <i class="material-symbols-rounded text-sm">description</i>
                                            <span>ID Surat: {{ $item->pengajuan_surat_id }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <i class="material-symbols-rounded text-sm">schedule</i>
                                            <span>{{ $item->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            {{-- <div class="flex items-center gap-2 ml-4">
                                @if($item->dibaca == 0)
                                    <button class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200" title="Tandai sebagai dibaca">
                                        <i class="material-symbols-rounded text-lg">visibility</i>
                                    </button>
                                @endif
                                
                                <button class="text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200" title="Detail">
                                    <i class="material-symbols-rounded text-lg">open_in_new</i>
                                </button>
                                
                                <button class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200" title="Hapus">
                                    <i class="material-symbols-rounded text-lg">delete</i>
                                </button>
                            </div> --}}
                        </div>
                    </div>
                </a>
                @empty
                <!-- Empty State -->
                <div class="p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="material-symbols-rounded text-4xl">notifications_off</i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Tidak Ada Notifikasi</h3>
                    <p class="text-gray-600 mb-6">Belum ada notifikasi yang tersedia saat ini.</p>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                        Refresh
                    </button>
                </div>
                @endforelse
            </div>

            <!-- Pagination (if needed) -->
            @if($notifikasi->count() >= 5)
            <div class="p-6 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Menampilkan {{ $notifikasi->count() }} dari total notifikasi
                    </p>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                        Muat Lebih Banyak
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // JavaScript untuk interaksi notifikasi bisa ditambahkan di sini
    document.addEventListener('DOMContentLoaded', function() {
        // Mark as read functionality
        document.querySelectorAll('[title="Tandai sebagai dibaca"]').forEach(button => {
            button.addEventListener('click', function() {
                // AJAX call to mark notification as read
                console.log('Mark as read clicked');
            });
        });
        
        // Delete functionality
        document.querySelectorAll('[title="Hapus"]').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                    // AJAX call to delete notification
                    console.log('Delete clicked');
                }
            });
        });
    });
</script>
@endpush