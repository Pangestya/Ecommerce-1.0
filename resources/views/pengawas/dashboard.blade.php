<x-pengawas-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Dashboard Monitoring Pengawas') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Pantau kinerja dan aktivitas sistem secara real-time</p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <span class="text-[#80489C] font-medium">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-white text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Bulan Ini</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp {{ number_format($netRevenue, 0, ',', '.') }}</h3>
                        <p class="text-sm text-gray-600">Pendapatan Bersih</p>
                        <div class="mt-3 flex items-center text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span>+12.5% dari bulan lalu</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-white text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Selesai</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalCompleted }}</h3>
                        <p class="text-sm text-gray-600">Pesanan Selesai</p>
                        <div class="mt-3 flex items-center text-xs text-blue-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            <span>{{ $totalCompleted }} transaksi sukses</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-truck text-white text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">Antrian</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $unshippedCount }}</h3>
                        <p class="text-sm text-gray-600">Antrian Pengiriman</p>
                        <div class="mt-3 flex items-center text-xs text-yellow-600">
                            <i class="fas fa-clock mr-1"></i>
                            <span>Paid & Processing</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border-2 border-[#80489C]">
                    <div class="p-6 bg-gradient-to-br from-purple-50 to-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-pie text-white text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-[#80489C] bg-purple-100 px-2 py-1 rounded-full">Rate</span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#80489C] mb-1">{{ number_format($cancelRate, 1) }}%</h3>
                        <p class="text-sm text-gray-600">Tingkat Pembatalan</p>
                        <div class="mt-3 flex items-center text-xs {{ $cancelRate < 5 ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas {{ $cancelRate < 5 ? 'fa-check-circle' : 'fa-exclamation-circle' }} mr-1"></i>
                            <span>Target: < 5%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Top Products -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden lg:col-span-2 card-hover">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Tren Pendapatan</h3>
                                <p class="text-sm text-gray-600">7 Hari Terakhir</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <canvas id="revenueChart" height="120"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-crown text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Top 5 Produk Terlaris</h3>
                                <p class="text-sm text-gray-600">Berdasarkan jumlah terjual</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-4">
                            @forelse($topProducts as $item)
                            <li>
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center">
                                        <span class="w-6 h-6 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-full text-white text-xs flex items-center justify-center font-bold mr-3">
                                            {{ $loop->iteration }}
                                        </span>
                                        <span class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                                    </div>
                                    <span class="text-sm font-bold text-[#80489C]">{{ $item->total_qty }} terjual</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-gradient-to-r from-[#80489C] to-[#9a65b3] h-1.5 rounded-full" 
                                         style="width: {{ ($item->total_qty / $topProducts->first()->total_qty) * 100 }}%"></div>
                                </div>
                            </li>
                            @empty
                            <li class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-600">Belum ada data penjualan</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Activities and Low Stock -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden lg:col-span-2 card-hover">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-history text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Aktivitas Sistem Terbaru</h3>
                                    <p class="text-sm text-gray-600">5 aktivitas terakhir</p>
                                </div>
                            </div>
                            <a href="{{ route('pengawas.audit.index') }}" class="text-sm text-[#80489C] hover:underline flex items-center">
                                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelaku</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentActivities as $log)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $log->created_at->format('H:i') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-7 h-7 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-full flex items-center justify-center mr-2">
                                                <span class="text-white text-xs font-bold">
                                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ $log->user->name ?? 'System' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $badgeColor = match($log->action) {
                                                'CREATE', 'TAMBAH' => 'bg-green-100 text-green-800',
                                                'UPDATE', 'EDIT' => 'bg-blue-100 text-blue-800',
                                                'DELETE', 'HAPUS' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span class="{{ $badgeColor }} text-xs font-medium px-2 py-1 rounded-full">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700 truncate max-w-xs">
                                            {{ $log->details }}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada aktivitas tercatat
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 px-6 py-4 border-b border-red-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-red-800">Stok Menipis</h3>
                                <p class="text-sm text-red-700">Stok kurang dari 5 unit</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <ul class="space-y-3">
                            @forelse($lowStockProducts as $product)
                            <li class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-box text-red-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">{{ $product->name }}</span>
                                        <p class="text-xs text-gray-500">SKU: {{ $product->sku ?? '-' }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-red-600">{{ $product->stock }}</span>
                            </li>
                            @empty
                            <li class="text-center py-8">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                                </div>
                                <p class="text-green-600 font-medium">Semua stok aman</p>
                                <p class="text-sm text-gray-500 mt-1">Tidak ada produk dengan stok menipis</p>
                            </li>
                            @endforelse
                        </ul>

                        @if($lowStockProducts->count() > 0)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="#" class="text-sm text-[#80489C] hover:underline flex items-center justify-center">
                                <i class="fas fa-eye mr-1"></i> Lihat semua produk
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-bolt text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Aksi Cepat</h3>
                            <p class="text-sm text-gray-600">Fitur yang sering digunakan</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('reports.index') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-purple-50 transition-colors duration-200 group">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-gradient-to-r group-hover:from-[#80489C] group-hover:to-[#9a65b3] transition-all duration-200">
                                <i class="fas fa-chart-bar text-[#80489C] group-hover:text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Laporan</span>
                        </a>
                        
                        <a href="{{ route('pengawas.users.index') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-purple-50 transition-colors duration-200 group">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-gradient-to-r group-hover:from-[#80489C] group-hover:to-[#9a65b3] transition-all duration-200">
                                <i class="fas fa-users text-[#80489C] group-hover:text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Manajemen User</span>
                        </a>
                        
                        <a href="{{ route('pengawas.audit.index') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-purple-50 transition-colors duration-200 group">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-gradient-to-r group-hover:from-[#80489C] group-hover:to-[#9a65b3] transition-all duration-200">
                                <i class="fas fa-history text-[#80489C] group-hover:text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Audit Trail</span>
                        </a>
                        
                        <a href="{{ route('pengawas.profile.edit') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-purple-50 transition-colors duration-200 group">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-gradient-to-r group-hover:from-[#80489C] group-hover:to-[#9a65b3] transition-all duration-200">
                                <i class="fas fa-user-cog text-[#80489C] group-hover:text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Edit Profil</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartDates) !!},
                datasets: [{
                    label: 'Pendapatan Bersih (Rp)',
                    data: {!! json_encode($chartRevenue) !!},
                    borderColor: '#80489C',
                    backgroundColor: 'rgba(128, 72, 156, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#80489C',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>

    @push('styles')
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(128, 72, 156, 0.15);
        }
        
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover::after {
            transform: rotate(45deg) translate(50%, 50%);
        }
    </style>
    @endpush
</x-pengawas-layout>