<x-pengawas-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Manajemen User') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Kelola semua pengguna dalam sistem</p>
            </div>
        </div>
    </x-slot>
    <div class="max-w-9xl mx-auto sm:px-7">
        <div class="flex  space-x-2 text-sm text-gray-600">
            <a href="{{ route('pengawas.users.create') }}" 
               class="bg-gradient-to-r from-[#80489C] to-[#9a65b3] text-white px-5 py-3 rounded-lg hover:from-[#66337a] hover:to-[#80489C] transition-all duration-300 shadow-md hover:shadow-lg font-medium flex items-center space-x-2">
                <i class="fas fa-user-plus"></i>
                <span>Tambah User Baru</span>
            </a>
        </div>
    </div>

    <div class="py-5">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-5 py-4 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-medium">{{ session('success') }}</p>
                            <p class="text-sm text-green-600 mt-1">Perubahan berhasil disimpan</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-5 py-4 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-medium">{{ session('error') }}</p>
                            <p class="text-sm text-red-600 mt-1">Terjadi kesalahan</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- User Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Daftar Pengguna</h3>
                            <p class="text-gray-600 text-sm">Menampilkan {{ $users->count() }} dari {{ $users->total() }} pengguna</p>
                        </div>
                        
                        <!-- Search and Filter -->
                        <div class="flex items-center space-x-4 mt-3 md:mt-0">
                            <div class="relative">
                                <input type="text" placeholder="Cari pengguna..." 
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:border-[#80489C] focus:ring-2 focus:ring-purple-200 focus:outline-none">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <select class="border border-gray-300 rounded-lg px-4 py-2 focus:border-[#80489C] focus:ring-2 focus:ring-purple-200 focus:outline-none">
                                <option value="">Semua Role</option>
                                <option value="1">Administrator</option>
                                <option value="2">Pengawas</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>Nama</span>
                                        <i class="fas fa-sort text-gray-400"></i>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status Email
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-[#80489C] to-[#9a65b3] flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $user->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role == 1) 
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-user-shield mr-1"></i>
                                            Administrator
                                        </span>
                                    @elseif($user->role == 2) 
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-eye mr-1"></i>
                                            Pengawas
                                        </span>
                                    @else 
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-shopping-cart mr-1"></i>
                                            Pembeli
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->email_verified_at)
                                        {{-- SUDAH VERIFIKASI (HIJAU) --}}
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                            Terverifikasi
                                        </span>
                                    @else
                                        {{-- BELUM VERIFIKASI (ABU-ABU) --}}
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                            <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                            Belum Terverifikasi
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('pengawas.users.edit', $user->id) }}" 
                                           class="text-[#80489C] hover:text-[#66337a] transition-colors duration-200 flex items-center space-x-1 group">
                                            <i class="fas fa-edit text-sm"></i>
                                            <span class="hidden md:inline group-hover:underline">Edit</span>
                                        </a>
                                    
                                        
                                        <form action="{{ route('pengawas.users.destroy', $user->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 transition-colors duration-200 flex items-center space-x-1 group">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                                <span class="hidden md:inline group-hover:underline">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer with Custom Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="text-sm text-gray-700 mb-4 md:mb-0">
                            Menampilkan <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span> sampai 
                            <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span> dari 
                            <span class="font-medium">{{ $users->total() }}</span> pengguna
                        </div>
                        
                        <!-- Custom Pagination -->
                        @if($users->hasPages())
                        <div class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if($users->onFirstPage())
                                <span class="px-3 py-2 border border-gray-300 rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" 
                                   class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif
                            
                            {{-- Pagination Elements --}}
                            <div class="flex items-center space-x-1">
                                @php
                                    $current = $users->currentPage();
                                    $last = $users->lastPage();
                                    $start = max($current - 2, 1);
                                    $end = min($current + 2, $last);
                                    
                                    if($start > 1) {
                                        echo '<a href="' . $users->url(1) . '" class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">1</a>';
                                        if($start > 2) {
                                            echo '<span class="px-3 py-2 text-gray-500">...</span>';
                                        }
                                    }
                                    
                                    for($page = $start; $page <= $end; $page++) {
                                        if($page == $current) {
                                            echo '<span class="px-3 py-2 border border-[#80489C] bg-[#80489C] text-white rounded-md font-medium">' . $page . '</span>';
                                        } else {
                                            echo '<a href="' . $users->url($page) . '" class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">' . $page . '</a>';
                                        }
                                    }
                                    
                                    if($end < $last) {
                                        if($end < $last - 1) {
                                            echo '<span class="px-3 py-2 text-gray-500">...</span>';
                                        }
                                        echo '<a href="' . $users->url($last) . '" class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">' . $last . '</a>';
                                    }
                                @endphp
                            </div>
                            
                            {{-- Next Page Link --}}
                            @if($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" 
                                   class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="px-3 py-2 border border-gray-300 rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-[#80489C] text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900">Informasi Manajemen User</h4>
                        <p class="text-gray-700 mt-2">
                            Anda dapat menambah, mengedit, atau menghapus pengguna dalam sistem. 
                            Pastikan untuk memberikan role yang sesuai dengan kebutuhan setiap pengguna.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Administrator: Akses penuh sistem</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Pengawas: Monitoring dan laporan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Details Modal (Hidden by default) -->
    <div id="userDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Detail Pengguna</h3>
                    <button onclick="closeUserDetails()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div id="userDetailsContent">
                    <!-- Content will be loaded via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showUserDetails(userId) {
            // In a real application, you would fetch user details via AJAX
            // For now, we'll show a placeholder
            const content = `
                <div class="space-y-4">
                    <div class="flex items-center justify-center">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-[#80489C] to-[#9a65b3] flex items-center justify-center text-white text-3xl font-bold">
                            L
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <h4 class="text-lg font-bold text-gray-900" id="userDetailName">Loading...</h4>
                        <p class="text-gray-600" id="userDetailEmail">Loading...</p>
                    </div>
                    
                    <div class="space-y-3 pt-4 border-t border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Role:</span>
                            <span class="font-medium" id="userDetailRole">Loading...</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Bergabung:</span>
                            <span class="font-medium" id="userDetailJoinDate">Loading...</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium text-green-600">Aktif</span>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            Detail lengkap pengguna akan ditampilkan di sini setelah data diambil dari server.
                        </p>
                    </div>
                </div>
            `;
            
            document.getElementById('userDetailsContent').innerHTML = content;
            document.getElementById('userDetailsModal').classList.remove('hidden');
            
            // In a real app, you would fetch data here:
            // fetch(`/api/users/${userId}`)
            //     .then(response => response.json())
            //     .then(data => {
            //         document.getElementById('userDetailName').textContent = data.name;
            //         document.getElementById('userDetailEmail').textContent = data.email;
            //         document.getElementById('userDetailRole').textContent = getRoleName(data.role);
            //         document.getElementById('userDetailJoinDate').textContent = new Date(data.created_at).toLocaleDateString('id-ID');
            //     });
        }
        
        function closeUserDetails() {
            document.getElementById('userDetailsModal').classList.add('hidden');
        }
        
        function getRoleName(role) {
            switch(role) {
                case 1: return 'Administrator';
                case 2: return 'Pengawas';
                case 3: return 'Pembeli';
                default: return 'Unknown';
            }
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeUserDetails();
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('userDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserDetails();
            }
        });
    </script>
</x-pengawas-layout>