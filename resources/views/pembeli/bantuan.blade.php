<x-pembeli-layout>
    @php
        // ============ LOGIKA TAMBAHAN (HANYA DI BLADE) ============
        // Menambahkan statistik dan fitur tanpa mengubah controller
        
        // 1. Hitung total pertanyaan per kategori
        $totalQuestions = $faqs->count();
        $popularFaqs = $faqs->take(3); // 3 FAQ populer
        
        // 2. Generate random support stats (akan berubah setiap request)
        $supportStats = [
            'response_time' => rand(2, 8) . ' Menit',
            'satisfaction' => rand(95, 99) . '%',
            'online_users' => rand(12, 35),
            'today_help' => rand(45, 120)
        ];
        
        // 3. Tentukan warna gradient untuk setiap kategori
        $gradientColors = [
            'from-purple-500 to-purple-400',
            'from-green-500 to-green-400',
            'from-yellow-500 to-yellow-400',
            'from-red-500 to-red-400',
            'from-indigo-500 to-indigo-400',
            'from-pink-500 to-pink-400',
            'from-teal-500 to-teal-400',
            'from-orange-500 to-orange-400'
        ];
        
        // 4. Hitung progress berdasarkan kategori yang dipilih
        $selectedCategory = request('category');
        $categoryProgress = $selectedCategory ? rand(60, 95) : 100;
        
        // 5. Artikel terkait (simulasi)
        $relatedArticles = [
            ['title' => 'Cara Melacak Pesanan', 'icon' => 'fa-truck', 'url' => '#'],
            ['title' => 'Kebijakan Pengembalian', 'icon' => 'fa-undo-alt', 'url' => '#'],
            ['title' => 'Metode Pembayaran', 'icon' => 'fa-credit-card', 'url' => '#'],
        ];
        
        // 6. Waktu operasional
        $operationalHours = [
            'senin_jumat' => '08:00 - 21:00',
            'sabtu' => '09:00 - 18:00',
            'minggu' => '10:00 - 16:00'
        ];
        
        // 7. Apakah sedang jam operasional?
        $currentHour = now()->format('H');
        $isOperational = ($currentHour >= 8 && $currentHour <= 21);
        
        // 8. Random tips
        $helpTips = [
            'Gunakan kata kunci yang spesifik untuk pencarian cepat',
            'Sertakan nomor pesanan saat bertanya via WhatsApp',
            'Cek halaman FAQ sebelum menghubungi admin',
            'Simpan bukti transaksi untuk memudahkan verifikasi',
            'Gunakan fitur chat untuk respon lebih cepat'
        ];
        $randomTip = $helpTips[array_rand($helpTips)];
    @endphp

    {{-- ================= HERO SECTION PREMIUM ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 overflow-hidden">
        
        <!-- Decorative Elements Premium -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        
        <!-- Particle Effects (CSS Dots) -->
        <div class="absolute inset-0" style="background-image: radial-gradient(#3B82F6 1px, transparent 1px); background-size: 30px 30px; opacity: 0.1;"></div>
        
        <div class="relative max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="text-center">
                <!-- Animated Icon -->
                <div class="inline-flex items-center justify-center relative mb-6">
                    <div class="absolute inset-0 bg-blue-400 rounded-full blur-xl opacity-50 animate-ping"></div>
                    <div class="absolute inset-0 bg-blue-400 rounded-full blur-xl opacity-30 animate-pulse"></div>
                    <div class="relative w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-2xl transform hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-headset text-white text-4xl"></i>
                    </div>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-bold text-blue-900 mb-4 leading-tight">
                    Halo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">ada yang bisa kami bantu?</span>
                </h1>
                
                <p class="text-lg md:text-xl text-blue-600/80 mb-8 max-w-2xl mx-auto">
                    Pilih kategori layanan atau cari jawaban dari ribuan pertanyaan yang tersedia
                </p>
                
                <!-- Premium Search Bar -->
                
                <!-- Live Support Status -->
                <div class="flex items-center justify-center mt-6 space-x-4 text-sm">
                    <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm border border-blue-100">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        <span class="text-blue-700">{{ $supportStats['online_users'] }} petugas online</span>
                    </div>
                    
                    <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm border border-blue-100">
                        <i class="fas fa-bolt text-yellow-500"></i>
                        <span class="text-blue-700">Respon < {{ $supportStats['response_time'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= QUICK STATS ================= --}}
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-7 -mt-6 relative z-20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-4 flex items-center space-x-3 transform hover:-translate-y-1 transition-all duration-300 hover:shadow-xl">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-question-circle text-blue-600"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-blue-900">{{ $totalQuestions }}+</span>
                    <p class="text-xs text-blue-600">Pertanyaan</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-4 flex items-center space-x-3 transform hover:-translate-y-1 transition-all duration-300 hover:shadow-xl">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-headset text-green-600"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-blue-900">{{ $supportStats['today_help'] }}</span>
                    <p class="text-xs text-blue-600">Hari ini</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-4 flex items-center space-x-3 transform hover:-translate-y-1 transition-all duration-300 hover:shadow-xl">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-smile text-yellow-600"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-blue-900">{{ $supportStats['satisfaction'] }}</span>
                    <p class="text-xs text-blue-600">Kepuasan</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-4 flex items-center space-x-3 transform hover:-translate-y-1 transition-all duration-300 hover:shadow-xl">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-purple-600"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-blue-900">{{ $isOperational ? 'Online' : 'Offline' }}</span>
                    <p class="text-xs text-blue-600">24/7 Support</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header dengan Progress -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <h2 class="text-2xl md:text-3xl font-bold text-blue-900">
                        <i class="fas fa-th-large mr-2 text-blue-500"></i>
                        Kategori <span class="text-blue-600">Layanan</span>
                    </h2>
                    
                    @if($selectedCategory)
                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1.5 rounded-full font-medium">
                        <i class="fas fa-filter mr-1"></i> Filtered
                    </span>
                    @endif
                </div>
                
                <!-- Progress Bar -->
                <div class="flex items-center space-x-3">
                    <div class="w-32 h-2 bg-blue-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-500" 
                             style="width: {{ $categoryProgress }}%"></div>
                    </div>
                    <span class="text-xs text-blue-600">{{ $categoryProgress }}% pertanyaan tersedia</span>
                </div>
            </div>
            
            <div class="mt-4 md:mt-0 flex items-center space-x-2">
                <span class="text-sm text-blue-600 bg-blue-50 px-4 py-2 rounded-lg border border-blue-200">
                    <i class="fas fa-sync-alt mr-1 text-xs"></i> 
                    Diupdate {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>

        {{-- GRID KATEGORI PREMIUM --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
            
            {{-- Tombol "Semua" Premium --}}
            <a href="{{ route('pembeli.bantuan') }}" 
               class="group relative flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 border-2 {{ !request('category') ? 'border-blue-500 bg-gradient-to-b from-blue-50 to-white' : 'border-blue-100 hover:border-blue-300' }} overflow-hidden transform hover:-translate-y-2">
                
                <!-- Shine Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                
                <div class="relative">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 shadow-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 {{ !request('category') ? 'ring-4 ring-blue-300 ring-offset-2' : '' }}">
                        <i class="fas fa-th-large text-white text-2xl"></i>
                    </div>
                    
                    <span class="font-bold {{ !request('category') ? 'text-blue-700' : 'text-blue-800 group-hover:text-blue-600' }} text-sm md:text-base block text-center">
                        Semua Topik
                    </span>
                    
                    @if(!request('category'))
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </span>
                    @endif
                    
                    <span class="text-xs text-blue-400 mt-2 block">
                        {{ $totalQuestions }} pertanyaan
                    </span>
                </div>
            </a>

            {{-- LOOP KATEGORI DENGAN GRADIENT DINAMIS --}}
            @foreach($categories as $index => $cat)
            <a href="{{ route('pembeli.bantuan', ['category' => $cat['id']]) }}" 
               class="group relative flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 border-2 {{ request('category') == $cat['id'] ? 'border-blue-500 bg-gradient-to-b from-blue-50 to-white' : 'border-blue-100 hover:border-blue-300' }} overflow-hidden transform hover:-translate-y-2">
                
                <!-- Shine Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                
                <div class="relative">
                    {{-- Icon dengan gradient dinamis --}}
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $gradientColors[$index % count($gradientColors)] }} flex items-center justify-center mb-4 shadow-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 {{ request('category') == $cat['id'] ? 'ring-4 ring-blue-300 ring-offset-2' : '' }}">
                        <i class="fas {{ $cat['icon'] }} text-white text-2xl"></i>
                    </div>
                    
                    <span class="font-bold {{ request('category') == $cat['id'] ? 'text-blue-700' : 'text-blue-800 group-hover:text-blue-600' }} text-sm md:text-base block text-center">
                        {{ $cat['label'] }}
                    </span>
                    
                    @if(request('category') == $cat['id'])
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </span>
                    @endif
                    
                    @php
                        $categoryCount = rand(5, 25); // Simulasi jumlah pertanyaan per kategori
                    @endphp
                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full mt-2 inline-block">
                        {{ $categoryCount }} pertanyaan
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        {{-- ================= FAQ SECTION PREMIUM ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main FAQ Column -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-2xl border border-blue-100 overflow-hidden">
                    
                    <!-- Header Premium -->
                    <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 relative overflow-hidden">
                        <!-- Decorative -->
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mt-10 -mr-10"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full -mb-10 -ml-10"></div>
                        
                        <div class="relative flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <i class="fas fa-question-circle text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-xl">
                                    @if(request('category'))
                                        {{ ucfirst(request('category')) }}
                                    @else
                                        Pertanyaan Populer
                                    @endif
                                </h3>
                                <p class="text-blue-100 text-sm">
                                    <i class="fas fa-star mr-1 text-yellow-300"></i> 
                                    {{ $faqs->count() }} jawaban tersedia
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- FAQ ACCORDION PREMIUM --}}
                    <div class="divide-y divide-blue-100" x-data="{ active: null }">
                        @forelse($faqs as $faq)
                            <div class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-white transition-all duration-300">
                                <button @click="active = active === {{ $faq->id }} ? null : {{ $faq->id }}" 
                                        class="w-full text-left px-6 py-5 flex items-center justify-between focus:outline-none">
                                    
                                    <div class="flex items-start space-x-4 flex-1">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                                <i class="fas fa-question text-white text-xs"></i>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-1 pr-8">
                                            <span class="text-base font-semibold text-blue-900 group-hover:text-blue-700 transition pr-4">
                                                {{ $faq->question }}
                                            </span>
                                            
                                            <!-- Meta Info -->
                                            <div class="flex items-center space-x-3 mt-1">
                                                <span class="text-xs text-blue-400">
                                                    <i class="fas fa-clock mr-1"></i> 
                                                    {{ rand(1, 7) }} hari lalu
                                                </span>
                                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">
                                                    <i class="fas fa-star mr-1 text-xs"></i> Populer
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <span class="text-xs text-blue-400">{{ rand(10, 99) }} views</span>
                                        <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center group-hover:bg-blue-100 transition">
                                            <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300 text-sm"
                                               :class="active === {{ $faq->id }} ? 'transform rotate-180' : ''"></i>
                                        </div>
                                    </div>
                                </button>
                                
                                <div x-show="active === {{ $faq->id }}" 
                                     x-collapse
                                     x-cloak
                                     class="px-6 pb-6 pl-[4.5rem] pr-6 text-gray-600 leading-relaxed bg-gradient-to-r from-blue-50/30 to-transparent">
                                    
                                    <div class="border-l-4 border-gradient-to-b from-blue-500 to-blue-600 pl-4 py-2">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex items-center space-x-4 mt-4">
                                        <button class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                                            <i class="fas fa-thumbs-up mr-1"></i> Bermanfaat ({{ rand(5, 20) }})
                                        </button>
                                        <button class="text-xs text-gray-500 hover:text-gray-700 flex items-center">
                                            <i class="fas fa-flag mr-1"></i> Laporkan
                                        </button>
                                        <a href="#" class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                                            <i class="fas fa-share mr-1"></i> Bagikan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- EMPTY STATE PREMIUM --}}
                            <div class="p-16 text-center">
                                <div class="relative inline-block">
                                    <div class="absolute inset-0 bg-blue-400 rounded-full blur-3xl opacity-20"></div>
                                    <div class="relative w-28 h-28 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-white shadow-2xl">
                                        <i class="fas fa-search text-5xl text-blue-400"></i>
                                    </div>
                                </div>
                                
                                <h4 class="text-2xl font-bold text-blue-900 mb-3">
                                    Belum Ada Pertanyaan
                                </h4>
                                
                                <p class="text-blue-600 mb-8 max-w-md mx-auto">
                                    @if(request('category'))
                                        Belum ada pertanyaan untuk kategori "{{ ucfirst(request('category')) }}"
                                    @else
                                        Belum ada pertanyaan yang tersedia
                                    @endif
                                </p>
                                
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    <a href="{{ route('pembeli.bantuan') }}" 
                                       class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                                        <i class="fas fa-th-large mr-2"></i>
                                        Lihat Semua Kategori
                                    </a>
                                    <a href="https://wa.me/628123456789" 
                                       class="px-8 py-4 bg-white text-blue-700 border-2 border-blue-200 rounded-xl font-bold hover:border-blue-400 hover:bg-blue-50 transition shadow-lg">
                                        <i class="fab fa-whatsapp mr-2 text-green-600"></i>
                                        Hubungi Admin
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- FAQ Footer -->
                    @if($faqs->count() > 0)
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50/50 to-white border-t border-blue-100 flex items-center justify-between">
                        <span class="text-sm text-blue-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Menampilkan {{ $faqs->count() }} pertanyaan
                        </span>
                        
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 flex items-center group">
                            Lihat Semua
                            <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar Column -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Operational Hours Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                    <div class="p-5 bg-gradient-to-r from-blue-500 to-blue-600">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <h4 class="font-bold text-white">Jam Operasional</h4>
                        </div>
                    </div>
                    
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-blue-700">Senin - Jumat</span>
                            <span class="text-sm font-semibold text-blue-900">{{ $operationalHours['senin_jumat'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-blue-700">Sabtu</span>
                            <span class="text-sm font-semibold text-blue-900">{{ $operationalHours['sabtu'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-blue-700">Minggu</span>
                            <span class="text-sm font-semibold text-blue-900">{{ $operationalHours['minggu'] }}</span>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-blue-100">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-blue-600">Status Layanan:</span>
                                @if($isOperational)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                        Offline
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
             
                <!-- Contact Card -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mt-10 -mr-10"></div>
                        
                        <div class="relative">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                    <i class="fab fa-whatsapp text-white text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-white">Chat Admin</h4>
                            </div>
                            
                            <p class="text-white/90 text-sm mb-4">
                                Respon cepat dalam <strong>{{ $supportStats['response_time'] }}</strong>
                            </p>
                            
                            <a href="https://wa.me/62859152698690" target="_blank" 
                               class="inline-flex items-center px-6 py-3 bg-white text-green-700 rounded-xl font-bold hover:bg-green-50 transition-all duration-300 transform hover:-translate-y-1 shadow-xl w-full justify-center">
                                <i class="fab fa-whatsapp mr-2 text-xl"></i>
                                Mulai Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #F0F7FF;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #3B82F6, #2563EB);
            border-radius: 10px;
            border: 2px solid #F0F7FF;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #2563EB, #1D4ED8);
        }
        
        /* Gradient Border */
        .border-gradient-to-b {
            border-image: linear-gradient(to bottom, #3B82F6, #2563EB) 1;
        }
        
        /* Smooth Animations */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
        
        /* Shine Effect */
        .group {
            position: relative;
            overflow: hidden;
        }
        
        /* Loading Animation */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Pulse Animation for Live Status */
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.5; }
            80% { transform: scale(1.2); opacity: 0; }
            100% { transform: scale(1.4); opacity: 0; }
        }
        
        /* Responsive Improvements */
        @media (max-width: 768px) {
            .grid-cols-2 {
                gap: 1rem;
            }
            
            .text-4xl {
                font-size: 2rem;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            // Keyboard shortcut for search (/)
            document.addEventListener('keydown', (e) => {
                if (e.key === '/' && !e.target.matches('input, textarea')) {
                    e.preventDefault();
                    const searchInput = document.querySelector('input[name="search"]');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            });
            
            // Track FAQ views (simulasi)
            document.querySelectorAll('[x-data]').forEach((el, index) => {
                el.addEventListener('click', () => {
                    console.log(`FAQ ${index + 1} viewed`);
                });
            });
            
            // Auto-dismiss notifications
            setTimeout(() => {
                const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
        
        // Smooth scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
    @endpush

</x-pembeli-layout>