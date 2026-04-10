<x-pembeli-layout>
    <div class="bg-gradient-to-b from-blue-50 to-white min-h-screen py-8">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-blue-900">
                        <i class="fas fa-shopping-cart text-blue-600 mr-2"></i> Keranjang Belanja
                    </h1>
                    <p class="text-blue-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i> Pastikan produk sudah sesuai sebelum checkout
                    </p>
                </div>
                <a href="{{ route('pembeli.dashboard') }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-white text-blue-600 border-2 border-blue-200 rounded-xl font-bold hover:bg-blue-50 hover:border-blue-400 transition-all duration-300 shadow-sm hover:shadow">
                    <i class="fas fa-arrow-left mr-2"></i> Lanjut Belanja
                </a>
            </div>

            @if($carts->count() > 0)
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    {{-- Daftar Produk --}}
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                            
                            {{-- Header Table (Desktop) --}}
                            <div class="hidden md:grid grid-cols-12 gap-4 p-4 bg-gradient-to-r from-blue-50 to-white text-sm font-bold text-blue-700 border-b border-blue-100">
                                <div class="col-span-6">Produk</div>
                                <div class="col-span-2 text-center">Harga Satuan</div>
                                <div class="col-span-2 text-center">Jumlah</div>
                                <div class="col-span-2 text-center">Total</div>
                            </div>

                            {{-- Items --}}
                            @foreach($carts as $cart)
                                <div class="p-4 border-b border-blue-100 last:border-0 relative hover:bg-blue-50/30 transition duration-300">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                        
                                        {{-- Produk --}}
                                        <div class="col-span-1 md:col-span-6 flex items-center space-x-4">
                                            {{-- Hapus --}}
                                            <form action="{{ route('pembeli.cart.destroy', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-gray-400 hover:text-red-500 transition p-2 rounded-full hover:bg-red-50"
                                                        title="Hapus Produk">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            {{-- Gambar --}}
                                            <div class="w-20 h-20 bg-gradient-to-b from-blue-50 to-white rounded-lg overflow-hidden border border-blue-200 flex-shrink-0 shadow-sm">
                                                @if($cart->product->image)
                                                    <img src="{{ asset('storage/' . $cart->product->image) }}" 
                                                         class="w-full h-full object-cover"
                                                         loading="lazy">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-blue-300">
                                                        <i class="fas fa-box text-2xl"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Info --}}
                                            <div>
                                                <div class="text-xs text-blue-500 mb-1 font-medium">
                                                    {{ $cart->product->category->name ?? 'Umum' }}
                                                </div>
                                                <a href="{{ route('pembeli.product', $cart->product->id) }}" 
                                                   class="font-bold text-blue-900 hover:text-blue-600 line-clamp-2 leading-tight transition">
                                                    {{ $cart->product->name }}
                                                </a>
                                                <span class="text-xs text-blue-400 md:hidden block mt-1">
                                                    Rp {{ number_format($cart->product->price, 0, ',', '.') }} x {{ $cart->quantity }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Harga Satuan (Desktop) --}}
                                        <div class="hidden md:block col-span-2 text-center text-sm text-blue-600 font-medium">
                                            Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                        </div>

                                        {{-- Quantity --}}
                                        <div class="col-span-1 md:col-span-2 flex justify-center">
                                            <form action="{{ route('pembeli.cart.update', $cart->id) }}" 
                                                  method="POST" 
                                                  class="flex items-center shadow-sm rounded-lg border border-blue-200 bg-white">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $cart->quantity }}" 
                                                       min="1" 
                                                       max="{{ $cart->product->stock }}" 
                                                       class="w-16 text-center border-0 rounded-l-lg text-sm py-1.5 focus:ring-2 focus:ring-blue-500 text-blue-700 font-medium"
                                                       onchange="this.form.submit()">
                                                <button type="submit" 
                                                        class="bg-blue-600 text-white px-2 py-1.5 rounded-r-lg hover:bg-blue-700 transition text-sm flex items-center justify-center"
                                                        title="Update Jumlah">
                                                    <i class="fas fa-sync-alt text-xs"></i>
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Total per Item --}}
                                        <div class="col-span-1 md:col-span-2 text-right md:text-center font-bold text-blue-700 text-lg">
                                            Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Ringkasan --}}
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6 sticky top-24">
                            <div class="flex items-center mb-6 border-b border-blue-100 pb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <h3 class="text-xl font-bold text-blue-900">Ringkasan Pesanan</h3>
                            </div>

                            @php
                                $grandTotal = 0;
                                foreach($carts as $item) {
                                    $grandTotal += ($item->product->price * $item->quantity);
                                }
                            @endphp

                            {{-- Detail --}}
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between items-center text-gray-600 text-sm">
                                    <span>Total Item</span>
                                    <span class="font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-full">
                                        {{ $carts->sum('quantity') }} Pcs
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-gray-600 text-sm">
                                    <span>Subtotal Produk</span>
                                    <span class="font-semibold text-blue-700">
                                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-gray-600 text-sm">
                                    <span>Ongkos Kirim</span>
                                    <span class="text-blue-400 italic bg-blue-50/50 px-2 py-0.5 rounded-full text-xs">
                                        Dihitung di checkout
                                    </span>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="border-t border-blue-100 pt-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-blue-900">Total Sementara</span>
                                    <span class="text-2xl font-extrabold text-blue-600">
                                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Checkout Button --}}
                            <a href="{{ route('pembeli.checkout') }}" 
                               class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-4 rounded-xl font-bold hover:from-blue-700 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center group transform hover:-translate-y-0.5">
                                Checkout Sekarang 
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1.5 transition"></i>
                            </a>

                            {{-- Secure Badge --}}
                            <div class="mt-6 text-center">
                                <p class="text-xs text-blue-400 flex items-center justify-center bg-blue-50/50 py-2.5 rounded-lg">
                                    <i class="fas fa-shield-alt mr-2 text-blue-500"></i> 
                                    Pembayaran Aman & Terpercaya
                                    <i class="fas fa-lock ml-2 text-blue-500 text-[10px]"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-12 text-center max-w-2xl mx-auto mt-10">
                    <div class="w-28 h-28 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shopping-basket text-5xl text-blue-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-900 mb-2">Keranjangmu Masih Kosong</h3>
                    <p class="text-blue-500 mb-8 max-w-md mx-auto">
                        Wah, sepertinya kamu belum memilih barang apapun. Yuk cari produk impianmu sekarang!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('pembeli.dashboard') }}" 
                           class="inline-flex items-center justify-center bg-blue-600 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-store mr-2"></i> Mulai Belanja
                        </a>
                        <a href="{{ route('pembeli.wishlist') }}" 
                           class="inline-flex items-center justify-center bg-white text-blue-600 border-2 border-blue-200 px-8 py-3.5 rounded-xl font-bold hover:bg-blue-50 transition-all duration-300">
                            <i class="fas fa-heart mr-2 text-red-400"></i> Lihat Wishlist
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-pembeli-layout>