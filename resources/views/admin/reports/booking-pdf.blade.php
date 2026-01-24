<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan ExploreIn</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #0046ff; margin-bottom: 5px; }
        .summary-box { background: #fdf5e6; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        .revenue { font-size: 24px; font-weight: bold; color: #73c8d2; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #eee; padding: 12px; text-align: left; font-size: 12px; }
        th { background-color: #f8f9fa; color: #666; font-weight: bold; text-transform: uppercase; }
        .status-success { color: green; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ExploreIn Travel</h1>
        <p>Laporan Riwayat Booking & Penghasilan</p>
        <small>Dicetak pada: {{ now()->format('d M Y, H:i') }}</small>
    </div>

    <div class="summary-box">
        <p style="margin: 0; color: #666;">Total Pendapatan Bersih:</p>
        <div class="revenue">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <p style="margin: 0; font-size: 10px;">Berdasarkan {{ $transactions->count() }} transaksi sukses.</p>
    </div>

    {{-- Grafik Sederhana (Tabel Bar) --}}
    <h3>Ringkasan Harian</h3>
    <table style="border: none;">
        @foreach($chartData as $data)
        <tr>
            <td style="border: none; width: 100px;">{{ $data->date }}</td>
            <td style="border: none;">
                <div style="background: #73c8d2; height: 15px; width: {{ ($data->total / $totalRevenue) * 100 }}%; border-radius: 3px;"></div>
            </td>
            <td style="border: none; width: 120px; text-align: right;">Rp {{ number_format($data->total) }}</td>
        </tr>
        @endforeach
    </table>

    <h3>Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Destinasi</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>#{{ $trx->id }}</td>
                <td>{{ $trx->user->name }}</td>
                <td>{{ $trx->destination->name }}</td>
                <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($trx->total_price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Laporan ini digenerate secara otomatis oleh Sistem ExploreIn.
    </div>
</body>
</html>