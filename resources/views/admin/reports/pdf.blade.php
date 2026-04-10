<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .text-right { text-align: right; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; color: white; }
        .bg-green { background-color: #28a745; } /* Completed */
        .bg-blue { background-color: #007bff; }  /* Shipped */
        .bg-yellow { background-color: #ffc107; color: black; } /* Processing */
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN PENJUALAN</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 15%">Pelanggan</th>
                <th style="width: 25%">Item Produk</th>
                <th style="width: 15%">Status</th>
                <th style="width: 15%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->user->name ?? 'Guest' }}</td>
                <td>
                    <ul style="padding-left: 15px; margin: 0;">
                        @foreach($order->items as $item)
                            <li>
                                {{ $item->product->name ?? 'Produk Dihapus' }} 
                                <span style="color: #666;">(x{{ $item->quantity }})</span>
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    {{ ucfirst($order->status) }}
                    @if($order->resi_number)
                        <br><small style="color: #666;">Resi: {{ $order->resi_number }}</small>
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data penjualan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right" style="border: none;">Total Pendapatan Kotor (Completed):</td>
                <td class="text-right">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</td>
            </tr>
            
            <tr class="total-row" style="background-color: #d4edda;"> <td colspan="5" class="text-right" style="border: none; color: #155724; font-weight: bold;">
                    Total Pendapatan Bersih (Excl. Ongkir):
                </td>
                <td class="text-right" style="color: #155724; font-weight: bold;">
                    Rp {{ number_format($netRevenue, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        <br><br><br>
        <p>( Administrator )</p>
    </div>

</body>
</html>