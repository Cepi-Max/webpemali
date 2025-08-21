<?php

namespace App\Http\Controllers;

use App\Models\DashboardImage;
use App\Models\Kependudukan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function index()
    {
        $totalPengguna = User::count();
        $totalPenduduk = Kependudukan::count();
        $totalKepalaKeluarga = Kependudukan::select('no_kk')->distinct()->count('no_kk');
        $totalAgama = Kependudukan::select('agama')->distinct()->count('agama');
        $statistikDusun = Kependudukan::select('dusun', DB::raw('count(*) as jumlah'))
            ->groupBy('dusun')
            ->get();
        $statistikPekerjaan = Kependudukan::select('pekerjaan', DB::raw('count(*) as jumlah'))
            ->groupBy('pekerjaan')
            ->get();
        $statistikJenisKelamin = Kependudukan::select('jenis_kelamin', DB::raw('count(*) as jumlah'))
            ->groupBy('jenis_kelamin')
            ->get();
        $statistikPendidikan = Kependudukan::select('pendidikan', DB::raw('count(*) as jumlah'))
            ->groupBy('pendidikan')
            ->get();

            $usiaKelompok = [
                '0-5'     => [0, 5],
                '6-12'    => [6, 12],
                '13-17'   => [13, 17],
                '18-25'   => [18, 25],
                '26-35'   => [26, 35],
                '36-45'   => [36, 45],
                '46-55'   => [46, 55],
                '56-65'   => [56, 65],
                '66-75'   => [66, 75],
                '76-85'   => [76, 85],
                '86-95'   => [86, 95],
                '>95'     => [96, 150],
            ];
        
            $statistikUsia = [];
        
            foreach ($usiaKelompok as $label => [$min, $max]) {
                $laki = Kependudukan::where('jenis_kelamin', 'Laki-laki')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?", [$min, $max])
                    ->count();
        
                $perempuan = Kependudukan::where('jenis_kelamin', 'Perempuan')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?", [$min, $max])
                    ->count();
        
                $statistikUsia[] = [
                    'usia' => $label,
                    'laki' => $laki,
                    'perempuan' => $perempuan,
                ];
            }
        
            
        $data = [
            'title' => 'Beranda Admin',
            'totalPengguna' => $totalPengguna,
            'totalPenduduk' => $totalPenduduk,
            'totalAgama' => $totalAgama,
            'totalKepalaKeluarga' => $totalKepalaKeluarga,
            'statistikUsia' => $statistikUsia,
            'statistikPekerjaan' => $statistikPekerjaan,
            'statistikDusun' => $statistikDusun,
            'statistikJenisKelamin' => $statistikJenisKelamin,
            'statistikPendidikan' => $statistikPendidikan,
        ];
        return view('admin/dashboard/index', $data);
    }

}
