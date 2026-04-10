<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mojoreno Wonogiri</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-lg p-8 rounded-3xl shadow-2xl text-center relative overflow-hidden">
            
            <!-- Background decorative elements -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-indigo-100 to-transparent rounded-full -translate-x-16 -translate-y-16"></div>
            <div class="absolute bottom-0 right-0 w-40 h-40 bg-gradient-to-tl from-purple-100 to-transparent rounded-full translate-x-20 translate-y-20"></div>
            
            <!-- Logo Section -->
            <div class="relative mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-store text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent tracking-tight">
                    Mojoreno<span class="text-gray-800">Shop</span>
                </h1>
                <p class="text-gray-600 mt-3 flex items-center justify-center gap-2">
                    <i class="fas fa-map-marker-alt text-indigo-500"></i>
                    Pusat Belanja Online Wonogiri
                </p>
                <p class="text-sm text-gray-400 mt-2 max-w-md mx-auto">
                    Belanja mudah, aman, dan terpercaya dengan produk asli Wonogiri
                </p>
            </div>

            <!-- Main Content -->
            <div class="relative space-y-4 mb-8">
                @if (Route::has('login'))
                    @auth
                        @php
                            $role = Auth::user()->role;
                            $dashboardRoute = match($role) {
                                1 => route('admin.dashboard'),
                                2 => route('pengawas.dashboard'),
                                3 => route('pembeli.dashboard'),
                                default => route('dashboard'),
                            };
                            
                            $roleNames = [
                                1 => 'Administrator',
                                2 => 'Pengawas',
                                3 => 'Pembeli'
                            ];
                            $roleName = $roleNames[$role] ?? 'Pengguna';
                        @endphp
                        
                        <!-- User Info Card -->
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-5 rounded-xl border border-indigo-100 shadow-sm mb-6 text-left transform transition-all hover:scale-[1.02]">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-medium rounded-full">
                                            <i class="fas fa-user-shield mr-1"></i>{{ $roleName }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            <i class="far fa-clock mr-1"></i>Login aktif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dashboard Button -->
                        <a href="{{ $dashboardRoute }}" 
                           class="group block w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <div class="flex items-center justify-center gap-3">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Buka Dashboard</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>
                        
                        <!-- Logout Option -->
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" 
                                    class="text-sm text-gray-500 hover:text-red-600 transition-colors duration-200 flex items-center justify-center gap-2 mx-auto">
                                <i class="fas fa-sign-out-alt"></i>
                                Keluar Akun
                            </button>
                        </form>
                    @else
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" 
                           class="group block w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <div class="flex items-center justify-center gap-3">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Masuk ke Akun</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        @if (Route::has('register'))
                            <!-- Register Button -->
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-2 bg-white text-gray-500">atau</span>
                                </div>
                            </div>

                            <a href="{{ route('register') }}" 
                               class="group block w-full py-4 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300">
                                <div class="flex items-center justify-center gap-3">
                                    <i class="fas fa-user-plus text-indigo-500"></i>
                                    <span>Buat Akun Baru</span>
                                </div>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Features Section -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="text-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <p class="text-xs font-medium text-gray-700">Aman</p>
                </div>
                <div class="text-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <p class="text-xs font-medium text-gray-700">Cepat</p>
                </div>
                <div class="text-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <p class="text-xs font-medium text-gray-700">Terpercaya</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-10 pt-8 border-t border-gray-100">
                <div class="flex justify-center space-x-6 mb-4">
                    <a href="#" class="text-gray-400 hover:text-indigo-500 transition-colors">
                        <i class="fab fa-facebook text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-500 transition-colors">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </a>
                </div>
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} MojorenoShop Wonogiri. <br class="sm:hidden">
                    <span class="hidden sm:inline">•</span> 
                    <span class="sm:ml-1">All rights reserved.</span>
                </p>
            </div>
            
        </div>

        <!-- Floating Elements for Visual Interest -->
        <div class="fixed top-10 left-10 w-4 h-4 bg-indigo-300 rounded-full animate-pulse"></div>
        <div class="fixed bottom-20 right-10 w-6 h-6 bg-purple-300 rounded-full animate-pulse delay-1000"></div>

        <!-- Optional: Add smooth fade-in animation -->
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fadeIn 0.5s ease-out;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.bg-white').classList.add('animate-fade-in');
            });
        </script>

    </body>
</html>