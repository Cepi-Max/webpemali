<?php

namespace App\Imports;

use App\Models\DataDusun;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataDusunImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataDusun([
            'nama_dusun'             => $row['nama_dusun'],
            'nama_rukun_tetangga'    => $row['nama_rukun_tetangga'],
            'periode'                => $row['periode'],
        ]);
    }
}
