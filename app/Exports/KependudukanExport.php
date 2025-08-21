<?php

namespace App\Exports;

use App\Models\Kependudukan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KependudukanExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    /**
     * Ambil data dari database dan tambahkan kolom nomor urut
     */
    public function collection()
    {
        // Ambil data dari database
        $data = Kependudukan::select([
            'rt',
            'dusun',
            'alamat',
            'no_kk',
            'kepala_keluarga',
            'nik',
            'nama_lengkap',
            'jenis_kelamin',
            'posisi_dalam_keluarga',
            'tempat_lahir',
            'tanggal_lahir',
            'usia',
            'status_pernikahan',
            'agama',
            'golongan_darah',
            'pendidikan',
            'pekerjaan'
        ])->get();

       $data->transform(function ($item, $key) {
            $item = $item->toArray(); 
            array_unshift($item, $key + 1);  // Menambahkan nomor urut di posisi pertama
            return (object) $item;  // Kembalikan ke object
        });

        return $data;
    }

    /**
     * Header Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'RT',
            'Dusun',
            'Alamat',
            'No KK',
            'Kepala Keluarga',
            'NIK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Posisi Dalam Keluarga',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia',
            'Status Pernikahan',
            'Agama',
            'Golongan Darah',
            'Pendidikan',
            'Pekerjaan',
        ];
    }

    /**
     * Set lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,    
            'B' => 15,   
            'C' => 25,  
            'D' => 18,   
            'E' => 20,   
            'F' => 20,  
            'G' => 20,   
            'H' => 15,  
            'I' => 20,   
            'J' => 20,   
            'K' => 15, 
            'L' => 8,    
            'M' => 20,  
            'N' => 15,  
            'O' => 15,  
            'P' => 20,   
            'Q' => 20,  
        ];
    }

    /**
     * Styling untuk header
     */
    public function styles(Worksheet $sheet)
    {
        // Style header (A1 sampai R1)
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Warna teks putih
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'], // Warna hijau
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Freeze header biar gak hilang pas scroll
        $sheet->freezePane('A2');
        // Aktifkan Auto Filter secara langsung
        $sheet->setAutoFilter('A1:R1');
    }
}
