<!DOCTYPE html>
<html lang="id">
  <head>
      <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ $title }}</title>
      {{-- fontawesome for social media icon --}}
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      {{-- Google font --}}
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
      <!-- Leaflet CSS -->
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
      <!-- Leaflet JS -->
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
      {{-- Alpine JS --}}
      <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
      <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
      {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
      <!-- Scripts -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <link rel="stylesheet" href="{{ secure_asset('build/assets/app-Bq1mf8_k.css') }}">
      <script src="{{ secure_asset('build/assets/app-DQNOlDuK.js') }}" defer></script>
      {{-- Chart --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
      <style>
        ol {
            list-style-type: decimal !important;
            padding-left: 24px;
        }
        ol li {
            display: list-item !important;
        }
    </style>
  </head>

  <body class="bg-gray-200 dark:bg-gray-800">
    <div class="mx-auto" style="font-family: 'Poppins', sans-serif;">
        @include('public-user.layouts.main.navbar')
          
        @yield('content')

        @include('public-user.layouts.main.footer')
    </div>
  </body>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.theme-toggle-btn');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const userTheme = localStorage.getItem('theme');
        const html = document.documentElement;

        // Inisialisasi tema
        if (userTheme === 'dark' || (!userTheme && prefersDark)) {
            html.classList.add('dark');
            toggleIcons('dark');
        } else {
            html.classList.remove('dark');
            toggleIcons('light');
        }

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                html.classList.toggle('dark');

                const isDark = html.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');

                toggleIcons(isDark ? 'dark' : 'light');
            });
        });

        function toggleIcons(theme) {
            document.querySelectorAll('#theme-toggle-dark-icon').forEach(icon => {
                icon.classList.toggle('hidden', theme !== 'dark');
            });

            document.querySelectorAll('#theme-toggle-light-icon').forEach(icon => {
                icon.classList.toggle('hidden', theme !== 'light');
            });
        }
    });
  </script>   
  
</html>
