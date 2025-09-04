<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="{{ route('dashboard') }}">
        {{-- <img src="../admin/assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo"> --}}
        <span class="ms-1 text-sm text-dark">Ayo Ajukan Pelayanan</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      @php
          $navLinks = [
              ['route' => 'show.community-services.dashboard', 'label' => 'Beranda'],
              ['route' => 'show.mysubmission', 'label' => 'Pengajuan Saya'],
              ['route' => 'show.mysubmission_history', 'label' => 'Riwayat Pengajuan'],
          ];
      @endphp
      <ul class="navbar-nav">
        @foreach ($navLinks as $link)
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs($link['route']  . '*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route($link['route']) }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text ms-1">{{ __($link['label']) }}</span>
            </a>
          </li>
        @endforeach
        
        {{-- <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('show.populations.statistics') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('show.populations.statistics') }}">
            <i class="material-symbols-rounded opacity-5">area_chart</i>
            <span class="nav-link-text ms-1">Statistik Masyarakat</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('show.articles') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('show.articles') }}">
            <i class="material-symbols-rounded opacity-5">article</i>
            <span class="nav-link-text ms-1">Artikel</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('show.constructions') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('show.constructions') }}">
            <i class="material-symbols-rounded opacity-5">domain</i>
            <span class="nav-link-text ms-1">Pembangunan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('show.galleries') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('show.galleries') }}">
            <i class="material-symbols-rounded opacity-5">gallery_thumbnail</i>
            <span class="nav-link-text ms-1">Galeri</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('show.officials') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('show.officials') }}">
            <i class="material-symbols-rounded opacity-5">account_balance_wallet</i>
            <span class="nav-link-text ms-1">Aparatur</span>
          </a>
        </li> --}}


        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/profile.html">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profil Saya</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-in.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Sign In</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-up.html">
            <i class="material-symbols-rounded opacity-5">assignment</i>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li>
      </ul>

    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline-dark mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a>

        @if (Auth::check())
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button class="bg-gradient-dark w-100">Logout</button>
        </form>
        @else
        <a class="btn bg-gradient-dark w-100" href="{{ route('login') }}" type="button">Login</a>
        @endif

      </div>
    </div>
  </aside>

 