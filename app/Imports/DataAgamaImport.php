<?php

namespace App\Imports;

use App\Models\DataAgama;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataAgamaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataAgama([
            'agama'     => $row['agama'] ,
            'laki_laki' => $row['laki_laki'] ,
            'perempuan' => $row['perempuan'] ,
            'jumlah'    => $row['jumlah'] ,
            'periode'   => $row['periode'] ,
        ]);
    }
    
}
