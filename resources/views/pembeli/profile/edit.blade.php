<x-pembeli-layout>
    {{-- ================= HEADER ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-6">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-circle text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-blue-900">
                        Profil <span class="text-blue-600">Saya</span>
                    </h1>
                    <p class="text-sm text-blue-600 mt-1">
                        <i class="fas fa-edit mr-1"></i>
                        Kelola informasi akun dan alamat pengiriman Anda
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-4 min-h-screen">
        
        {{-- Session Success --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center space-x-3 animate-fade-in">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- ================= KOLOM KIRI - INFO AKUN ================= --}}
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                    
                    {{-- Header Card --}}
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-id-card mr-2"></i>
                            Info Akun
                        </h2>
                    </div>

                    {{-- Form Profile --}}
                    <form method="post" action="{{ route('pembeli.profile.update') }}" enctype="multipart/form-data" class="p-6">
                        @csrf
                        @method('patch')

                        {{-- Avatar Upload --}}
                        <div class="flex flex-col items-center mb-8">
                            <div class="relative mb-4 group">
                                <div class="absolute inset-0 bg-blue-400 rounded-full blur-xl opacity-50 group-hover:opacity-70 transition"></div>
                                <div class="relative w-28 h-28 rounded-full border-4 border-white shadow-xl overflow-hidden">
                                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=3B82F6&color=fff&size=128' }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </div>
                                <label for="avatar-upload" class="absolute -bottom-2 -right-2 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-blue-700 transition border-2 border-white">
                                    <i class="fas fa-camera text-sm"></i>
                                </label>
                                <input type="file" name="avatar" id="avatar-upload" class="hidden">
                            </div>
                            <p class="text-xs text-blue-500">Klik icon kamera untuk mengganti foto</p>
                        </div>

                        {{-- Username --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-blue-800 mb-2">
                                <i class="fas fa-at mr-1 text-blue-500"></i>
                                Username
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 rounded-l-xl border-2 border-r-0 border-blue-200 bg-blue-50 text-blue-600 text-sm font-medium">@</span>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" 
                                       class="flex-1 px-4 py-2.5 bg-white border-2 border-blue-200 rounded-r-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all"
                                       placeholder="username">
                            </div>
                            @error('username')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-blue-800 mb-2">
                                <i class="fas fa-user mr-1 text-blue-500"></i>
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-4 py-2.5 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email (Disabled) --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-blue-800 mb-2">
                                <i class="fas fa-envelope mr-1 text-blue-500"></i>
                                Email
                            </label>
                            <div class="w-full px-4 py-2.5 bg-blue-50 border-2 border-blue-200 rounded-xl text-sm text-blue-700 flex items-center">
                                <i class="fas fa-lock mr-2 text-blue-400 text-xs"></i>
                                {{ $user->email }}
                            </div>
                        </div>

                        {{-- Nomor Telepon --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-blue-800 mb-2">
                                <i class="fas fa-phone-alt mr-1 text-blue-500"></i>
                                Nomor Telepon/WA
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="w-full px-4 py-2.5 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all"
                                   placeholder="08xxxxxxxxxx">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-blue-800 mb-2">
                                <i class="fas fa-birthday-cake mr-1 text-blue-500"></i>
                                Tanggal Lahir
                            </label>
                            <input type="date" name="birthday" value="{{ old('birthday', $user->birthday?->format('Y-m-d')) }}" 
                                   class="w-full px-4 py-2.5 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                            @error('birthday')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-blue-800 mb-3">
                                <i class="fas fa-venus-mars mr-1 text-blue-500"></i>
                                Jenis Kelamin
                            </label>
                            <div class="flex items-center space-x-6">
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="radio" name="gender" value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'checked' : '' }} 
                                           class="w-4 h-4 text-blue-600 border-2 border-blue-300 focus:ring-blue-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-blue-800 group-hover:text-blue-600 transition">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="radio" name="gender" value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'checked' : '' }} 
                                           class="w-4 h-4 text-blue-600 border-2 border-blue-300 focus:ring-blue-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-blue-800 group-hover:text-blue-600 transition">Perempuan</span>
                                </label>
                            </div>
                            @error('gender')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="submit" 
                                class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- ================= KOLOM KANAN - DAFTAR ALAMAT ================= --}}
            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden h-full">
                    @include('profile.partials.daftar-alamat')
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
        
        /* Custom radio button */
        input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #BFDBFE;
            border-radius: 50%;
            outline: none;
            transition: all 0.2s;
            position: relative;
            cursor: pointer;
        }
        input[type="radio"]:checked {
            border-color: #3B82F6;
            background-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: white;
        }
    </style>
    @endpush

</x-pembeli-layout>