<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RatingPelayanan;
use App\Models\Surat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardSubmissionLetterController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $month = Carbon::now()->month;

        // Total pengajuan hari ini
        $totalHariIni = Surat::whereDate('created_at', $today)->count();

        // Total pengajuan bulan ini
        $totalBulanIni = Surat::whereMonth('created_at', $month)->count();

        // Statistik pengajuan per minggu (7 hari terakhir)
        $pengajuanPerHari = Surat::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Surat tersering diajukan
        $suratTersering = Surat::select('jenis_surat_id', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_surat_id')
            ->orderByDesc('total')
            ->with('jenisSurat') // pastikan relasi sudah ada
            ->limit(5)
            ->get();

        // Surat dengan rating 5 terbaik (rata-rata tertinggi)
       $ratingTertinggi = RatingPelayanan::join('surat', 'rating_pelayanan.pengajuan_surat_id', '=', 'surat.id')
            ->join('jenis_surat', 'surat.jenis_surat_id', '=', 'jenis_surat.id')
            ->select(
                'jenis_surat.id as jenis_surat_id',
                'jenis_surat.nama as nama_jenis_surat',
                DB::raw('AVG(rating_pelayanan.rating) as rata_rating')
            )
            ->groupBy('jenis_surat.id', 'jenis_surat.nama')
            ->orderByDesc('rata_rating')
            ->limit(5)
            ->get();



        // Tambahan: total surat selesai, dalam proses, rating masuk
        $totalSemua = Surat::count(); // Semua status
        $totalSelesai = Surat::where('status', 'selesai')->count();
        $totalProses = Surat::where('status', 'diproses')->count();

        $totalRating  = RatingPelayanan::count();
// dd($totalSemua);
        $data = [
            'title' => 'Beranda Operator',
            'totalHariIni' => $totalHariIni,
            'totalBulanIni' => $totalBulanIni,
            'pengajuanPerHari' => $pengajuanPerHari,
            'suratTersering' => $suratTersering,
            'ratingTertinggi' => $ratingTertinggi,
            'totalSemua' => $totalSemua,
            'totalSelesai' => $totalSelesai,
            'totalProses' => $totalProses,
            'totalRating' => $totalRating,
        ];
         
        return view('admin-submission-letter/dashboard/index', $data);
    }

}
