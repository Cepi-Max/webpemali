@extends('public-user.layouts.main.app')

@section('content')

<main class="mx-auto pt-[6.5rem] md:pt-[7rem]">
    @forelse ($ppidData as $ppid)
    <div class="max-w-7xl mx-auto px-4 py-9 grid md:grid-cols-2 gap-12 items-center">
        <!-- Gambar kiri -->
        <div class="relative w-full h-80 rounded-md overflow-hidden shadow-lg">
            <img src="{{ asset('storage/images/publicImg/ppid/ppidImg/'. $ppid->gambar_depan_ppid) }}" alt="Gambar Depan" class="w-full h-full object-cover">
        </div>
        
        <!-- Konten kanan -->
        <div>
         <!-- <h3 class="text-sm font-bold tracking-widest uppercase text-gray-600">E-PPID</h3> -->
          <h1 class="text-3xl md:text-4xl font-bold leading-tight mt-2 mb-4 text-gray-900 dark:text-gray-100">
            Selamat Datang di Halaman Pengelola Pelayanan Informasi Publik Desa Pemali.
          </h1>
          <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
            PPID adalah pejabat yang bertanggung jawab dalam penyimpanan, pendokumentasian, penyediaan, dan pelayanan informasi di badan publik. Fungsi utama PPID adalah untuk mengelola dan menyampaikan dokumen yang dimiliki oleh badan publik sesuai dengan amanat Undang-Undang Nomor 14 tahun 2008 tentang Keterbukaan Informasi Publik.
          </p>
        </div>
      </div>
    
      <div>
        <header class="bg-white dark:bg-gray-900 shadow">
            <div class="max-w-7xl mx-auto px-4 pt-12 flex items-center justify-center">
                <nav class="flex flex-wrap justify-center space-x-4 gap-y-2 text-sm font-medium text-gray-700 dark:text-gray-200 md:space-x-8 md:gap-y-0">
                    <a href="#profilePPID" class="nav-link active hover:text-blue-600 dark:hover:text-blue-400">
                        Profil PPID
                    </a>
                    <a href="#visi-misi" class="nav-link hover:text-blue-600 dark:hover:text-blue-400">
                        Visi & Misi
                    </a>
                    <a href="#strukturOrganisasi" class="nav-link hover:text-blue-600 dark:hover:text-blue-400">
                        Struktur Organisasi
                    </a>
                    <a href="#maklumat" class="nav-link hover:text-blue-600 dark:hover:text-blue-400">
                        Maklumat
                    </a>
                    <a href="{{ route('ppid.preview.public',$ppid->id) }}" target="_blank" class="nav-link hover:text-blue-600 dark:hover:text-blue-400">
                        Regulasi PPID
                    </a>
                </nav>
            </div>
        </header>


          <!-- Profile Section -->
          @include('public-user.ppid.profile')
          <!-- Visi & Misi Section -->
          @include('public-user.ppid.visi-misi')
          <!-- Struktur Organisasi Section -->
          @include('public-user.ppid.struktur-organisasi')
          <!-- Maklumat Section -->
          @include('public-user.ppid.maklumat')
        
    </div>

      {{-- Hubungi Pelayanan --}}
      <div class="mb-10 mt-10 max-w-6xl mx-auto py-6">
        <h1 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">Dapatkan Pelayanan Informasi Publik</h1>
        <div class="px-4 pb-8">
              <p class="text-gray-700 dark:text-gray-300 mb-4">
                Warga desa berhak memperoleh informasi publik yang terbuka. Permintaan akan diproses sesuai dengan ketentuan yang ditetapkan oleh desa.
              </p>
              {{-- <p class="text-gray-700 dark:text-gray-300"><strong>Jam Layanan:</strong> Senin–Jumat, 08.00 – 15.00 WIB</p> --}}
              <div class="flex justify-between">
                <p class="text-gray-700 dark:text-gray-300"><strong>Kontak PPID:</strong> <a href="https://wa.me/{{ $ppid->kontak }}" target="_blank" class="hover:underline hover:text-blue-600 dark:hover:text-blue-400 cursor-pointer">{{ $ppid->kontak }}</a></p>
                  {{-- <a href="#"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Ajukan Permintaan Informasi
                  </a> --}}
              </div>
        </div>          
      </div>
    @empty
    <div class="flex items-center justify-center h-screen bg-gray-100 dark:bg-gray-800">
        <p class="text-center text-gray-600 dark:text-gray-300 text-lg md:text-xl font-semibold">
            Data belum dimasukkan
        </p>
    </div>    
    @endforelse
    





    {{-- @forelse ($ppidData as $ppid)
        <div id="visi-misi-ppid" class="w-full mx-auto lg:px-40 mt-4">
            <!-- Profil -->
            <div class="bg-gray-200 rounded-lg p-6 mb-6 bg-white dark:bg-gray-900 shadow-lg">
                <h5 class="text-2xl font-bold text-sky-950 dark:text-gray-200">Profil PPID:</h5>
                <div class="text-justify font-bold mt-6 text-sky-950 dark:text-gray-200">
                    {!! $ppid->profil !!}
                </div>
            </div>
            
            <!-- Visi Misi -->
            <div class="bg-gray-200 rounded-lg p-6 mb-6 bg-white dark:bg-gray-900 shadow-lg">
                <h5 class="text-2xl font-bold text-sky-950 dark:text-gray-200">Visi Misi PPID:</h5>
                <div class="text-justify font-bold mt-6 text-sky-950 dark:text-gray-200">
                    {!! $ppid->visi_misi !!}
                </div>
            </div>

            
            <div id="struktur-organisasi-ppid" class="w-full bg-white dark:bg-gray-900 mx-auto lg:px-10 lg:py-4 mt-6 mb-6 shadow-lg rounded-lg">
                <div class="flex gap-2">
                    <i class="fa-solid fa-book text-sky-950 dark:text-gray-200 mb-4 text-xl font-bold"></i>
                    <h1 class="mb-4 text-xl font-bold text-sky-950 dark:text-gray-200 text-left">Struktur Organisasi PPID</h1>
                </div>
                <div class="flex border-2 border-sky-950 rounded-lg gap-2 h-96 w-[100%] text-sky-950 dark:text-gray-200">
                    <div class="p-3">
                        <img class="w-full h-full rounded-lg object-contain" src="{{ asset('storage/images/publicImg/ppid/ppidImg/'. $ppid->gambar_struktur_organisasi) }}" alt="gambar struktur organisasi belum dimasukkan">
                    </div>
                </div>
            </div>

            <!-- Regulasi -->
            <div class="bg-gray-200 rounded-lg p-6 mb-6 bg-white dark:bg-gray-900 shadow-lg">
                <h5 class="text-2xl font-bold text-sky-950 dark:text-gray-200">Regulasi PPID</h5>
                <div class="text-justify font-bold mt-6 text-sky-950 dark:text-gray-200">
                    {!! $ppid->regulasi_ppid !!}
                </div>
                <div class="mt-2 flex gap-3 justify-end">
                    <a href="{{ route('ppid.preview.public', $ppid->id) }}" target="_blank" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <i class="fa-solid fa-file-pdf"></i> Lihat
                    </a>
                    <a href="{{ route('ppid.download.public', $ppid->id) }}" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                        <i class="fa-solid fa-download"></i> Unduh
                    </a>
                </div>
            </div>

            <!-- Maklumat -->
            <div class="bg-gray-200 rounded-lg p-6 mb-6 bg-white dark:bg-gray-900 shadow-lg">
                <h5 class="text-2xl font-bold text-sky-950 dark:text-gray-200">Maklumat Pelayanan Informasi Publik</h5>
                <div class="text-justify font-bold mt-6 text-sky-950 dark:text-gray-200">
                    {!! $ppid->maklumat !!}
                </div>
            </div>


        </div>

    @empty
    @endforelse
    @include('public-user.layouts.map.map')--}}
    @include('public-user.layouts.asset.msgnotif') 
