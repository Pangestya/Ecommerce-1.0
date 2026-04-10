<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Pembeli</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @php
            $midtransUrl = config('midtrans.isProduction') 
                ? 'https://app.midtrans.com/snap/snap.js' 
                : 'https://app.sandbox.midtrans.com/snap/snap.js';
        @endphp

        <script type="text/javascript"
            src="{{ $midtransUrl }}"
            data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Full Page Styles */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #F0F7FF;
            }
            
            ::-webkit-scrollbar-thumb {
                background: #3B82F6;
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: #2563EB;
            }

            /* Selection Color */
            ::selection {
                background-color: rgba(59, 130, 246, 0.2);
                color: #1E40AF;
            }

            /* Smooth Transitions */
            * {
                transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            }

            /* Full Height Container */
            .full-height-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* Main Content Full Width */
            .main-content-full {
                flex: 1;
                width: 100%;
                max-width: 100%;
            }

            /* Navigation Full Width */
            .navigation-full {
                width: 100%;
                left: 0;
                right: 0;
            }

            /* Content Wrapper */
            .content-wrapper {
                width: 100%;
                padding: 0;
            }

            /* Section Spacing */
            .section-spacing {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            @media (min-width: 640px) {
                .section-spacing {
                    padding-left: 1.5rem;
                    padding-right: 1.5rem;
                }
            }

            @media (min-width: 1024px) {
                .section-spacing {
                    padding-left: 2rem;
                    padding-right: 2rem;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Full Page Container -->
        <div class="full-height-container">
            <!-- Navigation Full Width -->
            @include('layouts.navigation_pembeli')

            <!-- Page Content Full Width -->
            <main class="main-content-full">
                <!-- Page Heading (Full Width) -->
                @isset($header)
                    <header class="bg-gradient-to-r from-blue-50 to-white shadow-sm border-b border-blue-100 navigation-full">
                        <div class="content-wrapper">
                            <div class="section-spacing py-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                                            {{ $header }}
                                        </h2>
                                        @isset($subheader)
                                            <p class="text-blue-600 mt-1">{{ $subheader }}</p>
                                        @endisset
                                    </div>
                                    @isset($headerAction)
                                        <div class="flex items-center space-x-3">
                                            {{ $headerAction }}
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Main Content Area (Full Width) -->
                <div class="content-wrapper">
                    <div class="section-spacing py-8">
                        <!-- Notifications/Alerts (Full Width) -->
                        <div class="mb-6">
                            @if(session('success'))
                                <div class="p-4 bg-green-50 border border-green-200 rounded-lg flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="p-4 bg-red-50 border border-red-200 rounded-lg flex items-center space-x-3">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Main Content Slot (Full Width) -->
                        {{ $slot }}
                    </div>
                </div>
            </main>

            <!-- Footer Full Width -->
            <footer class="bg-gradient-to-r from-blue-50 to-white border-t border-blue-100 mt-8 navigation-full">
                <div class="content-wrapper">
                    <div class="section-spacing py-6">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <div class="mb-4 md:mb-0">
                                <div class="flex items-center space-x-3">
                                    <x-application-logo class="block h-8 w-auto text-blue-600" />
                                    <span class="text-lg font-bold text-blue-700">{{ config('app.name', 'Laravel') }}</span>
                                </div>
                                <p class="text-gray-600 text-sm mt-2">Platform belanja online terpercaya</p>
                            </div>
                            
                            <div class="flex items-center space-x-6">
                                <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Tentang Kami</a>
                                <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Kontak</a>
                                <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Kebijakan Privasi</a>
                                <div class="flex items-center space-x-4">
                                    <a href="#" class="text-gray-400 hover:text-blue-600">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-blue-600">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-blue-600">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="text-center text-gray-500 text-xs mt-6 pt-4 border-t border-blue-100">
                            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Hak cipta dilindungi undang-undang.
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Floating Action Button (Mobile) -->
        <div class="fixed bottom-6 right-6 md:hidden z-50">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                    class="w-12 h-12 bg-blue-500 text-white rounded-full shadow-lg flex items-center justify-center hover:bg-blue-600 transition-all duration-300 hover:shadow-xl">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>

        <!-- JavaScript -->
        <script>
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Auto-dismiss alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    const alerts = document.querySelectorAll('[class*="bg-"]:not(.bg-white):not(.bg-gray-50)');
                    alerts.forEach(alert => {
                        if (alert.classList.contains('bg-green-50') || alert.classList.contains('bg-red-50')) {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    });
                }, 5000);
            });

            // Add active class to current page link
            document.addEventListener('DOMContentLoaded', function() {
                const currentPath = window.location.pathname;
                document.querySelectorAll('a[href]').forEach(link => {
                    if (link.getAttribute('href') === currentPath) {
                        link.classList.add('active');
                    }
                });
            });

            // Make navigation full width on scroll
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('nav');
                if (nav) {
                    if (window.scrollY > 10) {
                        nav.classList.add('shadow-lg');
                    } else {
                        nav.classList.remove('shadow-lg');
                    }
                }
            });

            // Responsive content adjustment
            function adjustContentWidth() {
                const contentElements = document.querySelectorAll('.content-wrapper');
                contentElements.forEach(el => {
                    el.style.maxWidth = '100%';
                    el.style.width = '100%';
                });
            }

            // Adjust on load and resize
            window.addEventListener('load', adjustContentWidth);
            window.addEventListener('resize', adjustContentWidth);
        </script>
    </body>
</html>