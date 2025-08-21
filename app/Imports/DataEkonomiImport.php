<?php

namespace App\Imports;

use App\Models\DataEkonomi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataEkonomiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataEkonomi([
            'jenis_lembaga_industri_usaha' => $row['jenis_lembaga_industri_usaha'],
            'jumlah_unit'                  => $row['jumlah_unit'],
            'periode'                      => $row['periode'],
        ]);
    }
}
