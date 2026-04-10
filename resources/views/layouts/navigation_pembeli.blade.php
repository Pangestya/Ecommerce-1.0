<nav x-data="{ open: false, dropdownOpen: false }" class="bg-gradient-to-r from-blue-50 to-white border-b border-blue-100 shadow-sm sticky top-0 z-50 navigation-full">
    <!-- Top Bar Full Width -->
    <div class="bg-blue-600 text-white w-full">
        <div class="content-wrapper">
            <div class="section-spacing py-1 flex justify-between items-center text-xs">
                <div class="flex items-center space-x-4">
                    <span><i class="fas fa-truck mr-1"></i> Gratis Ongkir untuk pesanan di atas Rp 100.000</span>
                    <span class="hidden md:inline"><i class="fas fa-shield-alt mr-1"></i> 100% Transaksi Aman</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:text-blue-200">Balai Desa Mojoreno</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Full Width -->
    <div class="content-wrapper">
        <div class="section-spacing">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('pembeli.dashboard') }}" class="flex items-center space-x-3 group">
                            <div class="relative">
                                <x-application-logo class="block h-10 w-auto text-blue-600 group-hover:text-blue-700 transition-colors" />
                                <div class="absolute -inset-1 bg-blue-100 rounded-full opacity-0 group-hover:opacity-50 transition-opacity blur-sm"></div>
                            </div>
                            <div>
                                <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                    {{ config('app.name', 'Laravel') }}
                                </span>
                                <p class="text-xs text-gray-500 -mt-1">Marketplace</p>
                            </div>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:ml-10 md:flex md:items-center md:space-x-1">
                        <x-nav-link :href="route('pembeli.dashboard')" :active="request()->routeIs('pembeli.dashboard')">
                            <div class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:shadow-sm transition-all">
                                <i class="fas fa-home text-blue-500"></i>
                                <span class="font-medium">Beranda</span>
                            </div>
                        </x-nav-link>

                        <x-nav-link :href="route('pembeli.riwayat.index')" :active="request()->routeIs('pembeli.riwayat.index')">
                            <div class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:shadow-sm transition-all">
                                <i class="fas fa-shopping-bag text-blue-500"></i>
                                <span class="font-medium">Manajemen Pesanan</span>
                            </div>
                        </x-nav-link>

                        <x-nav-link :href="route('pembeli.wishlist')" :active="request()->routeIs('pembeli.wishlist')">
                            <div class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:shadow-sm transition-all">
                                <div class="relative">
                                    <i class="fas fa-heart text-blue-500"></i>
                                    @auth
                                        @php
                                            // Hitung jumlah baris di tabel wishlist user ini
                                            $wishlistCount = \App\Models\Wishlist::where('user_id', Auth::id())->count();
                                        @endphp

                                        @if($wishlistCount > 0)
                                            <span class="absolute -top-1.5 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 ring-2 ring-white text-[9px] font-bold text-white">
                                                {{ $wishlistCount }}
                                            </span>
                                        @endif
                                    @endauth
                                </div>
                                <span class="font-medium">Wishlist</span>
                            </div>
                        </x-nav-link>

                        <x-nav-link :href="route('pembeli.bantuan')" :active="request()->routeIs('pembeli.bantuan')">
                            <div class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:shadow-sm transition-all">
                                <i class="fas fa-question-circle text-blue-500"></i>
                                <span class="font-medium">Bantuan</span>
                            </div>
                        </x-nav-link>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl mx-4 hidden lg:block">
                    <div class="relative">
                        <form action="{{ route('pembeli.dashboard') }}" method="GET">
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       placeholder="Cari produk..." 
                                       class="w-full pl-12 pr-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white shadow-sm"
                                       value="{{ request('search') }}">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600 transition-colors">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Cart Icon -->
                    <a href="{{ route('pembeli.cart.index') }}" class="relative p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all group">
                    <i class="fas fa-shopping-cart text-lg group-hover:scale-110 transition"></i>
    
                    @auth
                        @php
                            // Menghitung total quantity barang di keranjang user
                            $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                        @endphp

                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm border border-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    @endauth
                    
                    <span class="ml-2 md:hidden">Keranjang</span> </a>
                    </a>
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all group">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Poin: 1,250</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-blue-100 z-50 overflow-hidden">
                            
                            <!-- User Info -->
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-blue-600">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('pembeli.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 text-gray-700">
                                    <i class="fas fa-home text-blue-500 w-5"></i>
                                    <span>Dashboard</span>
                                </a>

                                <a href="{{ route('pembeli.profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 text-gray-700">
                                    <i class="fas fa-user-circle text-blue-500 w-5"></i>
                                    <span>Profil Saya</span>
                                </a>

                                <a href="{{ route('pembeli.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 text-gray-700">
                                    <i class="fas fa-clipboard-list text-blue-500 w-5"></i>
                                    <span>Pesanan Saya</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center space-x-3 w-full px-4 py-3 hover:bg-red-50 text-red-600">
                                        <i class="fas fa-sign-out-alt w-5"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="open = !open" class="md:hidden p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all">
                        <i class="fas fa-bars text-gray-600 text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Search -->
            <div class="lg:hidden pb-4">
                <div class="relative">
                    <form action="{{ route('pembeli.dashboard') }}" method="GET">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Cari produk..." 
                                   class="w-full pl-12 pr-4 py-3 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white shadow-sm"
                                   value="{{ request('search') }}">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white border-t border-blue-100 shadow-lg navigation-full">
        <div class="content-wrapper">
            <div class="section-spacing py-3 space-y-1">
                <a href="{{ route('pembeli.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700 {{ request()->routeIs('pembeli.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-home text-blue-500 w-5"></i>
                    <span class="font-medium">Beranda</span>
                </a>

                <a href="{{ route('pembeli.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700 {{ request()->routeIs('pembeli.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-shopping-bag text-blue-500 w-5"></i>
                    <span class="font-medium">Produk</span>
                </a>

                <a href="{{ route('pembeli.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700 {{ request()->routeIs('pembeli.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-tags text-blue-500 w-5"></i>
                    <span class="font-medium">Kategori</span>
                </a>

                <a href="{{ route('pembeli.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700 {{ request()->routeIs('pembeli.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-percent text-blue-500 w-5"></i>
                    <span class="font-medium">Promo</span>
                </a>

                <div class="border-t border-blue-100 my-2 pt-3">
                    <div class="px-4 mb-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Akun Saya</p>
                    </div>
                    
                    <a href="{{ route('pembeli.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700">
                        <i class="fas fa-user-edit text-blue-500 w-5"></i>
                        <span>Edit Profil</span>
                    </a>



                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 w-full px-4 py-3 rounded-lg hover:bg-red-50 text-red-600">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Handle logout form submission
    document.addEventListener('DOMContentLoaded', function() {
        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                if (!confirm('Apakah Anda yakin ingin keluar?')) {
                    e.preventDefault();
                }
            });
        }
    });
</script>