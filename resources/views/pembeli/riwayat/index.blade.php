<x-pembeli-layout>
    {{-- ================= HEADER ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-6">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-history text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-blue-900">
                        Riwayat <span class="text-blue-600">Pesanan</span>
                    </h1>
                    <p class="text-sm text-blue-600 mt-1">
                        <i class="fas fa-shopping-bag mr-1"></i>
                        Lihat dan lacak status pesanan Anda
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Inisialisasi State AlpineJS (LOGIKA LAMA) --}}
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-4 min-h-screen" x-data="{ activeTab: 'all' }">

        {{-- ================= TAB FILTER ================= --}}
        <div class="flex space-x-2 mb-8 overflow-x-auto pb-2 scrollbar-hide" x-data>
            
            {{-- Tombol SEMUA --}}
            <button @click="activeTab = 'all'" 
                :class="activeTab === 'all' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg border-blue-600' : 'bg-white text-blue-700 border-blue-200 hover:border-blue-400 hover:bg-blue-50'"
                class="whitespace-nowrap px-5 py-2.5 rounded-xl text-sm font-bold border-2 transition-all duration-300 focus:outline-none shadow-sm hover:shadow">
                <i class="fas fa-th-large mr-1"></i>
                Semua
            </button>

            {{-- Tombol BELUM BAYAR --}}
            <button @click="activeTab = 'pending'" 
                :class="activeTab === 'pending' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg border-blue-600' : 'bg-white text-blue-700 border-blue-200 hover:border-blue-400 hover:bg-blue-50'"
                class="whitespace-nowrap px-5 py-2.5 rounded-xl text-sm font-bold border-2 transition-all duration-300 focus:outline-none shadow-sm hover:shadow">
                <i class="fas fa-clock mr-1 text-yellow-500"></i>
                Belum Bayar
            </button>

            {{-- Tombol DIPROSES (Paid + Processing) --}}
            <button @click="activeTab = 'diproses'" 
                :class="activeTab === 'diproses' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg border-blue-600' : 'bg-white text-blue-700 border-blue-200 hover:border-blue-400 hover:bg-blue-50'"
                class="whitespace-nowrap px-5 py-2.5 rounded-xl text-sm font-bold border-2 transition-all duration-300 focus:outline-none shadow-sm hover:shadow">
                <i class="fas fa-box mr-1 text-blue-500"></i>
                Diproses
            </button>

            {{-- Tombol DIKIRIM --}}
            <button @click="activeTab = 'shipped'" 
                :class="activeTab === 'shipped' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg border-blue-600' : 'bg-white text-blue-700 border-blue-200 hover:border-blue-400 hover:bg-blue-50'"
                class="whitespace-nowrap px-5 py-2.5 rounded-xl text-sm font-bold border-2 transition-all duration-300 focus:outline-none shadow-sm hover:shadow">
                <i class="fas fa-truck mr-1 text-purple-500"></i>
                Dikirim
            </button>

            {{-- Tombol SELESAI --}}
            <button @click="activeTab = 'completed'" 
                :class="activeTab === 'completed' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg border-blue-600' : 'bg-white text-blue-700 border-blue-200 hover:border-blue-400 hover:bg-blue-50'"
                class="whitespace-nowrap px-5 py-2.5 rounded-xl text-sm font-bold border-2 transition-all duration-300 focus:outline-none shadow-sm hover:shadow">
                <i class="fas fa-check-circle mr-1 text-green-500"></i>
                Selesai
            </button>
        </div>

        {{-- ================= LIST PESANAN ================= --}}
        <div class="space-y-6">
            @forelse($orders as $order)
            
            {{-- LOGIKA FILTER (LOGIKA LAMA) --}}
            <div x-show="activeTab === 'all' || 
                         (activeTab === '{{ $order->status }}') || 
                         (activeTab === 'diproses' && ['paid', 'processing'].includes('{{ $order->status }}'))"
                 x-transition.duration.300ms
                 class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                
                {{-- Header Card --}}
                <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="flex items-center space-x-3 mb-2 md:mb-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-receipt text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <span class="font-bold text-blue-900 mr-2">{{ $order->invoice_number }}</span>
                            <span class="text-xs text-blue-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                    
                    {{-- Badge Status --}}
                    <div>
                        @if($order->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full text-xs font-bold border border-yellow-200 shadow-sm">
                                <i class="fas fa-clock mr-1"></i> Menunggu Pembayaran
                            </span>
                        @elseif($order->status == 'paid')
                            <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-xs font-bold border border-green-200 shadow-sm">
                                <i class="fas fa-check mr-1"></i> Lunas
                            </span>
                        @elseif($order->status == 'processing')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-xs font-bold border border-blue-200 shadow-sm">
                                <i class="fas fa-box mr-1"></i> Dikemas
                            </span>
                        @elseif($order->status == 'shipped')
                            <span class="bg-purple-100 text-purple-700 px-3 py-1.5 rounded-full text-xs font-bold border border-purple-200 shadow-sm">
                                <i class="fas fa-truck mr-1"></i> Dikirim
                            </span>
                        @elseif($order->status == 'completed')
                            <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-bold border border-gray-200 shadow-sm">
                                <i class="fas fa-check-circle mr-1"></i> Selesai
                            </span>
                        @elseif($order->status == 'cancelled')
                            <span class="bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-xs font-bold border border-red-200 shadow-sm">
                                <i class="fas fa-times mr-1"></i> Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Daftar Produk --}}
                <div class="p-6">
                    @foreach($order->items as $item)
                    <div class="flex items-start gap-4 mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-0 border-blue-100">
                        <div class="w-16 h-16 bg-gradient-to-b from-blue-50 to-white rounded-xl flex-shrink-0 overflow-hidden border border-blue-200 shadow-sm">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-blue-300">
                                    <i class="fas fa-box-open"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-blue-900 line-clamp-1">{{ $item->product_name }}</h4>
                            <p class="text-xs text-blue-500 mb-1">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-semibold text-blue-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Footer Card --}}
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-white border-t border-blue-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calculator text-blue-600 text-xs"></i>
                        </div>
                        <div class="text-sm">
                            <span class="text-blue-500">Total Pesanan:</span>
                            <span class="text-xl font-bold text-blue-700 ml-2">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto">
                        <a href="{{ route('pembeli.riwayat.show', $order->id) }}" 
                           class="flex-1 md:flex-none text-center px-5 py-2.5 bg-white border-2 border-blue-200 text-blue-700 rounded-xl text-sm font-semibold hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center">
                            <i class="fas fa-eye mr-2"></i>
                            Detail
                        </a>

                        @if($order->status == 'pending')
                            <button onclick="snap.pay('{{ $order->snap_token }}')" 
                                    class="flex-1 md:flex-none bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                                <i class="fas fa-credit-card mr-2"></i>
                                Bayar Sekarang
                            </button>
                        @endif
                        
                        @if($order->status == 'shipped')
                            <form action="{{ route('pembeli.riwayat.complete', $order->id) }}" method="POST" class="flex-1 md:flex-none">
                                @csrf @method('PATCH')
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Terima
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            {{-- ================= EMPTY STATE ================= --}}
            <div class="flex flex-col items-center justify-center py-16 md:py-20 bg-white rounded-2xl border-2 border-dashed border-blue-200 shadow-sm text-center">
                <div class="w-28 h-28 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                    <i class="fas fa-shopping-bag text-5xl text-blue-400"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-blue-900 mb-3">
                    Belum Ada <span class="text-blue-600">Pesanan</span>
                </h3>
                
                <p class="text-blue-600 max-w-md mb-8 px-4">
                    Kamu belum pernah berbelanja. Yuk cari produk favoritmu sekarang!
                </p>
                
                <a href="{{ route('pembeli.dashboard') }}" 
                   class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Mulai Belanja
                </a>
            </div>
            @endforelse
        </div>
    </div>

    @push('styles')
    <style>
        /* Hide scrollbar */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Line clamp */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Transition for Alpine.js */
        [x-cloak] { display: none !important; }
    </style>
    @endpush

</x-pembeli-layout>