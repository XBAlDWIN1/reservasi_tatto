<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kwitansi Reservasi</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header,
        .footer {
            background-color: #c05621;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Kwitansi Pembayaran</h2>
    </div>

    <p><strong>Dari :</strong> MK TATTO ART<br>
        <strong>Kepada :</strong> {{ $reservasi->pelanggan->nama_lengkap ?? '-' }}
    </p>

    <p><strong>Nomor Kwitansi:</strong> {{ $reservasi->id_reservasi }}<br>
        <strong>Tanggal dikeluarkan:</strong> {{ now()->format('d/m/Y') }}
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>Jadwal</th>
                <th>Teknik</th>
                <th>Lokasi Tato</th>
                <th>Ukuran Tato</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ \Carbon\Carbon::parse($reservasi->konsultasi->jadwal_konsultasi)->translatedFormat('D, d M Y') }}</td>
                <td>{{ $reservasi->konsultasi->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $reservasi->konsultasi->lokasiTato->nama_lokasi_tato ?? '-' }}</td>
                <td>{{ $reservasi->konsultasi->panjang ?? '-' }}x{{ $reservasi->konsultasi->lebar ?? '-' }} cm</td>
                <td><strong>IDR {{ number_format($biaya_dasar, 0, ',', '.') }}</strong></td>
                <td><strong>IDR {{ number_format($biaya_tambahan, 0, ',', '.') }}</strong></td>
                <td><strong>IDR {{ number_format($total_biaya, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p style="text-align: right; margin-top: 20px;"><strong>Total:</strong> <span style="font-style: italic;">IDR {{ number_format($reservasi->total_pembayaran, 0, ',', '.') }}</span></p>

    <div class="footer">
        <p>Terima kasih telah menato di mk tato art</p>
    </div>

</body>

</html>