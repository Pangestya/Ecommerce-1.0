<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mojoreno Wonogiri - Reset Password</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-md p-8 rounded-3xl shadow-2xl text-center relative overflow-hidden">
            
            <!-- Background decorative elements -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-indigo-100 to-transparent rounded-full -translate-x-16 -translate-y-16"></div>
            <div class="absolute bottom-0 right-0 w-40 h-40 bg-gradient-to-tl from-purple-100 to-transparent rounded-full translate-x-20 translate-y-20"></div>
            
            <!-- Logo Section -->
            <div class="relative mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent tracking-tight">
                    Reset <span class="text-gray-800">Password</span>
                </h1>
                <p class="text-gray-600 mt-3 text-sm">
                    Buat password baru untuk akun Anda
                </p>
            </div>

            <!-- Reset Form -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf
                
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                            value="{{ str_replace('\\', '', old('email', $request->email)) }}"
                            required 
                            autofocus 
                            autocomplete="email"
                            readonly
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl cursor-not-allowed"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <div class="mt-2 p-3 bg-red-50 border border-red-100 rounded-lg text-left">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="text-left">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-key text-indigo-500 mr-2"></i>Password Baru
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Masukkan password baru"
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
                        <div class="mt-2 p-3 bg-red-50 border border-red-100 rounded-lg text-left">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="text-left">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-key text-indigo-500 mr-2"></i>Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Konfirmasi password baru"
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
                        <div class="mt-2 p-3 bg-red-50 border border-red-100 rounded-lg text-left">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Simple Password Tip -->
                <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-xl text-left">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-lightbulb text-indigo-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm text-indigo-700">
                                Disarankan menggunakan kombinasi huruf angka simbol . Minimal 8 karakter.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="group w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-center gap-3">
                        <i class="fas fa-check-circle"></i>
                        <span>Reset Password</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </button>

                <!-- Back to Login Link -->
                <div class="text-center pt-4 border-t border-gray-100">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Login
                    </a>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-gray-100">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} MojorenoShop Wonogiri
                </p>
            </div>
            
        </div>

        <!-- Floating Elements for Visual Interest -->
        <div class="fixed top-10 left-10 w-4 h-4 bg-indigo-300 rounded-full animate-pulse"></div>
        <div class="fixed bottom-20 right-10 w-6 h-6 bg-purple-300 rounded-full animate-pulse delay-1000"></div>

        <!-- Smooth fade-in animation -->
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