
<!-- resources/views/layouts/app.blade.php -->
<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('storage/general/icon/favicon-32x32') }}">
  <title>
    {{ $title ?? 'Desa Pemali | Admin' }}
  </title>
  @stack('styles')
  <!-- Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('admin/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('admin/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- bootstrap icon 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">-->
  <!-- CDN Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('admin/assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
  <!-- style.css -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
  <!-- include summernote css/js-->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  {{-- Chart.Js --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  {{-- Alpine JS --}}
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="g-sidenav-show  bg-gray-100">




@include('admin.layouts.main.sidebar')





<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

  <div class="container-fluid py-2">

    @include('admin.layouts.main.navbar')

    @yield('content')

    @include('admin.layouts.main.footer')

  </div>

</main>




@include('admin.layouts.asset.materialUi')
@include('admin.layouts.asset.msgnotif')

{{-- <!--   Core JS Files   Error Dropdown-->
<script src="{{ ('admin/assets/js/core/popper.min.js') }}"></script>
<!-- Pakai versi 5.2.3 (karena lebih tinggi) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- Summernot JS dan jquery-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script> --}}

<!-- Core JS yang aman -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<!-- Summernote dan jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script>
      $(document).ready(function() {
        // Summernote Initialization
        $('.summernote').summernote({
          placeholder: 'Tulis teks...',
            tabsize: 2,
            height: 300,
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'video']],
              ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        $('.visi-misi-sejarah-desa-ppid-summernote').summernote({
          placeholder: 'Tulis teks...',
          height: 100,
          toolbar: [
              ['font', ['bold', 'underline', 'clear']],
              ['para', ['ul', 'ol', 'paragraph']]
            ]
        });
      });

    // Sidebar Scroll
   var win = navigator.platform.indexOf('Win') > -1;
   if (win && document.querySelector('#sidenav-scrollbar')) {
     var options = {
       damping: '0.5'
     }
     Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
   }

   // Fixed Plugin

  if (document.querySelector('.fixed-plugin')) {
    var fixedPlugin = document.querySelector('.fixed-plugin');
    var fixedPlugin = document.querySelector('.fixed-plugin');
    var fixedPluginButton = document.querySelector('.fixed-plugin-button');
    var fixedPluginButtonNav = document.querySelector('.fixed-plugin-button-nav');
    var fixedPluginCard = document.querySelector('.fixed-plugin .card');
    var fixedPluginCloseButton = document.querySelectorAll('.fixed-plugin-close-button');
    var navbar = document.getElementById('navbarBlur');
    var buttonNavbarFixed = document.getElementById('navbarFixed');

    if (fixedPluginButton) {
      fixedPluginButton.onclick = function() {
        if (!fixedPlugin.classList.contains('show')) {
          fixedPlugin.classList.add('show');
        } else {
          fixedPlugin.classList.remove('show');
        }
      }
    }

    if (fixedPluginButtonNav) {
      fixedPluginButtonNav.onclick = function() {
        if (!fixedPlugin.classList.contains('show')) {
          fixedPlugin.classList.add('show');
        } else {
          fixedPlugin.classList.remove('show');
        }
      }
    }

    fixedPluginCloseButton.forEach(function(el) {
      el.onclick = function() {
        fixedPlugin.classList.remove('show');
      }
    })

    document.querySelector('body').onclick = function(e) {
      if (e.target != fixedPluginButton && e.target != fixedPluginButtonNav && e.target.closest('.fixed-plugin .card') != fixedPluginCard) {
        fixedPlugin.classList.remove('show');
      }
    }

    if (navbar) {
      if (navbar.getAttribute('data-scroll') == 'true' && buttonNavbarFixed) {
        buttonNavbarFixed.setAttribute("checked", "true");
      }
    }

  }

  // Sweetalert modal
  document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-delete')) {
                const slug = e.target.dataset.id;
                Swal.fire({
                        title: 'Data akan dihapus!',
                        text: 'Apakah Anda yakin?',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-delete-' + slug).submit();
                        }
                });
            }
  });
 </script>

 <script>
   window.onload = function() {
       const notif = document.getElementById('notif');
       if (notif) {
           // Muncul dengan animasi geser dari kanan
           setTimeout(() => notif.style.transform = 'translateX(0)', 100);
 
           // Auto-close 5 detik
           setTimeout(() => closeNotif(), 5000);
       }
   };
 
   function closeNotif() {
       const notif = document.getElementById('notif');
       notif.style.transform = 'translateX(150%)';
   }
 </script>
 {{-- <!-- Github buttons -->
 <script async defer src="https://buttons.github.io/buttons.js"></script>
 <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
 <script src="{{ asset('admin/assets/js/material-dashboard.min.js?v=3.2.0') }}"></script> --}}
@stack('scripts')
</body>
</html>

