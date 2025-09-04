<?php

namespace App\Imports;

use App\Models\DataPekerjaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataPekerjaanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataPekerjaan([
            'jenis_pekerjaan' => $row['jenis_pekerjaan'],
            'laki_laki'       => $row['laki_laki'],
            'perempuan'       => $row['perempuan'],
            'jumlah'          => $row['jumlah'],
            'periode'         => $row['periode'],
        ]);
    }
}
