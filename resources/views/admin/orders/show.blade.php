<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                                    Detail Pesanan: #{{ $order->invoice_number }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Informasi lengkap dan status pesanan</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <a href="{{ route('admin.orders.index') }}" class="hover:text-[#80489C]">Pesanan</a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">#{{ $order->invoice_number }}</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content - Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Ordered Items -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <i class="fas fa-shopping-bag mr-2 text-[#432C7A]"></i>
                                Barang Dipesan
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                <div class="flex justify-between items-center border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $item->product_name }}</h4>
                                            <p class="text-sm text-gray-500">
                                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="font-bold text-gray-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="border-t-2 border-gray-200 mt-6 pt-6">
                                <div class="flex justify-between items-center text-lg">
                                    <span class="font-bold text-gray-700">Total Barang + Ongkir</span>
                                    <span class="font-bold text-[#432C7A] text-xl">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <i class="fas fa-truck mr-2 text-[#432C7A]"></i>
                                Informasi Pengiriman
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Penerima</p>
                                        <p class="font-bold text-gray-900">{{ $order->name ?? $order->recipient_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">No. HP</p>
                                        <p class="font-bold text-gray-900">{{ $order->phone ?? $order->recipient_phone }}</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Kurir</p>
                                        <p class="font-bold text-gray-900 uppercase">{{ $order->courier }} - {{ $order->shipping_service ?? $order->service }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Resi Saat Ini</p>
                                        <p class="font-bold {{ $order->resi_number ? 'text-green-600' : 'text-gray-400' }}">
                                            @if($order->resi_number)
                                                <i class="fas fa-check-circle mr-1"></i> {{ $order->resi_number }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Alamat Lengkap</p>
                                    <p class="font-medium text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                        {{ $order->address_detail ?? $order->shipping_address }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Status & Actions -->
                <div class="space-y-6">
                    <!-- Order Status -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-[#432C7A]"></i>
                                Status Pesanan
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-center mb-6">
                                @php
                                    $statusColors = [
                                        'paid' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'processing' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'completed' => 'bg-green-100 text-green-800 border-green-200',
                                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                    ];
                                    $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    $statusIcon = [
                                        'paid' => 'fa-credit-card',
                                        'processing' => 'fa-box-open',
                                        'shipped' => 'fa-truck',
                                        'completed' => 'fa-check-circle',
                                        'cancelled' => 'fa-times-circle',
                                    ];
                                    $icon = $statusIcon[$order->status] ?? 'fa-circle';
                                @endphp
                                <div class="text-center">
                                    <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center {{ str_replace('text-', 'bg-', $statusColor) }} bg-opacity-30">
                                        <i class="fas {{ $icon }} text-3xl {{ str_replace('bg-', 'text-', $statusColor) }}"></i>
                                    </div>
                                    <span class="mt-3 inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $statusColor }} border">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </div>
                            </div>

                            @if($order->status == 'paid')
                                <form action="{{ route('admin.orders.process', $order->id) }}" method="POST" class="mt-4">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="w-full bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white py-3 rounded-lg hover:from-[#35205e] hover:to-[#432C7A] shadow-md font-medium flex items-center justify-center transition-all">
                                        <i class="fas fa-box-open mr-2"></i>
                                        Kemas Pesanan
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2 text-center">Klik jika barang sedang disiapkan.</p>
                                </form>
                            @endif

                            @if(in_array($order->status, ['paid', 'processing']))
                                <hr class="my-6 border-gray-200">
                                <form action="{{ route('admin.orders.send', $order->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Input Nomor Resi</label>
                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-barcode text-gray-400"></i>
                                        </div>
                                        <input type="text" name="resi_number" class="pl-10 w-full border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none" placeholder="Contoh: JP12345678" required>
                                    </div>
                                    
                                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 shadow-md font-medium flex items-center justify-center transition-all">
                                        <i class="fas fa-truck mr-2"></i>
                                        Kirim Barang
                                    </button>
                                </form>
                            @endif

                            @if($order->status == 'shipped')
                                <div class="text-center mt-4">
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <i class="fas fa-check-circle text-green-500 text-4xl mb-2"></i>
                                        <p class="text-green-700 font-bold">Pesanan Telah Dikirim</p>
                                        <p class="text-sm text-gray-600 mt-1">Resi: {{ $order->resi_number }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Timeline (Optional) -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-sm font-bold text-gray-700 flex items-center">
                                <i class="fas fa-history mr-2 text-[#432C7A]"></i>
                                Timeline Pesanan
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 text-center">
                                        <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center mx-auto">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Pesanan Dibuat</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                
                                @if($order->paid_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 text-center">
                                        <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center mx-auto">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Pembayaran Dikonfirmasi</p>
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->paid_at)->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                @if($order->resi_number)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 text-center">
                                        <div class="w-5 h-5 rounded-full bg-[#432C7A] flex items-center justify-center mx-auto">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Dikirim dengan Resi: {{ $order->resi_number }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>