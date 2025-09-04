
 <!DOCTYPE html>
<html lang="id">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ $title }}</title>
      {{-- fontawesome for social media icon --}}
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      {{-- Google font --}}
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
      {{-- Google font --}}
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
      {{-- Alpine JS --}}
      <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
      {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
      <!-- Scripts -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="bg-gray-200 dark:bg-gray-800">
    <div class="mx-auto" style="font-family: 'Poppins', sans-serif;">
        @include('submission-letter.layouts.main.navbar')
          
        @yield('content')

        @include('submission-letter.layouts.main.footer')
    </div>
    @include('submission-letter.layouts.settingUi.msgnotif')
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
</html>

