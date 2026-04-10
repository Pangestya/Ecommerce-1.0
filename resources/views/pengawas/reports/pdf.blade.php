<!DOCTYPE html>
<html>
<head>
    <title>Laporan Lengkap Pengawas</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .page-break { page-break-after: always; }
        
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10px; }

        /* Style Kotak Statistik */
        .stats-box { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .stats-box td { width: 25%; text-align: center; padding: 10px; background: #f8f9fa; border: 1px solid #ddd; }
        .stats-val { font-size: 14px; font-weight: bold; display: block; margin-top: 5px; color: #2d3748; }
        .stats-lbl { font-size: 9px; color: #718096; text-transform: uppercase; letter-spacing: 1px; }

        /* Style Tabel Data */
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #cbd5e0; padding: 6px; text-align: left; vertical-align: top; }
        table.data th { background-color: #edf2f7; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        
        .section-title { font-size: 12px; font-weight: bold; margin: 20px 0 10px 0; border-bottom: 1px solid #333; display: inline-block; padding-bottom: 3px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 9px; color: white; display: inline-block; }
        .bg-green { background-color: #38a169; }
        .bg-red { background-color: #e53e3e; }
        .bg-yellow { background-color: #d69e2e; color: white; }
        .bg-blue { background-color: #3182ce; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Analisis Bisnis & Operasional</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <div class="section-title">1. RINGKASAN KEUANGAN (COMPLETED ONLY)</div>
    <table class="stats-box">
        <tr>
            <td>
                <span class="stats-lbl">Total Transaksi Selesai</span>
                <span class="stats-val">{{ $totalTransactions }} Pesanan</span>
            </td>
            <td>
                <span class="stats-lbl">Omzet Kotor (Gross)</span>
                <span class="stats-val">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="stats-lbl">Total Ongkir Keluar</span>
                <span class="stats-val" style="color: #e53e3e;">(Rp {{ number_format($totalShipping, 0, ',', '.') }})</span>
            </td>
            <td style="background-color: #f0fff4; border-color: #c6f6d5;">
                <span class="stats-lbl" style="color: #276749;">Omzet Bersih (Net)</span>
                <span class="stats-val" style="color: #2f855a;">Rp {{ number_format($netRevenue, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 10px;">
        <tr>
            <td style="width: 60%; vertical-align: top; padding-right: 10px;">
                <div class="section-title" style="margin-top: 0;">2. TOP 5 PRODUK TERLARIS</div>
                <table class="data">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Terjual (Qty)</th>
                            <th class="text-right">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="text-center">{{ $item->total_qty }}</td>
                            <td class="text-right">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Belum ada data penjualan selesai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
            
            <td style="width: 40%; vertical-align: top;">
                <div class="section-title" style="margin-top: 0;">3. PENGGUNAAN KURIR</div>
                <table class="data">
                    <thead>
                        <tr>
                            <th>Ekspedisi</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courierStats as $courier => $count)
                        <tr>
                            <td style="text-transform: uppercase;">{{ $courier ?: 'Lainnya' }}</td>
                            <td class="text-center">{{ $count }}</td>
                            <td class="text-center">
                                {{ $totalTransactions > 0 ? round(($count / $totalTransactions) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    <div class="header">
        <h1>Rincian Pesanan Belum Dikirim</h1>
        <p>Status: Paid (Sudah Bayar) & Processing (Sedang Dikemas)</p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 15%">Pelanggan</th>
                <th style="width: 35%">Detail Item (Digabung)</th>
                <th style="width: 10%">Status</th>
                <th style="width: 8%">Ekspedisi</th>
                <th style="width: 15%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unshippedOrders as $index => $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->user->name ?? 'Guest' }}</td>
                <td>
                    {{-- LOGIKA PENGGABUNGAN ITEM --}}
                    <ul style="padding-left: 15px; margin: 0;">
                        @foreach($order->items->groupBy('product_id') as $items)
                            <li>
                                {{ $items->first()->product->name ?? 'Item Dihapus' }}
                                <strong>(x{{ $items->sum('quantity') }})</strong>
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    @if($order->status == 'paid') <span class="badge bg-blue">Paid</span>
                    @else <span class="badge bg-yellow">Processing</span>
                    @endif
                </td>
                <td style="text-transform: uppercase;">{{ $order->shipping_service }}</td>
                <td class="text-right">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada pesanan yang perlu dikirim saat ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="header">
        <h1>Rincian Pesanan Dibatalkan</h1>
        <p>Status: Cancelled</p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal Cancel</th>
                <th style="width: 20%">Pelanggan</th>
                <th style="width: 40%">Detail Item (Digabung)</th>
                <th style="width: 20%" class="text-right">Nilai Transaksi (Hangus)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cancelledOrders as $index => $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->user->name ?? 'Guest' }}</td>
                <td>
                    <ul style="padding-left: 15px; margin: 0;">
                        @foreach($order->items->groupBy('product_id') as $items)
                            <li>
                                {{ $items->first()->product->name ?? 'Item Dihapus' }}
                                <strong>(x{{ $items->sum('quantity') }})</strong>
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td class="text-right" style="color: #e53e3e;">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 20px;">Tidak ada pesanan dibatalkan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>