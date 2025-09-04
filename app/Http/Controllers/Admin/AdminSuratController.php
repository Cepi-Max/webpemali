<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSuratStatusRequest;
use App\Models\BerkasPengajuan;
use App\Models\DokumenSurat;
use App\Models\HistorySuratSelesai;
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
        $surats = Surat::with('jenisSurat', 'pemohon')->latest()->get();

        return view('admin.submission-queue.index', compact('surats'));
    }

    public function show($id)
    {
        $surat = Surat::with('jenisSurat', 'dokumenSurat.syarat', 'pemohon')->findOrFail($id);
        return view('admin.submission-queue.show', compact('surat'));
    }

    public function updateStatus(UpdateSuratStatusRequest $request, $id)
    {
         // Update per file berkas
        foreach ($request->validasi as $dokumenSuratId => $data) {
            $dokumenSurat = DokumenSurat::find($dokumenSuratId); // ganti nama model kalau lo udah ubah
            if ($dokumenSurat) {
                $dokumenSurat->status_validasi = $data['status'];
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
        ->where('status_validasi', '!=', 'valid')
        ->exists();

        if ($request->status === 'disetujui' && $DokumenWajibInvalid) {
            return back()->with('error', 'Tidak bisa menyetujui pengajuan karena ada berkas wajib yang tidak valid.');
        }
        
        $status = $request->status === 'disetujui' ? 'diproses' : 'ditolak';
        $surat->status = $status;
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
}

