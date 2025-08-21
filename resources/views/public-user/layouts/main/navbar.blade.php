<header x-data="{ showDateHeader: true, lastScroll: 0, open: false }" x-init="
        $nextTick(() => {
            window.addEventListener('scroll', () => {
                const current = window.scrollY;
                showDateHeader = current < lastScroll || current < 100;
                lastScroll = current;
            });
        })
        " class="fixed top-0 left-0 right-0 z-40">

    <div class="w-full">
        <div x-show="showDateHeader" 
            x-ref="headerWrapper"
            x-transition:enter="transition-all ease-out duration-100"
            x-transition:enter-start="opacity-0 -translate-y-4 max-h-0"
            x-transition:enter-end="opacity-100 translate-y-0 max-h-16"
            x-transition:leave="transition-all ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0 max-h-16"
            x-transition:leave-end="opacity-0 -translate-y-4 max-h-0"
            class="option bg-gray-200 dark:bg-gray-800 p-4 flex justify-between items-center h-[2rem] text-sky-950 dark:text-gray-200">
          <div class="time">
              <i class="fa-solid fa-calendar-days mr-2"></i>
              {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
          </div>
          <div class="social flex gap-4">
              
              @if ($profiles->facebook)
                <a href="{{ $profiles->facebook }}" target="_blank" class="hover:underline">
                    <i class="fa-brands fa-facebook hover:underline"></i>
                </a>
              @endif

              @if ($profiles->x)
                <a href="{{ $profiles->x }}" target="_blank" class="hover:underline">
                    <i class="fa-brands fa-x-twitter hover:underline"></i>
                </a>
              @endif

              @if ($profiles->instagram)
                <a href="{{ $profiles->instagram }}" target="_blank" class="hover:underline">
                    <i class="fa-brands fa-instagram hover:underline"></i>
                </a>
              @endif

              @if ($profiles->whatsapp)
                <a href="https://wa.me/{{ $profiles->whatsapp }}" target="_blank" class="hover:underline">
                    <i class="fa-brands fa-whatsapp hover:underline"></i>
                </a>
              @endif
          </div>
        </div>
        <div class="h-20 bg-sky-950 dark:bg-gray-900 flex items-center justify-between px-4 transition-all duration-300">
            <a href="{{ route('show.dashboard') }}">
            <div class="flex items-center space-x-2 md:space-x-5 lg:space-x-5">
                    <img src="{{  asset('storage/images/general/lambang_kab_bangka.png') }}" class="h-10 w-8" alt="lambang kabupaten bangka">
                    <div>
                        <h1 class="text-xl font-bold text-white dark:text-gray-200">Desa Pemali</h1>
                        <h1 class="text-l font-bold text-white dark:text-gray-200 hidden lg:block">Kabupaten Bangka</h1>
                    </div>
            </div>
            </a>
            <nav class="">
                <div class="block sm:hidden right-0 flex items-center">
                    <button type="button" class="theme-toggle-btn text-gray-500 dark:text-gray-400 hover:bg-gray-500 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>
                    <!-- Mobile menu button -->
                    <button @click="open = !open" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-white dark:text-gray-400 hover:bg-gray-700 hover:text-white dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white dark:focus:ring-gray-700">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!open" class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg x-show="open" x-cloak class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    </button>
                </div>
                {{-- Nav md/lg --}}
                <div class="hidden sm:flex items-center gap-4 p-4">
                    <div class="hover:border-b-2 hover:border-orange-500">
                        <a href="{{ route('show.dashboard') }}" class="block rounded-md px-3 py-2 text-base text-white dark:text-gray-200 {{ request()->routeIs('show.dashboard'  . '*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}">Beranda</a>
                    </div>
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @mouseenter.window="if (window.innerWidth >= 768) open = true" @mouseleave.window="if (window.innerWidth >= 768) open = false">
                        <div id="dropdownWrapperProfile" class="hover:border-b-2 hover:border-orange-500">
                            <button type="button" @click="open = !open" class="inline-flex w-full justify-center rounded-md px-3 py-2 text-base text-white dark:text-gray-200 {{ request()->routeIs('show.profile.public'  . '*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}" id="dropdownButtonProfile">
                                Profil
                                <svg :class="open ? 'rotate-180' : 'rotate-0'" class="transition-transform duration-200 -mr-1 size-5 text-white dark:text-gray-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    
                        <div x-show="open" x-cloak x-transition @click.away="open = false" id="dropdownMenuProfile" class="z-10 absolute left-0 w-48 mt-2 bg-white dark:bg-gray-900 dark:bg-dark-900 border border-gray-200 rounded-lg shadow-lg">
                            <a href="{{ route('show.profile.public') }}#visi-misi" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Visi & Misi</a>
                            <a href="{{ route('show.profile.public') }}#sejarah" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Sejarah</a>
                            <a href="{{ route('show.profile.public') }}#peta" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Peta Desa</a>
                            <a href="{{ route('show.profile.public') }}#profil-aparatur" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Aparatur Desa</a>                    
                        </div>
                    </div>

                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @mouseenter.window="if (window.innerWidth >= 768) open = true" @mouseleave.window="if (window.innerWidth >= 768) open = false">
                        <div id="dropdownWrapperInfo" class="hover:border-b-2 hover:border-orange-500">
                            <button type="button" @click="open = !open" class="inline-flex w-full justify-center px-3 py-2 text-white dark:text-gray-200 rounded-md {{ request()->routeIs(['show.article' .'*', 'show.gallery'.'*', 'show.announcement'.'*', 'show.construction'.'*']) ? 'bg-gray-900 dark:bg-gray-700' : '' }}" id="dropdownButtonInfoDesktop">
                                Info
                                <svg :class="open ? 'rotate-180' : 'rotate-0'" class="transition-transform duration-200 -mr-1 size-5 text-white dark:text-gray-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    
                        <div x-show="open" x-cloak x-transition @click.away="open = false" id="dropdownMenuInfo" class="z-10 absolute left-0 w-48 mt-2 bg-white dark:bg-gray-900 dark:bg-dark-900 border border-gray-200 rounded-lg shadow-lg">
                            <a href="{{ route('show.article') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"><span class="{{ request()->routeIs('show.article' .'*') ? 'border-b-2 border-gray-700' : '' }}">Artikel</span></a>
                            <a href="{{ route('show.gallery') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"><span class="{{ request()->routeIs('show.gallery' .'*') ? 'border-b-2 border-gray-700' : '' }}">Galeri</span></a>
                            <a href="{{ route('show.announcement') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"><span class="{{ request()->routeIs('show.announcement' .'*') ? 'border-b-2 border-gray-700' : '' }}">Pengumuman</span></a> 
                            <a href="{{ route('show.construction') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"><span class="{{ request()->routeIs('show.construction' .'*') ? 'border-b-2 border-gray-700' : '' }}">Pembangunan</span></a> 
                        </div>
                    </div>
                    <div class="hover:border-b-2 hover:border-orange-500">
                        <a href="{{ route('show.umkm.public') }}" class="block rounded-md px-3 py-2 text-white dark:text-gray-200 {{ request()->routeIs('show.umkm'  . '*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}">UMKM</a>
                    </div>
                    <div class="hover:border-b-2 hover:border-orange-500">
                        <a href="{{ route('show.ppid') }}" class="block rounded-md px-3 py-2 text-white dark:text-gray-200 {{ request()->routeIs('show.ppid'  . '*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}">PPID</a>
                    </div>
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @mouseenter.window="if (window.innerWidth >= 768) open = true" @mouseleave.window="if (window.innerWidth >= 768) open = false">
                        <div id="dropdownWrapperInfo" class="hover:border-b-2 hover:border-orange-500">
                            <button type="button" @click="open = !open" class="inline-flex w-full justify-center px-3 py-2 text-white dark:text-gray-200 rounded-md {{ request()->routeIs('show.desa-cantik' .'*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}" id="dropdownButtonInfoDesktop">
                                Data & Statistik
                                <svg :class="open ? 'rotate-180' : 'rotate-0'" class="transition-transform duration-200 -mr-1 size-5 text-white dark:text-gray-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    
                        <div x-show="open" x-cloak x-transition @click.away="open = false" id="dropdownMenuInfo" class="z-10 absolute left-0 w-48 mt-2 bg-white dark:bg-gray-900 dark:bg-dark-900 border border-gray-200 rounded-lg shadow-lg">
                            <a href="{{ route('show.desa-cantik.statistik') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"><span class="{{ request()->routeIs('show.desa-cantik.statistik') ? 'border-b-2 border-gray-700' : '' }}">Statistik</span></a>
                            <a href="{{ route('show.desa-cantik.publikasi') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"><span class="{{ request()->routeIs('show.desa-cantik.publikasi') ? 'border-b-2 border-gray-700' : '' }}">Publikasi</span></a>
                            <a href="{{ route('show.desa-cantik.infografis') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"><span class="{{ request()->routeIs('show.desa-cantik.infografis') ? 'border-b-2 border-gray-700' : '' }}">Infografis</span></a> 
                            <a href="{{ route('show.desa-cantik.kewilayahan') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"><span class="{{ request()->routeIs('show.desa-cantik.kewilayahan') ? 'border-b-2 border-gray-700' : '' }}">Kewilayahan</span></a> 
                        </div>
                    </div>
                    <div class="hover:border-b-2 hover:border-orange-500">
                        @auth
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @mouseenter.window="if (window.innerWidth >= 768) open = true" @mouseleave.window="if (window.innerWidth >= 768) open = false">
                            <div id="dropdownWrapperUser" class="hover:border-b-2 hover:border-orange-500">
                                <button type="button" @click="open = !open" class="inline-flex w-full justify-center px-3 py-2 text-white dark:text-gray-200" id="dropdownButtonInfoMobile">
                                    <i class="fa-solid fa-circle-user text-white dark:text-gray-200"></i>
                                </button>
                            </div>
                        
                            <div x-show="open" x-cloak x-transition @click.away="open = false" id="dropdownMenuUser" class="z-10 absolute right-0 w-48 mt-2 bg-white dark:bg-gray-900 dark:bg-dark-900 border border-gray-200 rounded-lg shadow-lg">
                                <a href="{{ route('profile-user.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Profile</a>
                                @if (Auth::user()->role == 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Admin</a>
                                @elseif (Auth::user()->role == 'operator')
                                    <a href="{{ route('admin.dashboard-submission-letter') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Operator</a>
                                @endif
                                <hr>
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Log Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        @else
                            <a href="{{ route('login') }}" class="text-white dark:text-gray-200 font-bold">Login</a>
                        @endauth 
                    </div>
                    <button type="button" class="theme-toggle-btn text-gray-500 dark:text-gray-400 hover:bg-gray-500 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </nav>
        </div>
        <!-- Mobile menu -->
        <div class="sm:hidden bg-sky-950 dark:bg-gray-900 w-full" x-show="open" x-cloak x-transition @click.away="open = false">
            <div class="px-2 pb-3 pt-2">
                <a href="{{ route('show.dashboard') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white dark:text-gray-200 {{ request()->routeIs('show.dashboard'  . '*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}">Beranda</a>
                <!-- Tombol Profil -->
                <div x-data="{ dropdownOpen : false}">
                    <a href="#" @click="dropdownOpen = !dropdownOpen" class="flex items-center justify-between w-full rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 text-white dark:text-gray-200 {{ request()->routeIs('show.profile.public'  . '*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}">
                        Profil
                        <svg class="w-5 h-5 transition-transform duration-300" 
                            :class="{'rotate-180': dropdownOpen}" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <ul x-show="dropdownOpen" 
                        @click.away="dropdownOpen = false"
                        x-transition 
                        class="ml-4 mt-1 space-y-1 border-l-2 border-gray-600 pl-3">
                        <li><a href="{{ route('show.profile.public') }}#visi-misi" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200">Visi & Misi</a></li>
                        <li><a href="{{ route('show.profile.public') }}#sejarah" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200">Sejarah</a></li>
                        <li><a href="{{ route('show.profile.public') }}#peta" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200">Peta</a></li>
                        <li><a href="{{ route('show.profile.public') }}#profil-aparatur" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200">Aparatur Desa</a></li>
                    </ul>
                </div>

                <!-- Tombol Info -->
                <div x-data="{ dropdownOpen : false}">
                    <a href="#" @click="dropdownOpen = !dropdownOpen" class="flex items-center justify-between w-full rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 text-white dark:text-gray-200 {{ request()->routeIs(['show.article' .'*', 'show.gallery'.'*', 'show.announcement'.'*', 'show.construction'.'*']) ? 'bg-gray-900' : '' }}">
                        Info
                        <svg class="w-5 h-5 transition-transform duration-300" 
                            :class="{'rotate-180': dropdownOpen}" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <ul x-show="dropdownOpen" 
                        @click.away="dropdownOpen = false"
                        x-transition 
                        class="ml-4 mt-1 space-y-1 border-l-2 border-gray-600 pl-3">
                        <li><a href="{{ route('show.article') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200"><span class="{{ request()->routeIs('show.article' .'*') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Artikel</span></a></li>
                        <li><a href="{{ route('show.gallery') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200"><span class="{{ request()->routeIs('show.gallery' .'*') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Galeri</span></a></li>    
                        <li><a href="{{ route('show.announcement') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200"><span class="{{ request()->routeIs('show.announcement' .'*') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Pengumuman</span></a></li>    
                        <li><a href="{{ route('show.construction') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200"><span class="{{ request()->routeIs('show.construction' .'*') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Pembangunan</span></a></li>    
                    </ul>
                </div>

                <a href="{{ route('show.umkm.public') }}" class="block rounded-md mb-2 px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 text-white dark:text-gray-200 {{ request()->routeIs('show.umkm'  . '*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}">UMKM</a>
                <a href="{{ route('show.ppid') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 text-white dark:text-gray-200 {{ request()->routeIs('show.ppid'  . '*') ? 'bg-gray-900 dark:bg-gray-700' : '' }}">PPID</a>

                <div x-data="{ dropdownOpen: false }">
                    <a href="#" @click="dropdownOpen = !dropdownOpen" class="flex items-center justify-between w-full rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 text-white dark:text-gray-200 {{ request()->routeIs('show.desa-cantik.*') ? 'bg-gray-900' : '' }}">
                        Data & Statistik
                        <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': dropdownOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                
                    <ul x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition class="ml-4 mt-1 space-y-1 border-l-2 border-gray-600 pl-3">
                        <li>
                            <a href="{{ route('show.desa-cantik.statistik') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200">
                                <span class="{{ request()->routeIs('show.desa-cantik.statistik') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Statistik</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('show.desa-cantik.publikasi') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200">
                                <span class="{{ request()->routeIs('show.desa-cantik.publikasi') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Publikasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('show.desa-cantik.infografis') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200">
                                <span class="{{ request()->routeIs('show.desa-cantik.infografis') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Infografis</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('show.desa-cantik.kewilayahan') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200">
                                <span class="{{ request()->routeIs('show.desa-cantik.kewilayahan') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Kewilayahan</span>
                            </a>
                        </li>
                    </ul>
                </div>                

                @auth
                    <div x-data="{ dropdownOpen : false}" class="relative group">
                        <div class="border-b-2 border-gray-500 w-[98%] mx-2"></div>
                        <div>
                            <button @click="dropdownOpen = !dropdownOpen" type="button" class="flex items-center justify-between w-full rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 text-white dark:text-gray-200">
                                <span class="text-gray-300">{{ Auth::user()->name }}</span>
                                <svg class="w-5 h-5 transition-transform duration-300" 
                                    :class="{'rotate-180': dropdownOpen}" 
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <ul x-show="dropdownOpen" 
                            @click.away="dropdownOpen = false"
                            x-transition 
                            class="ml-4 mt-1 space-y-1 border-l-2 border-gray-600 pl-3">
                            <li><a href="{{ route('profile-user.edit') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200"><span class="{{ request()->routeIs('profile.edit' .'*') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Profile</span></a></li>
                            @if (Auth::user()->role == 'admin')
                                <li><a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200"><span class="{{ request()->routeIs('admin.dashboard' .'*') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Admin</span></a></li>    
                            @elseif (Auth::user()->role == 'operator')
                                <li><a href="{{ route('admin.dashboard-submission-letter') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200"><span class="{{ request()->routeIs('admin.dashboard-submission-letter' .'*') ? 'border-b-2 border-gray-900 dark:border-gray-300' : '' }}">Operator</span></a></li>    
                            @endif
                            
                            <li><a href="{{ route('logout') }}" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-200" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>    
                        </ul>
                    </div>
                    @else
                        <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 text-base font-bold text-gray-300 hover:bg-gray-700 text-white dark:text-gray-200">Login</a>
                    @endauth
            </div>
        </div>
    </div>
</header>