</main>

<style>
    .nav-link {
      transition: all 0.3s ease;
    }
  
    .nav-link.active {
      color: #2563eb; /* Tailwind blue-600 */
      border-bottom: 2px solid #2563eb;
      padding-bottom: 2px;
    }
</style>
  
<script>
    function closeNotif() {
        const notif = document.getElementById('notif');
        notif.classList.add('translate-x-full');
        setTimeout(() => notif.remove(), 500);
    }

    // Auto-show after render
    window.addEventListener('DOMContentLoaded', () => {
        const notif = document.getElementById('notif');
        if (notif) {
            setTimeout(() => notif.classList.remove('translate-x-full'), 100); // animate in
            setTimeout(closeNotif, 4000); // auto close after 4s
        }
    });

    // script untuk nav ppid
    document.addEventListener('DOMContentLoaded', () => {
        const links = document.querySelectorAll('nav a.nav-link');
        const sections = document.querySelectorAll('section');

        links.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');

                // Jika link adalah anchor (dimulai dengan #), tangani manual
                if (href.startsWith('#')) {
                    e.preventDefault();

                    const targetId = href.substring(1);

                    // Sembunyikan semua section
                    sections.forEach(section => section.classList.add('hidden'));

                    // Tampilkan section yang dipilih
                    const targetSection = document.getElementById(targetId);
                    if (targetSection) {
                        targetSection.classList.remove('hidden');
                    }

                    // Hapus class aktif dari semua link
                    links.forEach(l => l.classList.remove('active'));

                    // Tambahkan class aktif ke link yang diklik
                    link.classList.add('active');
                }
                // Kalau bukan anchor (misalnya route Laravel), biarkan browser handle
            });
        });
    });

</script>


@endsection