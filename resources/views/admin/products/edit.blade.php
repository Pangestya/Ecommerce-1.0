<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Edit Produk') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Edit informasi produk {{ $product->name }}</p>
            </div>
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.products.index') }}" class="hover:text-[#80489C]">
                <i class="fas fa-users mr-1"></i> Manajemen Produk
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Edit</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Product Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-[#432C7A]">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#432C7A] to-[#5a409e] flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">P{{ $product->id }}</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Product ID</p>
                            <p class="text-lg font-bold text-gray-900">#{{ $product->id }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 
                            {{ $product->is_active ? 'bg-green-100' : 'bg-gray-100' }}">
                            <i class="fas {{ $product->is_active ? 'fa-eye text-green-600' : 'fa-eye-slash text-gray-600' }} text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Saat Ini</p>
                            <p class="text-lg font-bold text-gray-900">
                                {{ $product->is_active ? 'Tayang' : 'Sembunyi' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-th-list text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kategori</p>
                            <p class="text-lg font-bold text-gray-900">{{ $product->category->name ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-[#432C7A] to-[#5a409e] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Form Edit Produk</h3>
                            <p class="text-sm text-gray-600">Perbarui informasi produk</p>
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

                    @if(session('success'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-5 py-4 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                <div>
                                    <p class="font-medium">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="editProductForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-info-circle text-[#432C7A] mr-2"></i>
                                Informasi Dasar
                            </h4>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Produk <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-tag text-gray-400"></i>
                                        </div>
                                        <input type="text" 
                                               name="name" 
                                               value="{{ old('name', $product->name) }}" 
                                               class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200"
                                               placeholder="Masukkan nama produk"
                                               required>
                                    </div>
                                </div>

                                <!-- Category Dropdown -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-th-list text-gray-400"></i>
                                        </div>
                                        <select name="category_id" 
                                                class="pl-10 pr-10 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200 bg-white appearance-none cursor-pointer"
                                                required>
                                            <option value="" disabled>Pilih Kategori Produk</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Pilih kategori yang sesuai untuk pengelompokan produk</p>
                                </div>

                                <!-- Price & Stock Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Harga (Rp) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">Rp</span>
                                            </div>
                                            <input type="number" 
                                                   name="price" 
                                                   min="0"
                                                   step="1000"
                                                   value="{{ old('price', $product->price) }}"
                                                   class="pl-12 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200"
                                                   placeholder="0"
                                                   required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Stok <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-boxes text-gray-400"></i>
                                            </div>
                                            <input type="number" 
                                                   name="stock" 
                                                   min="0"
                                                   value="{{ old('stock', $product->stock) }}"
                                                   class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200"
                                                   placeholder="0"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="mb-8">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-shipping-fast text-blue-600"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900">Data Pengiriman</h4>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Berat (Gram) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-weight text-gray-400"></i>
                                            </div>
                                            <input type="number" 
                                                   name="weight" 
                                                   min="1"
                                                   value="{{ old('weight', $product->weight) }}"
                                                   class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 focus:outline-none transition-colors duration-200"
                                                   placeholder="1000"
                                                   required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Dimensi Produk (cm)</label>
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1">Panjang</label>
                                                <div class="relative">
                                                    <input type="number" 
                                                           name="length" 
                                                           min="0"
                                                           value="{{ old('length', $product->length) }}"
                                                           class="pl-8 pr-2 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 focus:outline-none transition-colors duration-200"
                                                           placeholder="P">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1">Lebar</label>
                                                <div class="relative">
                                                    <input type="number" 
                                                           name="width" 
                                                           min="0"
                                                           value="{{ old('width', $product->width) }}"
                                                           class="pl-8 pr-2 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 focus:outline-none transition-colors duration-200"
                                                           placeholder="L">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1">Tinggi</label>
                                                <div class="relative">
                                                    <input type="number" 
                                                           name="height" 
                                                           min="0"
                                                           value="{{ old('height', $product->height) }}"
                                                           class="pl-8 pr-2 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 focus:outline-none transition-colors duration-200"
                                                           placeholder="T">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-align-left text-[#432C7A] mr-2"></i>
                                Deskripsi Produk
                            </h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea name="description" 
                                          rows="4"
                                          class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200 p-3"
                                          placeholder="Masukkan deskripsi lengkap produk...">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>

                        <!-- Images Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-images text-[#432C7A] mr-2"></i>
                                Gambar Produk
                            </h4>
                            
                            <div class="space-y-5">
                                <!-- Current Main Image -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Gambar Utama Saat Ini
                                    </label>
                                    <div class="flex items-center space-x-6">
                                        @if($product->image)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                     class="w-32 h-32 object-cover rounded-lg border border-gray-200 shadow">
                                                <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-0 hover:bg-opacity-10 rounded-lg transition-all duration-200 flex items-center justify-center opacity-0 hover:opacity-100">
                                                    <span class="text-white text-sm bg-black bg-opacity-50 px-3 py-1 rounded">Gambar Utama</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg border border-gray-300 flex items-center justify-center">
                                                <i class="fas fa-box text-gray-400 text-3xl"></i>
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Ganti Gambar Utama (Opsional)
                                            </label>
                                            <input type="file" 
                                                   name="image" 
                                                   id="mainImage"
                                                   accept="image/*"
                                                   class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-50 file:text-[#432C7A] hover:file:bg-purple-100">
                                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Gallery Images -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tambah Foto Galeri (Opsional)
                                    </label>
                                    <div class="relative">
                                        <input type="file" 
                                               name="gallery_images[]" 
                                               id="galleryImages"
                                               accept="image/*"
                                               multiple
                                               class="hidden"
                                               onchange="previewGalleryImages(this)">
                                        
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                             onclick="document.getElementById('galleryImages').click()">
                                            <div id="galleryPreview" class="flex flex-col items-center justify-center">
                                                <i class="fas fa-images text-3xl text-gray-400 mb-3"></i>
                                                <p class="text-sm text-gray-600">Klik untuk tambah gambar galeri</p>
                                                <p class="text-xs text-gray-500 mt-1">Maks 10 file • 5MB per file</p>
                                            </div>
                                        </div>
                                        
                                        <div id="galleryImagesList" class="mt-3 grid grid-cols-3 gap-3 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Options -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-cog text-[#432C7A] mr-2"></i>
                                Status & Opsi
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 cursor-pointer"
                                     onclick="toggleCheckbox('is_active')">
                                    <div class="flex-shrink-0 mr-4">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               id="is_active"
                                               {{ $product->is_active ? 'checked' : '' }}
                                               class="w-5 h-5 text-[#432C7A] border-gray-300 rounded focus:ring-[#432C7A]">
                                    </div>
                                    <div>
                                        <label for="is_active" class="font-medium text-gray-900 cursor-pointer">Produk Aktif</label>
                                        <p class="text-sm text-gray-600 mt-1">Tampilkan produk di katalog</p>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="w-3 h-3 {{ $product->is_active ? 'bg-green-500' : 'bg-gray-400' }} rounded-full"></span>
                                    </div>
                                </div>

                                <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 cursor-pointer"
                                     onclick="toggleCheckbox('is_featured')">
                                    <div class="flex-shrink-0 mr-4">
                                        <input type="checkbox" 
                                               name="is_featured" 
                                               id="is_featured"
                                               {{ $product->is_featured ? 'checked' : '' }}
                                               class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                    </div>
                                    <div>
                                        <label for="is_featured" class="font-medium text-gray-900 cursor-pointer">Produk Unggulan</label>
                                        <p class="text-sm text-gray-600 mt-1">Tandai sebagai produk unggulan</p>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fas fa-star {{ $product->is_featured ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between pt-6 border-t border-gray-200">
                            <div class="mb-4 md:mb-0">
                                <a href="{{ route('admin.products.index') }}" 
                                   class="flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Kembali ke Daftar Produk
                                </a>
                            </div>
                            <div class="flex space-x-4">
                                <button type="reset" 
                                        onclick="resetForm()"
                                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                                    <i class="fas fa-redo mr-2"></i>Reset Perubahan
                                </button>
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-lg hover:from-[#35205e] hover:to-[#432C7A] transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Gallery Management -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-images text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Kelola Galeri Foto</h3>
                                <p class="text-sm text-gray-600">Kelola foto-foto produk</p>
                            </div>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                            {{ $product->images->count() }} Foto
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($product->images->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($product->images as $img)
                                <div class="relative group border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-all duration-200">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" 
                                         class="w-full h-48 object-cover">
                                    
                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <div class="flex space-x-2">
                                            <!-- View Button -->
                                            <button type="button" 
                                                    onclick="viewImage('{{ asset('storage/' . $img->image_path) }}')"
                                                    class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors"
                                                    title="Lihat Gambar">
                                                <i class="fas fa-eye text-gray-700 text-sm"></i>
                                            </button>
                                            
                                            <!-- Delete Form -->
                                            <form action="{{ route('admin.products.delete-image', $img->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Hapus foto ini dari galeri?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors"
                                                        title="Hapus Gambar">
                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Info -->
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3">
                                        <p class="text-xs text-white truncate">
                                            Foto {{ $loop->iteration }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Belum ada foto galeri untuk produk ini</p>
                            <p class="text-sm text-gray-400 mt-2">Tambahkan foto melalui form di atas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Image View Modal -->
    <div id="imageViewModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 flex items-center justify-center p-4">
        <div class="relative max-w-4xl w-full">
            <button onclick="closeImageView()" 
                    class="absolute -top-10 right-0 text-white hover:text-gray-300">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <img id="modalImageView" src="" class="w-full h-auto rounded-lg shadow-2xl">
        </div>
    </div>

    <script>
        // Toggle checkbox when clicking on the card
        function toggleCheckbox(checkboxId) {
            const checkbox = document.getElementById(checkboxId);
            checkbox.checked = !checkbox.checked;
        }

        // Preview gallery images for edit
        function previewGalleryImages(input) {
            const galleryList = document.getElementById('galleryImagesList');
            const preview = document.getElementById('galleryPreview');
            
            if (input.files && input.files.length > 0) {
                galleryList.innerHTML = '';
                galleryList.classList.remove('hidden');
                
                // Hide the upload prompt if there are files
                preview.style.display = 'none';
                
                // Limit to 10 files
                const files = Array.from(input.files).slice(0, 10);
                
                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageItem = document.createElement('div');
                        imageItem.className = 'relative group';
                        imageItem.innerHTML = `
                            <div class="relative">
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="removeGalleryImage(${index})" 
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs py-1 px-2 text-center rounded-b-lg">
                                    Baru ${index + 1}
                                </div>
                            </div>
                        `;
                        galleryList.appendChild(imageItem);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Remove gallery image from preview
        function removeGalleryImage(index) {
            const galleryList = document.getElementById('galleryImagesList');
            const items = galleryList.querySelectorAll('.relative.group');
            
            if (items[index]) {
                items[index].remove();
                
                // Update remaining images
                const remainingItems = galleryList.querySelectorAll('.relative.group');
                if (remainingItems.length === 0) {
                    galleryList.classList.add('hidden');
                    document.getElementById('galleryPreview').style.display = 'block';
                }
            }
        }

        // View image in modal
        function viewImage(imageUrl) {
            document.getElementById('modalImageView').src = imageUrl;
            document.getElementById('imageViewModal').classList.remove('hidden');
        }

        // Close image view modal
        function closeImageView() {
            document.getElementById('imageViewModal').classList.add('hidden');
        }

        // Reset form
        function resetForm() {
            document.getElementById('editProductForm').reset();
            
            // Reset checkboxes to original state
            document.getElementById('is_active').checked = {{ $product->is_active ? 'true' : 'false' }};
            document.getElementById('is_featured').checked = {{ $product->is_featured ? 'true' : 'false' }};
            
            // Reset category to original value
            const originalCategoryId = {{ $product->category_id ?? 0 }};
            const categorySelect = document.querySelector('select[name="category_id"]');
            if (categorySelect) {
                categorySelect.value = originalCategoryId;
            }
            
            // Clear gallery preview
            const galleryList = document.getElementById('galleryImagesList');
            galleryList.innerHTML = '';
            galleryList.classList.add('hidden');
            document.getElementById('galleryPreview').style.display = 'block';
            document.getElementById('galleryImages').value = '';
        }

        // Form validation
        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            const price = document.querySelector('input[name="price"]').value;
            const stock = document.querySelector('input[name="stock"]').value;
            const weight = document.querySelector('input[name="weight"]').value;
            const category = document.querySelector('select[name="category_id"]').value;
            
            if (price <= 0) {
                e.preventDefault();
                alert('Harga harus lebih dari 0!');
                return false;
            }
            
            if (stock < 0) {
                e.preventDefault();
                alert('Stok tidak boleh negatif!');
                return false;
            }
            
            if (weight <= 0) {
                e.preventDefault();
                alert('Berat harus lebih dari 0!');
                return false;
            }
            
            if (!category) {
                e.preventDefault();
                alert('Silakan pilih kategori produk!');
                return false;
            }
            
            return true;
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageView();
            }
        });

        // Close modal when clicking outside
        document.getElementById('imageViewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageView();
            }
        });
    </script>
</x-admin-layout>