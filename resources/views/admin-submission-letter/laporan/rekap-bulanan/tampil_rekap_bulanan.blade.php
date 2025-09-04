@extends('admin-submission-letter.layouts.main.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Rekap Data Pengajuan Tahunan</h2>
        <div class="">
            <a href="{{ route('laporan.rekap-bulanan.print') }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md transition duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v16h16V4H4zm4 8l4 4m0 0l4-4m-4 4V8" />
                </svg>
                Cetak Halaman
            </a>
            <a href="{{ route('laporan.rekap-bulanan.download') }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md transition duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v16h16V4H4zm4 8l4 4m0 0l4-4m-4 4V8" />
                </svg>
                Download PDF
            </a>
        </div>
    </div>

    <div class="overflow-auto rounded-xl shadow ring-1 ring-black ring-opacity-5">
        <table class="w-full text-sm border border-gray-300 mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Bulan</th>
                    <th class="px-4 py-2 border">Jumlah Pengajuan</th>
                    <th class="px-4 py-2 border">Belum Diproses</th>
                    <th class="px-4 py-2 border">Sedang Diproses</th>
                    <th class="px-4 py-2 border">Selesai</th>
                    <th class="px-4 py-2 border">Ditolak</th>
                    <th class="px-4 py-2 border">Surat Terpopuler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="px-4 py-2 border">{{ $item->bulan }}</td>
                        <td class="px-4 py-2 border">{{ $item->total_pengajuan }}</td>
                        <td class="px-4 py-2 border text-green-600">{{ $item->pending }}</td>
                        <td class="px-4 py-2 border text-green-600">{{ $item->diproses }}</td>
                        <td class="px-4 py-2 border text-green-600">{{ $item->selesai }}</td>
                        <td class="px-4 py-2 border text-red-600">{{ $item->ditolak }}</td>
                        <td class="px-4 py-2 border">{{ $item->surat_terpopuler }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
