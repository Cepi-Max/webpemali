<?php

namespace App\Imports;

use App\Models\Kependudukan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class KependudukanImport implements ToCollection, WithHeadingRow
{
    public $invalidRows = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $rowNumber => $row) {
            $errors = [];            

            if (Kependudukan::where('nik', $row['nik'])->exists()) {
                $errors[] = 'NIK sudah terdaftar';
            }

            if (strlen($row['rt']) > 5) $errors[] = 'RT melebihi 5 karakter';
            if (strlen($row['dusun']) > 100) $errors[] = 'Dusun melebihi 100 karakter';
            if (strlen($row['alamat']) > 255) $errors[] = 'Alamat melebihi 255 karakter';
            if (strlen($row['no_kk']) > 20) $errors[] = 'No KK melebihi 20 karakter';
            if (strlen($row['kepala_keluarga']) > 100) $errors[] = 'Kepala keluarga melebihi 100 karakter';
            if (strlen($row['nik']) > 20) $errors[] = 'NIK melebihi 20 karakter';
            if (strlen($row['nama_lengkap']) > 100) $errors[] = 'Nama lengkap melebihi 100 karakter';

            $normalizedGender = $this->normalizeGender($row['jenis_kelamin']);
            if (!$normalizedGender) {
                $errors[] = 'Jenis kelamin tidak valid';
            }

            if (!in_array($row['posisi_dalam_keluarga'], ['Kepala Keluarga', 'Istri', 'Suami', 'Anak Kandung', 'Anak Tiri', 'Anak Angkat', 'Mertua', 'Menantu', 'Ibu', 'Bapak', 'Orang Tua', 'Adik', 'Kakak', 'Cucu', 'Keponakan', 'Famili Lain', 'Lainnya'])) $errors[] = 'Posisi dalam keluarga tidak valid';
            
            $tanggalLahirRaw = trim($row['tanggal_lahir'] ?? '');
            if ($tanggalLahirRaw === '') {
                $errors[] = 'Tanggal lahir wajib diisi';
            } else {
                $tanggalLahir = $this->normalizeAndValidateDate($tanggalLahirRaw);
                if (!$tanggalLahir) {
                    $errors[] = 'Format tanggal lahir tidak valid';
                }
            }

            if (!is_numeric($row['usia']) || $row['usia'] < 0 || $row['usia'] > 300) $errors[] = 'Usia tidak valid';
            if (!in_array($row['status_pernikahan'], ['Kawin', 'Belum Kawin', 'Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati', 'Janda/Duda'])) $errors[] = 'Status pernikahan tidak valid';
            if (strlen($row['agama']) > 50) $errors[] = 'Agama melebihi 50 karakter';
            if (strlen($row['golongan_darah']) > 20) $errors[] = 'Golongan darah melebihi 20 karakter';
            if (strlen($row['pendidikan']) > 100) $errors[] = 'Pendidikan melebihi 100 karakter';
            if (strlen($row['pekerjaan']) > 100) $errors[] = 'Pekerjaan melebihi 100 karakter';

            if (count($errors) > 0) {
                $row['error'] = implode(', ', $errors);
                $row['no'] = $rowNumber + 2; // +2 karena index 0 = header, dan index PHP mulai dari 0
                $this->invalidRows[] = $row;
                continue;
            }

            Kependudukan::create([
                'rt'                    => $row['rt'],
                'dusun'                 => $row['dusun'],
                'alamat'                => $row['alamat'],
                'no_kk'                 => $row['no_kk'],
                'kepala_keluarga'       => $row['kepala_keluarga'],
                'nik'                   => $row['nik'],
                'nama_lengkap'          => $row['nama_lengkap'],
                'jenis_kelamin'         => $normalizedGender,
                'posisi_dalam_keluarga' => $row['posisi_dalam_keluarga'],
                'tempat_lahir'          => $row['tempat_lahir'],
                'tanggal_lahir'         => $tanggalLahir,
                'usia'                  => $row['usia'],
                'status_pernikahan'     => $row['status_pernikahan'],
                'agama'                 => $row['agama'],
                'golongan_darah'        => $row['golongan_darah'],
                'pendidikan'            => $row['pendidikan'],
                'pekerjaan'             => $row['pekerjaan'],
            ]);
        }
    }

    private function normalizeGender($gender)
    {
        $gender = strtolower(trim($gender));

        $map = [
            'l' => 'LAKI-LAKI',
            'laki' => 'LAKI-LAKI',
            'laki-laki' => 'LAKI-LAKI',
            'cowok' => 'LAKI-LAKI',
            'pr' => 'PEREMPUAN',
            'p' => 'PEREMPUAN',
            'perempuan' => 'PEREMPUAN',
            'wanita' => 'PEREMPUAN',
            'cewek' => 'PEREMPUAN',
        ];

        return $map[$gender] ?? null; 
    }


    private function normalizeAndValidateDate($date)
    {
        // Kalau null atau kosong
        if (!$date || trim($date) === '') return null;

        $carbonDate = null;

        // Jika Excel format serial number (angka)
        if (is_numeric($date)) {
            try {
                $carbonDate = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
            } catch (\Exception $e) {
                return null;
            }
        } else {
            // Coba parsing dengan berbagai format umum
            $formats = ['Y-m-d', 'd-m-Y', 'm-d-Y', 'Y/m/d', 'd/m/Y', 'm/d/Y', 'Y.m.d', 'd.m.Y', 'M d Y', 'd M Y'];

            foreach ($formats as $format) {
                try {
                    $parsed = \Carbon\Carbon::createFromFormat($format, trim($date));
                    if ($parsed) {
                        $carbonDate = $parsed;
                        break;
                    }
                } catch (\Exception $e) {
                    // skip
                }
            }

            // Coba auto parse bebas kalau format di atas gak kena
            if (!$carbonDate) {
                try {
                    $carbonDate = \Carbon\Carbon::parse($date);
                } catch (\Exception $e) {
                    return null;
                }
            }
        }

        // Final check: pastikan tahun masih masuk akal (contoh: max 2100, min 1900)
        if ($carbonDate && $carbonDate->year >= 1900 && $carbonDate->year <= 2100) {
            return $carbonDate->format('Y-m-d');
        }

        return null; // jika tahun aneh atau gagal parse
    }


}
