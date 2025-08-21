{{-- resources/views/admin-submission-letter/laporan/rekap-bulanan/rekap_bulanan_print.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Rekap Bulanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        @page { size: A4; margin: 1cm; }
    </style>
</head>
<body onload="window.print()">
    <h2>Laporan Rekap Pengajuan Bulanan</h2>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah Pengajuan</th>
                <th>Belum Diproses</th>
                <th>Sedang Diproses</th>
                <th>Selesai</th>
                <th>Ditolak</th>
                <th>Surat Terpopuler</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $item->bulan }}</td>
                <td>{{ $item->total_pengajuan }}</td>
                <td>{{ $item->pending }}</td>
                <td>{{ $item->diproses }}</td>
                <td>{{ $item->selesai }}</td>
                <td>{{ $item->ditolak }}</td>
                <td>{{ $item->surat_terpopuler }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
