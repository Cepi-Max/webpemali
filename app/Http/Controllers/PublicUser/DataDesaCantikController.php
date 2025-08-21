<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\DataAgama;
use App\Models\DataDusun;
use App\Models\DataEkonomi;
use App\Models\DataJenisCacat;
use App\Models\DataKewarganegaraan;
use App\Models\DataPekerjaan;
use App\Models\DataPendidikan;
use App\Models\DataTenagaKerja;
use App\Models\DataUsia;
use App\Models\Infografis;
use App\Models\Kewilayahan2;
use App\Models\KewilayahanDesaCantik;
use App\Models\KewilayahanKategori;
use App\Models\PublikasiDesaCantik;
use App\Models\StatistikPenduduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataDesaCantikController extends Controller
{
    //
    public function statistik(Request $request)
    {
        // Ambil tahun dari request, default tahun sekarang
        $tahunSekarang = Carbon::now()->year;
        $tahunValid = range($tahunSekarang - 3, $tahunSekarang);
        $tahunTerpilih = $request->input('tahun', $tahunSekarang); // default tahun sekarang

        // Validasi: Pastikan tahunTerpilih hanya 5 tahun terakhir
        $tahunValid = range($tahunSekarang - 3, $tahunSekarang);
        if (!in_array($tahunTerpilih, $tahunValid)) {
            $tahunTerpilih = $tahunSekarang;
        } 

        $statistikPenduduk = StatistikPenduduk::where('periode', $tahunTerpilih)->get();
        $dataDusun = DataDusun::where('periode', $tahunTerpilih)->get();
        $dataAgama = DataAgama::where('periode', $tahunTerpilih)->get();
        $dataKewarganegaraan = DataKewarganegaraan::where('periode', $tahunTerpilih)->get();
        $dataJenisCacat = DataJenisCacat::where('periode', $tahunTerpilih)->get();
        $dataTenagaKerja = DataTenagaKerja::where('periode', $tahunTerpilih)->get();
        $dataEkonomi = DataEkonomi::where('periode', $tahunTerpilih)->get();
        $dataUsia = DataUsia::where('periode', $tahunTerpilih)->get();
        $dataPendidikan = DataPendidikan::where('periode', $tahunTerpilih)->get();
        $dataPekerjaan = DataPekerjaan::where('periode', $tahunTerpilih)->get();
        
        return view('public-user.desa-cantik.statistik-kependudukan', [
            'title' => 'Statistik Desa',
            'statpenduduk' => $statistikPenduduk,
            'tahunTerpilih' => $tahunTerpilih,
            'tahunValid' => $tahunValid,
            'dataDusun' => $dataDusun,
            'dataAgama' => $dataAgama,
            'dataKewarganegaraan' => $dataKewarganegaraan,
            'dataJenisCacat' => $dataJenisCacat,
            'dataTenagaKerja' => $dataTenagaKerja,
            'dataEkonomi' => $dataEkonomi,
            'dataUsia' => $dataUsia,
            'dataPendidikan' => $dataPendidikan,
            'dataPekerjaan' => $dataPekerjaan,
        ]);
    }

    // public function statistik(Request $request)
    // {
    //     // ========================
    //     // 1. Tentukan tahun filter
    //     // ========================
    //     $tahunSekarang = date('Y');
    //     $tahunTerpilih = $request->input('tahun', $tahunSekarang); // default tahun sekarang

    //     // Validasi: Pastikan tahunTerpilih hanya 5 tahun terakhir
    //     $tahunValid = range($tahunSekarang - 5, $tahunSekarang);
    //     if (!in_array($tahunTerpilih, $tahunValid)) {
    //         $tahunTerpilih = $tahunSekarang;
    //     }

    //     // Base query dengan filter tahun
    //     $baseQuery = DB::table('kependudukan')
    //         ->whereYear('created_at', $tahunTerpilih);

    //     // ===========================
    //     // 2. Statistik Global
    //     // ===========================

    //     // Statistik jenis kelamin
    //     $statistikJenisKelamin = (clone $baseQuery)
    //         ->select('jenis_kelamin', DB::raw('count(*) as total'))
    //         ->groupBy('jenis_kelamin')
    //         ->get();

    //     // Statistik status pernikahan
    //     $statistikPernikahan = (clone $baseQuery)
    //         ->select('status_pernikahan')
    //         ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki")
    //         ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan")
    //         ->selectRaw("COUNT(*) as total")
    //         ->groupBy('status_pernikahan')
    //         ->get();

    //     // Statistik agama
    //     $statistikAgama = (clone $baseQuery)
    //         ->select('agama')
    //         ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki")
    //         ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan")
    //         ->selectRaw("COUNT(*) as total")
    //         ->groupBy('agama')
    //         ->orderByDesc('total')
    //         ->get();

    //     // Statistik usia
    //     $statistikUsia = (clone $baseQuery)
    //         ->select(
    //             DB::raw("CASE 
    //                 WHEN usia BETWEEN 0 AND 5 THEN '0-5'
    //                 WHEN usia BETWEEN 6 AND 10 THEN '6-10'
    //                 WHEN usia BETWEEN 11 AND 15 THEN '11-15'
    //                 WHEN usia BETWEEN 16 AND 20 THEN '16-20'
    //                 WHEN usia BETWEEN 21 AND 30 THEN '21-30'
    //                 WHEN usia BETWEEN 31 AND 40 THEN '31-40'
    //                 WHEN usia BETWEEN 41 AND 50 THEN '41-50'
    //                 WHEN usia BETWEEN 51 AND 60 THEN '51-60'
    //                 WHEN usia BETWEEN 61 AND 70 THEN '61-70'
    //                 WHEN usia BETWEEN 71 AND 80 THEN '71-80'
    //                 ELSE '80+' END as rentang_usia"),
    //             DB::raw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki"),
    //             DB::raw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan"),
    //             DB::raw('COUNT(*) as total')
    //         )
    //         ->groupBy('rentang_usia')
    //         ->get()
    //         ->keyBy('rentang_usia');

    //     // Statistik pendidikan
    //     $statistikPendidikan = (clone $baseQuery)
    //         ->select(
    //             'pendidikan',
    //             DB::raw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki"),
    //             DB::raw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan"),
    //             DB::raw("COUNT(*) as total")
    //         )
    //         ->groupBy('pendidikan')
    //         ->orderBy('total', 'desc')
    //         ->get();

    //     // Statistik pekerjaan
    //     $statistikPekerjaan = (clone $baseQuery)
    //         ->select(
    //             'pekerjaan',
    //             DB::raw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki"),
    //             DB::raw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan"),
    //             DB::raw("COUNT(*) as total")
    //         )
    //         ->groupBy('pekerjaan')
    //         ->orderBy('total', 'desc')
    //         ->get();

    //     // ===========================
    //     // 3. Statistik per Dusun & RT
    //     // ===========================

    //     $dataDusunRt = (clone $baseQuery)
    //         ->select('dusun', 'rt')
    //         ->selectRaw('COUNT(DISTINCT no_kk) as total_kk')
    //         ->selectRaw('COUNT(*) as total_jiwa')
    //         ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki")
    //         ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan")
    //         ->groupBy('dusun', 'rt')
    //         ->orderBy('dusun')
    //         ->orderBy('rt')
    //         ->get();

    //     $rekap = [];
    //     foreach ($dataDusunRt as $row) {
    //         $key = $row->dusun;

    //         if (!isset($rekap[$key])) {
    //             $rekap[$key] = [
    //                 'no' => count($rekap) + 1,
    //                 'dusun' => $row->dusun,
    //                 'ketua' => '-', // Bisa diisi data ketua nanti
    //                 'total_kk' => 0,
    //                 'total_jiwa' => 0,
    //                 'laki' => 0,
    //                 'perempuan' => 0,
    //                 'rts' => []
    //             ];
    //         }

    //         $rekap[$key]['total_kk'] += $row->total_kk;
    //         $rekap[$key]['total_jiwa'] += $row->total_jiwa;
    //         $rekap[$key]['laki'] += $row->total_laki;
    //         $rekap[$key]['perempuan'] += $row->total_perempuan;

    //         $laki_persen = $row->total_jiwa ? round($row->total_laki / $row->total_jiwa * 100, 2) : 0;
    //         $perempuan_persen = $row->total_jiwa ? round($row->total_perempuan / $row->total_jiwa * 100, 2) : 0;

    //         $rekap[$key]['rts'][] = [
    //             'rt' => $row->rt,
    //             'kk' => $row->total_kk,
    //             'jiwa' => $row->total_jiwa,
    //             'laki' => $row->total_laki,
    //             'laki_persen' => $laki_persen,
    //             'perempuan' => $row->total_perempuan,
    //             'perempuan_persen' => $perempuan_persen,
    //         ];
    //     }

    //     foreach ($rekap as &$dusun) {
    //         $total_jiwa = $dusun['total_jiwa'];
    //         $dusun['laki_persen'] = $total_jiwa ? round($dusun['laki'] / $total_jiwa * 100, 2) : 0;
    //         $dusun['perempuan_persen'] = $total_jiwa ? round($dusun['perempuan'] / $total_jiwa * 100, 2) : 0;

    //         // Urutkan RT dari kecil ke besar
    //         usort($dusun['rts'], function ($a, $b) {
    //             return intval($a['rt']) <=> intval($b['rt']);
    //         });
    //     }

    //     // ===========================
    //     // 4. Kirim ke View
    //     // ===========================
    //     return view('public-user.desa-cantik.statistik-kependudukan', [
    //         'title' => 'Statistik Kependudukan',
    //         'tahunTerpilih' => $tahunTerpilih,
    //         'tahunValid' => $tahunValid, // buat dropdown filter
    //         'statistikJenisKelamin' => $statistikJenisKelamin,
    //         'statistikPernikahan' => $statistikPernikahan,
    //         'statistikAgama' => $statistikAgama,
    //         'statistikUsia' => $statistikUsia,
    //         'statistikPendidikan' => $statistikPendidikan,
    //         'statistikPekerjaan' => $statistikPekerjaan,
    //         'rekap' => $rekap
    //     ]);
    // }

    public function detailStatistik(Request $request)
    {
        // ========================
        // 1. Tentukan tahun filter
        // ========================
        $tahunSekarang = date('Y');
        $tahunTerpilih = $request->input('tahun', $tahunSekarang); // default tahun sekarang

        // Validasi: Pastikan tahunTerpilih hanya 5 tahun terakhir
        $tahunValid = range($tahunSekarang - 5, $tahunSekarang);
        if (!in_array($tahunTerpilih, $tahunValid)) {
            $tahunTerpilih = $tahunSekarang;
        }

        // ========================
        // 2. Base Query dengan filter tahun
        // ========================
        $baseQuery = DB::table('kependudukan')
            ->whereYear('created_at', $tahunTerpilih);

        // Total penduduk & kepala keluarga
        $totalPenduduk = (clone $baseQuery)->count();
        $totalKepalaKeluarga = (clone $baseQuery)->select('no_kk')->distinct()->count('no_kk');

        // Statistik jenis kelamin
        $statistikJenisKelamin = (clone $baseQuery)
            ->selectRaw("
                SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki,
                SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan,
                COUNT(*) as total,
                ROUND(SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) as persentase_laki,
                ROUND(SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) as persentase_perempuan
            ")
            ->first();

        // Statistik pernikahan
        $statistikPernikahan = (clone $baseQuery)
            ->select('status_pernikahan')
            ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki")
            ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan")
            ->selectRaw("COUNT(*) as total")
            ->groupBy('status_pernikahan')
            ->get();

        // Statistik agama
        $statistikAgama = (clone $baseQuery)
            ->select('agama')
            ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki")
            ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan")
            ->selectRaw("COUNT(*) as total")
            ->groupBy('agama')
            ->orderByDesc('total')
            ->get();

        // Statistik usia
        $statistikUsia = (clone $baseQuery)
            ->select(
                DB::raw("CASE 
                    WHEN usia BETWEEN 0 AND 5 THEN '0-5'
                    WHEN usia BETWEEN 6 AND 10 THEN '6-10'
                    WHEN usia BETWEEN 11 AND 15 THEN '11-15'
                    WHEN usia BETWEEN 16 AND 20 THEN '16-20'
                    WHEN usia BETWEEN 21 AND 30 THEN '21-30'
                    WHEN usia BETWEEN 31 AND 40 THEN '31-40'
                    WHEN usia BETWEEN 41 AND 50 THEN '41-50'
                    WHEN usia BETWEEN 51 AND 60 THEN '51-60'
                    WHEN usia BETWEEN 61 AND 70 THEN '61-70'
                    WHEN usia BETWEEN 71 AND 80 THEN '71-80'
                    ELSE '80+' END as rentang_usia"),
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki"),
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('rentang_usia')
            ->get()
            ->keyBy('rentang_usia');

        // Statistik pendidikan
        $statistikPendidikan = (clone $baseQuery)
            ->select(
                'pendidikan',
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki"),
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('pendidikan')
            ->orderBy('total', 'desc')
            ->get();

        // Statistik pekerjaan
        $statistikPekerjaan = (clone $baseQuery)
            ->select(
                'pekerjaan',
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki"),
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('pekerjaan')
            ->orderBy('total', 'desc')
            ->get();

        // Statistik per dusun & RT
        $dataDusunRt = (clone $baseQuery)
            ->select('dusun', 'rt')
            ->selectRaw('COUNT(DISTINCT no_kk) as total_kk')
            ->selectRaw('COUNT(*) as total_jiwa')
            ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki")
            ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan")
            ->groupBy('dusun', 'rt')
            ->orderBy('dusun')
            ->orderBy('rt')
            ->get();

        // Olah data dusun & RT
        $rekap = [];
        foreach ($dataDusunRt as $row) {
            $key = $row->dusun;

            if (!isset($rekap[$key])) {
                $rekap[$key] = [
                    'no' => count($rekap) + 1,
                    'dusun' => $row->dusun,
                    'ketua' => '-',
                    'total_kk' => 0,
                    'total_jiwa' => 0,
                    'laki' => 0,
                    'perempuan' => 0,
                    'rts' => []
                ];
            }

            $rekap[$key]['total_kk'] += $row->total_kk;
            $rekap[$key]['total_jiwa'] += $row->total_jiwa;
            $rekap[$key]['laki'] += $row->total_laki;
            $rekap[$key]['perempuan'] += $row->total_perempuan;

            $laki_persen = $row->total_jiwa ? round($row->total_laki / $row->total_jiwa * 100, 2) : 0;
            $perempuan_persen = $row->total_jiwa ? round($row->total_perempuan / $row->total_jiwa * 100, 2) : 0;

            $rekap[$key]['rts'][] = [
                'rt' => $row->rt,
                'kk' => $row->total_kk,
                'jiwa' => $row->total_jiwa,
                'laki' => $row->total_laki,
                'laki_persen' => $laki_persen,
                'perempuan' => $row->total_perempuan,
                'perempuan_persen' => $perempuan_persen,
            ];
        }

        foreach ($rekap as &$dusun) {
            $total_jiwa = $dusun['total_jiwa'];
            $dusun['laki_persen'] = $total_jiwa ? round($dusun['laki'] / $total_jiwa * 100, 2) : 0;
            $dusun['perempuan_persen'] = $total_jiwa ? round($dusun['perempuan'] / $total_jiwa * 100, 2) : 0;

            usort($dusun['rts'], function ($a, $b) {
                return intval($a['rt']) <=> intval($b['rt']);
            });
        }

        // Kirim ke view
        return view('public-user.desa-cantik.detail-statistik', [
            'title' => 'Statistik Kependudukan',
            'tahunTerpilih' => $tahunTerpilih,
            'tahunValid' => $tahunValid,
            'totalPenduduk' => $totalPenduduk,
            'totalKepalaKeluarga' => $totalKepalaKeluarga,
            'statistikJenisKelamin' => $statistikJenisKelamin,
            'statistikPernikahan' => $statistikPernikahan,
            'statistikAgama' => $statistikAgama,
            'statistikUsia' => $statistikUsia,
            'statistikPendidikan' => $statistikPendidikan,
            'statistikPekerjaan' => $statistikPekerjaan,
            'rekap' => $rekap
        ]);
    }

    // public function rekapPenduduk()
    // {
    //     $data = Kependudukan::select('dusun', 'rt')
    //         ->selectRaw('COUNT(DISTINCT no_kk) as total_kk')
    //         ->selectRaw('COUNT(*) as total_jiwa')
    //         ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as total_laki")
    //         ->selectRaw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as total_perempuan")
    //         ->groupBy('dusun', 'rt')
    //         ->orderBy('dusun')
    //         ->orderBy('rt')
    //         ->get();

    //     // Kelompokkan berdasarkan dusun
    //     $rekap = [];
    //     foreach ($data as $row) {
    //         $key = $row->dusun;

    //         if (!isset($rekap[$key])) {
    //             $rekap[$key] = [
    //                 'no' => count($rekap) + 1,
    //                 'dusun' => $row->dusun,
    //                 'ketua' => '-', // Bisa diganti kalau ada tabel ketua dusun
    //                 'total_kk' => 0,
    //                 'total_jiwa' => 0,
    //                 'laki' => 0,
    //                 'perempuan' => 0,
    //                 'rts' => []
    //             ];
    //         }

    //         // Hitung total dusun
    //         $rekap[$key]['total_kk'] += $row->total_kk;
    //         $rekap[$key]['total_jiwa'] += $row->total_jiwa;
    //         $rekap[$key]['laki'] += $row->total_laki;
    //         $rekap[$key]['perempuan'] += $row->total_perempuan;

    //         // Hitung persen RT
    //         $laki_persen = $row->total_jiwa ? round($row->total_laki / $row->total_jiwa * 100, 2) : 0;
    //         $perempuan_persen = $row->total_jiwa ? round($row->total_perempuan / $row->total_jiwa * 100, 2) : 0;

    //         $rekap[$key]['rts'][] = [
    //             'rt' => $row->rt,
    //             'kk' => $row->total_kk,
    //             'jiwa' => $row->total_jiwa,
    //             'laki' => $row->total_laki,
    //             'laki_persen' => $laki_persen,
    //             'perempuan' => $row->total_perempuan,
    //             'perempuan_persen' => $perempuan_persen,
    //         ];
    //     }

    //     // Hitung persentase laki-perempuan di tingkat dusun
    //     foreach ($rekap as &$dusun) {
    //         $total_jiwa = $dusun['total_jiwa'];
    //         $dusun['laki_persen'] = $total_jiwa ? round($dusun['laki'] / $total_jiwa * 100, 2) : 0;
    //         $dusun['perempuan_persen'] = $total_jiwa ? round($dusun['perempuan'] / $total_jiwa * 100, 2) : 0;
    //     }

    //     return view('statistik.rekap', ['rekap' => $rekap]);
    // }

    public function publikasi()
    {
        $publikasi = PublikasiDesaCantik::latest()->paginate(6)->withQueryString();

        $data = [
            'title' => 'Publikasi Desa Cantik',
            'publikasi' => $publikasi
        ];

        return view('public-user.desa-cantik.publikasi-desa-cantik', $data);
    }

    public function infografis()
    {
        $infografis = Infografis::latest()->paginate(12)->withQueryString();

        $data = [
            'title' => 'Infografis Desa Cantik',
            'infografis' => $infografis,
        ];

        return view('public-user.desa-cantik.infografis-desa-cantik', $data);
    }

    public function kewilayahan(Request $request)
    {
        $kategoriList = KewilayahanKategori::all();

        // Filter berdasarkan kategori dan search
        $kewilayahan = KewilayahanDesaCantik::with('kewilayahan_kategori')
            ->filter($request->only(['search', 'kategori']))
            ->get();

        $kewilayahan2 = Kewilayahan2::get();
        // dd($kewilayahan2);
        
        $data = [
            'title' => 'Kewilayahan Desa Pemali',
            'kewilayahan' => $kewilayahan,
            'kategoriList' => $kategoriList,
            'kewilayahan2' => $kewilayahan2,
        ];

        return view('public-user.desa-cantik.kewilayahan', $data);
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('search', '');

        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $suggestions = KewilayahanDesaCantik::where('nama_fasilitas', 'like', "%{$search}%")
            ->orderBy('nama_fasilitas')
            ->limit(10)
            ->pluck('nama_fasilitas');

        return response()->json($suggestions);
    }
}
