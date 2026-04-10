<x-pengawas-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Tambah User Internal') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Tambah pengguna baru ke dalam sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-3">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('pengawas.users.index') }}" class="hover:text-[#80489C]">
                <i class="fas fa-users mr-1"></i> Manajemen User
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Tambah Baru</span>
        </div>
    </div>

    <div class="py-6"> <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            </div>
    </div>



    <div class="py-6">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-r from-[#80489C] to-[#9a65b3] text-white rounded-xl p-5 shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user-plus text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-90">Pengguna Baru</p>
                            <p class="text-2xl font-bold">#{{ $nextUserId ?? 'NEW' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-info-circle text-[#80489C] text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Instruksi</p>
                            <p class="text-sm font-medium text-gray-900">Isi semua field dengan data yang valid</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Form Tambah Pengguna</h3>
                            <p class="text-sm text-gray-600">Masukkan informasi pengguna baru</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-5 py-4 rounded-lg shadow-sm">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                                <div>
                                    <p class="font-medium mb-2">Terdapat kesalahan dalam pengisian form:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-sm">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('pengawas.users.store') }}" method="POST" id="userForm">
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-id-card text-[#80489C] mr-2"></i>
                                Informasi Pribadi
                            </h4>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input type="text" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               placeholder="Masukkan nama lengkap"
                                               required>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Contoh: John Doe</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               placeholder="contoh@email.com"
                                               required>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Email harus unik dan valid</p>
                                </div>
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-user-shield text-[#80489C] mr-2"></i>
                                Hak Akses (Role)
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="role-option border-2 rounded-lg p-4 cursor-pointer transition-all duration-200 hover:border-[#80489C] hover:bg-purple-50"
                                     onclick="selectRole(2)">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-eye text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Pengawas</p>
                                            <p class="text-sm text-gray-600">Monitoring dan laporan</p>
                                        </div>
                                        <div class="ml-auto">
                                            <input type="radio" name="role" value="2" 
                                                   class="role-radio" 
                                                   {{ old('role', 2) == 2 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="role-option border-2 rounded-lg p-4 cursor-pointer transition-all duration-200 hover:border-[#80489C] hover:bg-purple-50"
                                     onclick="selectRole(1)">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-user-shield text-red-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Administrator</p>
                                            <p class="text-sm text-gray-600">Akses penuh sistem</p>
                                        </div>
                                        <div class="ml-auto">
                                            <input type="radio" name="role" value="1" 
                                                   class="role-radio" 
                                                   {{ old('role') == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <select name="role" class="hidden" id="roleSelect">
                                <option value="2" {{ old('role', 2) == 2 ? 'selected' : '' }}>Pengawas</option>
                                <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </div>

                        <!-- Password Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-key text-[#80489C] mr-2"></i>
                                Keamanan Akun
                            </h4>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" 
                                               name="password" 
                                               id="password"
                                               class="pl-10 pr-10 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               placeholder="Masukkan password"
                                               required>
                                        <button type="button" 
                                                onclick="togglePassword('password')"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2 space-y-1" id="passwordStrength"></div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Konfirmasi Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation"
                                               class="pl-10 pr-10 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                               placeholder="Ulangi password"
                                               required>
                                        <button type="button" 
                                                onclick="togglePassword('password_confirmation')"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2" id="passwordMatch"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between pt-6 border-t border-gray-200">
                            <div class="mb-4 md:mb-0">
                                <a href="{{ route('pengawas.users.index') }}" 
                                   class="flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Kembali ke Daftar User
                                </a>
                            </div>
                            <div class="flex space-x-4">
                                <button type="reset" 
                                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                                    <i class="fas fa-redo mr-2"></i>Reset Form
                                </button>
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-[#80489C] to-[#9a65b3] text-white rounded-lg hover:from-[#66337a] hover:to-[#80489C] transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                    <i class="fas fa-save mr-2"></i>Simpan User Baru
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-[#80489C] text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900">Tips Menambahkan User</h4>
                        <ul class="mt-3 space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Pastikan email yang digunakan belum terdaftar sebelumnya</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Password minimal 8 karakter dengan kombinasi huruf dan angka</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Pilih role sesuai dengan kebutuhan akses pengguna</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Role selection
        function selectRole(role) {
            document.getElementById('roleSelect').value = role;
            document.querySelectorAll('.role-radio').forEach(radio => {
                radio.checked = radio.value == role;
            });
            document.querySelectorAll('.role-option').forEach(option => {
                if (option.querySelector('.role-radio').value == role) {
                    option.classList.add('border-[#80489C]', 'bg-purple-50');
                } else {
                    option.classList.remove('border-[#80489C]', 'bg-purple-50');
                }
            });
        }

        // Initialize role selection
        document.addEventListener('DOMContentLoaded', function() {
            const initialRole = document.getElementById('roleSelect').value;
            selectRole(initialRole);
            
            // Password strength indicator
            document.getElementById('password').addEventListener('input', checkPasswordStrength);
            document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
        });

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
            
            let strength = 0;
            let tips = [];
            
            // Check length
            if (password.length >= 8) strength++;
            else tips.push('Minimal 8 karakter');
            
            // Check for mixed case
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            else tips.push('Gunakan huruf besar dan kecil');
            
            // Check for numbers
            if (/\d/.test(password)) strength++;
            else tips.push('Tambahkan angka');
            
            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            else tips.push('Tambahkan karakter khusus (!@#$%^&*)');
            
            // Display strength
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
                <div class="flex items-center">
                    <span class="text-xs font-medium mr-2">Kekuatan password:</span>
                    <span class="text-xs font-bold text-${color}-600">${strengthText}</span>
                </div>
                ${tips.length > 0 ? `<div class="text-xs text-gray-500">${tips.join(', ')}</div>` : ''}
            `;
            
            checkPasswordMatch();
        }

        // Check password match
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (confirm.length === 0) {
                matchDiv.textContent = '';
                return;
            }
            
            if (password === confirm) {
                matchDiv.innerHTML = '<span class="text-green-600">✓ Password cocok</span>';
            } else {
                matchDiv.innerHTML = '<span class="text-red-600">✗ Password tidak cocok</span>';
            }
        }

        // Form validation
        document.getElementById('userForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter!');
                return false;
            }
            
            return true;
        });
    </script>

    <style>
        .role-option {
            border-color: #e5e7eb;
        }
        
        .role-option:hover {
            border-color: #80489C;
        }
        
        .role-radio {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            position: relative;
        }
        
        .role-radio:checked {
            border-color: #80489C;
            background-color: #80489C;
        }
        
        .role-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
        }
    </style>
</x-pengawas-layout>