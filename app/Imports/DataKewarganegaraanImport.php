<?php

namespace App\Imports;

use App\Models\DataKewarganegaraan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataKewarganegaraanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataKewarganegaraan([
            'kewarganegaraan' => $row['kewarganegaraan'],
            'laki_laki'       => $row['laki_laki'],
            'perempuan'       => $row['perempuan'],
            'jumlah'          => $row['jumlah'],
            'periode'         => $row['periode'],
        ]);
    }
}
