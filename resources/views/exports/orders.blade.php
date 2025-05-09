<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Order</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #eaeaea; }
    </style>
</head>
<body>
    <h2>Laporan Order Selesai</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSemuaHarga = 0; @endphp
            @foreach($orders as $order)
                @php $totalSemuaHarga += $order->total_price; @endphp
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">Total Keseluruhan</td>
                <td colspan="2">Rp {{ number_format($totalSemuaHarga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
