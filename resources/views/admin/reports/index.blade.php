<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Laporan Penjualan') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Analisis dan rekap data penjualan</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Laporan Penjualan</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">Filter Laporan</h3>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.reports.index') }}" method="GET" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="date" name="start_date" id="start_date" 
                                        value="{{ request('start_date') }}" required
                                        class="pl-10 w-full border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none">
                                </div>
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="date" name="end_date" id="end_date" 
                                        value="{{ request('end_date') }}" required
                                        class="pl-10 w-full border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none">
                                </div>
                            </div>

                            <div class="flex space-x-3">
                                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-lg hover:from-[#35205e] hover:to-[#432C7A] shadow-md font-medium flex items-center">
                                    <i class="fas fa-search mr-2"></i>
                                    Tampilkan
                                </button>
                                
                                @if(request('start_date') && request('end_date'))
                                    <a href="{{ route('admin.reports.print', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                                       target="_blank"
                                       class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 shadow-md font-medium flex items-center">
                                        <i class="fas fa-file-pdf mr-2"></i>
                                        Cetak PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    @if(request('start_date'))
                        <div class="mt-8">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                                <h4 class="text-lg font-bold text-gray-900">Hasil Laporan</h4>
                                <div class="mt-2 md:mt-0 px-4 py-2 bg-purple-50 rounded-lg border border-purple-200">
                                    <span class="text-sm text-gray-600">Periode: </span>
                                    <span class="text-sm font-semibold text-[#432C7A]">
                                        {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pelanggan</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Item Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($orders as $index => $order)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="font-medium">{{ $order->created_at->format('d/m/Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->user->name ?? 'Guest' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div class="max-w-xs">
                                                    @foreach($order->items as $item)
                                                        <div class="flex items-center text-xs mb-1 last:mb-0">
                                                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#432C7A] mr-2"></span>
                                                            <span>{{ $item->product->name ?? 'Produk Dihapus' }} (x{{ $item->quantity }})</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'completed' => 'bg-green-100 text-green-800 border-green-200',
                                                        'shipped' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                        'processing' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                        'paid' => 'bg-gray-100 text-gray-800 border-gray-200',
                                                    ];
                                                    $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }} border">
                                                    <div class="w-1.5 h-1.5 rounded-full mr-1.5 
                                                        {{ $order->status == 'completed' ? 'bg-green-500' : 
                                                           ($order->status == 'shipped' ? 'bg-blue-500' : 
                                                           ($order->status == 'processing' ? 'bg-yellow-500' : 'bg-gray-500')) }}">
                                                    </div>
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                                @if($order->resi_number)
                                                    <div class="text-xs text-gray-500 mt-1">Resi: {{ $order->resi_number }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                                                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                                <i class="fas fa-chart-line text-gray-300 text-4xl mb-3"></i>
                                                <p>Tidak ada data penjualan pada periode ini</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                        <tr>
                                            <td colspan="5" class="px-6 py-3 text-right text-sm font-medium text-gray-700">
                                                Total Pendapatan Kotor (Completed Only):
                                            </td>
                                            <td class="px-6 py-3 text-right text-sm font-bold text-gray-800">
                                                Rp {{ number_format($grossRevenue, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        
                                        <tr class="bg-green-50">
                                            <td colspan="5" class="px-6 py-4 text-right text-sm font-bold text-green-700">
                                                Total Pendapatan Bersih (Tanpa Ongkir):
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-bold text-green-700">
                                                Rp {{ number_format($netRevenue, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>