<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Dashboard Operasional Admin') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Ringkasan aktivitas toko Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Operasional</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#432C7A]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Perlu Diproses (Paid)</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $ordersToProcess }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-[#432C7A] text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="text-xs text-[#432C7A] hover:text-[#35205e] font-medium flex items-center">
                            <span>Lihat Pesanan</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Siap Dikirim (Processing)</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $ordersToShip }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box-open text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="text-xs text-yellow-600 hover:text-yellow-700 font-medium flex items-center">
                            <span>Input Resi</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Produk Aktif</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalProducts }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pelanggan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalCustomers }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Orders -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden lg:col-span-2">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Pesanan Masuk Terbaru</h3>
                            <p class="text-gray-600 text-sm">{{ $recentOrders->count() }} pesanan terbaru</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#432C7A] hover:text-[#35205e] font-medium flex items-center">
                            <span>Semua Pesanan</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID / Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">#{{ $order->id }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'paid' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'processing' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                'completed' => 'bg-green-100 text-green-800 border-green-200',
                                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                            ];
                                            $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }} border">
                                            <div class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $order->status == 'paid' ? 'bg-blue-500' : ($order->status == 'processing' ? 'bg-yellow-500' : ($order->status == 'shipped' ? 'bg-purple-500' : ($order->status == 'completed' ? 'bg-green-500' : 'bg-red-500'))) }}"></div>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center text-sm text-[#432C7A] hover:text-[#35205e] font-medium">
                                            <span>Proses</span>
                                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-shopping-cart text-gray-300 text-4xl mb-2"></i>
                                        <p>Belum ada pesanan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Low Stock Products -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-bold text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Perlu Restock
                            </h3>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-4">
                                @forelse($lowStockProducts as $product)
                                <li class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                    <div class="flex-1">
                                        <span class="text-sm font-medium text-gray-800 block">{{ $product->name }}</span>
                                        <div class="flex items-center mt-1">
                                            <div class="w-full max-w-[100px] bg-gray-200 rounded-full h-2 mr-2">
                                                @php
                                                    $stockPercentage = min(100, ($product->stock / 20) * 100);
                                                    $stockColor = $product->stock < 5 ? 'bg-red-500' : 'bg-yellow-500';
                                                @endphp
                                                <div class="h-2 rounded-full {{ $stockColor }}" style="width: {{ $stockPercentage }}%"></div>
                                            </div>
                                            <span class="text-xs font-medium {{ $product->stock < 5 ? 'text-red-500' : 'text-yellow-500' }}">
                                                Sisa: {{ $product->stock }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg border border-gray-200 transition-colors">
                                        Edit Stok
                                    </a>
                                </li>
                                @empty
                                <li class="text-sm text-green-600 bg-green-50 p-3 rounded-lg flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Semua stok aman
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Order Chart -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-sm font-bold text-gray-700">Volume Pesanan (7 Hari Terakhir)</h3>
                        </div>
                        <div class="p-4">
                            <canvas id="orderChart" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('orderChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartDates) !!},
                datasets: [{
                    label: 'Jumlah Order',
                    data: {!! json_encode($chartOrders) !!},
                    backgroundColor: 'rgba(67, 44, 122, 0.7)',
                    borderRadius: 6,
                    barPercentage: 0.7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { display: true, color: 'rgba(0,0,0,0.05)' }
                    },
                    x: { grid: { display: false } }
                },
                plugins: { 
                    legend: { display: false },
                    tooltip: { backgroundColor: '#432C7A' }
                }
            }
        });
    </script>
</x-admin-layout>