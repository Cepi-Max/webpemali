<?php

namespace App\Imports;

use App\Models\DataJenisCacat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataJenisCacatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataJenisCacat([
            'jenis_cacat' => $row['jenis_cacat_fisik_mental'],
            'laki_laki'   => $row['laki_laki'],
            'perempuan'   => $row['perempuan'],
            'jumlah'      => $row['jumlah'],
            'periode'     => $row['periode'],
        ]);
    }
}
