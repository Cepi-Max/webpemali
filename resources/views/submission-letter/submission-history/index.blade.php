@extends('submission-letter.layouts.main.app')

@section('content')
<div x-data="{ showModal: false, ratingData: {} }" class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50" style="margin-top: 100px">
    <div x-data="{ open: false, selectedId: null, rating: 0 }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="GET" action="{{ route('show.historymysubmission') }}" class="flex flex-col lg:flex-row items-start lg:items-center gap-4 mb-6">
            <!-- Pencarian Jenis Surat -->
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis pelayanan..."
                class="w-full lg:w-1/3 px-4 py-2 border rounded-md shadow-sm focus:ring focus:border-blue-300" />

            <!-- Filter Tanggal -->
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                class="w-full lg:w-1/4 px-4 py-2 border rounded-md shadow-sm focus:ring focus:border-blue-300" />

            <!-- Tombol -->
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                Cari
            </button>

            @if(request()->has('search') || request()->has('tanggal'))
                <a href="{{ route('show.historymysubmission') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                    Reset
                </a>
            @endif
        </form>

        <!-- Table Header -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-sky-950 px-6 py-4">  
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-list"></i>
                    Riwayat Pengajuan Pelayanan
                </h3>
            </div>
            <!-- Riwayat Table -->
            @if ($histories->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-folder-open text-4xl text-gray-400 mb-2"></i>
                    <h3 class="text-lg font-semibold text-gray-700">Belum ada riwayat pengajuan</h3>
                    <p class="text-gray-500">Pengajuan yang selesai akan muncul di sini.</p>
                </div>
            @else
                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Jenis Pelayanan</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="text-left">Aksi</th>
                                <th class="text-left">Rating Saya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($histories as $i => $item)
                                <tr>
                                    <td class="px-4 py-3 text-gray-600">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-800">{{ $item->pengajuan->jenisSurat->nama ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">Kode: {{ $item->pengajuan->jenisSurat->slug ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ \Carbon\Carbon::parse($item->pengajuan->created_at)->format('d M Y') }}<br>
                                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->pengajuan->created_at)->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($item->pengajuan->status === 'selesai')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">Selesai</span>
                                        @elseif ($item->pengajuan->status === 'ditolak')
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-medium">Ditolak</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-medium">{{ ucfirst($item->pengajuan->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ asset('storage/dokumen_surat/surat-selesai/' . $item->file_path_selesai) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($item->pengajuan->status === 'selesai')
                                            <a href="{{ route('download.surat.selesai', ['filename' => $item->file_path_selesai]) }}" class="text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-all duration-200" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap text-sm font-medium">
                                        @if($item->pengajuan->status == 'selesai' && !$item->pengajuan->rating)
                                            <div class="flex items-center gap-2">
                                                <button @click="open = true; selectedId = {{ $item->pengajuan->id }}; rating = 0" class="rating-trigger-btn inline-flex items-center gap-2 px-3 py-2 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-all duration-200" 
                                                    title="Beri Rating">
                                                    <i class="fas fa-star text-yellow-400"></i>
                                                    <span>Beri Rating</span>
                                                </button>
                                            </div>
                                       @elseif($item->pengajuan->rating)
                                            <div>
                                                <div 
                                                    class="flex items-center gap-1 text-yellow-400 text-sm cursor-pointer"
                                                    @click="showModal = true; ratingData = { rating: {{ $item->pengajuan->rating->rating ?? 0 }}, komentar: '{{ $item->pengajuan->rating->komentar ?: 'Tidak ada komentar.' }}' }"
                                                >
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= ($item->pengajuan->rating->rating ?? 0) ? 'fas' : 'far' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                      @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 py-4 px-6">
                    {{ $histories->links() }}
                </div>
            @endif
        </div>
        <!-- Modal Form Rating -->
        <div
            x-show="open"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
            x-cloak>
            <!-- Form Rating Pelayanan -->
            <div @click.away="open = false" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                    <h2 class="text-lg font-semibold mb-4">Form Rating Pelayanan</h2>

                    <form action="{{ route('rating.store') }}" method="POST" class="space-y-4" x-data="{ rating: 0 }">
                        @csrf
                        <input type="hidden" name="pengajuan_surat_id" :value="selectedId">
                        <input type="hidden" name="rating" :value="rating" required>

                        <!-- Rating Bintang -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating:</label>
                            <div class="flex items-center gap-1 text-yellow-400 text-3xl">
                                <template x-for="star in 5" :key="star">
                                    <i 
                                        :class="rating >= star ? 'fas fa-star' : 'far fa-star'" 
                                        class="cursor-pointer transition-all duration-200"
                                        @click="rating = star"
                                    ></i>
                                </template>
                            </div>
                            <div class="text-sm text-gray-500 mt-1" x-text="rating > 0 ? `${rating} Bintang` : 'Klik untuk memberi rating'"></div>
                        </div>

                        <!-- Komentar -->
                        <div>
                            <label for="komentar" class="block text-sm font-medium text-gray-700">Komentar:</label>
                            <textarea 
                                name="komentar" 
                                rows="3" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" 
                                placeholder="Komentar (opsional)"></textarea>
                        </div>


                        <!-- Tombol -->
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Kirim</button>
                        </div>
                    </form>
            </div>
        </div>
        {{-- Modal Form Selesai --}}
        <div 
            x-show="showModal" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                                    style="display: none;" {{-- Penting untuk menyembunyikan di awal --}}
                                                >
                                                    <div 
                                                        class="fixed inset-0 bg-black bg-opacity-50"
                                                        @click="showModal = false"
                                                    ></div>

                                                    <div 
                                                        class="relative bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto"
                                                        @click.away="showModal = false" {{-- Menutup modal jika klik di luar --}}
                                                    >
                                                        <h3 class="text-lg font-semibold mb-4">Detail Rating</h3>
                                                        
                                                        <div class="mb-4">
                                                            <div class="flex items-center gap-1 text-yellow-400 text-xl mb-2">
                                                                <template x-for="i in 5" :key="i">
                                                                    <i :class="i <= ratingData.rating ? 'fas fa-star' : 'far fa-star'"></i>
                                                                </template>
                                                            </div>
                                                            <p class="text-gray-600 text-sm italic" x-text="ratingData.komentar"></p>
                                                        </div>

                                                        <div class="flex justify-end">
                                                            <button 
                                                                @click="showModal = false" 
                                                                class="px-4 py-2 bg-sky-950 text-white rounded hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-sky-950 focus:ring-opacity-50"
                                                            >
                                                                Tutup
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
    </div>
</div>
@endsection
