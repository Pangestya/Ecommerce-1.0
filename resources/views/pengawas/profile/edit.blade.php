<x-pengawas-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Edit Profil Pengawas') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Kelola informasi akun dan keamanan Anda</p>
            </div>
        </div>
    </x-slot>
    
    <div class="max-w-8xl mx-auto sm:px-3">
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
            <a href="{{ route('pengawas.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <a href="#" class="hover:text-[#80489C]">
                <i class="fas fa-user mr-1"></i> Profile
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Edit Profile</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- User Profile Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-[#80489C] to-[#9a65b3] px-6 py-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-20 h-20 rounded-full bg-white/20 border-4 border-white/30 flex items-center justify-center mr-6">
                                <span class="text-white text-3xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">{{ $user->name }}</h3>
                                <p class="text-white/90">{{ $user->email }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="bg-white/30 text-white text-xs px-3 py-1 rounded-full">
                                        <i class="fas fa-user-shield mr-1"></i> Pengawas
                                    </span>
                                    <span class="ml-3 bg-white/30 text-white text-xs px-3 py-1 rounded-full">
                                        <i class="fas fa-calendar-alt mr-1"></i> Bergabung: {{ $user->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 text-right">
                            <div class="text-white/80 text-sm">ID Pengguna</div>
                            <div class="text-white text-xl font-bold">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Management Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-8">
                    <!-- Informasi Profil Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Informasi Profil</h3>
                                    <p class="text-sm text-gray-600">Update nama akun dan alamat email profil Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <form method="post" action="{{ route('pengawas.profile.update') }}" class="space-y-6">
                                @csrf
                                @method('patch')

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input id="name" 
                                               name="name" 
                                               type="text" 
                                               class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               value="{{ old('name', $user->name) }}" 
                                               required 
                                               autofocus />
                                    </div>
                                    @error('name') 
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input id="email" 
                                               name="email" 
                                               type="email" 
                                               class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               value="{{ old('email', $user->email) }}" 
                                               required />
                                    </div>
                                    @error('email') 
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <button type="submit" 
                                                    class="px-5 py-2.5 bg-gradient-to-r from-[#80489C] to-[#9a65b3] text-white rounded-lg hover:from-[#66337a] hover:to-[#80489C] transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                            </button>
                                            
                                            @if (session('status') === 'profile-updated')
                                                <div x-data="{ show: true }" 
                                                     x-show="show" 
                                                     x-transition 
                                                     x-init="setTimeout(() => show = false, 3000)"
                                                     class="flex items-center text-green-600">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    <span class="text-sm">Profile berhasil diperbarui!</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('pengawas.dashboard') }}" 
                                           class="text-sm text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                            <i class="fas fa-times mr-1"></i>Batal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Keamanan Akun Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-shield-alt text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Keamanan Akun</h3>
                                    <p class="text-sm text-gray-600">Pantau aktivitas dan keamanan akun Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-key text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Status Password</p>
                                            <p class="text-sm text-gray-600">Terakhir diubah: 2 minggu lalu</p>
                                        </div>
                                    </div>
                                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                        <i class="fas fa-check mr-1"></i>Aman
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-clock text-gray-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Sesi Aktif</p>
                                            <p class="text-sm text-gray-600">Login terakhir: 30 menit lalu</p>
                                        </div>
                                    </div>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                                        <i class="fas fa-circle text-xs mr-1"></i>Aktif
                                    </span>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-mobile-alt text-[#80489C]"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Perangkat Terdaftar</p>
                                            <p class="text-sm text-gray-600">3 perangkat aktif</p>
                                        </div>
                                    </div>
                                    <a href="#" class="text-xs text-[#80489C] hover:underline">Kelola</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Update Password Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-lock text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Update Password</h3>
                                    <p class="text-sm text-gray-600">Gunakan password yang kuat dan unik</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <form method="post" action="{{ route('pengawas.password.update') }}" class="space-y-6" id="passwordForm">
                                @csrf
                                @method('put')

                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password Saat Ini <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-key text-gray-400"></i>
                                        </div>
                                        <input id="current_password" 
                                               name="current_password" 
                                               type="password" 
                                               class="pl-10 pr-10 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               autocomplete="current-password" />
                                        <button type="button" 
                                                onclick="togglePassword('current_password')"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                    @error('current_password', 'updatePassword') 
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password Baru <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input id="password" 
                                               name="password" 
                                               type="password" 
                                               class="pl-10 pr-10 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               autocomplete="new-password"
                                               oninput="checkPasswordStrength()" />
                                        <button type="button" 
                                                onclick="togglePassword('password')"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2 space-y-1" id="passwordStrength"></div>
                                    @error('password', 'updatePassword') 
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Konfirmasi Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input id="password_confirmation" 
                                               name="password_confirmation" 
                                               type="password" 
                                               class="pl-10 pr-10 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               autocomplete="new-password"
                                               oninput="checkPasswordMatch()" />
                                        <button type="button" 
                                                onclick="togglePassword('password_confirmation')"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2" id="passwordMatch"></p>
                                    @error('password_confirmation', 'updatePassword') 
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <button type="submit" 
                                                    class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                                <i class="fas fa-sync-alt mr-2"></i>Update Password
                                            </button>
                                            
                                            @if (session('status') === 'password-updated')
                                                <div x-data="{ show: true }" 
                                                     x-show="show" 
                                                     x-transition 
                                                     x-init="setTimeout(() => show = false, 3000)"
                                                     class="flex items-center text-green-600">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    <span class="text-sm">Password berhasil diperbarui!</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <button type="button" 
                                                onclick="resetPasswordForm()"
                                                class="text-sm text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                            <i class="fas fa-redo mr-1"></i>Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Hapus Akun Card -->
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl overflow-hidden card-hover">
                        <div class="bg-red-100 px-6 py-4 border-b border-red-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-red-900">Hapus Akun</h3>
                                    <p class="text-sm text-red-700">Tindakan ini bersifat permanen dan tidak dapat dibatalkan</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="bg-white border border-red-200 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                                        <div>
                                            <p class="text-sm text-red-700 font-medium">Perhatian!</p>
                                            <p class="text-sm text-gray-700 mt-1">
                                                Setelah menghapus akun, semua data Anda akan dihapus secara permanen.
                                                Termasuk semua informasi profil, aktivitas, dan data terkait lainnya.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <form method="post" action="{{ route('pengawas.profile.destroy') }}" id="deleteAccountForm">
                                    @csrf
                                    @method('delete')

                                    <div>
                                        <label for="password_del" class="block text-sm font-medium text-red-700 mb-2">
                                            Konfirmasi Password <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-key text-red-400"></i>
                                            </div>
                                            <input id="password_del" 
                                                   name="password" 
                                                   type="password" 
                                                   class="pl-10 pr-4 py-3 w-full border border-red-300 rounded-lg focus:ring-2 focus:ring-red-200 focus:border-red-500 focus:outline-none transition-colors duration-200"
                                                   placeholder="Masukkan password Anda"
                                                   required />
                                        </div>
                                        @error('password', 'userDeletion') 
                                            <div class="mt-2 flex items-center text-red-600 text-sm">
                                                <i class="fas fa-exclamation-circle mr-2"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mt-6 flex items-center space-x-4">
                                        <button type="button" 
                                                onclick="showDeleteConfirmation()"
                                                class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                            <i class="fas fa-trash-alt mr-2"></i>Hapus Akun Saya
                                        </button>
                                        
                                        <span class="text-sm text-gray-600">
                                            <i class="fas fa-info-circle mr-1"></i>
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

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
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
                            class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button onclick="submitDeleteForm()" 
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 font-medium">
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
            const icon = field.parentNode.querySelector('i');
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
            
            if (password.length === 0) {
                strengthDiv.innerHTML = '';
                return;
            }
            
            let strength = 0;
            let tips = [];
            
            if (password.length >= 8) strength++;
            else tips.push('Minimal 8 karakter');
            
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            else tips.push('Gunakan huruf besar dan kecil');
            
            if (/\d/.test(password)) strength++;
            else tips.push('Tambahkan angka');
            
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            else tips.push('Tambahkan karakter khusus (!@#$%^&*)');
            
            let strengthText = '';
            let color = 'red';
            
            switch(strength) {
                case 0:
                case 1:
                    strengthText = 'Sangat Lemah';
                    color = 'red';
                    break;
                case 2:
                    strengthText = 'Lemah';
                    color = 'orange';
                    break;
                case 3:
                    strengthText = 'Cukup';
                    color = 'yellow';
                    break;
                case 4:
                    strengthText = 'Kuat';
                    color = 'green';
                    break;
            }
            
            strengthDiv.innerHTML = `
                <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium">Kekuatan password:</span>
                        <span class="text-xs font-bold text-${color}-600">${strengthText}</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-${color}-500" style="width: ${strength * 25}%"></div>
                    </div>
                    ${tips.length > 0 ? `<div class="text-xs text-gray-500 mt-2">${tips.join(' • ')}</div>` : ''}
                </div>
            `;
            
            checkPasswordMatch();
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (password.length === 0 && confirm.length === 0) {
                matchDiv.textContent = '';
                return;
            }
            
            if (confirm.length === 0) {
                matchDiv.textContent = '';
                return;
            }
            
            if (password === confirm) {
                matchDiv.innerHTML = '<span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Password cocok</span>';
            } else {
                matchDiv.innerHTML = '<span class="text-red-600"><i class="fas fa-times-circle mr-1"></i> Password tidak cocok</span>';
            }
        }

        function resetPasswordForm() {
            document.getElementById('passwordForm').reset();
            document.getElementById('passwordStrength').innerHTML = '';
            document.getElementById('passwordMatch').innerHTML = '';
        }

        function showDeleteConfirmation() {
            const password = document.getElementById('password_del').value;
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

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(128, 72, 156, 0.15);
        }
        
        input:focus {
            box-shadow: 0 0 0 3px rgba(128, 72, 156, 0.1);
        }
    </style>
</x-pengawas-layout>