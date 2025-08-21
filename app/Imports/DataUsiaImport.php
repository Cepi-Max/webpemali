<?php

namespace App\Imports;

use App\Models\DataUsia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataUsiaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataUsia([
            'usia'        => $row['usia'],
            'laki_laki'   => $row['laki_laki'],
            'perempuan'   => $row['perempuan'],
            'jumlah'      => $row['jumlah'],
            'periode'     => $row['periode'],
        ]);
    }
}