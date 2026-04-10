<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mojoreno Wonogiri - Daftar</title>
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
                    Bergabunglah sekarang untuk pengalaman belanja terbaik
                </p>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6 mb-8">
                @csrf
                
                <!-- Name Input -->
                <div class="text-left">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-indigo-500 mr-2"></i>Nama Lengkap
                    </label>
                    <div class="relative">
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}"
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition-all duration-200"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user-circle text-gray-400"></i>
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="text-left">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>Alamat Email
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autocomplete="email"
                            placeholder="@email.com"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition-all duration-200"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-at text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="text-left">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-key text-indigo-500 mr-2"></i>Kata Sandi
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition-all duration-200"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <button type="button" 
                                onclick="togglePasswordVisibility('password', 'togglePasswordIcon')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-500 transition-colors">
                            <i id="togglePasswordIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Disarankan menggunakan kombinasi huruf angka simbol . Minimal 8 karakter.
                    </p>
                </div>

                <!-- Confirm Password Input -->
                <div class="text-left">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-key text-indigo-500 mr-2"></i>Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Ketik ulang kata sandi"
                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition-all duration-200"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <button type="button" 
                                onclick="togglePasswordVisibility('password_confirmation', 'toggleConfirmPasswordIcon')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-500 transition-colors">
                            <i id="toggleConfirmPasswordIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Register Button -->
                <button type="submit" 
                        class="group w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-center gap-3">
                        <i class="fas fa-user-plus"></i>
                        <span>Daftar Sekarang</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </button>

                <!-- Login Link -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Sudah punya akun?</span>
                    </div>
                </div>

                <a href="{{ route('login') }}" 
                   class="group block w-full py-4 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300">
                    <div class="flex items-center justify-center gap-3">
                        <i class="fas fa-sign-in-alt text-indigo-500"></i>
                        <span>Masuk ke Akun</span>
                    </div>
                </a>
            </form>

            <!-- Footer -->
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} MojorenoShop Wonogiri. <br class="sm:hidden">
                    <span class="hidden sm:inline">•</span> 
                    <span class="sm:ml-1">Bergabung dengan pelanggan yang lain untuk menemukan produk yang kamu cari</span>
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
            
            function togglePasswordVisibility(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>

    </body>
</html>