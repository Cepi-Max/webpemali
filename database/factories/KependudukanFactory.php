<?php

namespace Database\Factories;

use App\Models\Kependudukan;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class KependudukanFactory extends Factory
{
    protected $model = Kependudukan::class;

     // Fungsi untuk menghitung usia
     public function hitungUsia($tanggalLahir) {
        $tanggalSekarang = new DateTime();

        // Ambil tahun, bulan, dan hari dari tanggal lahir dan tanggal sekarang
        $tahunLahir = $tanggalLahir->format('Y');
        $bulanLahir = $tanggalLahir->format('m');
        $hariLahir = $tanggalLahir->format('d');
    
        $tahunSekarang = $tanggalSekarang->format('Y');
        $bulanSekarang = $tanggalSekarang->format('m');
        $hariSekarang = $tanggalSekarang->format('d');
    
        // Hitung usia berdasarkan tahun
        $usia = $tahunSekarang - $tahunLahir;
    
        // Jika bulan sekarang lebih kecil dari bulan lahir, berarti belum ulang tahun tahun ini
        // Atau jika bulan sekarang sama dengan bulan lahir, tetapi hari sekarang lebih kecil dari hari lahir
        if ($bulanSekarang < $bulanLahir || ($bulanSekarang == $bulanLahir && $hariSekarang < $hariLahir)) {
            $usia--; // Kurangi 1 tahun
        }
    
        return $usia;
    }

    public function definition(): array
    {
        $dusunList = [
            'Dusun Air Ruai',
            'Dusun Air Pengabis',
            'Dusun Sigambir',
            'Dusun Air Bakung',
            'Dusun Air Raya',
        ];

        $pekerjaanList = [
            'Petani',
            'Nelayan',
            'Guru',
            'Pedagang',
            'PNS',
            'Karyawan Swasta',
            'Buruh Harian',
            'Ibu Rumah Tangga',
            'Pelajar/Mahasiswa',
            'Tidak Bekerja',
        ];

        $pendidikanList = [
            'Tidak Sekolah',
            'PAUD',
            'TK',
            'SD',
            'SMP',
            'SMA',
            'D1',
            'D3',
            'S1',
            'S2',
            'S3'
        ];

        // Menghasilkan tanggal lahir menggunakan Faker
        $tanggalLahir = $this->faker->dateTimeBetween('-70 years', '-18 years');

        // Hitung usia berdasarkan tanggal lahir
        $usia = $this->hitungUsia($tanggalLahir);

        return [
            'rt' => str_pad($this->faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
            'dusun' => $this->faker->randomElement($dusunList),
            'alamat' => $this->faker->streetAddress,
            'no_kk' => $this->faker->numerify('###########'),
            'kepala_keluarga' => $this->faker->name,

            'nik' => $this->faker->unique()->numerify('3201############'),
            'nama_lengkap' => $this->faker->name,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'posisi_dalam_keluarga' => $this->faker->randomElement([
                'Suami', 'Istri', 'Anak', 'Menantu', 'Cucu', 
                'Orangtua', 'Mertua', 'Famili Lain', 'Pembantu', 'Lainnya'
            ]),

            'tempat_lahir' => $this->faker->randomElement([
                'Jakarta', 'Bandung', 'Surabaya', 'Palembang', 'Pontianak', 
                'Medan', 'Yogyakarta', 'Semarang', 'Padang', 'Makassar'
            ]),
            'tanggal_lahir' => $tanggalLahir,
            'usia' => $usia,

            'status_pernikahan' => $this->faker->randomElement([
                'Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati', 'Janda/Duda'
            ]),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'golongan_darah' => $this->faker->optional(0.1)->randomElement(['A', 'B', 'AB', 'O']), // 10% null
            'pendidikan' => $this->faker->randomElement($pendidikanList),
            'pekerjaan' => $this->faker->randomElement($pekerjaanList),
        ];
    }
}
