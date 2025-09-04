<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Surat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function tampilLaporanPengguna()
    {
        $users = User::withCount('pengajuan')->get();
        $data = [
            'title' => 'Laporan Pengguna',
            'users' => $users
        ];
        return view('admin-submission-letter.laporan.pengguna.tampil_pengguna', $data);
    }

    public function downloadPengguna()
    {
        $users = User::withCount('pengajuan')->get();
        $pdf = Pdf::loadView('admin-submission-letter.laporan.pengguna.pdf_pengguna', compact('users'))->setPaper('A4', 'landscape');
        return $pdf->download('laporan_pengguna.pdf');
    }

    public function printPengguna()
    {
        $users = User::withCount('pengajuan')->get();
        return view('admin-submission-letter.laporan.pengguna.pdf_pengguna', compact('users'));
    }

    public function tampilLaporanPengajuan()
    {
        $pengajuan = Surat::with(['pemohon', 'jenisSurat'])->latest()->get();
        $data = [
            'title' => 'Laporan Pengajuan',
            'pengajuan' => $pengajuan
        ];
        return view('admin-submission-letter.laporan.pengajuan.tampil_pengajuan', $data);
    }

    public function downloadPengajuan()
    {
        $pengajuan = Surat::with(['pemohon', 'jenisSurat'])->latest()->get();
        $pdf = PDF::loadView('admin-submission-letter.laporan.pengajuan.pdf_pengajuan', compact('pengajuan'))->setPaper('A4', 'landscape');
        return $pdf->download('laporan_pengajuan.pdf');
    }
    
    public function printPengajuan()
    {
        $pengajuan = Surat::with(['pemohon', 'jenisSurat'])->latest()->get();
        return view('admin-submission-letter.laporan.pengajuan.pdf_pengajuan', compact('pengajuan'));
    }

    public function tampilLaporanRekapBulanan()
    {
        $data = collect();

        // Loop tiap bulan (1 - 12)
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Ambil data pengajuan di bulan ini
            $pengajuan = Surat::whereMonth('created_at', $bulan)->get();

            $jumlah_pengajuan = $pengajuan->count();
            $jumlah_pending = $pengajuan->where('status', 'pending')->count();
            $jumlah_diproses = $pengajuan->where('status', 'diproses')->count();
            $jumlah_selesai = $pengajuan->where('status', 'selesai')->count();
            $jumlah_ditolak = $pengajuan->where('status', 'ditolak')->count();

            // Hitung jenis surat terpopuler di bulan itu
            $terpopuler = $pengajuan->groupBy('jenis_surat_id')
                ->map(fn($items) => $items->count())
                ->sortDesc()
                ->take(1);

            $surat_terpopuler = '-';

            if ($terpopuler->count()) {
                $jenis_id = $terpopuler->keys()->first();
                $jumlah = $terpopuler->first();
                $jenis = \App\Models\JenisSurat::find($jenis_id);

                if ($jenis) {
                    $surat_terpopuler = $jenis->nama . " ($jumlah)";
                }
            }

            // Simpan ke koleksi data
            $data->push((object)[
                'bulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
                'total_pengajuan' => $jumlah_pengajuan,
                'pending' => $jumlah_pending,
                'diproses' => $jumlah_diproses,
                'selesai' => $jumlah_selesai,
                'ditolak' => $jumlah_ditolak,
                'surat_terpopuler' => $surat_terpopuler,
            ]);
        }

        return view('admin-submission-letter.laporan.rekap-bulanan.tampil_rekap_bulanan', [
            'title' => 'Laporan Pengajuan Bulanan',
            'data' => $data,
        ]);
    }

    private function generateRekapBulanan()
    {
        $data = collect();

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $pengajuan = Surat::whereMonth('created_at', $bulan)->get();

            $jumlah_pengajuan = $pengajuan->count();
            $jumlah_pending = $pengajuan->where('status', 'pending')->count();
            $jumlah_diproses = $pengajuan->where('status', 'diproses')->count();
            $jumlah_selesai = $pengajuan->where('status', 'selesai')->count();
            $jumlah_ditolak = $pengajuan->where('status', 'ditolak')->count();

            $terpopuler = $pengajuan->groupBy('jenis_surat_id')
                ->map(fn($items) => $items->count())
                ->sortDesc()
                ->take(1);

            $surat_terpopuler = '-';

            if ($terpopuler->count()) {
                $jenis_id = $terpopuler->keys()->first();
                $jumlah = $terpopuler->first();
                $jenis = \App\Models\JenisSurat::find($jenis_id);

                if ($jenis) {
                    $surat_terpopuler = $jenis->nama . " ($jumlah)";
                }
            }

            $data->push((object)[
                'bulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
                'total_pengajuan' => $jumlah_pengajuan,
                'pending' => $jumlah_pending,
                'diproses' => $jumlah_diproses,
                'selesai' => $jumlah_selesai,
                'ditolak' => $jumlah_ditolak,
                'surat_terpopuler' => $surat_terpopuler,
            ]);
        }

        return $data;
    }

    public function downloadRekap()
    {
        $data = $this->generateRekapBulanan(); 
        $pdf = PDF::loadView('admin-submission-letter.laporan.rekap-bulanan.pdf_rekap_bulanan', compact('data'));
        return $pdf->download('rekap_pengajuan_bulanan.pdf');
    }

    public function printRekap()
    {
        $data = $this->generateRekapBulanan(); 
        return view('admin-submission-letter.laporan.rekap-bulanan.pdf_rekap_bulanan', compact('data'));
    }
    
}


