<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Manajemen Kategori') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Kelola semua kategori produk</p>
            </div>
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Manajemen Kategori</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-5 py-4 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-medium">{{ session('success') }}</p>
                            <p class="text-sm text-green-600 mt-1">Operasi berhasil dilakukan</p>
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

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#432C7A]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Kategori</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $categories->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-th-large text-[#432C7A] text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Produk</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ $categories->sum(function($category) { return $category->products->count(); }) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Kategori Rata-rata</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ round($categories->avg(function($category) { return $category->products->count(); }), 1) }}
                            </p>
                            <p class="text-green-600 text-sm mt-2">Produk per kategori</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-bar text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- button tambah produk -->
            <div class="max-w-9xl mx-auto">
                <div class="flex  space-x-2 text-sm text-gray-600">
                    <a href="{{ route('admin.categories.create') }}" 
                    class="px-6 py-3.5 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-xl hover:from-[#35205e] hover:to-[#432C7A] shadow-lg font-semibold flex items-center">
                        <span>+ Tambah Kategori</span>
                    </a>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Daftar Kategori</h3>
                            <p class="text-gray-600 text-sm">Menampilkan semua kategori produk</p>
                        </div>
                        
                        <!-- Search -->
                        <div class="flex items-center space-x-4 mt-3 md:mt-0">
                            <div class="relative">
                                <input type="text" placeholder="Cari kategori..." 
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Nama Kategori
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Slug
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Jumlah Produk
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Nama Kategori -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-purple-100 to-indigo-100 flex items-center justify-center">
                                                <i class="fas fa-folder text-[#432C7A]"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $category->name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $category->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Slug -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $category->slug }}</div>
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $category->created_at->format('d M Y') }}
                                    </div>
                                </td>

                                <!-- Jumlah Produk -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                            @php
                                                $productCount = $category->products->count();
                                                $maxProducts = $categories->max(function($cat) { return $cat->products->count(); });
                                                $percentage = $maxProducts > 0 ? ($productCount / $maxProducts) * 100 : 0;
                                                $color = $productCount == 0 ? 'bg-gray-400' : 
                                                         ($productCount < 5 ? 'bg-red-500' : 
                                                         ($productCount < 20 ? 'bg-yellow-500' : 'bg-green-500'));
                                            @endphp
                                            <div class="h-2 rounded-full {{ $color }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                                {{ $productCount == 0 ? 'bg-gray-100 text-gray-800' : 
                                                   ($productCount < 5 ? 'bg-red-100 text-red-800' : 
                                                   ($productCount < 20 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                                                {{ $productCount }} Produk
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($productCount > 0)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                            Kosong
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <!-- Edit -->
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                           class="text-[#432C7A] hover:text-[#35205e] transition-colors duration-200 flex items-center space-x-1 group"
                                           title="Edit Kategori">
                                            <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                                                <i class="fas fa-edit text-sm"></i>
                                            </div>
                                            <span class="hidden md:inline text-sm font-medium">Edit</span>
                                        </a>
                                        
                                        <!-- View Products -->
                                        @if($productCount > 0)
                                            <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" 
                                               class="text-blue-600 hover:text-blue-800 transition-colors duration-200 flex items-center space-x-1 group"
                                               title="Lihat Produk">
                                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                                    <i class="fas fa-eye text-sm"></i>
                                                </div>
                                                <span class="hidden md:inline text-sm font-medium">Lihat</span>
                                            </a>
                                        @endif
                                        
                                        <!-- Delete -->
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirmDeleteCategory({{ $productCount }}, '{{ $category->name }}')"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 transition-colors duration-200 flex items-center space-x-1 group"
                                                    title="Hapus Kategori">
                                                <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center group-hover:bg-red-100 transition-colors">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </div>
                                                <span class="hidden md:inline text-sm font-medium">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                @if($categories->isEmpty())
                <div class="px-6 py-12 text-center border-t border-gray-200">
                    <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada kategori</h3>
                    <p class="text-gray-500 mb-6">Tambahkan kategori pertama Anda untuk mengelompokkan produk</p>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-lg hover:from-[#35205e] hover:to-[#432C7A] transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>Tambah Kategori Pertama
                    </a>
                </div>
                @endif
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-[#432C7A] text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900">Informasi Manajemen Kategori</h4>
                        <p class="text-gray-700 mt-2">
                            Kategori membantu mengelompokkan produk untuk navigasi yang lebih mudah. 
                            Fitur yang tersedia:
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-[#432C7A] rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Edit: Ubah nama kategori kapan saja</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Status: Indikator jumlah produk</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Hapus: Hati-hati jika kategori memiliki produk</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Filter: Lihat produk berdasarkan kategori</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteCategory(productCount, categoryName) {
            if (productCount > 0) {
                return confirm(`Kategori "${categoryName}" memiliki ${productCount} produk.\n\nHapus kategori ini akan menyebabkan:\n• Produk menjadi tidak terkategori\n• Kategori tidak dapat dipulihkan\n\nApakah Anda yakin ingin melanjutkan?`);
            }
            return confirm(`Hapus kategori "${categoryName}"?\nKategori ini kosong dan tidak memiliki produk.`);
        }
    </script>

    <style>
        /* Custom styles for category management */
        .category-card {
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 44, 122, 0.1);
        }
        
        .product-count-bar {
            height: 6px;
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        
        .empty-state {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }
        
        /* Status indicators */
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        
        /* Action buttons hover */
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
        }
    </style>
</x-admin-layout>