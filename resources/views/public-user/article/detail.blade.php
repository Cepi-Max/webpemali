@extends('public-user.layouts.main.app')

@section('content')
    
    <main class="mx-auto w-[90%] pt-[6.5rem] md:pt-[7rem]">
        <div class="grid grid-cols-1 lg:grid-cols-[70%_30%] gap-5 p-3 w-full mx-auto lg:px-10 lg:py-4 mt-4 shadow-lg bg-white dark:bg-gray-900 rounded-lg">
            <!-- Kolom 1-->
            <div class="row justify-content-center">
                <div class="col-lg-8 p-4 shadow-sm rounded-md">
        
                    <div class="text-sky-950 dark:text-gray-200 lg:text-4xl md:text-2xl mt-10 text-center lg:px-40" style="font-family: 'Arial', sans-serif;"><b>{{ $dA->title }}</b></div>
        
                    <div class="text-center mt-5 mb-5">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('ds') ?>" 
                        target="_blank" 
                        title="Share on Facebook" 
                        class="text-sky-950 inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode('Check out this article!') ?>&url=<?= urlencode('Yoi Guys') ?>" 
                        target="_blank" 
                        title="Share on Twitter" 
                        class="inline-flex items-center text-sky-950 justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text=<?= urlencode('Check out this article: ' . 'Yoi Guys') ?>" 
                        target="_blank" 
                        title="Share on WhatsApp" 
                        class="inline-flex items-center text-sky-950 justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <!-- Tombol Copy to Clipboard (Hanya tampil di desktop) -->
                        <button onclick="copyToClipboard()" 
                                title="Copy Link" 
                                class="hidden md:inline-flex items-center text-sky-950 justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                            <i class="fa-solid fa-link"></i>
                        </button>
                        <!-- Notifikasi -->
                        <div id="notification" 
                            class="hidden fixed top-[10%] left-[43%] bg-green-900 bg-opacity-90 text-white text-sm rounded-md px-4 py-2 shadow-md animate-fade-in-out">
                            Link copied to clipboard!
                        </div>
        
                        <!-- Tombol Web Share API (Hanya tampil di mobile) -->
                        <button onclick="shareLink()" 
                                title="Share Link" 
                                class="inline-flex md:hidden items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>
        
                    <?php
                        $hariIndo = [
                            'Sunday' => 'Minggu',
                            'Monday' => 'Senin',
                            'Tuesday' => 'Selasa',
                            'Wednesday' => 'Rabu',
                            'Thursday' => 'Kamis',
                            'Friday' => 'Jumat',
                            'Saturday' => 'Sabtu'
                        ];
        
                        $tanggal = new DateTime($dA['created_at']);
                        $hari = strftime('%A', $tanggal->getTimestamp()); // Mendapatkan nama hari dalam bahasa Inggris
                        $hari = $hariIndo[$hari]; // Menerjemahkan ke bahasa Indonesia
                    ?>
                    
        
                    <div class="mb-3 w-full h-auto bg-black flex items-center justify-center">
                        <img src="{{ asset('storage/images/publicImg/article/articleImg/'. $dA->image) }}" 
                             alt="{{ $dA->title }}" 
                             class="w-full h-full object-contain rounded-sm">
                    </div>
        
        
                    <div class="flex items-center mb-5 text-xs text-gray-800 dark:text-gray-300">
                        <small class=""><i class="fa-solid fa-pen-nib"></i></small>
                        <small class="mx-1 mr-3 ">{{ $dA->author->name }}</small>
                        <small class=""><i class="fa-solid fa-eye"></i></small>
                        <small class="mx-1 mr-3 ">{{ $dA->seen }}</small>
                        <small class=""><i class="fas fa-tag"></i></small>
                        <small class="mx-1 mr-3 "><a href="/admin/daftar-artikel?category={{ $dA->article_category->slug }}">
                            @if (isset($dA->article_category->name))
                              {{ $dA->article_category->name }}
                            @else
                                <small class="text-muted">kategori tidak ditemukan</small>
                            @endif
                            
                        </a></small>
                        <div class="flex items-center  text-xs text-grey-500">
                            <small class="mx-1 mr-2 "><?= $hari . ', ' . $tanggal->format('d F Y'); ?></small>
                        </div>
                    </div>
        
                    <div class="lg:px-20 mt-5 text-sky-950 dark:text-gray-200">
                        {!!  $dA->body  !!}
                    </div>
                    <div class="container px-20 mx-auto lg:px-60 md:px-30 mb-10 mt-10">
                        <hr>
                        <div class="text-x" style="font-family: 'Arial', sans-serif;">
                            <span class="text-sky-950 dark:text-gray-300">Share :</span>
                            <div class="text-center text-sky-950 mt-5 mb-5">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('current_url()') ?>" 
                                    target="_blank" 
                                    title="Share on Facebook" 
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode('Check out this article!') ?>&url=<?= urlencode('current_url()') ?>" 
                                    target="_blank" 
                                    title="Share on Twitter" 
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text=<?= urlencode('Check out this article: ' . 'current_url()') ?>" 
                                    target="_blank" 
                                    title="Share on WhatsApp" 
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                    <!-- Tombol Copy to Clipboard (Hanya tampil di desktop) -->
                                    <button onclick="copyToClipboard()" 
                                            title="Copy Link" 
                                            class="hidden md:inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                                        <i class="fa-solid fa-link"></i>
                                    </button>
        
                                    <!-- Tombol Web Share API (Hanya tampil di mobile) -->
                                    <button onclick="shareLink()" 
                                            title="Share Link" 
                                            class="inline-flex md:hidden items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300">
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </button>
                                </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="p-[2px] inline-block w-full h-10 mb-4">
                        <div class="p-2 bg-sky-950 dark:bg-gray-700 w-full h-full flex justify-between items-center rounded-md">
                            <h2 class="text-lg text-white dark:text-gray-200 font-bold">Artikel Terpopuler &gt;</h2>
                        </div>
                    </div>
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 w-full flex justify-center md:justify-between lg:justify-between overflow-hidden">
                        @foreach ($popularArticle as $article)
                        <a href="{{ route('show.article.detail', $article->slug) }}">
                        <div class="relative w-full h-52 rounded-xl overflow-hidden shadow-lg">
                            <img src="{{ asset('storage/images/publicImg/article/articleImg/'. $article->image) }}" alt="Article Image" class="w-full flex-shrink-0 object-cover h-64">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-end p-4">
                              <h2 class="text-white text-xl font-bold">{{  $article->title }}</h2>
                              <p class="text-white text-sm">{{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('l, d-F-Y') }}</p>
                            </div>
                        </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>    
            <!-- Kolom 2 -->
            <div class="row">
                <section class="rounded-md mt-3 sticky top-[6.5rem] md:top-[7rem] pb-4 bg-gray-300 dark:bg-gray-800">
                    <div class="p-[2px] inline-block w-full h-10">
                        <div class="p-2 bg-sky-950 dark:bg-gray-900 w-full h-full flex justify-between items-center rounded-md">
                            <h2 class="text-lg text-white font-bold">Baca juga &gt;</h2>
                        </div>
                    </div>
                    <div class="mt-2 space-y-4 lg:px-2 max-h-[70vh] overflow-y-auto">
                        @foreach ($latestArticles as $la)     
                        <a href="{{ route('show.article.detail', $la->slug) }}" class="block">
                            <div class="group bg-white dark:bg-gray-700 dark:text-gray-300 p-4 shadow-md mt-2 rounded-lg">
                                <p class="group-hover:text-blue-600">{{ $la->title }}</p>
                                <div class="flex mt-2">
                                    <small class="text-gray-500 ml-2">
                                        {{ \Carbon\Carbon::parse($la->created_at)->translatedFormat('l, d F Y') }}
                                    </small>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </section>
            </div>
            
        </div>   
        @include('public-user.layouts.map.map')     
    </main>

@endsection