@extends('public-user.layouts.main.app')

@section('content')

<div class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-900 shadow-md border border-gray-200 dark:border-gray-700 rounded-xl mt-[7.5rem] text-sky-950 dark:text-gray-200 transition-all duration-300">
    <span class="text-xl sm:text-2xl lg:text-3xl font-bold">Publikasi Desa Cantik</span>
</div>  

<div class="container mx-auto px-4 py-8">

    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal Rilis</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Rilis</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Publikasi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($publikasi as $item)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->judul }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <img src="{{ asset('storage/pdf/desa-cantik/thumbnails/' . $item->cover) }}" alt="Cover {{ $item->judul }}" class="h-16 w-24 object-cover rounded" />
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ 
              \Carbon\Carbon::parse($item->jadwal_rilis)->format('d M Y H:i') }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              @if($item->status_rilis === 'published')
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
              @elseif($item->status_rilis === 'draft')
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
              @else
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ ucfirst($item->status_rilis) }}</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap space-x-4">
              <!-- View option opens in new tab -->
              <a href="{{ asset('storage/pdf/desa-cantik/' . $item->file_publikasi) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">Lihat</a>
              <!-- Download option triggers download -->
              <a href="{{ asset('storage/pdf/desa-cantik/' . $item->file_publikasi) }}" download class="text-indigo-600 hover:text-indigo-900 font-medium">Download</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if($publikasi->isEmpty())
      <p class="mt-4 text-center text-gray-500">Belum ada publikasi yang tersedia.</p>
    @endif
  </div>

@endsection