<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengguna</title>
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
    <h2>Laporan Data Pengguna</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Tgl Registrasi</th>
                <th>Jumlah Pengajuan</th>
                <th>Status Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $user)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->nik }}</td>
                <td>{{ $user->number_phone }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d-m-Y') }}</td>
                <td>{{ $user->pengajuans_count }}</td>
                <td>{{ $user->hasVerifiedEmail() ? 'Terverifikasi' : 'Belum' }}</td>
                <td>{{ ucfirst($user->role) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
