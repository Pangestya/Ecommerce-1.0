<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Daftar Pesanan Masuk') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Kelola semua pesanan pelanggan</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Pesanan</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Semua Pesanan</h3>
                            <p class="text-gray-600 text-sm">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan</p>
                        </div>
                        
                        <!-- Status Filter Tabs -->
                        <div class="flex flex-wrap gap-2 mt-3 md:mt-0">
                            <a href="{{ route('admin.orders.index') }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ !request('status') ? 'bg-[#432C7A] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Semua
                            </a>
                            <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request('status') == 'paid' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                                Siap Proses
                            </a>
                            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request('status') == 'processing' ? 'bg-yellow-600 text-white' : 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' }}">
                                Sedang Dikemas
                            </a>
                            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request('status') == 'shipped' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' }}">
                                Dikirim
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Invoice</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pembeli</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-900">{{ $order->invoice_number }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-sm font-medium text-[#432C7A]">
                                                {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="text-sm text-gray-900">{{ $order->user->name ?? 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'paid' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'processing' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            'pending' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'completed' => 'bg-green-100 text-green-800 border-green-200',
                                        ];
                                        $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        $statusDots = [
                                            'paid' => 'bg-blue-500',
                                            'processing' => 'bg-yellow-500',
                                            'shipped' => 'bg-purple-500',
                                            'pending' => 'bg-orange-500',
                                            'completed' => 'bg-green-500',
                                        ];
                                        $dotClass = $statusDots[$order->status] ?? 'bg-gray-500';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $statusClass }} border">
                                        <div class="w-2 h-2 rounded-full {{ $dotClass }} mr-2"></div>
                                        {{ $order->status == 'paid' ? 'Sudah Bayar' : 
                                           ($order->status == 'processing' ? 'Dikemas' : 
                                           ($order->status == 'shipped' ? 'Dikirim' : 
                                           ($order->status == 'pending' ? 'Pending' : ucfirst($order->status)))) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="far fa-calendar-alt mr-2 text-gray-400"></i>
                                        {{ $order->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-[#432C7A] text-white rounded-lg hover:bg-[#35205e] transition-colors text-xs font-medium">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail & Proses
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="text-sm text-gray-700 mb-4 md:mb-0">
                            Menampilkan <span class="font-medium">{{ $orders->firstItem() }}</span> sampai 
                            <span class="font-medium">{{ $orders->lastItem() }}</span> dari 
                            <span class="font-medium">{{ $orders->total() }}</span> pesanan
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if($orders->onFirstPage())
                                <span class="px-3 py-2 border border-gray-300 rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}" 
                                   class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#432C7A] transition-colors duration-200">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif
                            
                            {{-- Pagination Elements --}}
                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                @if ($page == $orders->currentPage())
                                    <span class="px-3 py-2 border border-[#432C7A] bg-[#432C7A] text-white rounded-md font-medium">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#432C7A] transition-colors duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                            
                            {{-- Next Page Link --}}
                            @if($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}" 
                                   class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#432C7A] transition-colors duration-200">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="px-3 py-2 border border-gray-300 rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>