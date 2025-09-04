@extends('submission-letter.layouts.main.app')

@section('content')
    <main class="mx-auto w-full" style="margin-top: 120px;">
        <!-- Search Form -->
        <div class="max-w-4xl mx-auto px-4 mb-8">
            <form action="{{ route('show.community-services.result') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <input 
                    type="text" 
                    name="query" 
                    placeholder="Cari formulir surat dan layanan lainnya..." 
                    value="{{ request('query') }}"
                    class="w-full sm:flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:bg-gray-800 bg-white text-gray-900 dark:text-white dark:border-gray-600"
                >
                <div class="flex gap-2 w-full sm:w-auto">
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-6 py-2 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 transition duration-300"
                    >
                        Cari
                    </button>
                    <a 
                        href="{{ route('show.community-services.dashboard') }}" 
                        class="w-full sm:w-auto px-6 py-2 bg-gray-600 text-gray-200 font-semibold rounded-lg hover:bg-gray-700 transition duration-300 text-center"
                    >
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Search Results Info -->
        @if(request('query'))
            <div class="max-w-4xl mx-auto px-4 mb-6">
                <div class="bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-800 rounded-lg p-4">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-search text-sky-600 dark:text-sky-400"></i>
                        <span class="text-gray-800 dark:text-gray-200">
                            Hasil pencarian untuk: 
                            <span class="font-semibold text-sky-700 dark:text-sky-300">"{{ request('query') }}"</span>
                        </span>
                    </div>
                    @if(isset($jenisSurat) && $jenisSurat->count() > 0)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Ditemukan {{ $jenisSurat->count() }} layanan yang sesuai
                        </p>
                    @endif
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4">
            @if(isset($jenisSurat) && $jenisSurat->count() > 0)
                <!-- Services Grid -->
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($jenisSurat as $index => $js)   
                        <a href="{{ route('pengajuan.form', $js->slug) }}" 
                           class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-sky-200 dark:hover:border-sky-600 transform hover:-translate-y-1">
                            
                            <!-- Card Header dengan Gradient -->
                            <div class="bg-gradient-to-r from-sky-500 to-blue-600 h-20 relative overflow-hidden">
                                <div class="absolute inset-0 bg-black/10"></div>
                                <div class="absolute -top-6 -right-6 w-20 h-20 bg-white/20 rounded-full"></div>
                                <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-white/10 rounded-full"></div>
                            </div>
                            
                            <!-- Icon -->
                            <div class="relative -mt-8 flex justify-center">
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-full shadow-lg border-4 border-sky-100 dark:border-sky-900 group-hover:scale-110 transition-transform duration-300">
                                    @php
                                        $icons = [
                                            'fa-solid fa-user-check',
                                            'fa-solid fa-home',
                                            'fa-solid fa-id-card',
                                            'fa-solid fa-file-contract',
                                            'fa-solid fa-people-roof',
                                            'fa-solid fa-briefcase',
                                            'fa-solid fa-graduation-cap',
                                            'fa-solid fa-heart',
                                            'fa-solid fa-car',
                                            'fa-solid fa-building',
                                            'fa-solid fa-users',
                                            'fa-solid fa-certificate'
                                        ];
                                        $iconClass = $icons[$index % count($icons)];
                                    @endphp
                                    <i class="{{ $iconClass }} text-2xl text-sky-600 dark:text-sky-400"></i>
                                </div>
                            </div>
                            @php
                                $rating = round($ratingPerJenis[$js->id] ?? 0); // default 0 kalau tidak ada
                            @endphp
                            <!-- Content -->
                            <div class="px-6 py-6 text-center">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors duration-300">
                                    {{ $js->nama }}
                                </h3>
                                <div class="flex justify-center items-center mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star text-yellow-400"></i>
                                    @endfor
                                    @if ($ratingPerJenis[$js->id] ?? false)
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">
                                            {{ number_format($ratingPerJenis[$js->id], 1) }}
                                        </span>
                                    @endif
                                </div>
                                <div class=" hidden md:block">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                        Ajukan pelayanan {{ strtolower($js->nama) }} secara online dengan mudah dan cepat
                                    </p>
                                    
                                    <!-- CTA Button -->
                                    <div class="inline-flex items-center text-sky-600 dark:text-sky-400 font-medium text-sm group-hover:text-sky-700 dark:group-hover:text-sky-300 transition-colors duration-300">
                                        <span>Ajukan Sekarang</span>
                                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hover Effect Border -->
                            <div class="absolute inset-0 border-2 border-transparent group-hover:border-sky-300 dark:group-hover:border-sky-500 rounded-2xl transition-colors duration-300 pointer-events-none"></div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Empty State / No Results Found -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <!-- Icon -->
                        <div class="mb-6">
                            <div class="mx-auto w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-search text-3xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        </div>
                        
                        <!-- Message -->
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            @if(request('query'))
                                Hasil Pencarian Tidak Ditemukan
                            @else
                                Tidak Ada Layanan Tersedia
                            @endif
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            @if(request('query'))
                                Maaf, tidak ada layanan yang cocok dengan pencarian "{{ request('query') }}". 
                                Coba gunakan kata kunci yang berbeda atau periksa ejaan Anda.
                            @else
                                Saat ini belum ada layanan yang tersedia. Silakan kembali lagi nanti.
                            @endif
                        </p>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            @if(request('query'))
                                <a href="{{ route('show.community-services.dashboard') }}" 
                                   class="px-6 py-3 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 transition duration-300 inline-flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    Lihat Semua Layanan
                                </a>
                                <button type="button" 
                                        onclick="document.querySelector('input[name=query]').focus()" 
                                        class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300 inline-flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-search"></i>
                                    Coba Pencarian Lain
                                </button>
                            @else
                                <a href="{{ route('show.community-services.dashboard') }}" 
                                   class="px-6 py-3 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 transition duration-300 inline-flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-refresh"></i>
                                    Muat Ulang
                                </a>
                            @endif
                        </div>
                        
                        <!-- Help Text -->
                        <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Tips Pencarian:</h4>
                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                <li>• Gunakan kata kunci yang lebih umum</li>
                                <li>• Periksa ejaan kata kunci</li>
                                <li>• Coba singkatan atau istilah alternatif</li>
                                <li>• Gunakan satu atau dua kata kunci saja</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection