<x-pembeli-layout>

    {{-- ================= HERO / FEATURED SLIDER ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-8">

        @if(isset($featuredProducts) && $featuredProducts->count() > 0)

        <div class="relative w-full overflow-hidden h-[400px] md:h-[450px] z-0"
            x-data="{ 
                activeSlide: 0,
                slides: {{ $featuredProducts->count() }},
                timer: null,

                loop() {
                    this.timer = setInterval(() => {
                        this.next()
                    }, 5000)
                },

                next() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides
                },

                prev() {
                    this.activeSlide = this.activeSlide === 0 ? this.slides - 1 : this.activeSlide - 1
                }
            }"
            x-init="loop()"
        >

            {{-- TRACK --}}
            <div class="flex h-full transition-transform duration-700 ease-in-out"
                :style="`transform: translateX(-${activeSlide * 100}%)`">

                @foreach($featuredProducts as $promo)

                {{-- SLIDE --}}
                <div class="w-full flex-shrink-0 h-full relative">

                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400">
                        @if($promo->image)
                            <img src="{{ asset('storage/' . $promo->image) }}"
                                class="w-full h-full object-cover opacity-10 mix-blend-overlay">
                        @endif
                    </div>

                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col md:flex-row items-center justify-between z-10">

                        {{-- TEXT --}}
                        <div class="md:w-1/2 text-white pt-10 md:pt-0 text-center md:text-left">

                            <span class="inline-block px-4 py-1.5 bg-yellow-400 text-blue-800 text-sm font-bold rounded-full mb-4 shadow-lg">
                                <i class="fas fa-star mr-1.5"></i> PRODUK UNGGULAN
                            </span>

                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight drop-shadow-lg">
                                {{ $promo->name }}
                            </h1>

                            <p class="text-lg md:text-xl text-blue-100 mb-6 line-clamp-3 max-w-2xl">
                                {{ $promo->description ?? 'Promo terbaik hari ini' }}
                            </p>

                            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                                <a href="{{ route('pembeli.product', $promo->id) }}"
                                    class="bg-white text-blue-600 px-8 py-3.5 rounded-xl font-bold hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1 shadow-lg flex items-center">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Beli Sekarang
                                </a>

                                <div class="flex flex-col">
                                    <span class="text-sm text-blue-200">Harga Promo</span>
                                    <span class="text-3xl md:text-4xl font-bold text-yellow-300 drop-shadow-md">
                                        Rp {{ number_format($promo->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                        </div>

                        {{-- IMAGE --}}
                        <div class="md:w-1/2 flex justify-center mt-8 md:mt-0">
                            <div class="relative">
                                <div class="absolute -inset-4 bg-blue-400 rounded-full blur-xl opacity-30 animate-pulse"></div>
                                <div class="relative w-56 h-56 md:w-80 md:h-80 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center border-4 border-white/30 shadow-2xl overflow-hidden">
                                    
                                    @if($promo->image)
                                        <img src="{{ asset('storage/' . $promo->image) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-shopping-bag text-8xl text-white/80"></i>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <button @click="prev()" 
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 md:p-4 rounded-full backdrop-blur-md transition-all duration-300 z-30 focus:outline-none shadow-lg">
                <i class="fas fa-chevron-left text-xl md:text-2xl"></i>
            </button>
            
            <button @click="next()" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 md:p-4 rounded-full backdrop-blur-md transition-all duration-300 z-30 focus:outline-none shadow-lg">
                <i class="fas fa-chevron-right text-xl md:text-2xl"></i>
            </button>

            <!-- Progress Indicators -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-30 pointer-events-auto">
                @foreach($featuredProducts as $index => $promo)
                    <button 
                        @click="activeSlide = {{ $index }}"
                        class="h-2 rounded-full transition-all duration-300 focus:outline-none"
                        :class="activeSlide === {{ $index }} 
                            ? 'bg-white w-8 shadow-md' 
                            : 'bg-white/40 w-2 hover:bg-white/70'">
                    </button>
                @endforeach
            </div>
        </div>

        @else

        {{-- ================= BANNER DEFAULT ================= --}}
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-16 h-[400px] flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between w-full">

                <div class="md:w-1/2 text-center md:text-left">
                    <span class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm rounded-full mb-4">
                        <i class="fas fa-gem mr-2"></i> WELCOME TO SHOPHUB
                    </span>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
                        Belanja Hemat,<br>Barang Berkualitas!
                    </h1>

                    <p class="text-lg md:text-xl text-blue-100 mb-6 max-w-xl">
                        Temukan ribuan produk menarik dengan harga terbaik hanya di sini.
                    </p>

                    <a href="#katalog"
                        class="inline-flex items-center bg-white text-blue-600 px-8 py-3.5 rounded-xl font-bold hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1 shadow-lg">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Mulai Belanja
                    </a>
                </div>

                <div class="md:w-1/2 flex justify-center mt-8 md:mt-0">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-blue-400 rounded-full blur-xl opacity-30 animate-pulse"></div>
                        <div class="relative w-64 h-64 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center border-4 border-white/30 shadow-2xl">
                            <i class="fas fa-shopping-bag text-8xl text-white/80"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endif
    </div>

    {{-- ================= CATEGORIES NAVIGATION ================= --}}
    <div class="sticky top-16 z-40 bg-white/95 backdrop-blur-sm border-b border-blue-100 shadow-sm">
        <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center">
                    <h3 class="font-bold text-blue-800 text-lg hidden md:block mr-4">
                        <i class="fas fa-list mr-2"></i> Kategori
                    </h3>
                </div>
            </div>
            <div class="flex space-x-3 overflow-x-auto pb-4 scrollbar-thin">
                <a href="{{ route('pembeli.dashboard') }}" 
                   class="flex-shrink-0 px-5 py-2.5 rounded-xl border-2 transition-all duration-300 flex items-center {{ !request('category') ? 'bg-blue-600 text-white border-blue-600 shadow-lg' : 'bg-white text-blue-700 border-blue-200 hover:border-blue-400 hover:bg-blue-50 hover:shadow-md' }}">
                   <i class="fas fa-th-large mr-2"></i> Semua
                </a>
                
                @foreach($categories as $cat)
                    <a href="{{ route('pembeli.dashboard', ['category' => $cat->slug]) }}" 
                       class="flex-shrink-0 px-5 py-2.5 rounded-xl border-2 transition-all duration-300 flex items-center {{ request('category') == $cat->slug ? 'bg-blue-600 text-white border-blue-600 shadow-lg' : 'bg-white text-blue-700 border-blue-200 hover:border-blue-400 hover:bg-blue-50 hover:shadow-md' }}">
                       <i class="fas {{ 
                           $cat->slug == 'audio' ? 'fa-headphones-alt' : 
                           ($cat->slug == 'wearables' ? 'fa-watch' : 
                           ($cat->slug == 'komputer' ? 'fa-laptop' : 
                           ($cat->slug == 'fotografi' ? 'fa-camera' : 
                           ($cat->slug == 'ponsel' ? 'fa-mobile-alt' : 
                           ($cat->slug == 'tablet' ? 'fa-tablet-alt' : 
                           ($cat->slug == 'gaming' ? 'fa-gamepad' : 'fa-tag')))))) 
                       }} mr-2"></i>
                       {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div id="katalog" class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div class="mb-4 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-bold text-blue-900">
                    @if(request('category'))
                        <span class="text-blue-600">{{ ucfirst(str_replace('-', ' ', request('category'))) }}</span>
                    @else
                        Produk <span class="text-blue-600">Terbaru</span>
                    @endif
                </h2>
                <p class="text-sm text-blue-500 mt-1 flex items-center">
                    <i class="fas fa-box-open mr-2"></i>
                    @if(request('search'))
                        Hasil pencarian untuk "{{ request('search') }}"
                    @else
                        Menampilkan produk berkualitas untuk Anda
                    @endif
                </p>
            </div>
            
            @if(request('search'))
                <div class="flex items-center bg-blue-50 text-blue-700 px-4 py-2.5 rounded-lg text-sm font-medium border border-blue-200">
                    <i class="fas fa-search mr-2"></i> "{{ request('search') }}"
                    <a href="{{ route('pembeli.dashboard') }}" class="ml-3 text-red-500 hover:text-red-700 font-bold" title="Hapus Pencarian">
                        <i class="fas fa-times-circle"></i>
                    </a>
                </div>
            @endif
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-blue-100 overflow-hidden group flex flex-col h-full transform hover:-translate-y-1">
                        
                        <div class="relative h-48 md:h-56 bg-gradient-to-b from-blue-50 to-white overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-blue-300">
                                    <i class="fas fa-box-open text-4xl mb-2"></i>
                                    <span class="text-xs">No Image</span>
                                </div>
                            @endif
                            
                            @if($product->is_featured)
                                <span class="absolute top-3 left-3 bg-yellow-400 text-blue-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm flex items-center">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            @endif

                            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button class="w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center text-blue-600 hover:bg-blue-50">
                                    <i class="fas fa-heart text-sm"></i>
                                </button>
                            </div>

                            <div class="absolute bottom-3 left-3">
                                <span class="bg-blue-600 text-white text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $product->category->name ?? 'Umum' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-bold text-blue-900 text-sm md:text-base mb-2 line-clamp-2 group-hover:text-blue-600 transition flex-grow">
                                <a href="{{ route('pembeli.product', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            
                            @if($product->rating)
                            <div class="flex items-center mb-3">
                                <div class="flex text-yellow-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i == ceil($product->rating) && $product->rating != floor($product->rating))
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs text-blue-500 ml-1">{{ number_format($product->rating, 1) }}</span>
                            </div>
                            @endif
                            
                            <div class="mt-auto">
                                <div class="flex items-end justify-between mb-4">
                                    <div>
                                        <p class="text-xs text-blue-400 mb-0.5">Harga</p>
                                        <span class="font-bold text-blue-600 text-lg">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        @if($product->original_price)
                                            <span class="text-xs text-red-500 line-through ml-1">
                                                Rp {{ number_format($product->original_price, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-blue-400 mb-0.5">Stok</p>
                                        <span class="text-xs font-medium {{ $product->stock > 10 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }} px-2.5 py-1 rounded-full">
                                            {{ $product->stock }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('pembeli.product', $product->id) }}" 
                                       class="flex-1 text-center bg-blue-600 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition flex items-center justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        Detail
                                    </a>
                                    <button class="w-12 bg-blue-50 text-blue-600 py-2.5 rounded-lg text-sm hover:bg-blue-100 transition flex items-center justify-center">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>

        @else
            <div class="flex flex-col items-center justify-center py-16 md:py-20 bg-gradient-to-b from-blue-50 to-white rounded-2xl border-2 border-dashed border-blue-200">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-search text-4xl text-blue-400"></i>
                </div>
                <h3 class="text-xl font-bold text-blue-900 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-blue-600 mt-2 max-w-md text-center mb-6">
                    @if(request('search'))
                        Tidak ada produk yang sesuai dengan pencarian "{{ request('search') }}"
                    @elseif(request('category'))
                        Belum ada produk untuk kategori "{{ ucfirst(str_replace('-', ' ', request('category'))) }}"
                    @else
                        Belum ada produk yang tersedia
                    @endif
                </p>
                <div class="flex space-x-3">
                    <a href="{{ route('pembeli.dashboard') }}" 
                       class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition shadow-md font-medium flex items-center">
                        <i class="fas fa-th-large mr-2"></i>
                        Lihat Semua Produk
                    </a>
                    <a href="#" 
                       class="px-6 py-3 bg-white text-blue-600 border border-blue-200 rounded-xl hover:bg-blue-50 transition font-medium flex items-center">
                        <i class="fas fa-tags mr-2"></i>
                        Lihat Kategori
                    </a>
                </div>
            </div>
        @endif

    </div>

</x-pembeli-layout>