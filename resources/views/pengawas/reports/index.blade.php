<x-pengawas-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Pusat Laporan & Analisis') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Pantau kinerja dan analisis data penjualan</p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('pengawas.dashboard') }}" class="hover:text-[#80489C]">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </a>
                <span>/</span>
                <span class="text-[#80489C] font-medium">Laporan</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-filter text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Filter Laporan</h3>
                            <p class="text-sm text-gray-600">Pilih rentang tanggal untuk melihat laporan</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('reports.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt text-[#80489C] mr-1"></i>
                                    Dari Tanggal <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-day text-gray-400"></i>
                                    </div>
                                    <input type="date" 
                                           name="start_date" 
                                           value="{{ request('start_date') }}" 
                                           required 
                                           class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt text-[#80489C] mr-1"></i>
                                    Sampai Tanggal <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-check text-gray-400"></i>
                                    </div>
                                    <input type="date" 
                                           name="end_date" 
                                           value="{{ request('end_date') }}" 
                                           required 
                                           class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200">
                                </div>
                            </div>
                            
                            <div class="flex items-end space-x-3">
                                <button type="submit" 
                                        class="flex-1 px-5 py-3 bg-gradient-to-r from-[#80489C] to-[#9a65b3] text-white rounded-lg hover:from-[#66337a] hover:to-[#80489C] transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center justify-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    Tampilkan Preview
                                </button>
                                
                                @if(request('start_date'))
                                    <a href="{{ route('pengawas.reports.print', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                                       target="_blank"
                                       class="px-5 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                        <i class="fas fa-file-pdf mr-2"></i>
                                        <span class="hidden md:inline">PDF</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(request('start_date'))
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-[#80489C] text-xl"></i>
                                </div>
                                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">Total</span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $totalTransactions }}</h3>
                            <p class="text-sm text-gray-600">Total Transaksi</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                                </div>
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Kotor</span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-1">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</h3>
                            <p class="text-sm text-gray-600">Omzet Kotor</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border-2 border-[#80489C]">
                        <div class="p-6 bg-gradient-to-br from-purple-50 to-white">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-line text-white text-xl"></i>
                                </div>
                                <span class="text-xs font-semibold text-[#80489C] bg-purple-100 px-2 py-1 rounded-full">Bersih</span>
                            </div>
                            <h3 class="text-3xl font-bold text-[#80489C] mb-1">Rp {{ number_format($netRevenue, 0, ',', '.') }}</h3>
                            <p class="text-sm text-gray-600">Omzet Bersih</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-crown text-yellow-600 text-xl"></i>
                                </div>
                                <span class="text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">#1</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1 truncate">{{ $topProducts->first()->product->name ?? '-' }}</h3>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-box mr-1"></i>
                                {{ $topProducts->first() ? $topProducts->first()->total_qty . ' terjual' : 'Belum ada data' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Perlu Dikirim Section -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4 border-b border-yellow-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-yellow-800">Perlu Dikirim</h3>
                                <p class="text-sm text-yellow-700">Pesanan dengan status Paid & Processing</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Pelanggan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Item</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($unshippedOrders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white text-sm font-bold">{{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                                                <div class="text-xs text-gray-500">#{{ $order->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @foreach($order->items->groupBy('product_id') as $items)
                                                <div class="flex items-center text-sm">
                                                    <span class="text-gray-600">{{ $items->first()->product->name ?? 'Produk Hapus' }}</span>
                                                    <span class="ml-2 px-2 py-0.5 bg-purple-100 text-[#80489C] text-xs rounded-full font-bold">
                                                        x{{ $items->sum('quantity') }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($order->status == 'paid')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i> Paid
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                                <i class="fas fa-clock mr-1"></i> Processing
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                                            </div>
                                            <p class="text-gray-600 font-medium">Semua aman, tidak ada antrian pengiriman</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Riwayat Pembatalan Section -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 px-6 py-4 border-b border-red-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-ban text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-red-800">Riwayat Pembatalan</h3>
                                <p class="text-sm text-red-700">Daftar pesanan yang dibatalkan</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Pelanggan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Item</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase">Nilai Hilang</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($cancelledOrders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-red-600 text-sm font-bold">{{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}</span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @foreach($order->items->groupBy('product_id') as $items)
                                                <div class="flex items-center text-sm">
                                                    <span class="text-gray-600">{{ $items->first()->product->name ?? 'Produk Hapus' }}</span>
                                                    <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-600 text-xs rounded-full font-bold">
                                                        x{{ $items->sum('quantity') }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-lg font-bold text-red-600">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                                            </div>
                                            <p class="text-gray-600 font-medium">Tidak ada pembatalan di periode ini</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-[#80489C] text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-900">Ringkasan Laporan</h4>
                            <p class="text-gray-700 mt-2">
                                Menampilkan data dari <span class="font-bold">{{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}</span> 
                                sampai <span class="font-bold">{{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}</span>
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Total {{ $totalTransactions }} transaksi</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Omzet bersih Rp {{ number_format($netRevenue, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">{{ $unshippedOrders->count() }} pesanan perlu dikirim</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-chart-pie text-[#80489C] text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Belum Ada Data Laporan</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Silakan pilih rentang tanggal di atas dan klik "Tampilkan Preview" untuk melihat laporan penjualan.
                        </p>
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                            <i class="fas fa-calendar-alt text-[#80489C]"></i>
                            <span>Contoh: 01 Jan 2024 - 31 Jan 2024</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(128, 72, 156, 0.15);
        }
    </style>
    @endpush
</x-pengawas-layout>