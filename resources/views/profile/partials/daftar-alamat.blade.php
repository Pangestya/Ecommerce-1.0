<section class="h-full flex flex-col">
    {{-- Header dengan background gradient --}}
    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Daftar Alamat
                </h2>
                <p class="text-xs text-blue-100 mt-1">
                    <i class="fas fa-info-circle mr-1"></i>
                    Kelola alamat pengiriman kamu
                </p>
            </div>
            
            <a href="{{ route('pembeli.alamat.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg font-semibold text-xs uppercase tracking-wider hover:bg-blue-50 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-1"></i>
                Tambah
            </a>
        </div>
    </div>

    {{-- Content Area --}}
    <div class="p-6 flex-1">
        @if($alamats->isEmpty())
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-12 bg-blue-50/30 rounded-xl border-2 border-dashed border-blue-200 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-map-marked-alt text-3xl text-blue-400"></i>
                </div>
                <h4 class="text-base font-bold text-blue-900 mb-2">Belum Ada Alamat</h4>
                <p class="text-sm text-blue-600 max-w-xs mx-auto">
                    Kamu belum menambahkan alamat pengiriman. Tambah alamat sekarang untuk mulai berbelanja.
                </p>
            </div>
        @else
            <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scroll">
                @foreach($alamats as $alamat)
                    {{-- Card Alamat --}}
                    <div class="group relative bg-white rounded-xl border-2 {{ $alamat->is_primary ? 'border-blue-500 bg-gradient-to-r from-blue-50/50 to-white' : 'border-blue-100 hover:border-blue-300' }} shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                        
                        {{-- Badge Utama --}}
                        @if($alamat->is_primary)
                            <div class="absolute top-0 right-0">
                                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white text-xs font-bold px-4 py-1.5 rounded-bl-xl shadow-md">
                                    <i class="fas fa-star mr-1"></i> UTAMA
                                </div>
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="p-5">
                            <div class="flex items-start justify-between">
                                {{-- Info Alamat --}}
                                <div class="flex-1 pr-8">
                                    <div class="flex items-center flex-wrap gap-2 mb-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600 text-sm"></i>
                                        </div>
                                        <h4 class="font-bold text-blue-900">{{ $alamat->name }}</h4>
                                        <span class="text-blue-400 text-sm">|</span>
                                        <span class="text-sm text-blue-700">{{ $alamat->phone }}</span>
                                    </div>

                                    <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100 space-y-2 mb-4">
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
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('pembeli.alamat.edit', $alamat->id) }}" 
                                           class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition group/btn">
                                            <i class="fas fa-edit mr-1 group-hover/btn:scale-110 transition-transform"></i>
                                            Ubah Alamat
                                        </a>

                                        @if(!$alamat->is_primary)
                                            <span class="text-blue-200">|</span>
                                            
                                            <form action="{{ route('pembeli.alamat.setPrimary', $alamat->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center text-sm font-medium text-blue-500 hover:text-green-600 transition group/btn">
                                                    <i class="fas fa-check-circle mr-1 group-hover/btn:scale-110 transition-transform"></i>
                                                    Jadikan Utama
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                {{-- Action Icons --}}
                                <div class="absolute top-8 right-4 flex items-center gap-2">
                                    <a href="{{ route('pembeli.alamat.edit', $alamat->id) }}" 
                                       class="w-9 h-9 bg-white border-2 border-blue-200 text-blue-600 rounded-lg flex items-center justify-center hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 shadow-sm hover:shadow-md"
                                       title="Ubah Alamat">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if(!$alamat->is_primary)
                                        <form action="{{ route('pembeli.alamat.destroy', $alamat->id) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus alamat ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-9 h-9 bg-white border-2 border-red-200 text-red-500 rounded-lg flex items-center justify-center hover:border-red-400 hover:bg-red-50 transition-all duration-300 shadow-sm hover:shadow-md"
                                                    title="Hapus Alamat">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @push('styles')
    <style>
        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scroll::-webkit-scrollbar-track {
            background: #F0F7FF;
            border-radius: 10px;
        }
        
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #3B82F6;
            border-radius: 10px;
        }
        
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #2563EB;
        }
        
        /* Card hover effect */
        .group:hover .group-hover\:border-blue-300 {
            border-color: #93C5FD;
        }
    </style>
    @endpush
</section>