<?php

// app/Http/Requests/UpdateSuratStatusRequest.php
namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use App\Models\JenisSuratSyarat;
use App\Models\Surat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSuratStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('status') === 'disetujui') {
                $suratId = $this->route('surat');
                $surat = Surat::with('jenisSurat')->find($suratId);

                if ($surat) {
                    $jenisSuratId = $surat->jenis_surat_id;

                    $syaratWajib = JenisSuratSyarat::where('jenis_surat_id', $jenisSuratId)
                        ->where('wajib', true)
                        ->pluck('syarat_dokumen_id')
                        ->toArray();

                    $validasi = $this->input('validasi', []);

                    foreach ($syaratWajib as $dokId) {
                        if (!isset($validasi[$dokId]) || $validasi[$dokId]['status'] !== 'valid') {
                            $validator->errors()->add("validasi.$dokId.status", 'Syarat wajib ini harus divalidasi sebagai "valid" sebelum dapat disetujui.');
                        }
                    }
                }
            }
        });
    }


    public function rules()
    {
        $rules = [
            'status' => ['required', Rule::in(['disetujui', 'ditolak'])],
            'validasi' => 'array',
        ];

        $validasi = $this->input('validasi', []);
        $keys = array_keys($validasi);

        $suratId = $this->route('surat'); // asumsi nama route parameter 'surat'
        $surat = Surat::with('jenisSurat')->find($suratId);

        if ($surat) {
            $jenisSuratId = $surat->jenis_surat_id;

            // Ambil daftar syarat wajib untuk jenis surat ini
            $syaratWajib = JenisSuratSyarat::where('jenis_surat_id', $jenisSuratId)
                ->where('wajib', true)
                ->pluck('syarat_dokumen_id')
                ->toArray();

            foreach ($keys as $dokId) {
                if (in_array($dokId, $syaratWajib)) {
                    $rules["validasi.$dokId.status"] = ['required', Rule::in(['valid', 'invalid'])];
                } else {
                    $rules["validasi.$dokId.status"] = [Rule::in(['valid', 'invalid'])];
                }
                $rules["validasi.$dokId.catatan"] = ['nullable', 'string'];
            }
        }

        return $rules;
    }

    public function attributes()
    {
        $attrs = [];
        $validasi = $this->input('validasi', []);
        $keys = array_keys($validasi);

        foreach ($keys as $index => $dokId) {
            $attrs["validasi.{$dokId}.status"] = 'berkas ' . ($index + 1);
        }

        return $attrs;
    }

    public function messages()
    {
        return [
            'status.required' => 'Mohon masukkan status permohonan.',
            'validasi.*.status.required' => 'Status validasi dokumen wajib diisi.',
            'validasi.*.status.in' => 'Mohon periksa :attribute terlebih dahulu.',
        ];
    }
}
