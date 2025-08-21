<div class="fixed-plugin">
    {{-- <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a> --}}
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Pengaturan Website</h5>
          {{-- <p>See our dashboard options.</p> --}}
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body w-auto pt-sm-3 pt-0">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link rounded m-auto p-2 {{ request()->routeIs('show.settingBanner') ? 'active border-bottom text-light bg-dark' : 'text-dark' }}" href="{{ route('show.settingBanner') }}">
              <i class="material-symbols-rounded">ad</i>
              <span class="nav-link-text ms-1">Spanduk Beranda Utama</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link rounded m-auto p-2 {{ request()->routeIs('show.setting-banner-service') ? 'active border-bottom text-light bg-dark' : 'text-dark' }}" href="{{ route('show.setting-banner-service') }}">
              <i class="material-symbols-rounded">text_ad</i>
              <span class="nav-link-text ms-1">Spanduk Beranda Pelayanan</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>