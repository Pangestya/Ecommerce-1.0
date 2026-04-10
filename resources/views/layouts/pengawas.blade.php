<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Supervisor Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-color: #80489C;
                --primary-light: #9a65b3;
                --primary-dark: #66337a;
                --sidebar-width: 280px;
                --header-height: 70px;
                --card-shadow: 0 4px 12px rgba(128, 72, 156, 0.1);
            }
            
            body {
                font-family: 'Figtree', sans-serif;
            }
            /* Custom Purple Theme */
            .bg-gradient-sidebar {
                background: linear-gradient(180deg, #80489C 0%, #66337a 100%);
            }

            .text-primary {
                color: #80489C;
            }

            .bg-primary {
                background-color: #80489C;
            }

            .bg-primary-light {
                background-color: #9a65b3;
            }

            .border-primary {
                border-color: #80489C;
            }

            .hover\:bg-primary-dark:hover {
                background-color: #66337a;
            }

            /* Card hover effects */
            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px rgba(128, 72, 156, 0.15);
            }

            /* Custom scrollbar for sidebar */
            #sidebar::-webkit-scrollbar {
                width: 6px;
            }

            #sidebar::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }

            #sidebar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 10px;
            }

            #sidebar::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.5);
            }

            /* Animation for active menu */
            .active-menu {
                position: relative;
            }

            .active-menu::after {
                content: '';
                position: absolute;
                right: -16px;
                top: 50%;
                transform: translateY(-50%);
                width: 4px;
                height: 24px;
                background-color: white;
                border-radius: 2px 0 0 2px;
            }

            /* Stats badges */
            .stat-badge {
                font-size: 0.7rem;
                padding: 2px 8px;
                border-radius: 12px;
                font-weight: 600;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .main-content {
                    padding-left: 0 !important;
                }
            }
        </style>
    </head>
    <body class="bg-gray-50">
        <!-- Sidebar Navigation -->
        @include('layouts.navigation_pengawas')

        <!-- Main Content Area -->
        <div class="ml-0 md:ml-[var(--sidebar-width)] min-h-screen transition-all duration-300">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20" style="height: var(--header-height);">
                <div class="flex items-center justify-between h-full px-6">
                    <div class="flex items-center space-x-4">
                        <button id="sidebar-toggle" class="md:hidden text-gray-700 hover:text-[#80489C]">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $header ?? 'Supervisor Panel' }}</h1>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <!-- Notifications -->
                        <button class="relative text-gray-600 hover:text-[#80489C]">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#80489C] to-[#9a65b3] flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">Supervisor</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-500 hidden md:block"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-30">
                                <a href="{{ route('pengawas.profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user text-gray-500 w-5"></i>
                                    <span>Profile</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-3 w-full px-4 py-3 text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt text-red-500 w-5"></i>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
                <main class="p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
        </div>

        <script>
            // Toggle sidebar for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('shadow-2xl');
            });
            
            // Close sidebar when clicking on a link (mobile)
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        const sidebar = document.getElementById('sidebar');
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('shadow-2xl');
                    }
                });
            });
            
            // Responsive sidebar behavior
            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.remove('shadow-2xl');
                }
            });
        </script>
    </body>
</html>