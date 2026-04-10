<x-pembeli-layout>
    <div class="bg-gradient-to-b from-blue-50 to-white min-h-screen py-8">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb --}}
            <nav class="flex mb-6 text-sm font-medium bg-white/80 backdrop-blur-sm p-3 rounded-xl border border-blue-100 shadow-sm">
                <a href="{{ route('pembeli.dashboard') }}" class="text-blue-600 hover:text-blue-800 transition flex items-center">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
                <span class="mx-2 text-blue-300">/</span>
                <span class="text-blue-500">{{ $product->category->name ?? 'Produk' }}</span>
                <span class="mx-2 text-blue-300">/</span>
                <span class="text-blue-700 font-bold truncate">{{ $product->name }}</span>
            </nav>

            {{-- Main Product Card --}}
            <div class="bg-white rounded-3xl shadow-xl border border-blue-100 overflow-hidden mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    
                    {{-- Gallery --}}
                    <div class="p-6 bg-gradient-to-br from-blue-50/50 to-white flex flex-col" 
                         x-data="{ activeImage: '{{ $product->image ? asset('storage/' . $product->image) : '' }}' }">
                        
                        {{-- Main Image --}}
                        <div class="relative w-full h-[400px] bg-white rounded-2xl border-2 border-blue-100 shadow-lg overflow-hidden mb-4 group flex items-center justify-center p-4">
                            <template x-if="activeImage">
                                <img :src="activeImage" 
                                     class="w-full h-full object-contain group-hover:scale-105 transition duration-500"
                                     loading="lazy">
                            </template>
                            <template x-if="!activeImage">
                                <div class="flex flex-col items-center justify-center text-blue-300">
                                    <i class="fas fa-image text-6xl mb-2"></i>
                                    <span class="text-blue-400">Tidak ada gambar</span>
                                </div>
                            </template>
                            
                            @if($product->is_featured)
                                <span class="absolute top-4 left-4 bg-yellow-400 text-blue-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-md flex items-center">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            @endif
                        </div>

                        {{-- Thumbnails --}}
                        @if($product->image || ($product->images && $product->images->count() > 0))
                            <div class="flex space-x-3 overflow-x-auto pb-2 scrollbar-thin">
                                @if($product->image)
                                <div @click="activeImage = '{{ asset('storage/' . $product->image) }}'" 
                                     class="flex-shrink-0 w-20 h-20 border-2 rounded-xl overflow-hidden cursor-pointer transition-all bg-white shadow-sm"
                                     :class="activeImage === '{{ asset('storage/' . $product->image) }}' 
                                        ? 'border-blue-600 ring-2 ring-blue-200 opacity-100 scale-105' 
                                        : 'border-blue-200 opacity-70 hover:opacity-100 hover:border-blue-400'">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="w-full h-full object-cover"
                                         loading="lazy">
                                </div>
                                @endif

                                @foreach($product->images as $gallery)
                                    <div @click="activeImage = '{{ asset('storage/' . $gallery->image_path) }}'"
                                         class="flex-shrink-0 w-20 h-20 border-2 rounded-xl overflow-hidden cursor-pointer transition-all bg-white shadow-sm"
                                         :class="activeImage === '{{ asset('storage/' . $gallery->image_path) }}' 
                                            ? 'border-blue-600 ring-2 ring-blue-200 opacity-100 scale-105' 
                                            : 'border-blue-200 opacity-70 hover:opacity-100 hover:border-blue-400'">
                                        <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                             class="w-full h-full object-cover"
                                             loading="lazy">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Info Produk --}}
                    <div class="p-8 md:p-10 flex flex-col">
                        {{-- Kategori --}}
                        <div class="mb-4">
                            <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wide rounded-full border border-blue-200">
                                <i class="fas fa-tag mr-1"></i> {{ $product->category->name ?? 'Umum' }}
                            </span>
                        </div>

                        {{-- Nama --}}
                        <h1 class="text-3xl md:text-4xl font-bold text-blue-900 mb-3 leading-tight">{{ $product->name }}</h1>

                        {{-- Rating --}}
                        <div class="flex items-center space-x-3 mb-5">
                            <div class="flex text-yellow-400 text-sm">
                                @php $avgRating = round($product->averageRating()); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-blue-500 text-sm bg-blue-50 px-2 py-0.5 rounded-full">
                                {{ $product->reviews->count() }} Ulasan
                            </span>
                        </div>

                        {{-- Harga & Stok --}}
                        <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-blue-100">
                            <div>
                                <span class="text-xs text-blue-500 block mb-1">Harga</span>
                                <h2 class="text-3xl md:text-4xl font-extrabold text-blue-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </h2>
                            </div>
                            @if($product->stock > 0)
                                <span class="bg-green-100 text-green-700 text-xs px-3 py-1.5 rounded-full font-bold flex items-center border border-green-200">
                                    <i class="fas fa-check-circle mr-1"></i> Stok Tersedia: {{ $product->stock }}
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 text-xs px-3 py-1.5 rounded-full font-bold flex items-center border border-red-200">
                                    <i class="fas fa-times-circle mr-1"></i> Stok Habis
                                </span>
                            @endif
                        </div>

                        {{-- Deskripsi --}}
                        <div class="prose prose-sm text-blue-700 mb-8">
                            <div class="bg-blue-50/30 p-5 rounded-xl border border-blue-100">
                                <h4 class="text-sm font-bold text-blue-800 mb-2 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i> Deskripsi Produk
                                </h4>
                                <p class="leading-relaxed text-blue-600">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="mt-auto">
                            @if($product->stock > 0)
                                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                    
                                    {{-- Add to Cart Form --}}
                                    <form action="{{ route('pembeli.cart.store') }}" method="POST" class="flex-1 flex space-x-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        {{-- Quantity Control --}}
                                        <div class="flex items-center border-2 border-blue-200 rounded-xl w-32 md:w-36 bg-white shadow-sm" 
                                             x-data="{ qty: 1 }"
                                             x-init="$watch('qty', value => document.getElementById('quantity').value = value)">
                                            <button type="button" 
                                                    @click="qty = Math.max(1, qty - 1)"
                                                    class="w-10 h-10 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-l-xl transition font-bold text-xl flex items-center justify-center">
                                                -
                                            </button>
                                            <input type="number" 
                                                   id="quantity" 
                                                   name="quantity" 
                                                   x-model="qty"
                                                   min="1" 
                                                   max="{{ $product->stock }}" 
                                                   class="w-full h-10 text-center border-0 focus:ring-0 text-blue-700 font-bold bg-transparent"
                                                   readonly>
                                            <button type="button" 
                                                    @click="qty = Math.min({{ $product->stock }}, qty + 1)"
                                                    class="w-10 h-10 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-r-xl transition font-bold text-xl flex items-center justify-center">
                                                +
                                            </button>
                                        </div>

                                        <button type="submit" 
                                                class="flex-1 bg-gradient-to-r from-blue-600 to-blue-500 text-white h-11 rounded-xl font-bold hover:from-blue-700 hover:to-blue-600 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center transform active:scale-95">
                                            <i class="fas fa-shopping-cart mr-2"></i> 
                                            <span class="hidden md:inline">Masukkan</span> Keranjang
                                        </button>
                                    </form>

                                    {{-- Wishlist --}}
                                    @php
                                        $isWishlisted = \App\Models\Wishlist::where('user_id', Auth::id())
                                            ->where('product_id', $product->id)
                                            ->exists();
                                    @endphp
                                    
                                    <form action="{{ route('pembeli.wishlist.toggle', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-12 h-11 rounded-xl flex items-center justify-center transition-all duration-300 border-2 
                                                {{ $isWishlisted 
                                                    ? 'bg-red-50 text-red-500 border-red-200 hover:bg-red-100 hover:border-red-300' 
                                                    : 'bg-white text-gray-400 border-blue-200 hover:text-red-500 hover:bg-red-50 hover:border-red-200' }}"
                                                title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                                            <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart text-xl"></i>
                                        </button>
                                    </form>

                                </div>
                            @else
                                <button disabled 
                                        class="w-full bg-gray-200 text-gray-500 h-12 rounded-xl font-bold cursor-not-allowed flex items-center justify-center border border-gray-300">
                                    <i class="fas fa-lock mr-2"></i> Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ulasan --}}
            <div class="bg-white rounded-3xl shadow-lg border border-blue-100 p-8 mb-12">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-star text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-blue-900">Ulasan Pelanggan</h3>
                            <p class="text-sm text-blue-500">Rating & review produk</p>
                        </div>
                    </div>
                    <div class="text-right bg-gradient-to-r from-blue-50 to-white p-3 rounded-xl border border-blue-100">
                        <div class="text-3xl font-bold text-blue-600">{{ number_format($product->averageRating(), 1) }}<span class="text-lg text-blue-400">/5</span></div>
                        <div class="text-xs text-blue-500">Berdasarkan {{ $product->reviews->count() }} ulasan</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    {{-- Form Ulasan --}}
                    <div class="lg:col-span-1">
                        @auth
                            <div class="bg-gradient-to-br from-blue-50/70 to-white rounded-2xl p-6 border border-blue-100 shadow-sm">
                                <h4 class="font-bold text-blue-900 mb-4 flex items-center">
                                    <i class="fas fa-pencil-alt mr-2 text-blue-500"></i>
                                    Tulis Ulasan Anda
                                </h4>
                                <form action="{{ route('pembeli.reviews.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="mb-4" x-data="{ currentRating: 0, hoverRating: 0 }">
                                        <label class="block text-xs font-bold text-blue-600 uppercase tracking-wide mb-2">Rating</label>
                                        <div class="flex space-x-2">
                                            <template x-for="star in 5">
                                                <button type="button" 
                                                        @mouseenter="hoverRating = star" 
                                                        @mouseleave="hoverRating = 0"
                                                        @click="currentRating = star"
                                                        class="focus:outline-none transition transform hover:scale-110">
                                                    <i class="fas fa-star text-2xl transition-colors duration-200"
                                                       :class="(hoverRating >= star || currentRating >= star) ? 'text-yellow-400' : 'text-gray-300'"></i>
                                                </button>
                                            </template>
                                        </div>
                                        <input type="hidden" name="rating" :value="currentRating" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-xs font-bold text-blue-600 uppercase tracking-wide mb-2">Komentar</label>
                                        <textarea name="comment" rows="4" 
                                                  class="w-full rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm p-3"
                                                  placeholder="Bagaimana kualitas produk ini?" required></textarea>
                                    </div>

                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-2.5 rounded-xl font-bold hover:from-blue-700 hover:to-blue-600 transition-all duration-300 shadow-md">
                                        <i class="fas fa-paper-plane mr-2"></i> Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="bg-blue-50 p-6 rounded-xl border border-blue-200 text-center">
                                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-lock text-blue-500 text-xl"></i>
                                </div>
                                <p class="text-blue-700 text-sm mb-3">Silakan login untuk memberikan ulasan</p>
                                <a href="{{ route('login') }}" 
                                   class="inline-block bg-blue-600 text-white px-5 py-2 rounded-full text-sm font-bold hover:bg-blue-700 transition shadow-md">
                                    <i class="fas fa-sign-in-alt mr-1"></i> Login
                                </a>
                            </div>
                        @endauth
                    </div>

                    {{-- Daftar Ulasan --}}
                    <div class="lg:col-span-2">
                        <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2 scrollbar-thin">
                            @forelse($product->reviews as $review)
                                <div class="flex space-x-4 border-b border-blue-100 pb-6 last:border-0 last:pb-0 hover:bg-blue-50/30 p-3 rounded-xl transition">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $review->user->avatar ? asset('storage/'.$review->user->avatar) : 'https://ui-avatars.com/api/?background=3B82F6&color=fff&name='.urlencode($review->user->name) }}" 
                                             class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-100"
                                             loading="lazy">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <h5 class="font-bold text-blue-900">{{ $review->user->name }}</h5>
                                            <span class="text-xs bg-blue-50 px-2 py-1 rounded-full text-blue-600">
                                                {{ $review->created_at->isoFormat('D MMM Y') }}
                                            </span>
                                        </div>
                                        <div class="flex text-yellow-400 text-xs mb-2">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-200' }}"></i>
                                            @endfor
                                        </div>
                                        <p class="text-blue-700 text-sm leading-relaxed bg-white p-3 rounded-xl border border-blue-100">
                                            {{ $review->comment }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 mb-4">
                                        <i class="far fa-comment-dots text-3xl text-blue-500"></i>
                                    </div>
                                    <p class="text-blue-700 font-medium">Belum ada ulasan untuk produk ini.</p>
                                    <p class="text-blue-400 text-sm mt-1">Jadilah yang pertama memberikan penilaian!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produk Serupa --}}
            @if($relatedProducts->count() > 0)
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h3 class="text-xl font-bold text-blue-900">Produk Serupa</h3>
                        </div>
                        <a href="{{ route('pembeli.dashboard', ['category' => $product->category->slug]) }}" 
                           class="text-sm bg-blue-50 text-blue-600 px-4 py-2 rounded-full font-bold hover:bg-blue-100 transition border border-blue-200">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $rel)
                            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-blue-100 overflow-hidden group">
                                <div class="relative h-48 bg-gradient-to-b from-blue-50 to-white overflow-hidden">
                                    @if($rel->image)
                                        <img src="{{ asset('storage/' . $rel->image) }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                             loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-blue-300">
                                            <i class="fas fa-box text-3xl"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute inset-0 bg-blue-900/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <a href="{{ route('pembeli.product', $rel->id) }}" 
                                           class="bg-white text-blue-600 px-4 py-2 rounded-full text-xs font-bold shadow-lg transform translate-y-2 group-hover:translate-y-0 transition border-2 border-white">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-blue-900 text-sm truncate mb-1">{{ $rel->name }}</h4>
                                    <div class="flex items-center justify-between">
                                        <span class="text-blue-600 font-bold">Rp {{ number_format($rel->price, 0, ',', '.') }}</span>
                                        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">{{ $rel->category->name ?? 'Umum' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-pembeli-layout>