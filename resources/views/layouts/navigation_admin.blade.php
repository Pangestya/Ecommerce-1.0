<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 h-screen bg-gradient-to-b from-[#432C7A] to-[#35205e] text-white w-[var(--sidebar-width)] overflow-y-auto transition-transform duration-300 md:translate-x-0 -translate-x-full shadow-2xl">
    <!-- Logo & Brand -->
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md">
                <i class="fas fa-store text-[#432C7A] text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold tracking-tight">{{ config('app.name', 'Laravel') }}</h2>
                <p class="text-white/70 text-xs flex items-center">
                    <i class="fas fa-shield-alt mr-1 text-[10px]"></i>
                    Administrator Dashboard
                </p>
            </div>
        </div>
    </div>

    <!-- User Info (Compact) -->
    <div class="px-4 py-3 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/30">
                <span class="text-sm font-bold text-white">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                <p class="text-xs text-white/60 truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4">
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">Menu Utama</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 backdrop-blur-sm shadow-lg' : 'hover:bg-white/10' }}">
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-tachometer-alt text-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"></i>
                        </div>
                        <span class="font-medium text-sm flex-1">Dashboard</span>
                        @if(request()->routeIs('admin.dashboard'))
                            <span class="bg-white/30 text-white text-xs px-2 py-0.5 rounded-full">active</span>
                        @endif
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.products.*') ? 'bg-white/20 backdrop-blur-sm shadow-lg' : 'hover:bg-white/10' }}">
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-box-open text-lg {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"></i>
                        </div>
                        <span class="font-medium text-sm flex-1">Manajemen Produk</span>
                        @if(request()->routeIs('admin.products.*'))
                            <span class="bg-white/30 text-white text-xs px-2 py-0.5 rounded-full">{{ $totalProducts ?? '' }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.orders.*') ? 'bg-white/20 backdrop-blur-sm shadow-lg' : 'hover:bg-white/10' }}">
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-shopping-cart text-lg {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"></i>
                        </div>
                        <span class="font-medium text-sm flex-1">Manajemen Pesanan</span>
                        @php
                            $pendingOrders = \App\Models\Order::where('status', 'paid')->count() ?? 0;
                        @endphp
                        @if($pendingOrders > 0)
                            <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">{{ $pendingOrders }}</span>
                        @endif
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 backdrop-blur-sm shadow-lg' : 'hover:bg-white/10' }}">
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-tags text-lg {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"></i>
                        </div>
                        <span class="font-medium text-sm flex-1">Manajemen Kategori</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.faq.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.faq.*') ? 'bg-white/20 backdrop-blur-sm shadow-lg' : 'hover:bg-white/10' }}">
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-question-circle text-lg {{ request()->routeIs('admin.faq.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"></i>
                        </div>
                        <span class="font-medium text-sm flex-1">Manajemen FAQ</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">Laporan & Pengaturan</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.reports.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.reports.*') ? 'bg-white/20 backdrop-blur-sm shadow-lg' : 'hover:bg-white/10' }}">
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-chart-bar text-lg {{ request()->routeIs('admin.reports.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"></i>
                        </div>
                        <span class="font-medium text-sm flex-1">Laporan Penjualan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.profile.edit') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.profile.*') ? 'bg-white/20 backdrop-blur-sm shadow-lg' : 'hover:bg-white/10' }}">
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-user-cog text-lg {{ request()->routeIs('admin.profile.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"></i>
                        </div>
                        <span class="font-medium text-sm flex-1">Profil Saya</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10 bg-gradient-to-t from-[#35205e] to-transparent">
        <div class="flex items-center justify-between text-xs text-white/50">
            <span>© {{ date('Y') }} {{ config('app.name') }}</span>
            <span>v1.0.0</span>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 md:hidden transition-opacity duration-300" style="display: none;" onclick="toggleSidebar()"></div>

<!-- Mobile Header -->
<div class="md:hidden fixed top-0 left-0 right-0 z-30 bg-white border-b border-gray-200 shadow-sm" style="height: 60px;">
    <div class="flex items-center justify-between h-full px-4">
        <button onclick="toggleSidebar()" class="w-10 h-10 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gradient-to-r from-[#432C7A] to-[#5a409e] rounded-lg flex items-center justify-center shadow-md">
                <i class="fas fa-store text-white text-sm"></i>
            </div>
            <span class="font-bold text-gray-900">{{ config('app.name') }}</span>
        </a>
        
        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#432C7A] to-[#5a409e] flex items-center justify-center text-white font-semibold shadow-md">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
    </div>
</div>

<!-- Spacer for mobile header -->
<div class="md:hidden h-[60px]"></div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        sidebar.classList.toggle('-translate-x-full');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        } else {
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Close sidebar when clicking on a link (mobile)
    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (window.innerWidth < 768) {
                // Don't close if it's the same page (prevent flash)
                if (!this.classList.contains('bg-white/20')) {
                    toggleSidebar();
                }
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth < 768 && !sidebar.classList.contains('-translate-x-full')) {
                toggleSidebar();
            }
        }
    });
    
    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial state for mobile
        if (window.innerWidth < 768) {
            document.getElementById('sidebar').classList.add('-translate-x-full');
        }
        
        // Connect with header toggle button if exists
        const sidebarToggle = document.getElementById('sidebar-toggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
    });
</script>