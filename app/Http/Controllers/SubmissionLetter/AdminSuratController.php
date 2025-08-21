<?php

namespace App\Http\Controllers\SubmissionLetter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSuratStatusRequest;
use App\Models\BerkasPengajuan;
use App\Models\DokumenSurat;
use App\Models\HistorySuratSelesai;
use App\Models\Notifikasi;
use App\Models\Surat;
use App\Notifications\SuratDiterima;
use App\Notifications\SuratDitolak;
use App\Notifications\SuratSelesai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminSuratController extends Controller
{
    public function index()
    {
        $surats = Surat::with('jenisSurat', 'pemohon')->latest()->paginate(10);
        $data = [
            'title' => 'Daftar Antrian Pengajuan Pelayanan',
            'surats' => $surats,
        ];

        return view('admin-submission-letter.submission-queue.index', $data);
    }

    public function show($id)
    {
        $surat = Surat::with('jenisSurat', 'dokumenSurat.syarat', 'pemohon')->findOrFail($id);
        $data = [
            'title' => 'Detail Pengajuan Pelayanan',
            'surat' => $surat,
        ];

        $notifikasi = Notifikasi::where('pengajuan_surat_id', $id)->first();
        // Tandai notifikasi sebagai sudah dibaca operator jika belum
        if ($notifikasi) {
            $notifikasi->update([
                'dibaca' => true,
                'updated_at' => now(),
            ]);
        }

        return view('admin-submission-letter.submission-queue.show', $data);
    }

    public function showPrivateFile($filename)
    {
        $path = storage_path('app/private/dokumen_surat/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file($path);
    }

    public function updateStatus(UpdateSuratStatusRequest $request, $id)
    {
         // Update per file berkas
        foreach ($request->validasi as $dokumenSuratId => $data) {
            $dokumenSurat = DokumenSurat::find($dokumenSuratId);
            if ($dokumenSurat) {
                $dokumenSurat->status_validasi = 'valid';
                $dokumenSurat->catatan = $data['catatan'] ?? null;
                $dokumenSurat->save();
            }
        }

        $surat = Surat::findOrFail($id);

        $syaratWajib = $surat->jenisSurat->syaratDokumen
        ->filter(fn($s) => $s->pivot->wajib)
        ->pluck('id')
        ->toArray();

        $DokumenWajibInvalid = $surat->dokumenSurat()
        ->whereIn('syarat_dokumen_id', $syaratWajib)
        ->where(function ($query) {
            $query->where('status_validasi', '!=', 'valid')
                ->orWhereNull('status_validasi');
        })
        ->exists();

        if ($request->status === 'disetujui' && $DokumenWajibInvalid) {
            return back()->with('error', 'Tidak bisa menyetujui surat karena ada berkas wajib yang belum divalidasi atau tidak valid.');
        }
        
        $status = $request->status === 'disetujui' ? 'diproses' : 'ditolak';
        $surat->status = $status;
        $surat->pesan = $request->pesan ?? null;
        $surat->save();

        $pemohon = $surat->pemohon; 
        if ($request->status === 'disetujui') {
            if ($pemohon) {
                $pemohon->notify(new SuratDiterima($surat));
            }
        } else {
            // kirim notif bahwa pengajuan ditolak
            if ($pemohon) {
                $pemohon->notify(new SuratDitolak($surat));
            }
        }

        return redirect()->route('admin.surat.index')->with('success', 'Status pelayanan diperbarui.');
    }

    public function kirimSurat(Request $request, $id)
    {
        $request->validate([
            'file_surat_jadi' => 'required|mimes:pdf|max:10240',
        ], [
            'file_surat_jadi.required' => 'File PDF harus diunggah.',
            'file_surat_jadi.mimes' => 'File harus berformat PDF.',
            'file_surat_jadi.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
        ]);

        $surat = $surat = Surat::with(['jenisSurat', 'pemohon'])->findOrFail($id);

        if ($request->hasFile('file_surat_jadi') && $request->file('file_surat_jadi')->isValid()) {
            $file = $request->file('file_surat_jadi'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'dokumen_surat/surat-selesai/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
        } 

        $suratSelesai = new HistorySuratSelesai;
        $suratSelesai->surat_id = $surat->id;
        $suratSelesai->file_path_selesai = $fileName;
        $suratSelesai->save();

        $surat->status = 'selesai';
        $surat->save();
        
        $link = asset('storage/dokumen_surat/surat-selesai/' . $fileName);
        $pemohon = $surat->pemohon; 
        $pemohon->notify(new SuratSelesai($surat, $link));

        return redirect()->route('admin.surat.index')
            ->with('success', 'Hasil pengajuan berhasil dikirim ke pengaju.');
    }

    public function detailSyarat($filename)
    {
        $path = storage_path('app/private/dokumen_surat/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}

