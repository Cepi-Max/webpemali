@extends('admin-submission-letter.layouts.main.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="container mx-auto px-6">
        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-200">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                    <i class="fas fa-envelope-open-text text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Pengajuan Pelayanan</h2>
                    <p class="text-gray-500 text-sm mt-1">Lihat dan kelola semua pengajuan pelayanan dari pemohon</p>
                </div>
            </div>
        </div>

        {{-- Flash Message
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700 shadow-sm border border-green-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-lg"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif --}}

        {{-- Tabel Pengajuan --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs text-left">
                    <tr>
                        <th class="px-6 py-3 text-center">No</th>
                        <th class="px-6 py-3">Jenis Pelayanan</th>
                        <th class="px-6 py-3">Pemohon</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($surats as $surat)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center text-gray-700 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $surat->jenisSurat->nama }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $surat->pemohon->name }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'selesai' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        'diproses' => 'bg-yellow-100 text-yellow-700',
                                        'pending' => 'bg-orange-100 text-orange-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$surat->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($surat->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $surat->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.surat.show', $surat->id) }}"
                                   class="inline-flex items-center px-4 py-2 text-sm text-blue-600 border border-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition">
                                    <i class="fas fa-info-circle mr-2 text-sm"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-8 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-100 p-4 rounded-full mb-4">
                                        <i class="fas fa-folder-open text-4xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-600 mb-2">Belum Ada Pengajuan Pelayanan</h3>
                                    <p class="text-sm text-gray-500">Tidak ada data pengajuan pelayanan yang tersedia saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
