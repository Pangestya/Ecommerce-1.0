<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Manajemen Produk') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Kelola semua produk dalam sistem</p>
            </div>
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Manajemen Produk</span>
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
                            <p class="text-sm text-green-600 mt-1">Perubahan berhasil disimpan</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#432C7A]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Produk</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $products->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes text-[#432C7A] text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Produk Tayang</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ $products->where('is_active', true)->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Produk Unggulan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ $products->where('is_featured', true)->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- button tambah produk -->
            <div class="max-w-9xl mx-auto">
                <div class="flex  space-x-2 text-sm text-gray-600">
                    <a href="{{ route('admin.products.create') }}" 
                    class="px-6 py-3.5 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-xl hover:from-[#35205e] hover:to-[#432C7A] shadow-lg font-semibold flex items-center">
                        <span>+ Tambah Produk Baru</span>
                    </a>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Daftar Produk</h3>
                            <p class="text-gray-600 text-sm">Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk</p>
                        </div>
                        
                        <!-- Search and Filter -->
                        <div class="flex items-center space-x-4 mt-3 md:mt-0">
                            <div class="relative">
                                <input type="text" placeholder="Cari produk..." 
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            
                            <select class="border border-gray-300 rounded-lg px-4 py-2 focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none">
                                <option value="">Semua Status</option>
                                <option value="active">Tayang</option>
                                <option value="inactive">Sembunyi</option>
                                <option value="featured">Unggulan</option>
                                <option value="low_stock">Stok Rendah</option>
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
                                    Gambar
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Info Produk
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Stok & Harga
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
                            @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Gambar -->
                                <td class="px-6 py-4">
                                    <div class="relative group">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow-sm group-hover:shadow-md transition-shadow duration-200">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-lg transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                <i class="fas fa-search-plus text-white text-lg"></i>
                                            </div>
                                        @else
                                            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg border border-gray-300 flex items-center justify-center">
                                                <i class="fas fa-box text-gray-400 text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Info Produk -->
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <div class="flex items-start">
                                            <div>
                                                <div class="text-sm font-bold text-gray-900 mb-1">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500 mb-2 truncate">
                                                    @if($product->description)
                                                        {{ Str::limit($product->description, 80) }}
                                                    @else
                                                        <span class="text-gray-400">Tidak ada deskripsi</span>
                                                    @endif
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    @if($product->is_featured)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-star mr-1 text-xs"></i>Unggulan
                                                        </span>
                                                    @endif
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        ID: {{ $product->id }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Stok & Harga -->
                                <td class="px-6 py-4">
                                    <div class="space-y-3">
                                        <!-- Harga -->
                                        <div>
                                            <div class="text-sm text-gray-500">Harga</div>
                                            <div class="text-lg font-bold text-gray-900">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        
                                        <!-- Stok -->
                                        <div>
                                            <div class="flex justify-between items-center mb-1">
                                                <div class="text-sm text-gray-500">Stok</div>
                                                <div class="text-sm font-medium {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-700' }}">
                                                    {{ $product->stock }} unit
                                                </div>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                @php
                                                    $stockPercentage = min(100, ($product->stock / 100) * 100);
                                                    $stockColor = $product->stock < 10 ? 'bg-red-500' : ($product->stock < 30 ? 'bg-yellow-500' : 'bg-green-500');
                                                @endphp
                                                <div class="h-2 rounded-full {{ $stockColor }}"@style(['width: ' . $stockPercentage . '%'])></div>
                                            </div>
                                            @if($product->stock < 10)
                                                <div class="text-xs text-red-500 mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>Stok rendah
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Status Tayang -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center">
                                        <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <button type="submit" 
                                                    class="relative inline-flex h-7 w-14 items-center rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#432C7A] focus:ring-offset-2 {{ $product->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-gray-300 to-gray-400' }} shadow-sm hover:shadow-md"
                                                    title="Klik untuk mengubah status">
                                                <span class="sr-only">Ubah Status</span>
                                                <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition-transform duration-300 {{ $product->is_active ? 'translate-x-8' : 'translate-x-1' }}"></span>
                                            </button>
                                        </form>
                                        
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                <div class="w-2 h-2 rounded-full mr-2 {{ $product->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                                                {{ $product->is_active ? 'Tayang' : 'Sembunyi' }}
                                            </span>
                                            
                                            <div class="text-xs text-gray-500">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ $product->created_at->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <!-- Edit -->
                                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                                           class="text-[#432C7A] hover:text-[#35205e] transition-colors duration-200 flex items-center space-x-1 group relative"
                                           title="Edit Produk">
                                            <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                                                <i class="fas fa-edit text-sm"></i>
                                            </div>
                                            <span class="hidden md:inline text-sm font-medium">Edit</span>
                                        </a>
                                        
                                        <!-- Quick View -->
                                        <button type="button" 
                                                data-product-id="{{ $product->id }}" onclick="showProductDetails(this)"
                                                class="text-blue-600 hover:text-blue-800 transition-colors duration-200 flex items-center space-x-1 group"
                                                title="Lihat Detail">
                                            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                                <i class="fas fa-eye text-sm"></i>
                                            </div>
                                            <span class="hidden md:inline text-sm font-medium">Detail</span>
                                        </button>
                                        
                                        <!-- Delete -->
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}?');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 transition-colors duration-200 flex items-center space-x-1 group"
                                                    title="Hapus Produk">
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
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="text-sm text-gray-700 mb-4 md:mb-0">
                            Menampilkan <span class="font-medium">{{ $products->firstItem() }}</span> sampai 
                            <span class="font-medium">{{ $products->lastItem() }}</span> dari 
                            <span class="font-medium">{{ $products->total() }}</span> produk
                        </div>
                        
                        <!-- Custom Pagination -->
                        @if($products->hasPages())
                        <div class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if($products->onFirstPage())
                                <span class="px-3 py-2 border border-gray-300 rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" 
                                   class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#432C7A] transition-colors duration-200">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif
                            
                            {{-- Pagination Elements --}}
                            <div class="flex items-center space-x-1">
                                @php
                                    $current = $products->currentPage();
                                    $last = $products->lastPage();
                                    $start = max($current - 2, 1);
                                    $end = min($current + 2, $last);
                                    
                                    if($start > 1) {
                                        echo '<a href="' . $products->url(1) . '" class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#432C7A] transition-colors duration-200">1</a>';
                                        if($start > 2) {
                                            echo '<span class="px-3 py-2 text-gray-500">...</span>';
                                        }
                                    }
                                    
                                    for($page = $start; $page <= $end; $page++) {
                                        if($page == $current) {
                                            echo '<span class="px-3 py-2 border border-[#432C7A] bg-[#432C7A] text-white rounded-md font-medium">' . $page . '</span>';
                                        } else {
                                            echo '<a href="' . $products->url($page) . '" class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#432C7A] transition-colors duration-200">' . $page . '</a>';
                                        }
                                    }
                                    
                                    if($end < $last) {
                                        if($end < $last - 1) {
                                            echo '<span class="px-3 py-2 text-gray-500">...</span>';
                                        }
                                        echo '<a href="' . $products->url($last) . '" class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#432C7A] transition-colors duration-200">' . $last . '</a>';
                                    }
                                @endphp
                            </div>
                            
                            {{-- Next Page Link --}}
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" 
                                   class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#432C7A] transition-colors duration-200">
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
                        <i class="fas fa-info-circle text-[#432C7A] text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900">Informasi Manajemen Produk</h4>
                        <p class="text-gray-700 mt-2">
                            Anda dapat mengelola semua produk dalam sistem. Fitur yang tersedia:
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Toggle Status: Kontrol visibilitas produk</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Produk Unggulan: Highlight produk terbaik</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-[#432C7A] rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Quick Actions: Edit, lihat detail, dan hapus</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div id="productDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Detail Produk</h3>
                    <button onclick="closeProductDetails()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div id="productDetailsContent">
                    <!-- Content will be loaded via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showProductDetails(productId) {
            // In a real application, you would fetch product details via AJAX
            // For now, we'll show a placeholder
            const content = `
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Image -->
                        <div class="bg-gray-100 rounded-xl p-4 flex items-center justify-center">
                            <div class="w-48 h-48 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-gray-400 text-5xl"></i>
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div>
                            <div class="mb-4">
                                <h4 class="text-lg font-bold text-gray-900" id="productDetailName">Loading...</h4>
                                <p class="text-gray-600" id="productDetailSKU">SKU: Loading...</p>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Harga:</span>
                                    <span class="font-bold text-gray-900" id="productDetailPrice">Loading...</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Stok:</span>
                                    <span class="font-medium" id="productDetailStock">Loading...</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="font-medium text-green-600" id="productDetailStatus">Loading...</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal Ditambahkan:</span>
                                    <span class="font-medium" id="productDetailCreated">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="font-bold text-gray-900 mb-3">Deskripsi Produk</h4>
                        <p class="text-gray-700" id="productDetailDescription">
                            Loading description...
                        </p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 text-center">
                            Detail lengkap produk akan ditampilkan di sini setelah data diambil dari server.
                        </p>
                    </div>
                </div>
            `;
            
            document.getElementById('productDetailsContent').innerHTML = content;
            document.getElementById('productDetailsModal').classList.remove('hidden');
            
            // In a real app, you would fetch data here:
            // fetch(`/api/products/${productId}`)
            //     .then(response => response.json())
            //     .then(data => {
            //         document.getElementById('productDetailName').textContent = data.name;
            //         document.getElementById('productDetailSKU').textContent = `SKU: ${data.sku}`;
            //         document.getElementById('productDetailPrice').textContent = `Rp ${data.price.toLocaleString()}`;
            //         document.getElementById('productDetailStock').textContent = `${data.stock} unit`;
            //         document.getElementById('productDetailStatus').textContent = data.is_active ? 'Tayang' : 'Sembunyi';
            //         document.getElementById('productDetailStatus').className = `font-medium ${data.is_active ? 'text-green-600' : 'text-gray-600'}`;
            //         document.getElementById('productDetailCreated').textContent = new Date(data.created_at).toLocaleDateString('id-ID');
            //         document.getElementById('productDetailDescription').textContent = data.description || 'Tidak ada deskripsi';
            //     });
        }
        
        function closeProductDetails() {
            document.getElementById('productDetailsModal').classList.add('hidden');
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeProductDetails();
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('productDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductDetails();
            }
        });
        
        // Toggle button animation
        document.querySelectorAll('form[action*="toggle-status"] button').forEach(button => {
            button.addEventListener('click', function() {
                this.classList.add('active');
                setTimeout(() => this.classList.remove('active'), 300);
            });
        });
    </script>

    <style>
        /* Custom styles for product management */
        .product-image-hover {
            transition: all 0.3s ease;
        }
        
        .product-image-hover:hover {
            transform: scale(1.05);
        }
        
        .stock-bar-low {
            background-color: #ef4444;
        }
        
        .stock-bar-medium {
            background-color: #f59e0b;
        }
        
        .stock-bar-high {
            background-color: #10b981;
        }
        
        /* Toggle switch animation */
        .toggle-switch.active span {
            animation: toggleSwitch 0.3s ease;
        }
        
        @keyframes toggleSwitch {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        /* Hover effects for action buttons */
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
        }
        
        /* Pagination active state */
        .pagination-active {
            background-color: #432C7A;
            color: white;
            border-color: #432C7A;
        }
        
        .pagination-link:hover {
            border-color: #432C7A;
            background-color: rgba(67, 44, 122, 0.05);
        }
    </style>
</x-admin-layout>