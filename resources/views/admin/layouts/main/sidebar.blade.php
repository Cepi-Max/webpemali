<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main" style="z-index: 0; important">
    <div class="sidenav-header text-center">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-4 m-0" href="{{ route('show.dashboard') }}" target="_blank">
        <h1 class="ms-1 text-lg font-bold text-dark">Admin Desa Pemali</h1>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    @php
      $userRole = auth()->user()->role;

      if ($userRole === 'operator') {
          $navLinks = [
              ['route' => 'admin.dashboard', 'label' => 'Beranda', 'icon' => 'dashboard'],
              ['route' => 'show.admin.submission_option', 'label' => 'Pilihan Surat', 'icon' => 'high_quality'],
              ['route' => 'show.admin.submission_requirements', 'label' => 'Dokumen Syarat', 'icon' => 'upcoming'],
              [
                  'route' => 'admin.surat.index',
                  'label' => 'Antrian Pengajuan',
                  'icon' => 'pending_actions',
                  'badge_count' => $totalPengajuan ?? 2,
                  'badge_color' => 'primary',
                  'children' => [
                      [
                          'route' => 'admin.surat.index',
                          'label' => 'Semua Antrian',
                          'badge_count' => $semuaAntrian ?? 3,
                          'badge_color' => 'secondary'
                      ],
                      [
                          'route' => 'admin.surat.ditolak',
                          'label' => 'Antrian Ditolak',
                          'badge_count' => $antrianDitolak ?? 4,
                          'badge_color' => 'danger'
                      ],
                      [
                          'route' => 'admin.surat.diproses',
                          'label' => 'Antrian Diproses',
                          'badge_count' => $antrianDiproses ?? 5,
                          'badge_color' => 'warning'
                      ],
                  ]
              ]
          ];
      } else {
          // Role lain (misalnya admin, superadmin) bisa melihat semua menu
          $navLinks = [
              ['route' => 'admin.dashboard', 'label' => 'Beranda', 'icon' => 'dashboard'],
              ['route' => 'admin.pengguna', 'label' => 'Atur Pengguna', 'icon' => 'settings_account_box'],
              ['route' => 'show.populations', 'label' => 'Kependudukan', 'icon' => 'groups'],
              ['route' => 'show.announcements', 'label' => 'Pengumuman', 'icon' => 'campaign'],
              ['route' => 'show.articles', 'label' => 'Artikel', 'icon' => 'article'],
              ['route' => 'show.constructions', 'label' => 'Pembangunan', 'icon' => 'domain'],
              ['route' => 'show.galleries', 'label' => 'Galeri', 'icon' => 'gallery_thumbnail'],
              ['route' => 'show.officials', 'label' => 'Aparatur', 'icon' => 'badge'],
              ['route' => 'ppid.edit', 'label' => 'PPID', 'icon' => 'info'],
              ['route' => 'show.umkm', 'label' => 'UMKM', 'icon' => 'shopping_cart_checkout'],
              ['route' => 'profile_village.edit', 'label' => 'Profil Desa', 'icon' => 'public'],
              ['route' => 'social-media', 'label' => 'Media Sosial', 'icon' => 'thumb_up'],
              [
                  'route' => 'show.admin.desa-cantik',
                  'label' => 'Desa Cantik',
                  'icon' => 'spa',
                  'children' => [
                      ['route' => 'show.admin.desa-cantik.data-statistik', 'label' => 'Data Statistik'],
                      ['route' => 'show.admin.desa-cantik.publikasi', 'label' => 'Publikasi Desa'],
                      ['route' => 'show.admin.desa-cantik.infografis', 'label' => 'Infografis Desa'],
                      ['route' => 'show.admin.desa-cantik.kewilayahan', 'label' => 'Fasilitas Desa'],
                      ['route' => 'show.admin.desa-cantik.pembagian-kewilayahan', 'label' => 'Kewilayahan Desa'],
                  ]
              ]
          ];
      }
    @endphp

        <ul class="navbar-nav">
          @foreach ($navLinks as $link)
          <li class="nav-item">
              @if (isset($link['children']))
              <a
                  class="nav-link {{ request()->routeIs($link['route'] . '*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                  data-bs-toggle="collapse"
                  href="#collapse{{ Str::camel($link['label']) }}"
                  role="button"
                  aria-expanded="{{ request()->routeIs($link['route'] . '*') ? 'true' : 'false' }}"
                  aria-controls="collapse{{ Str::camel($link['label']) }}"
              >
                  <i class="material-symbols-rounded opacity-5">{{ $link['icon'] }}</i>
                  <span class="nav-link-text ms-1">{{ __($link['label']) }}</span>
                  
                  {{-- Badge untuk parent menu --}}
                  @if (isset($link['badge_count']) && $link['badge_count'] > 0)
                      <span class="badge bg-{{ $link['badge_color'] ?? 'primary' }} ms-auto">
                          {{ $link['badge_count'] }}
                      </span>
                  @endif
              </a>
              <div class="collapse {{ request()->routeIs($link['route'] . '*') ? 'show' : '' }}" id="collapse{{ Str::camel($link['label']) }}">
                  <ul class="nav ms-3">
                      @foreach ($link['children'] as $child)
                      <li class="nav-item">
                          <a class="nav-link text-dark d-flex align-items-center justify-content-between"
                            href="{{ route($child['route']) }}"
                            @if(request()->routeIs($child['route'] . '*'))
                            style="background-color: rgba(0, 0, 0, 0.2);"
                            @endif>
                              <span class="nav-link-text ms-1">{{ $child['label'] }}</span>
                              
                              {{-- Badge untuk child menu --}}
                              @if (isset($child['badge_count']) && $child['badge_count'] > 0)
                                  <span class="badge bg-{{ $child['badge_color'] ?? 'secondary' }} badge-sm">
                                      {{ $child['badge_count'] }}
                                  </span>
                              @endif
                          </a>
                      </li>
                      @endforeach
                  </ul>
              </div>
              @else
              {{-- Jika tidak ada submenu --}}
              <a class="nav-link {{ request()->routeIs($link['route']. '*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" 
                href="{{ route($link['route']) }}">
                  <i class="material-symbols-rounded opacity-5">{{ $link['icon'] }}</i>
                  <span class="nav-link-text ms-1">{{ $link['label'] }}</span>
                  
                  {{-- Badge untuk menu biasa (jika diperlukan) --}}
                  @if (isset($link['badge_count']) && $link['badge_count'] > 0)
                      <span class="badge bg-{{ $link['badge_color'] ?? 'primary' }} ms-auto">
                          {{ $link['badge_count'] }}
                      </span>
                  @endif
              </a>
              @endif
          </li>
          @endforeach
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Akun</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="{{ route('profile-admin.edit') }}">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profil Admin</span>
          </a>
        </li>
      </ul>

    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        @if (Auth::check())
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn bg-dark text-white w-100 mb-3 rounded">Logout</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        
        @else
          <a class="btn bg-dark text-white w-100 mb-3 rounded" href="{{ route('login') }}" type="button">Login</a>
        @endif
      </div>
    </div>
  </aside>

 