@extends('public-user.layouts.main.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-sky-900 dark:text-white">Daftar Profil Sosial Media</h1>

    @foreach ($profiles as $profile)
        <div class="bg-white dark:bg-gray-800 p-5 mb-4 rounded-xl shadow transition hover:shadow-lg">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $profile->name }}</h2>
            <div class="flex flex-wrap gap-4 text-blue-600 dark:text-blue-400">
                @if ($profile->facebook)
                    <a href="{{ $profile->facebook }}" target="_blank" class="hover:underline">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                @endif
                @if ($profile->x)
                    <a href="{{ $profile->x }}" target="_blank" class="hover:underline">
                        <i class="fab fa-twitter"></i> X
                    </a>
                @endif
                @if ($profile->instagram)
                    <a href="{{ $profile->instagram }}" target="_blank" class="hover:underline">
                        <i class="fab fa-instagram"></i> Instagram
                    </a>
                @endif
                @if ($profile->whatsapp)
                    <a href="{{ $profile->whatsapp }}" target="_blank" class="hover:underline">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
