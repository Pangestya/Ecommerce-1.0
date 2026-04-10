<x-pembeli-layout>
    {{-- ================= HEADER ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">
                            Daftar <span class="text-blue-600">Alamat Saya</span>
                        </h1>
                        <p class="text-sm text-blue-600 mt-1">
                            <i class="fas fa-home mr-1"></i>
                            Kelola alamat pengiriman Anda
                        </p>
                    </div>
                </div>
                
                <a href="{{ route('pembeli.alamat.create') }}" 
                   class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Alamat Baru
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 min-h-screen">
        
        {{-- Session Success --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center space-x-3 animate-fade-in">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if($alamats->isEmpty())
            {{-- ================= EMPTY STATE ================= --}}
            <div class="flex flex-col items-center justify-center py-16 md:py-20 bg-white rounded-2xl border-2 border-dashed border-blue-200 shadow-sm text-center">
                <div class="w-28 h-28 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                    <i class="fas fa-map-marked-alt text-5xl text-blue-400"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-blue-900 mb-3">
                    Belum Ada <span class="text-blue-600">Alamat</span>
                </h3>
                
                <p class="text-blue-600 max-w-md mb-6 px-4">
                    Kamu belum menambahkan alamat pengiriman. Silakan tambah alamat agar bisa belanja.
                </p>
                
                <a href="{{ route('pembeli.alamat.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Alamat Sekarang
                </a>
            </div>
        @else
            {{-- ================= GRID ALAMAT ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($alamats as $alamat)
                    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 {{ $alamat->is_primary ? 'border-blue-500 bg-gradient-to-b from-blue-50/30 to-white' : 'border-blue-100 hover:border-blue-300' }} overflow-hidden relative transform hover:-translate-y-1">
                        
                        {{-- Badge Utama --}}
                        @if($alamat->is_primary)
                            <div class="absolute top-0 right-0">
                                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white text-xs font-bold px-4 py-2 rounded-bl-xl shadow-lg">
                                    <i class="fas fa-star mr-1"></i> ALAMAT UTAMA
                                </div>
                            </div>
                        @endif

                        {{-- Header Card --}}
                        <div class="p-5 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-circle text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-blue-900 text-lg">{{ $alamat->name }}</h4>
                                        <p class="text-sm text-blue-600 flex items-center">
                                            <i class="fas fa-phone-alt mr-1 text-xs"></i>
                                            {{ $alamat->phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detail Alamat --}}
                        <div class="p-5">
                            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100 space-y-2">
                                <p class="text-sm text-blue-800 flex items-start">
                                    <i class="fas fa-home w-5 text-blue-400 mt-0.5"></i>
                                    <span>{{ $alamat->detail_alamat }}</span>
                                </p>
                                <p class="text-sm text-blue-800 flex items-start">
                                    <i class="fas fa-map-pin w-5 text-blue-400 mt-0.5"></i>
                                    <span>
                                        <span class="font-medium">{{ $alamat->subdistrict_name }}</span>, {{ $alamat->city_name }}
                                    </span>
                                </p>
                                <p class="text-sm text-blue-800 flex items-start">
                                    <i class="fas fa-globe w-5 text-blue-400 mt-0.5"></i>
                                    <span>
                                        {{ $alamat->province_name }} 
                                        @if($alamat->postal_code)
                                            <span class="font-medium">- {{ $alamat->postal_code }}</span>
                                        @endif
                                    </span>
                                </p>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center gap-3 mt-5 pt-3 border-t border-blue-100">
                                <a href="{{ route('pembeli.alamat.edit', $alamat->id) }}" 
                                   class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-white border-2 border-blue-200 text-blue-700 rounded-xl text-sm font-semibold hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 group/btn">
                                    <i class="fas fa-edit mr-2 group-hover/btn:scale-110 transition-transform"></i>
                                    Ubah
                                </a>
                                
                                <form action="{{ route('pembeli.alamat.destroy', $alamat->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus alamat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-white border-2 border-red-200 text-red-600 rounded-xl text-sm font-semibold hover:border-red-400 hover:bg-red-50 transition-all duration-300 group/btn">
                                        <i class="fas fa-trash-alt mr-2 group-hover/btn:scale-110 transition-transform"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
    </style>
    @endpush

</x-pembeli-layout>