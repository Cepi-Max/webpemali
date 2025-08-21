<aside class="w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-white shadow-2xl">
            <div class="p-6 border-b border-blue-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-folder-open text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Operator</h1>
                        <p class="text-blue-200 text-sm">Desa Pemali</p>
                    </div>
                </div>
            </div>
            
            @php
                $navLinks = [
                    [
                        'section' => 'Menu Utama',
                        'items' => [
                            ['route' => 'admin.dashboard-submission-letter', 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'],
                            ['route' => 'show.admin.submission_option', 'label' => 'Kelola Daftar Pelayanan', 'icon' => 'fas fa-file'],
                            ['route' => 'show.admin.submission_requirements', 'label' => 'Kelola Syarat Pelayanan', 'icon' => 'fas fa-sliders'],
                            ['route' => 'admin.surat.index', 'label' => 'Antrian Pengajuan', 'icon' => 'fas fa-chart-bar'],
                            [
                                'route' => 'laporan.pengguna.tampil', 
                                'label' => 'Laporan',
                                'icon' => 'fas fa-flag',
                                'children' => [
                                    ['route' => 'laporan.pengguna.tampil', 'label' => 'Pengguna'],
                                    ['route' => 'laporan.pengajuan.tampil', 'label' => 'Pengajuan'],
                                    ['route' => 'laporan.rekap-bulanan.tampil', 'label' => 'Rekap Bulanan'],
                                ]
                            ]
                        ]
                    ],
                    [
                        'section' => 'Lainnya',
                        'items' => [
                            // ['route' => 'admin.settings', 'label' => 'Pengaturan', 'icon' => 'fas fa-cog'],
                            ['route' => 'logout', 'label' => 'Logout', 'icon' => 'fas fa-sign-out-alt'],
                        ]
                    ],
                ];
            @endphp

            <nav class="mt-6">
                @foreach ($navLinks as $section)
                    <div class="px-4 {{ !$loop->first ? 'mt-8' : '' }} mb-4">
                        <h3 class="text-blue-200 text-xs uppercase tracking-wider font-semibold">{{ $section['section'] }}</h3>
                    </div>
                    <ul class="space-y-2 font-medium"> {{-- Tambahkan ul di sini untuk setiap section --}}
                        @foreach ($section['items'] as $link)
                            <li class="nav-item" x-data="{ open: {{ request()->routeIs($link['route'] . '*') ? 'true' : 'false' }} }">
                                                                @if ($link['route'] === 'logout')
                                    {{-- JIKA LOGOUT: Buat form khusus yang mengirim request POST --}}
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <div class="w-full flex items-center justify-between p-3 rounded-lg group text-blue-100 hover:bg-blue-700 hover:text-white">
                                            <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="flex items-center flex-grow cursor-pointer">
                                                <i class="{{ $link['icon'] }} w-5 h-5 mr-3"></i>
                                                <span class="ms-3">{{ __($link['label']) }}</span>
                                            </a>
                                        </div>
                                    </form>
                                @else
                                    <div class="w-full flex items-center justify-between p-3 rounded-lg group
                                                {{ request()->routeIs($link['route'] . '*') ? 'bg-blue-700 text-white border-r-4 border-orange-500' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">

                                                {{-- Link utama --}}
                                                <a href="{{ route($link['route']) }}" class="flex items-center flex-grow">
                                                    <i class="{{ $link['icon'] }} w-5 h-5 mr-3"></i>
                                                    <span class="ms-3">{{ __($link['label']) }}</span>
                                                </a>

                                                {{-- Tombol toggle dropdown (jika ada children) --}}
                                                @if (isset($link['children']))
                                                    <button @click="open = !open" class="ml-2 focus:outline-none">
                                                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 text-blue-100 transition-transform duration-200"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                @endif

                                {{-- Submenu --}}
                                @if (isset($link['children']))
                                    <ul x-show="open" x-transition class="ml-6 mt-1 space-y-1" x-cloak>
                                        @foreach ($link['children'] as $child)
                                            <li>
                                                <a href="{{ route($child['route']) }}"
                                                    class="block px-3 py-2 text-sm rounded-lg
                                                    {{ request()->routeIs($child['route'] . '*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 text-blue-200' }}">
                                                    {{ $child['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </nav>
        </aside>