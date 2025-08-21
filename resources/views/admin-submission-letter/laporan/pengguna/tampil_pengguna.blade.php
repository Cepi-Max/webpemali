@extends('admin-submission-letter.layouts.main.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Data Pengguna</h2>
        <div class="">
            <a href="{{ route('laporan.pengguna.print') }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md transition duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v16h16V4H4zm4 8l4 4m0 0l4-4m-4 4V8" />
                </svg>
                Cetak Halaman
            </a>
            <a href="{{ route('laporan.pengguna.download') }}" target="_blank"
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
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 font-semibold text-left">No</th>
                    <th class="px-4 py-2 font-semibold text-left">Nama</th>
                    <th class="px-4 py-2 font-semibold text-left">NIK</th>
                    <th class="px-4 py-2 font-semibold text-left">No HP</th>
                    <th class="px-4 py-2 font-semibold text-left">Email</th>
                    <th class="px-4 py-2 font-semibold text-left">Tgl Registrasi</th>
                    <th class="px-4 py-2 font-semibold text-left">Jumlah Pengajuan</th>
                    <th class="px-4 py-2 font-semibold text-left">Status Email</th>
                    <th class="px-4 py-2 font-semibold text-left">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $i => $user)
                <tr class="bg-white hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $i + 1 }}</td>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->nik }}</td>
                    <td class="px-4 py-2">{{ $user->number_phone }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->created_at->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">{{ $user->pengajuan_count }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                            {{ $user->hasVerifiedEmail() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->hasVerifiedEmail() ? 'Terverifikasi' : 'Belum' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
