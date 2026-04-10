<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-color: #432C7A;
                --primary-light: #5a409e;
                --primary-dark: #35205e;
                --sidebar-width: 280px;
                --header-height: 70px;
                --card-shadow: 0 4px 12px rgba(67, 44, 122, 0.1);
            }
            
            body {
                font-family: 'Figtree', sans-serif;
            }
            /* resources/css/app.css - Add these styles */

/* Admin Theme - #432C7A */
            .bg-admin-gradient {
                background: linear-gradient(135deg, #432C7A 0%, #5a409e 100%);
            }

            .text-admin {
                color: #432C7A;
            }

            .bg-admin {
                background-color: #432C7A;
            }

            .bg-admin-light {
                background-color: #5a409e;
            }

            .bg-admin-dark {
                background-color: #35205e;
            }

            .border-admin {
                border-color: #432C7A;
            }

            .hover\:bg-admin-dark:hover {
                background-color: #35205e;
            }

            /* Admin Card Styles */
            .admin-card {
                background: white;
                border-radius: 12px;
                border-left: 4px solid #432C7A;
                box-shadow: 0 4px 12px rgba(67, 44, 122, 0.1);
                transition: all 0.3s ease;
            }

            .admin-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(67, 44, 122, 0.15);
            }

            /* Admin Button Styles */
            .btn-admin {
                background: linear-gradient(135deg, #432C7A 0%, #5a409e 100%);
                color: white;
                transition: all 0.3s ease;
            }

            .btn-admin:hover {
                background: linear-gradient(135deg, #35205e 0%, #432C7A 100%);
                transform: translateY(-1px);
                box-shadow: 0 6px 15px rgba(67, 44, 122, 0.2);
            }

            /* Admin Badge Styles */
            .badge-admin {
                background-color: rgba(67, 44, 122, 0.1);
                color: #432C7A;
                border: 1px solid rgba(67, 44, 122, 0.2);
            }

            /* Focus styles for admin inputs */
            input.admin-focus:focus,
            select.admin-focus:focus,
            textarea.admin-focus:focus {
                border-color: #432C7A;
                box-shadow: 0 0 0 3px rgba(67, 44, 122, 0.1);
            }

            /* Admin Table Styles */
            .admin-table th {
                background-color: #f8f9fa;
                color: #432C7A;
                font-weight: 600;
            }

            .admin-table tr:hover {
                background-color: rgba(67, 44, 122, 0.05);
            }

            /* Status Indicators */
            .status-active {
                background-color: rgba(34, 197, 94, 0.1);
                color: #16a34a;
            }

            .status-inactive {
                background-color: rgba(239, 68, 68, 0.1);
                color: #dc2626;
            }

            .status-pending {
                background-color: rgba(245, 158, 11, 0.1);
                color: #d97706;
            }

            /* Scrollbar styling for admin sidebar */
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

            /* Admin Dashboard Grid */
            .dashboard-grid {
                display: grid;
                gap: 1.5rem;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            /* Responsive adjustments for admin */
            @media (max-width: 768px) {
                .admin-content {
                    padding-left: 0 !important;
                }
                
                .admin-card {
                    margin: 0.5rem;
                }
            }
        </style>
    </head>
    <body class="bg-gray-50">
        <!-- Sidebar Navigation -->
        @include('layouts.navigation_admin')

        <!-- Main Content Area -->
        <div class="ml-0 md:ml-[var(--sidebar-width)] min-h-screen transition-all duration-300">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20" style="height: var(--header-height);">
                <div class="flex items-center justify-between h-full px-6">
                    <div class="flex items-center space-x-4">
                        <button id="sidebar-toggle" class="md:hidden text-gray-700 hover:text-[#432C7A]">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $header ?? 'Admin Panel' }}</h1>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <!-- Notifications -->
                        <button class="relative text-gray-600 hover:text-[#432C7A]">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">5</span>
                        </button>
                        
                        <!-- Quick Actions -->
                        <button class="text-gray-600 hover:text-[#432C7A]">
                            <i class="fas fa-plus-circle text-xl"></i>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#432C7A] to-[#5a409e] flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">Administrator</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-500 hidden md:block"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-30">
                                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user text-gray-500 w-5"></i>
                                    <span>Profile</span>
                                </a>
                                <a href="" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog text-gray-500 w-5"></i>
                                    <span>Settings</span>
                                </a>
                                <div class="border-t border-gray-200 my-2"></div>
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
            <main class="p-6">
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