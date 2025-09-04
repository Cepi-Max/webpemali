<?php

namespace App\Imports;

use App\Models\DataPendidikan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;

class DataPendidikanImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new DataPendidikan([
            'tingkat_pendidikan' => $row['tingkat_pendidikan'],
            'laki_laki'          => $row['laki_laki'],
            'perempuan'          => $row['perempuan'],
            'jumlah'             => $row['jumlah'],
            'periode'            => $row['periode'],
        ]);
    }
}
