@foreach ($villageProfile as $vp)
<div class="w-full mx-auto lg:px-10 lg:py-4 mt-6 mb-6 shadow-lg bg-white dark:bg-gray-900 rounded-lg p-6">
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-map-location-dot text-sky-950 dark:text-gray-300 text-2xl"></i>
        <h1 class="text-2xl font-bold text-sky-950 dark:text-gray-300">Peta & Batas Desa</h1>
    </div>
    <div class="flex flex-col md:flex-row border-2 border-sky-950 dark:border-gray-700 rounded-lg overflow-hidden">
        <!-- Tabel Batas Desa -->
        <div class="flex flex-col justify-between p-4 w-full md:w-1/2 bg-gray-50 dark:bg-gray-900">
            <p class="text-xl text-center font-bold border-b-4 border-sky-950 pb-2 dark:text-gray-300">Batas Desa Pemali</p>
            <table class="w-full text-lg border border-gray-400 mt-4">
                <thead>
                    <tr class="bg-sky-100 dark:bg-gray-700 dark:text-gray-300">
                        <th class="border border-gray-700 dark:border-gray-700 py-2">Batas</th>
                        <th class="border border-gray-700 dark:border-gray-700 py-2">Nama Desa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center dark:text-gray-300">
                        <td class="border border-gray-700 py-2">Timur</td>
                        <td class="border border-gray-700 py-2">{{ $vp->batas_timur }}</td>
                    </tr>
                    <tr class="text-center bg-gray-100 dark:bg-gray-900 dark:text-gray-300">
                        <td class="border border-gray-700 py-2">Barat</td>
                        <td class="border border-gray-700 py-2">{{ $vp->batas_barat }}</td>
                    </tr>
                    <tr class="text-center dark:text-gray-300">
                        <td class="border border-gray-700 py-2">Selatan</td>
                        <td class="border border-gray-700 py-2">{{ $vp->batas_selatan }}</td>
                    </tr>
                    <tr class="text-center bg-gray-100 dark:bg-gray-900 dark:text-gray-300">
                        <td class="border border-gray-700 py-2">Utara</td>
                        <td class="border border-gray-700 py-2">{{ $vp->batas_utara }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4 text-center dark:text-gray-300">
                <p class="font-bold">Luas Desa: {{ $vp->luas_desa }} Km</p>
                <p class="font-bold border-b-4 border-sky-950 dark:border-gray-700 inline-block pb-1">Jumlah Penduduk: Belum diketahui</p>
            </div>
        </div>
        <!-- Peta Google Maps -->
        <div class="w-full md:w-1/2 h-64 md:h-auto">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63802.7318304458!2d105.98851564682704!3d-1.8799890642987473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e22f1a59b977d23%3A0x6a8f1d7bbd1e8bc9!2sPemali%2C%20Kec.%20Pemali%2C%20Kabupaten%20Bangka%2C%20Kepulauan%20Bangka%20Belitung!5e0!3m2!1sid!2sid!4v1740573248238!5m2!1sid!2sid" 
                width="100%" height="100%" 
                class="border-4 border-gray-400 rounded-lg" 
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>

@endforeach