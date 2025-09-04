<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permohonan Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap gap-6">
            
            {{-- Kartu Keluarga
            @include('application-letter.kartu-keluarga.card-kartu-keluarga')
            Akta Kelahiran
            @include('application-letter.akta-kelahiran.card-akta-kelahiran') --}}
              
        </div>
    </div>
</x-app-layout>
