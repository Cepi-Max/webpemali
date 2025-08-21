<footer class="bg-white dark:bg-gray-900 text-dark dark:text-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-10">
      <!-- Section 1 -->
      <div class="text-sky-950 dark:text-gray-200">
        <h4 class="text-lg font-semibold mb-4">Desa Pemali</h4>
        <ul class="space-y-4">
          <li><a href="{{ route('show.profile.public') }}" class="hover:underline">Profil Desa</a></li>
          <li><a href="{{ route('show.article') }}" class="hover:underline">Berita</a></li>
          <li><a href="{{ route('show.ppid') }}" class="hover:underline">PPID</a></li>
        </ul>
      </div>
      <!-- Section 2 -->
      <div class="text-sky-950 dark:text-gray-200">
        <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
        <ul class="space-y-4">
          <li class="flex items-center space-x-2">
            {{-- <i class="fa-solid fa-phone"></i>
            <a href="#" class="hover:underline">0897656567</a> --}}
            @if ($profiles->whatsapp)
              <a href="https://wa.me/{{ $profiles->whatsapp }}" target="_blank" class="hover:underline">
                  <i class="fa-brands fa-whatsapp hover:underline mr-2"></i>Hubungi whatssapp
              </a>
            @endif
          </li>
          <li class="flex items-center space-x-2">
            @if ($profiles->instagram)
                <a href="{{ $profiles->instagram }}" target="_blank" class="hover:underline">
                    <i class="fa-brands fa-instagram hover:underline mr-2"></i>Instagram
                </a>
            @endif
          </li>
          <li class="flex items-center space-x-2">
            @if ($profiles->facebook)
                <a href="{{ $profiles->facebook }}" target="_blank" class="hover:underline">
                    <i class="fa-brands fa-facebook hover:underline mr-2"></i>Facebook
                </a>
            @endif
          </li>
        </ul>
      </div>
      <!-- Section 3 -->
      <div class="text-sky-950 dark:text-gray-200">
        <h4 class="text-lg font-semibold mb-4">Profil</h4>
        <div class="flex flex-row gap-3 justify-center items-center">
          {{-- <img src="{{  asset('storage/images/publicImg/icons/lambang_kabupaten_bangka.png') }}" class="h-25 w-20" alt="logo"> --}}
          <p class="">Website ini bertujuan untuk memudahkan akses informasi bagi warga, pengunjung, dan pihak terkait. Melalui platform ini.</p>
        </div>
        {{-- <form>
          <div class="flex flex-col space-y-4">
            <input
              type="email"
              placeholder="Email Anda"
              class="p-2 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <button
              type="submit"
              class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded"
            >
              Berlangganan
            </button>
          </div>
        </form> --}}
      </div>
    </div>
    <div class="border-t border-gray-700 py-4 text-center text-sky-950 dark:text-gray-200">
      <p class="text-sm">&copy; 2025 Desa Pemali. Hak Cipta Dilindungi.</p>
    </div>
  </div>
</footer>
