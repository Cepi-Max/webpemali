<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengajuan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }

        @page {
            size: A4 landscape;
            margin: 1cm;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <h2>Laporan Data Pengajuan Pelayanan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemohon</th>
                <th>Jenis Pelayanan</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                {{-- <th>Tanggal Selesai</th> --}} {{-- Optional --}}
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuan as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->pemohon->name ?? '-' }}</td>
                <td>{{ $item->jenisSurat->nama ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                {{-- <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') : '-' }}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
