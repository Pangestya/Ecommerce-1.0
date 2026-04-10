<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
            <div>
                <h2 class="font-bold text-2xl md:text-3xl text-gray-900 leading-tight">
                    {{ __('Edit Profil Admin') }}
                </h2>
                <p class="text-gray-600 text-sm md:text-base mt-1">Kelola informasi akun dan keamanan Anda</p>
            </div>
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Profile</span>
        </div>
    </div>

    <div class="py-6 md:py-8">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            <div class="mb-6 space-y-4">
                @if (session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 p-5 rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-lg">{{ session('success') }}</p>
                                <p class="text-green-700 mt-1">Perubahan berhasil disimpan</p>
                            </div>
                            <button class="ml-auto text-green-600 hover:text-green-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 p-5 rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-lg">{{ session('error') }}</p>
                                <p class="text-red-700 mt-1">Terjadi kesalahan</p>
                            </div>
                            <button class="ml-auto text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- User Profile Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-[#432C7A] to-[#5a409e] px-6 py-8 md:py-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-24 h-24 rounded-full bg-white/20 border-4 border-white/30 flex items-center justify-center mr-6 shadow-lg">
                                <span class="text-white text-4xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="text-white">
                                <h3 class="text-2xl md:text-3xl font-bold mb-2">{{ $user->name }}</h3>
                                <div class="flex items-center space-x-4 mb-3">
                                    <p class="text-white/90 flex items-center">
                                        <i class="fas fa-envelope mr-2"></i>{{ $user->email }}
                                    </p>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-white/20 text-white text-sm px-4 py-1.5 rounded-full flex items-center">
                                        <i class="fas fa-user-shield mr-2"></i> 
                                        admin
                                    </span>
                                    <span class="bg-white/20 text-white text-sm px-4 py-1.5 rounded-full flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i> 
                                        Bergabung {{ $user->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 md:mt-0 text-center md:text-right">
                            <div class="inline-flex flex-col items-center md:items-end">
                                <span class="text-white/80 text-sm mb-2">ID Pengguna</span>
                                <span class="text-white text-2xl font-bold bg-white/10 px-4 py-2 rounded-lg">
                                    #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Management Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                <!-- Left Column -->
                <div class="space-y-6 md:space-y-8">
                    <!-- Informasi Profil Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-5 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-[#432C7A] to-[#5a409e] rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class="fas fa-user-edit text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Informasi Profil</h3>
                                    <p class="text-sm text-gray-600">Update nama akun dan alamat email profil Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-6" id="profileForm">
                                @csrf
                                @method('patch')

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                        <div class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs mr-2">1</div>
                                        Nama Lengkap <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input id="name" 
                                               name="name" 
                                               type="text" 
                                               class="pl-12 pr-4 py-4 w-full border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-100 focus:border-[#432C7A] focus:outline-none"
                                               value="{{ old('name', $user->name) }}" 
                                               required 
                                               autofocus 
                                               placeholder="Masukkan nama lengkap"/>
                                    </div>
                                    @error('name') 
                                        <div class="mt-3 flex items-center text-red-600 text-sm bg-red-50 px-4 py-2 rounded-lg">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                        <div class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs mr-2">2</div>
                                        Alamat Email <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input id="email" 
                                               name="email" 
                                               type="email" 
                                               class="pl-12 pr-4 py-4 w-full border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-100 focus:border-[#432C7A] focus:outline-none"
                                               value="{{ old('email', $user->email) }}" 
                                               required 
                                               placeholder="contoh@email.com"/>
                                    </div>
                                    @error('email') 
                                        <div class="mt-3 flex items-center text-red-600 text-sm bg-red-50 px-4 py-2 rounded-lg">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Role Information --}}
                                <div class="bg-gradient-to-r from-gray-50 to-purple-50 border border-gray-200 rounded-xl p-5 mt-4">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-r from-[#432C7A] to-[#5a409e] rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                            <i class="fas fa-user-shield text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-medium">Role / Jabatan</p>
                                            <p class="text-lg font-bold text-gray-900 mt-1">Admin</p>
                                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                                Akses terbatas sesuai peran admin
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0">
                                        <div class="flex items-center space-x-4">
                                            <button type="submit" 
                                                    class="px-6 py-3.5 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-xl hover:from-[#35205e] hover:to-[#432C7A] shadow-lg font-semibold flex items-center">
                                                <i class="fas fa-save mr-3"></i>
                                                Simpan Perubahan
                                            </button>
                                            
                                            @if (session('status') === 'profile-updated')
                                                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-check-circle text-emerald-500 text-xl mr-3"></i>
                                                        <div>
                                                            <p class="font-medium text-emerald-800">Profile berhasil diperbarui!</p>
                                                            <p class="text-sm text-emerald-600 mt-1">Informasi akun telah diupdate</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                                            <i class="fas fa-times mr-2"></i>
                                            Batal & Kembali
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Keamanan Akun Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-5 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class="fas fa-shield-alt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Keamanan Akun</h3>
                                    <p class="text-sm text-gray-600">Pantau aktivitas dan keamanan akun Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Security Score -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-5">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mr-4 shadow-sm">
                                                <i class="fas fa-star text-yellow-500 text-xl"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Skor Keamanan</p>
                                                <p class="text-2xl font-bold text-gray-900">8.5/10</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs text-gray-500 mb-1">Tingkat</div>
                                            <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                                Baik
                                            </span>
                                        </div>
                                    </div>
                                    <div class="relative pt-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-semibold text-gray-600">Progress</span>
                                            <span class="text-xs font-semibold text-gray-600">85%</span>
                                        </div>
                                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-200">
                                            <div style="width:85%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-green-500 to-emerald-600"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Items -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-key text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Status Password</p>
                                                <p class="text-sm text-gray-600">Terakhir diubah: {{ $user->updated_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex justify-end">
                                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                                <i class="fas fa-check mr-1"></i>Aman
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 border border-gray-200 rounded-xl p-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Sesi Aktif</p>
                                                <p class="text-sm text-gray-600">Login terakhir: Sekarang</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex justify-end">
                                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                                                <i class="fas fa-circle text-xs mr-1"></i>Aktif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Last Activity -->
                                <div class="pt-4 border-t border-gray-200">
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                        <i class="fas fa-history text-gray-400 mr-2 text-sm"></i>
                                        Aktivitas Terakhir
                                    </h4>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-2 h-2 mt-2 rounded-full bg-green-500"></div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-700">Login berhasil</p>
                                            <p class="text-xs text-gray-500">{{ now()->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6 md:space-y-8">
                    <!-- Update Password Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-5 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class="fas fa-lock text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Update Password</h3>
                                    <p class="text-sm text-gray-600">Gunakan password yang kuat dan unik</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <form method="post" action="{{ route('admin.password.update') }}" class="space-y-6" id="passwordForm">
                                @csrf
                                @method('put')

                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                        <i class="fas fa-key text-gray-400 mr-2"></i>
                                        Password Saat Ini <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input id="current_password" 
                                               name="current_password" 
                                               type="password" 
                                               class="pl-12 pr-12 py-4 w-full border border-gray-300 rounded-xl focus:ring-3 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none"
                                               autocomplete="current-password"
                                               placeholder="Masukkan password saat ini" />
                                        <button type="button" 
                                                onclick="togglePassword('current_password')"
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye" id="current_password_icon"></i>
                                        </button>
                                    </div>
                                    @error('current_password', 'updatePassword') 
                                        <div class="mt-3 flex items-center text-red-600 text-sm bg-red-50 px-4 py-2 rounded-lg">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                        <i class="fas fa-lock text-gray-400 mr-2"></i>
                                        Password Baru <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-shield-alt text-gray-400"></i>
                                        </div>
                                        <input id="password" 
                                               name="password" 
                                               type="password" 
                                               class="pl-12 pr-12 py-4 w-full border border-gray-300 rounded-xl focus:ring-3 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none"
                                               autocomplete="new-password"
                                               oninput="checkPasswordStrength()"
                                               placeholder="Minimal 8 karakter" />
                                        <button type="button" 
                                                onclick="togglePassword('password')"
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye" id="password_icon"></i>
                                        </button>
                                    </div>
                                    <div class="mt-3 space-y-2" id="passwordStrength"></div>
                                    @error('password', 'updatePassword') 
                                        <div class="mt-3 flex items-center text-red-600 text-sm bg-red-50 px-4 py-2 rounded-lg">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                        <i class="fas fa-lock text-gray-400 mr-2"></i>
                                        Konfirmasi Password <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-check-circle text-gray-400"></i>
                                        </div>
                                        <input id="password_confirmation" 
                                               name="password_confirmation" 
                                               type="password" 
                                               class="pl-12 pr-12 py-4 w-full border border-gray-300 rounded-xl focus:ring-3 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none"
                                               autocomplete="new-password"
                                               oninput="checkPasswordMatch()"
                                               placeholder="Ulangi password baru" />
                                        <button type="button" 
                                                onclick="togglePassword('password_confirmation')"
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye" id="password_confirmation_icon"></i>
                                        </button>
                                    </div>
                                    <p class="text-sm mt-3" id="passwordMatch"></p>
                                    @error('password_confirmation', 'updatePassword') 
                                        <div class="mt-3 flex items-center text-red-600 text-sm bg-red-50 px-4 py-2 rounded-lg">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0">
                                        <div class="flex items-center space-x-4">
                                            <button type="submit" 
                                                    class="px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:from-emerald-600 hover:to-teal-700 shadow-lg font-semibold flex items-center">
                                                <i class="fas fa-sync-alt mr-3"></i>
                                                Update Password
                                            </button>
                                            
                                            @if (session('status') === 'password-updated')
                                                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-check-circle text-emerald-500 text-xl mr-3"></i>
                                                        <div>
                                                            <p class="font-medium text-emerald-800">Password berhasil diperbarui!</p>
                                                            <p class="text-sm text-emerald-600 mt-1">Keamanan akun Anda telah ditingkatkan</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <button type="button" 
                                                onclick="resetPasswordForm()"
                                                class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                                            <i class="fas fa-redo mr-2"></i>
                                            Reset Form
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Hapus Akun Card -->
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-100 rounded-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-red-100 to-rose-100 px-6 py-5 border-b border-red-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-rose-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-red-900">Hapus Akun</h3>
                                    <p class="text-sm text-red-700">Tindakan ini bersifat permanen dan tidak dapat dibatalkan</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-6">
                                <!-- Warning Box -->
                                <div class="bg-white border border-red-200 rounded-xl p-5">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-bold text-red-800 mb-2">Perhatian!</h4>
                                            <ul class="text-sm text-red-700 space-y-2">
                                                <li class="flex items-start">
                                                    <i class="fas fa-times text-xs mt-1 mr-2"></i>
                                                    <span>Semua data Anda akan dihapus secara permanen</span>
                                                </li>
                                                <li class="flex items-start">
                                                    <i class="fas fa-times text-xs mt-1 mr-2"></i>
                                                    <span>Tidak dapat dikembalikan atau dibatalkan</span>
                                                </li>
                                                <li class="flex items-start">
                                                    <i class="fas fa-times text-xs mt-1 mr-2"></i>
                                                    <span>Akses ke semua fitur sistem akan hilang</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Form -->
                                <div>
                                    <form method="post" action="{{ route('admin.profile.destroy') }}" id="deleteAccountForm">
                                        @csrf
                                        @method('delete')

                                        <!-- Confirmation Input -->
                                        <div class="mb-4">
                                            <label for="delete_confirmation" class="block text-sm font-medium text-red-700 mb-3">
                                                Ketik <span class="font-mono bg-red-100 px-2 py-1 rounded">HAPUS AKUN SAYA</span> untuk konfirmasi:
                                            </label>
                                            <input type="text" 
                                                   id="delete_confirmation"
                                                   name="confirmation"
                                                   class="w-full px-4 py-3 border-2 border-red-300 rounded-xl focus:ring-2 focus:ring-red-200 focus:border-red-500 focus:outline-none"
                                                   placeholder="HAPUS AKUN SAYA"
                                                   autocomplete="off"
                                                   required>
                                        </div>

                                        <!-- Password Input -->
                                        <div class="mb-6">
                                            <label for="password_del" class="block text-sm font-medium text-red-700 mb-3">
                                                Masukkan password untuk konfirmasi:
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <i class="fas fa-key text-red-400"></i>
                                                </div>
                                                <input id="password_del" 
                                                       name="password" 
                                                       type="password" 
                                                       class="pl-12 pr-4 py-3 w-full border-2 border-red-300 rounded-xl focus:ring-2 focus:ring-red-200 focus:border-red-500 focus:outline-none"
                                                       placeholder="Password Anda"
                                                       required />
                                            </div>
                                        </div>

                                        <!-- Delete Button -->
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0">
                                            <button type="button" 
                                                    onclick="showDeleteConfirmation()"
                                                    class="px-6 py-3.5 bg-gradient-to-r from-red-600 to-rose-700 text-white rounded-xl hover:from-red-700 hover:to-rose-800 font-semibold flex items-center justify-center">
                                                <i class="fas fa-trash-alt mr-3"></i>
                                                Hapus Akun Saya
                                            </button>
                                            
                                            <span class="text-sm text-gray-600 flex items-center">
                                                <i class="fas fa-info-circle mr-2 text-red-500"></i>
                                                Proses ini tidak dapat dibatalkan
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Konfirmasi Penghapusan Akun</h3>
                <p class="text-gray-700 text-center mb-2">
                    Apakah Anda yakin ingin menghapus akun <span class="font-bold">{{ $user->name }}</span>?
                </p>
                <p class="text-sm text-red-600 text-center mb-6">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Semua data akan dihapus permanen dan tidak dapat dikembalikan!
                </p>
                
                <div class="flex space-x-4">
                    <button onclick="closeDeleteModal()" 
                            class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button onclick="submitDeleteForm()" 
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-medium">
                        <i class="fas fa-trash-alt mr-2"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthDiv = document.getElementById('passwordStrength');
            
            if (!password) {
                strengthDiv.innerHTML = '';
                return;
            }
            
            let strength = 0;
            let tips = [];
            
            // Check criteria
            const checks = [
                { test: password.length >= 8, message: 'Minimal 8 karakter' },
                { test: /[a-z]/.test(password) && /[A-Z]/.test(password), message: 'Huruf besar & kecil' },
                { test: /\d/.test(password), message: 'Angka' },
                { test: /[^A-Za-z0-9]/.test(password), message: 'Karakter khusus' },
                { test: password.length >= 12, message: 'Panjang 12+ karakter' }
            ];
            
            checks.forEach(check => {
                if (check.test) strength++;
                else if (check.message) tips.push(check.message);
            });
            
            // Strength levels
            const levels = [
                { text: 'Sangat Lemah', color: 'text-red-600', bg: 'bg-red-100', width: '20%', icon: 'fa-exclamation-triangle' },
                { text: 'Lemah', color: 'text-orange-600', bg: 'bg-orange-100', width: '40%', icon: 'fa-exclamation-circle' },
                { text: 'Cukup', color: 'text-yellow-600', bg: 'bg-yellow-100', width: '60%', icon: 'fa-check-circle' },
                { text: 'Kuat', color: 'text-green-600', bg: 'bg-green-100', width: '80%', icon: 'fa-shield-alt' },
                { text: 'Sangat Kuat', color: 'text-emerald-600', bg: 'bg-emerald-100', width: '100%', icon: 'fa-lock' }
            ];
            
            const level = Math.min(strength, 4);
            
            strengthDiv.innerHTML = `
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas ${levels[level].icon} ${levels[level].color} mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Kekuatan password:</span>
                        </div>
                        <span class="text-sm font-bold ${levels[level].color}">${levels[level].text}</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full ${levels[level].bg}" style="width: ${levels[level].width}"></div>
                    </div>
                    ${tips.length > 0 ? `
                        <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-500 mb-2">Saran untuk meningkatkan keamanan:</p>
                            <ul class="text-xs text-gray-600 space-y-1">
                                ${tips.map(tip => `<li class="flex items-center"><i class="fas fa-exclamation-circle text-red-400 mr-2 text-xs"></i> ${tip}</li>`).join('')}
                            </ul>
                        </div>
                    ` : `
                        <div class="mt-2 p-3 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <div class="flex items-center text-emerald-700">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span class="text-sm font-medium">Password Anda sudah cukup kuat!</span>
                            </div>
                        </div>
                    `}
                </div>
            `;
            
            checkPasswordMatch();
        }

        // Check password match
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (!password && !confirm) {
                matchDiv.innerHTML = '';
                return;
            }
            
            if (!confirm) {
                matchDiv.innerHTML = '<span class="text-gray-500 text-sm flex items-center"><i class="fas fa-info-circle mr-2"></i> Konfirmasi password Anda</span>';
                return;
            }
            
            if (password === confirm) {
                matchDiv.innerHTML = '<span class="text-emerald-600 text-sm flex items-center"><i class="fas fa-check-circle mr-2 text-lg"></i> Password cocok! Siap disimpan.</span>';
            } else {
                matchDiv.innerHTML = '<span class="text-red-600 text-sm flex items-center"><i class="fas fa-times-circle mr-2 text-lg"></i> Password tidak cocok!</span>';
            }
        }

        // Reset password form
        function resetPasswordForm() {
            document.getElementById('passwordForm').reset();
            document.getElementById('passwordStrength').innerHTML = '';
            document.getElementById('passwordMatch').innerHTML = '';
        }

        // Delete modal functions
        function showDeleteConfirmation() {
            const confirmation = document.getElementById('delete_confirmation').value;
            const password = document.getElementById('password_del').value;
            
            if (!confirmation) {
                alert('Silakan ketik "HAPUS AKUN SAYA" untuk konfirmasi');
                document.getElementById('delete_confirmation').focus();
                return;
            }
            
            if (confirmation !== 'HAPUS AKUN SAYA') {
                alert('Teks konfirmasi tidak sesuai! Silakan ketik "HAPUS AKUN SAYA"');
                return;
            }
            
            if (!password) {
                alert('Silakan masukkan password Anda untuk konfirmasi');
                document.getElementById('password_del').focus();
                return;
            }
            
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function submitDeleteForm() {
            document.getElementById('deleteAccountForm').submit();
        }

        // Form validation for password update
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const currentPassword = document.getElementById('current_password').value;
            const newPassword = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (!currentPassword) {
                e.preventDefault();
                alert('Silakan masukkan password saat ini');
                return false;
            }
            
            if (newPassword && newPassword.length < 8) {
                e.preventDefault();
                alert('Password baru minimal 8 karakter!');
                return false;
            }
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Password baru dan konfirmasi password tidak cocok!');
                return false;
            }
            
            return true;
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>

    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #432C7A 0%, #5a409e 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #35205e 0%, #432C7A 100%);
        }
        
        /* Enhanced focus styles */
        input:focus, textarea:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(67, 44, 122, 0.1) !important;
            outline: none !important;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-header .avatar {
                margin: 0 auto 1.5rem;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }
            
            .form-actions button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</x-admin-layout>