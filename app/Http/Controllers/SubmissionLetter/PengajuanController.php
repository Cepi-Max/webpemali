<?php

namespace App\Http\Controllers\SubmissionLetter;

use App\Http\Controllers\Controller;
use App\Models\DokumenSurat;
use App\Models\JenisSurat;
use App\Models\Notifikasi;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function form($slug)
    {
        $jenis = JenisSurat::where('slug', $slug)->firstOrFail();
        $syarat = $jenis->syaratDokumen;

        $data = [
            'title' => 'Formulir Syarat Pengajuan Surat',
            'jenis' => $jenis,
            'syarat' => $syarat,
        ];

        return view('submission-letter.form', $data);
    }

    public function store(Request $request)
    {
        $jenis = JenisSurat::find($request->jenis_surat_id);
        $syarat = $jenis->syaratDokumen;

        $rules = [
            // 'tujuan' => 'required|string|max:255',
        ];

        foreach ($syarat as $s) {
            switch ($s->tipe_input) {
                case 'file':
                    $rule = ['file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'];
                    break;
                case 'number':
                    $rule = ['numeric'];
                    break;
                case 'date':
                    $rule = ['date'];
                    break;
                case 'select':
                case 'text':
                case 'textarea':
                    $rule = ['string', 'max:1000'];
                    break;
                default:
                    $rule = [];
            }


            if ($s->pivot->wajib) {
                array_unshift($rule, 'required');
            } else {
                array_unshift($rule, 'nullable');
            }

            $rules['dokumen_' . $s->id] = $rule;
        }

        $messages = [];

        foreach ($syarat as $s) {
            if ($s->pivot->wajib) {
                $messages['dokumen_' . $s->id . '.required'] = 'Berkas ' . $s->nama . ' wajib diunggah.';
            }
        }

        $request->validate($rules, $messages);
        $validated = $request->validate($rules);

        $pemohon_id = Auth::id();
        
        // Simpan surat
        $surat = Surat::create([
            'jenis_surat_id' => $jenis->id,
            'pemohon_id' => $pemohon_id,
            'tanggal_pengajuan' => now(),
            'status' => 'pending'
        ]);

        // Simpan dokumen
        foreach ($syarat as $s) {
            $inputName = 'dokumen_' . $s->id;

                if ($s->tipe_input === 'file' && $request->hasFile($inputName)) {
                    $file = $request->file($inputName);
                    $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = 'dokumen_surat/' . $fileName;
                    Storage::put($path, file_get_contents($file));

                    DokumenSurat::create([
                        'surat_id' => $surat->id,
                        'syarat_dokumen_id' => $s->id,
                        'file_path' => $path
                    ]);
                } elseif ($s->tipe_input !== 'file') {
                    $value = $request->input($inputName);

                    DokumenSurat::create([
                        'surat_id' => $surat->id,
                        'syarat_dokumen_id' => $s->id,
                        'keterangan' => $value 
                    ]);
                }

        }

        Notifikasi::create([
            'pengaju_id' => Auth::user()->id,
            'pengajuan_surat_id' => $surat->id,
            'jenis_surat_id' => $jenis->id,
            'pesan' => "Pengajuan {$jenis->nama} dari " . Auth::user()->name
        ]);

        return redirect()->route('show.mysubmission')->with('success', 'Pengajuan berhasil dikirim.');
    }
}
