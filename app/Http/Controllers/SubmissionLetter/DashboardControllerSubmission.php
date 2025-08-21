<?php

namespace App\Http\Controllers\SubmissionLetter;

use App\Http\Controllers\Controller;
use App\Models\bannerImg;
use App\Models\DashboardImageService;
use App\Models\DokumenSurat;
use App\Models\HistorySuratSelesai;
use App\Models\JenisSurat;
use App\Models\Notifikasi;
use App\Models\RatingPelayanan;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardControllerSubmission extends Controller
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
        $bannerImg = DashboardImageService::latest()->get();
        $jenisSurat = JenisSurat::all();
        $ratingPerJenis = RatingPelayanan::join('surat', 'rating_pelayanan.pengajuan_surat_id', '=', 'surat.id')
        ->join('jenis_surat', 'surat.jenis_surat_id', '=', 'jenis_surat.id')
        ->select('jenis_surat.id', DB::raw('AVG(rating) as rata_rating'))
        ->groupBy('jenis_surat.id')
        ->pluck('rata_rating', 'jenis_surat.id');

        
        $data = [
            'title' => 'Pelayanan Administrasi Desa Pemali',
            'bannerImg' => $bannerImg,
            'jenisSurat' => $jenisSurat,
            'ratingPerJenis' => $ratingPerJenis,
        ];
        
        return view('submission-letter/dashboard/index', $data);
    }

    public function result(Request $request)
    {
        $bannerImg = DashboardImageService::latest()->get();

        $query = $request->input('query');
        if ($query) {
            $jenisSurat = JenisSurat::where('nama', 'like', '%' . $query . '%')
                        ->orWhere('deskripsi', 'like', '%' . $query . '%')
                        ->get();
        } else {
            $jenisSurat = JenisSurat::all();
        }
        $ratingPerJenis = RatingPelayanan::join('surat', 'rating_pelayanan.pengajuan_surat_id', '=', 'surat.id')
        ->join('jenis_surat', 'surat.jenis_surat_id', '=', 'jenis_surat.id')
        ->select('jenis_surat.id', DB::raw('AVG(rating) as rata_rating'))
        ->groupBy('jenis_surat.id')
        ->pluck('rata_rating', 'jenis_surat.id');

        $data = [
            'title' => 'Pelayanan Administrasi Desa Pemali',
            'bannerImg' => $bannerImg,
            'jenisSurat' => $jenisSurat,
            'ratingPerJenis' => $ratingPerJenis,
        ];
        
        return view('submission-letter/dashboard/result', $data);
    }

    public function mySubmissionPage(Request $request)
    {
        $userId = Auth::id();

        $allUserSubmissions = Surat::where('pemohon_id', $userId)
            ->whereNotIn('status', ['selesai'])
            ->get();

        // Untuk count masing-masing status
        $countAll = $allUserSubmissions->count();
        $countPending = (clone $allUserSubmissions)->where('status', 'pending')->count();
        $countDiproses = (clone $allUserSubmissions)->where('status', 'diproses')->count();
        $countRejected = (clone $allUserSubmissions)->where('status', 'ditolak')->count();

        // Query utama sesuai filter
        $query = Surat::with('jenisSurat')->where('pemohon_id', $userId);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('jenisSurat', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $submission = $query->whereNotIn('status', ['selesai'])->latest()->paginate(10);

        return view('submission-letter.mysubmission.index', [
            'title' => 'Pengajuan Saya',
            'submission' => $submission,
            'countAll' => $countAll,
            'countPending' => $countPending,
            'countDiproses' => $countDiproses,
            'countRejected' => $countRejected,
        ]);
    }

    public function myDetailSubmission(Request $request, $id)
    {
        $userId = Auth::id();
        // Query utama sesuai filter
        $detailSubmission = Surat::with('jenisSurat', 'dokumenSurat.syarat')
                                ->where('id', $id)
                                ->where('pemohon_id', $userId)
                                ->firstOrFail();

        return view('submission-letter.mysubmission.detail', [
            'title' => 'Pengajuan Saya',
            'ds' => $detailSubmission,
        ]);
    }

    public function submissionHistory(Request $request)
    {
        $userId = Auth::id();

        // Ambil semua history selesai yang terkait surat user ini
        $query = HistorySuratSelesai::with(['pengajuan.jenisSurat'])
            ->whereHas('pengajuan', function ($q) use ($userId) {
                $q->where('pemohon_id', $userId)->where('status', 'selesai');
            });

        // Filter jenis surat berdasarkan nama
        if ($request->filled('search')) {
            $query->whereHas('pengajuan.jenisSurat', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan tanggal pengajuan (dari tabel surat)
        if ($request->filled('tanggal')) {
            $query->whereHas('pengajuan', function ($q) use ($request) {
                $q->whereDate('created_at', $request->tanggal);
            });
        }

        // Ambil data hasil akhir
        $histories = $query->latest()->paginate(10);
// dd($histories);
        return view('submission-letter.submission-history.index', [
            'title' => 'Riwayat Pengajuan',
            'histories' => $histories,
        ]);
    }

    public function downloadSuratSelesai($filename)
    {
        $filePath = 'dokumen_surat/surat-selesai/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath);
    }
}
