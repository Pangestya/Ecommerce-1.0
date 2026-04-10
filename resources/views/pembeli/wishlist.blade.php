<x-pembeli-layout>
    {{-- ================= HEADER WISHLIST ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-8">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">
                            Wishlist <span class="text-blue-600">Saya</span>
                        </h1>
                        <p class="text-sm text-blue-600 mt-1">
                            <i class="fas fa-heart text-red-400 mr-1"></i>
                            {{ $wishlists->count() }} produk tersimpan
                        </p>
                    </div>
                </div>
                
                <a href="{{ route('pembeli.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-blue-200 text-blue-700 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 shadow-sm mt-4 md:mt-0">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali Belanja
                </a>
            </div>
        </div>
    </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-screen">
        
        @if($wishlists->count() > 0)
            {{-- ================= GRID PRODUK WISHLIST ================= --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                @foreach($wishlists as $item)
                    @if($item->product)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-blue-100 hover:border-blue-300 overflow-hidden relative transform hover:-translate-y-1">
                        
                        {{-- Form Hapus (LOGIKA LAMA) --}}
                        <form action="{{ route('pembeli.wishlist.toggle', $item->product->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                            @csrf
                            <button type="submit" 
                                    class="w-8 h-8 bg-white/90 backdrop-blur-sm text-gray-400 hover:text-red-500 rounded-full flex items-center justify-center shadow-md hover:shadow-lg transition-all border border-gray-200"
                                    title="Hapus dari Wishlist">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </form>

                        {{-- Badge Kategori --}}
                        <div class="absolute top-3 left-3 z-10">
                            <span class="px-2.5 py-1 bg-blue-600 text-white text-xs font-medium rounded-full shadow-sm">
                                {{ $item->product->category->name ?? 'Produk' }}
                            </span>
                        </div>

                        {{-- Image Container --}}
                        <div class="relative h-48 md:h-56 bg-gradient-to-b from-blue-50 to-white overflow-hidden">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-blue-300">
                                    <i class="fas fa-box-open text-4xl"></i>
                                </div>
                            @endif

                            {{-- Overlay Stok Habis (LOGIKA LAMA) --}}
                            @if($item->product->stock <= 0)
                                <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                    <span class="bg-red-600 text-white px-3 py-1.5 rounded-lg font-bold text-sm transform -rotate-12 shadow-lg border border-white/30">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> STOK HABIS
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-4">
                            <h3 class="font-bold text-blue-900 text-sm md:text-base mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                <a href="{{ route('pembeli.product', $item->product->id) }}">
                                    {{ $item->product->name }}
                                </a>
                            </h3>
                            
                            {{-- Harga --}}
                            <div class="flex items-center justify-between mb-4">
                                <span class="font-bold text-blue-700 text-lg">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </span>
                                
                                {{-- Stok Indicator (LOGIKA LAMA) --}}
                                <span class="text-xs font-medium px-2 py-1 rounded-full 
                                    {{ $item->product->stock > 10 ? 'bg-green-100 text-green-700' : 
                                       ($item->product->stock > 0 ? 'bg-yellow-100 text-yellow-700' : 
                                       'bg-red-100 text-red-700') }}">
                                    {{ $item->product->stock > 0 ? $item->product->stock . ' tersisa' : 'Habis' }}
                                </span>
                            </div>

                            {{-- Action Button (LOGIKA LAMA) --}}
                            @if($item->product->stock > 0)
                                <a href="{{ route('pembeli.product', $item->product->id) }}" 
                                   class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-2.5 rounded-lg text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Lihat Detail
                                </a>
                            @else
                                <button disabled 
                                        class="block w-full text-center bg-gray-100 text-gray-500 py-2.5 rounded-lg text-sm font-semibold cursor-not-allowed border border-gray-200">
                                    <i class="fas fa-ban mr-2"></i>
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            {{-- Pagination (jika ada) --}}
            @if(method_exists($wishlists, 'links'))
            <div class="mt-12">
                {{ $wishlists->links('vendor.pagination.tailwind') }}
            </div>
            @endif

        @else
            {{-- ================= EMPTY STATE WISHLIST ================= --}}
            <div class="flex flex-col items-center justify-center py-16 md:py-20 bg-white rounded-2xl border-2 border-dashed border-blue-200 shadow-sm text-center">
                <div class="w-28 h-28 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                    <i class="fas fa-heart-broken text-5xl text-red-400"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-blue-900 mb-3">
                    Wishlist <span class="text-blue-600">Masih Kosong</span>
                </h3>
                
                <p class="text-blue-600 max-w-md mb-8 px-4">
                    Kamu belum menyimpan produk apapun. Yuk cari produk favoritmu dan simpan di sini!
                </p>
                
                <a href="{{ route('pembeli.dashboard') }}" 
                   class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Mulai Belanja
                </a>
            </div>
        @endif

        {{-- ================= FEATURE CARDS ================= --}}
        @if($wishlists->count() > 0)
        <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg border border-blue-100 p-3 flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-bolt text-blue-600 text-sm"></i>
                </div>
                <span class="text-xs text-blue-800 font-medium">Checkout Cepat</span>
            </div>
            
            <div class="bg-white rounded-lg border border-blue-100 p-3 flex items-center space-x-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-truck text-green-600 text-sm"></i>
                </div>
                <span class="text-xs text-blue-800 font-medium">Gratis Ongkir</span>
            </div>
            
            <div class="bg-white rounded-lg border border-blue-100 p-3 flex items-center space-x-3">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-yellow-600 text-sm"></i>
                </div>
                <span class="text-xs text-blue-800 font-medium">Garansi Original</span>
            </div>
            
            <div class="bg-white rounded-lg border border-blue-100 p-3 flex items-center space-x-3">
                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-credit-card text-purple-600 text-sm"></i>
                </div>
                <span class="text-xs text-blue-800 font-medium">Pembayaran Mudah</span>
            </div>
        </div>
        @endif
    </div>

    @push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Konfirmasi hapus dari wishlist
        document.querySelectorAll('form[action*="wishlist/toggle"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Hapus produk ini dari wishlist?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
    @endpush

</x-pembeli-layout>