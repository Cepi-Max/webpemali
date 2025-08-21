<?php

namespace App\Imports;

use App\Models\DataTenagaKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataTenagaKerjaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataTenagaKerja([
            'tenaga_kerja' => $row['tenaga_kerja'],
            'laki_laki'    => $row['laki_laki'],
            'perempuan'    => $row['perempuan'],
            'jumlah'       => $row['jumlah'],
            'periode'   => $row['periode'],
        ]);
    }
}
