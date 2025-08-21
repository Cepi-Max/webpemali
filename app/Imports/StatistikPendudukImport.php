<?php

namespace App\Imports;

use App\Models\StatistikPenduduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;

class StatistikPendudukImport implements ToModel, WithHeadingRow, WithEvents
{
    protected $headerMap = [];

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                // Ambil baris header (baris pertama)
                $headingRow = $event->getReader()->getSheet(0)->toArray()[0];

                // Mapping: Ubah header ke format snake_case biar cocok
                foreach ($headingRow as $original) {
                    $normalized = strtolower(str_replace([' ', '-', '.'], '_', trim($original)));
                    $this->headerMap[$normalized] = $original;
                }
            }
        ];
    }

    public function model(array $row)
    {
        return new StatistikPenduduk([
            'wilayah' => $row['wilayah'],
            'jumlah_kepala_keluarga' => $row['jumlah_kepala_keluarga'],
            'jumlah_penduduk_laki_laki' => $row['jumlah_penduduk_laki_laki'],
            'jumlah_penduduk_perempuan' => $row['jumlah_penduduk_perempuan'],
            'jumlah_penduduk' => $row['jumlah_penduduk'],
            'periode' => $row['periode'],
        ]);
    }

}
