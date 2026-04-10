<x-pembeli-layout>
    {{-- ================= HEADER ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-6">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pembeli.riwayat.index') }}" 
                       class="w-10 h-10 bg-white border-2 border-blue-200 rounded-lg flex items-center justify-center text-blue-600 hover:border-blue-400 hover:bg-blue-50 transition-all duration-300">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">
                            Detail <span class="text-blue-600">Pesanan</span>
                        </h1>
                        <p class="text-sm text-blue-600 mt-1">
                            <i class="fas fa-file-invoice mr-1"></i>
                            Invoice: <span class="font-bold">{{ $order->invoice_number }}</span>
                        </p>
                    </div>
                </div>
                
                {{-- Badge Status --}}
                <div>
                    @if($order->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold border border-yellow-200 shadow-sm">
                            <i class="fas fa-clock mr-1"></i> Menunggu Pembayaran
                        </span>
                    @elseif($order->status == 'paid')
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold border border-green-200 shadow-sm">
                            <i class="fas fa-check mr-1"></i> Lunas
                        </span>
                    @elseif($order->status == 'processing')
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-bold border border-blue-200 shadow-sm">
                            <i class="fas fa-box mr-1"></i> Dikemas
                        </span>
                    @elseif($order->status == 'shipped')
                        <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full text-sm font-bold border border-purple-200 shadow-sm">
                            <i class="fas fa-truck mr-1"></i> Dikirim
                        </span>
                    @elseif($order->status == 'completed')
                        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-bold border border-gray-200 shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i> Selesai
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mb-10">
        <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            
            {{-- ================= STATUS TRACKER (LOGIKA LAMA) ================= --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-white">
                <div class="flex justify-between items-center text-center">
                    {{-- Dibayar --}}
                    <div class="flex flex-col items-center flex-1 {{ in_array($order->status, ['paid', 'processing', 'shipped', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                        <div class="w-12 h-12 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold mb-2 shadow-lg">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <span class="text-xs md:text-sm font-medium">Dibayar</span>
                    </div>
                    
                    <div class="h-1 flex-1 bg-white/30 mx-2"></div>

                    {{-- Dikemas --}}
                    <div class="flex flex-col items-center flex-1 {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                        <div class="w-12 h-12 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold mb-2 shadow-lg">
                            <i class="fas fa-box"></i>
                        </div>
                        <span class="text-xs md:text-sm font-medium">Dikemas</span>
                    </div>

                    <div class="h-1 flex-1 bg-white/30 mx-2"></div>

                    {{-- Dikirim --}}
                    <div class="flex flex-col items-center flex-1 {{ in_array($order->status, ['shipped', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                        <div class="w-12 h-12 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold mb-2 shadow-lg">
                            <i class="fas fa-truck"></i>
                        </div>
                        <span class="text-xs md:text-sm font-medium">Dikirim</span>
                    </div>

                    <div class="h-1 flex-1 bg-white/30 mx-2"></div>

                    {{-- Selesai --}}
                    <div class="flex flex-col items-center flex-1 {{ $order->status == 'completed' ? 'opacity-100' : 'opacity-50' }}">
                        <div class="w-12 h-12 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold mb-2 shadow-lg">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="text-xs md:text-sm font-medium">Selesai</span>
                    </div>
                </div>
            </div>

            {{-- ================= INFO PENGIRIMAN (DIPERBAIKI - ALAMAT LENGKAP) ================= --}}
            <div class="p-6 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Alamat Pengiriman (LENGKAP DARI DATABASE) --}}
                    <div class="bg-white rounded-xl p-5 border border-blue-100 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <h3 class="text-base font-bold text-blue-900">Alamat Pengiriman</h3>
                        </div>
                        
                        <div class="space-y-3">
                            {{-- Nama Penerima & No HP --}}
                            <div class="flex items-start">
                                <div class="w-8 text-blue-400">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="font-bold text-blue-900">{{ $order->name }}</span>
                                    <span class="text-sm text-blue-600 ml-2">({{ $order->phone }})</span>
                                </div>
                            </div>
                            
                            {{-- Detail Alamat --}}
                            <div class="flex items-start">
                                <div class="w-8 text-blue-400">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="flex-1 text-sm text-blue-700 leading-relaxed">
                                    {{ $order->address_detail }}
                                </div>
                            </div>
                            
                            {{-- Kelurahan/Kecamatan/Kota --}}
                            <div class="flex items-start">
                                <div class="w-8 text-blue-400">
                                    <i class="fas fa-map-pin"></i>
                                </div>
                                <div class="flex-1 text-sm text-blue-700">
                                    @if($order->village_name)
                                        Kel. {{ $order->village_name }}, 
                                    @endif
                                    Kec. {{ $order->subdistrict_name }}, 
                                    {{ $order->city_name }}
                                </div>
                            </div>
                            
                            {{-- Provinsi & Kode Pos --}}
                            <div class="flex items-start">
                                <div class="w-8 text-blue-400">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="flex-1 text-sm text-blue-700">
                                    Prov. {{ $order->province_name }}
                                    @if($order->postal_code)
                                        <span class="ml-2 font-medium">- {{ $order->postal_code }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Label Alamat Utama (Jika Ada) --}}
                            @if($order->is_primary ?? false)
                            <div class="mt-2 pt-2 border-t border-blue-100">
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-full">
                                    <i class="fas fa-star mr-1"></i> ALAMAT UTAMA
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Jasa Pengiriman --}}
                    <div class="bg-white rounded-xl p-5 border border-blue-100 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-truck text-blue-600"></i>
                            </div>
                            <h3 class="text-base font-bold text-blue-900">Jasa Pengiriman</h3>
                        </div>
                        
                        <div class="space-y-3">
                            {{-- Kurir & Layanan --}}
                            <div class="flex items-start">
                                <div class="w-8 text-blue-400">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="font-bold text-blue-900 uppercase">{{ $order->courier }}</span>
                                    <span class="text-sm text-blue-600 ml-2">- {{ $order->shipping_service }}</span>
                                </div>
                            </div>
                            
                            {{-- Estimasi --}}
                            <div class="flex items-start">
                                <div class="w-8 text-blue-400">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="flex-1 text-sm text-blue-700">
                                    Estimasi: <span class="font-medium">{{ $order->etd }} hari</span>
                                </div>
                            </div>
                            
                            {{-- No. Resi --}}
                            <div class="flex items-start">
                                <div class="w-8 text-blue-400">
                                    <i class="fas fa-barcode"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-blue-600 mb-1">No. Resi</p>
                                    @if($order->resi_number)
                                        <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-lg font-mono font-bold select-all border border-green-200 shadow-sm">
                                            {{ $order->resi_number }}
                                        </span>
                                    @else
                                        <span class="inline-block bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm italic border border-gray-200">
                                            Belum ada resi
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= RINCIAN PRODUK ================= --}}
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-box text-blue-600"></i>
                    </div>
                    <h3 class="text-base font-bold text-blue-900">Rincian Produk</h3>
                </div>
                
                <div class="space-y-6">
                    @foreach($order->items as $item)
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between border-b border-blue-100 pb-6 last:border-0 last:pb-0">
                        
                        {{-- Bagian Kiri: Gambar & Info Produk --}}
                        <div class="flex gap-4 flex-1">
                            {{-- Gambar --}}
                            <div class="w-20 h-20 bg-gradient-to-b from-blue-50 to-white rounded-xl overflow-hidden border-2 border-blue-100 flex-shrink-0 shadow-sm">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-blue-300">
                                        <i class="fas fa-image text-xl"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Detail Text & Tombol --}}
                            <div class="flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-blue-900 text-sm md:text-base">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-blue-600 mb-2">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>

                                {{-- Tombol Aksi (LOGIKA LAMA) --}}
                                @if($item->product)
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        {{-- Tombol Beli Lagi --}}
                                        <a href="{{ route('pembeli.product', $item->product->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 border-2 border-blue-200 text-blue-700 text-xs font-bold rounded-lg hover:border-blue-400 hover:bg-blue-50 transition shadow-sm">
                                            <i class="fas fa-shopping-bag mr-1"></i> Beli Lagi / Ulas
                                        </a>

                                        {{-- Tombol Ulasan (Hanya jika pesanan selesai) --}}
                                        @if($order->status == 'completed')
                                            <a href="{{ route('pembeli.product', $item->product->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-xs font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-md">
                                                <i class="fas fa-star mr-1"></i> Berikan Ulasan
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-red-500 italic bg-red-50 px-2 py-1 rounded">Produk tidak tersedia</span>
                                @endif
                            </div>
                        </div>

                        {{-- Bagian Kanan: Subtotal --}}
                        <div class="font-bold text-blue-700 text-right mt-2 sm:mt-0">
                            <span class="text-xs text-blue-400 block sm:hidden">Subtotal:</span>
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Total Pembayaran --}}
                <div class="mt-6 pt-6 border-t border-blue-100 space-y-2 bg-blue-50/30 p-4 rounded-xl">
                    <div class="flex justify-between text-sm">
                        <span class="text-blue-700">Subtotal Produk</span>
                        <span class="font-medium text-blue-900">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-blue-700">Ongkos Kirim</span>
                        <span class="font-medium text-blue-900">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold bg-gradient-to-r from-blue-600 to-blue-700 text-white p-3 rounded-lg mt-2">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- ================= STATUS ACTIONS (LOGIKA LAMA) ================= --}}
            @if($order->status == 'shipped')
                <div class="p-6 bg-gradient-to-r from-green-50 to-green-100 border-t border-green-200">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center text-green-700">
                            <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-shipping-fast text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-bold">Pesanan sedang dalam pengiriman</p>
                                <p class="text-sm text-green-600">Jika barang sudah sampai, mohon konfirmasi pesanan diterima.</p>
                            </div>
                        </div>
                        <form action="{{ route('pembeli.riwayat.complete', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" 
                                    class="bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-3 rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 w-full md:w-auto">
                                <i class="fas fa-check-circle mr-2"></i> Pesanan Diterima
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($order->status == 'completed')
                <div class="p-6 bg-gradient-to-r from-blue-50 to-white border-t border-blue-200 text-center">
                    <div class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-full text-sm font-bold border border-gray-300 shadow-sm">
                        <i class="fas fa-check-circle mr-2 text-green-600"></i> Transaksi Selesai
                    </div>
                    <p class="text-sm text-blue-600 mt-3">Terima kasih telah berbelanja di {{ config('app.name') }}!</p>
                </div>
            @endif

        </div>
    </div>

    @push('styles')
    <style>
        /* Custom styles */
        .select-all {
            user-select: all;
        }
    </style>
    @endpush

</x-pembeli-layout>