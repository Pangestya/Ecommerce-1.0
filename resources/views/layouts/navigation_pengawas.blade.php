<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 h-screen bg-gradient-to-b from-[#80489C] to-[#66337a] text-white w-[280px] transition-transform duration-300 md:translate-x-0 -translate-x-full shadow-2xl flex flex-col overflow-hidden">
    
    <!-- Logo Section -->
    <div class="p-6 border-b border-white/10 shrink-0">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-clipboard-check text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold tracking-tight">Supervisor</h2>
                <p class="text-white/60 text-xs font-medium uppercase tracking-wider">Dashboard Pengawas</p>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('pengawas.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 group @if(request()->routeIs('pengawas.dashboard')) bg-white/20 shadow-lg @endif">
                    <div class="w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-tachometer-alt w-5 text-center text-white/80 group-hover:text-white transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Dashboard</span>
                    @if(request()->routeIs('pengawas.dashboard'))
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
            </li>

            <!-- Manajemen User -->
            <li>
                <a href="{{ route('pengawas.users.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 group @if(request()->routeIs('pengawas.users.*')) bg-white/20 shadow-lg @endif">
                    <div class="w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-users-cog w-5 text-center text-white/80 group-hover:text-white transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Manajemen User</span>
                    @if(request()->routeIs('pengawas.users.*'))
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
            </li>

            <!-- Laporan -->
            <li>
                <a href="{{ route('reports.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 group @if(request()->routeIs('reports.*')) bg-white/20 shadow-lg @endif">
                    <div class="w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-file-alt w-5 text-center text-white/80 group-hover:text-white transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Laporan & Analisis</span>
                    @if(request()->routeIs('reports.*'))
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
            </li>

            <!-- Profile -->
            <li>
                <a href="{{ route('pengawas.profile.edit') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 group @if(request()->routeIs('pengawas.profile.*')) bg-white/20 shadow-lg @endif">
                    <div class="w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-user w-5 text-center text-white/80 group-hover:text-white transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Profile Saya</span>
                    @if(request()->routeIs('pengawas.profile.*'))
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
            </li>

            <!-- Audit Trail -->
            <li>
                <a href="{{ route('pengawas.audit.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 group @if(request()->routeIs('pengawas.audit.*')) bg-white/20 shadow-lg @endif">
                    <div class="w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-history w-5 text-center text-white/80 group-hover:text-white transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Audit Trail</span>
                    @if(request()->routeIs('pengawas.audit.*'))
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
            </li>

            <!-- Separator dengan label -->
            <li class="pt-6 mt-6 border-t border-white/10">
                <p class="px-4 text-xs font-semibold text-white/40 uppercase tracking-wider">Lainnya</p>
            </li>

            <!-- Settings (hidden, bisa diaktifkan nanti) -->
            <li class="opacity-50 cursor-not-allowed">
                <div class="flex items-center space-x-3 px-4 py-3 rounded-xl">
                    <div class="w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-cog w-5 text-center text-white/40"></i>
                    </div>
                    <span class="font-medium text-sm text-white/40">Pengaturan</span>
                </div>
            </li>
        </ul>
    </nav>

    <!-- User Profile Footer -->
    <footer class="shrink-0 p-4 border-t border-white/10 bg-black/20 backdrop-blur-sm">
        <div class="flex items-center gap-3">
            <!-- Avatar dengan fallback gradient -->
            <div class="relative">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-white/20 to-white/5 flex items-center justify-center border-2 border-white/30 shadow-lg overflow-hidden">
                    @php
                        $name = Auth::user()->name ?? 'User';
                        $initials = strtoupper(substr($name, 0, 2));
                    @endphp
                    <span class="text-white font-bold text-lg">{{ $initials }}</span>
                </div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white/30"></div>
            </div>
            
            <!-- User Info -->
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Nama User' }}</p>
                <p class="text-xs text-white/60 truncate flex items-center">
                    <i class="fas fa-envelope mr-1 text-[10px]"></i>
                    {{ Auth::user()->email ?? 'email@role.com' }}
                </p>
                <p class="text-xs text-white/40 mt-0.5 flex items-center">
                    <i class="fas fa-shield-alt mr-1 text-[10px]"></i>
                    Role: Pengawas
                </p>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                @csrf
                <button type="submit" 
                        class="p-2.5 text-white/60 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group"
                        title="Logout">
                    <i class="fas fa-sign-out-alt text-lg group-hover:scale-110 transition-transform"></i>
                </button>
            </form>
        </div>
    </footer>

    <!-- Sidebar Collapse Button (Desktop) -->
    <button id="sidebar-collapse" class="absolute -right-3 top-20 hidden md:block w-6 h-6 bg-white rounded-full shadow-lg text-[#80489C] hover:bg-gray-100 transition-all duration-200 z-50">
        <i class="fas fa-chevron-left text-sm"></i>
    </button>
</aside>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 md:hidden transition-opacity duration-300" style="display: none;" onclick="toggleSidebar()"></div>

<!-- Mobile Header (akan muncul di pengawas.blade.php, tapi kita tambahkan toggle di sini) -->
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

    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (!sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
    });

    // Initialize sidebar toggle
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        // Collapse functionality for desktop (optional)
        const collapseBtn = document.getElementById('sidebar-collapse');
        if (collapseBtn) {
            collapseBtn.addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.querySelector('.ml-0.md\\:ml-\\[var\\(--sidebar-width\\)\\]');
                
                if (sidebar.style.width === '80px') {
                    // Expand
                    sidebar.style.width = 'var(--sidebar-width)';
                    mainContent.style.marginLeft = 'var(--sidebar-width)';
                    collapseBtn.innerHTML = '<i class="fas fa-chevron-left text-sm"></i>';
                    
                    // Show text again
                    document.querySelectorAll('#sidebar nav span').forEach(el => el.style.display = 'inline');
                    document.querySelector('#sidebar footer .flex-1').style.display = 'block';
                } else {
                    // Collapse
                    sidebar.style.width = '80px';
                    mainContent.style.marginLeft = '80px';
                    collapseBtn.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
                    
                    // Hide text
                    document.querySelectorAll('#sidebar nav span').forEach(el => el.style.display = 'none');
                    document.querySelector('#sidebar footer .flex-1').style.display = 'none';
                    
                    // Center icons
                    document.querySelectorAll('#sidebar nav a').forEach(el => {
                        el.classList.add('justify-center');
                    });
                }
            });
        }
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
</script>

<!-- Custom Scrollbar Style -->
<style>
    /* Scrollbar styling */
    #sidebar::-webkit-scrollbar {
        width: 4px;
    }
    
    #sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    
    #sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
    }
    
    #sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    /* Active menu indicator animation */
    .active-menu-indicator {
        position: relative;
        overflow: hidden;
    }
    
    .active-menu-indicator::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: white;
        border-radius: 0 4px 4px 0;
        animation: slideIn 0.2s ease-out;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Menu item hover effect */
    .nav-item-hover {
        position: relative;
        overflow: hidden;
    }
    
    .nav-item-hover::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s ease;
    }
    
    .nav-item-hover:hover::after {
        transform: translateX(100%);
    }
</style>