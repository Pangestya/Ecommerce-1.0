<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Tambah Produk Baru') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Tambah produk baru ke dalam katalog</p>
            </div>
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.products.index') }}" class="hover:text-[#80489C]">
                <i class="fas fa-users mr-1"></i> Manajemen Produk
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Tambah Baru</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-xl p-5 shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-plus-circle text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-90">Produk Baru</p>
                            <p class="text-2xl font-bold">#NEW</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-th-list text-[#432C7A] text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Kategori</p>
                            <p class="text-lg font-bold text-gray-900">{{ $categories->count() ?? 0 }} Kategori</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-lightbulb text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tips</p>
                            <p class="text-sm font-medium text-gray-900">Isi semua field dengan lengkap</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-[#432C7A] to-[#5a409e] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-box text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Form Tambah Produk</h3>
                            <p class="text-sm text-gray-600">Masukkan informasi produk baru</p>
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

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        
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
                                               value="{{ old('name') }}" 
                                               class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200"
                                               placeholder="Masukkan nama produk"
                                               required>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Contoh: Laptop Gaming ASUS ROG</p>
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
                                            <option value="" disabled selected>Pilih Kategori Produk</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                                   class="pl-12 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200"
                                                   placeholder="0"
                                                   required>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Harga dalam Rupiah</p>
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
                                                   class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200"
                                                   placeholder="0"
                                                   required>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Jumlah unit yang tersedia</p>
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
                                                   class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 focus:outline-none transition-colors duration-200"
                                                   placeholder="1000"
                                                   required>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Berat produk dalam gram</p>
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
                                                           class="pl-8 pr-2 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 focus:outline-none transition-colors duration-200"
                                                           placeholder="T">
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Opsional: Panjang x Lebar x Tinggi dalam cm</p>
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
                                    Deskripsi <span class="text-gray-500 text-xs">(Opsional)</span>
                                </label>
                                <textarea name="description" 
                                          rows="4"
                                          class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200 p-3"
                                          placeholder="Masukkan deskripsi lengkap produk...">{{ old('description') }}</textarea>
                                <p class="text-xs text-gray-500 mt-2">Deskripsi akan membantu pelanggan memahami produk Anda</p>
                            </div>
                        </div>

                        <!-- Images Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-images text-[#432C7A] mr-2"></i>
                                Gambar Produk
                            </h4>
                            
                            <div class="space-y-5">
                                <!-- Main Image -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Gambar Utama (Cover) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="file" 
                                               name="image" 
                                               id="mainImage"
                                               accept="image/*"
                                               class="hidden"
                                               required
                                               onchange="previewImage(this, 'mainImagePreview')">
                                        
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#432C7A] hover:bg-purple-50 transition-all duration-200 cursor-pointer"
                                             onclick="document.getElementById('mainImage').click()">
                                            <div id="mainImagePreview" class="flex flex-col items-center justify-center">
                                                <i class="fas fa-camera text-3xl text-gray-400 mb-3"></i>
                                                <p class="text-sm text-gray-600">Klik untuk upload gambar utama</p>
                                                <p class="text-xs text-gray-500 mt-1">Ukuran maks: 5MB • Format: JPG, PNG, GIF</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gallery Images -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Galeri Foto <span class="text-gray-500 text-xs">(Opsional, bisa pilih banyak)</span>
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
                                                <p class="text-sm text-gray-600">Klik untuk upload gambar galeri</p>
                                                <p class="text-xs text-gray-500 mt-1">Maks 10 file • 5MB per file • Format: JPG, PNG, GIF</p>
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
                                               checked
                                               class="w-5 h-5 text-[#432C7A] border-gray-300 rounded focus:ring-[#432C7A]">
                                    </div>
                                    <div>
                                        <label for="is_active" class="font-medium text-gray-900 cursor-pointer">Produk Aktif</label>
                                        <p class="text-sm text-gray-600 mt-1">Produk akan langsung ditampilkan di katalog</p>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                    </div>
                                </div>

                                <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 cursor-pointer"
                                     onclick="toggleCheckbox('is_featured')">
                                    <div class="flex-shrink-0 mr-4">
                                        <input type="checkbox" 
                                               name="is_featured" 
                                               id="is_featured"
                                               class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                    </div>
                                    <div>
                                        <label for="is_featured" class="font-medium text-gray-900 cursor-pointer">Produk Unggulan</label>
                                        <p class="text-sm text-gray-600 mt-1">Tandai produk sebagai produk unggulan</p>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fas fa-star text-yellow-400"></i>
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
                                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                                    <i class="fas fa-redo mr-2"></i>Reset Form
                                </button>
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-lg hover:from-[#35205e] hover:to-[#432C7A] transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                    <i class="fas fa-save mr-2"></i>Simpan Produk
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="mt-8 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-[#432C7A] text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900">Tips Menambahkan Produk</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-th-list text-[#432C7A]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Kategori yang Tepat</p>
                                    <p class="text-sm text-gray-600 mt-1">Pilih kategori yang paling sesuai dengan produk Anda</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-camera text-[#432C7A]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Gambar Berkualitas</p>
                                    <p class="text-sm text-gray-600 mt-1">Gunakan foto dengan resolusi tinggi dan pencahayaan baik</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-weight text-[#432C7A]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Data Pengiriman Akurat</p>
                                    <p class="text-sm text-gray-600 mt-1">Pastikan berat dan dimensi sesuai untuk kalkulasi ongkir</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-tag text-[#432C7A]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Harga Kompetitif</p>
                                    <p class="text-sm text-gray-600 mt-1">Tetapkan harga yang sesuai dengan nilai dan pasar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle checkbox when clicking on the card
        function toggleCheckbox(checkboxId) {
            const checkbox = document.getElementById(checkboxId);
            checkbox.checked = !checkbox.checked;
        }

        // Preview main image
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="relative">
                            <img src="${e.target.result}" class="w-32 h-32 object-cover rounded-lg shadow-md">
                            <button type="button" onclick="removeImage('${previewId}', 'mainImage')" 
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview gallery images
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
                                    Gambar ${index + 1}
                                </div>
                            </div>
                        `;
                        galleryList.appendChild(imageItem);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Remove main image
        function removeImage(previewId, inputId) {
            document.getElementById(previewId).innerHTML = `
                <i class="fas fa-camera text-3xl text-gray-400 mb-3"></i>
                <p class="text-sm text-gray-600">Klik untuk upload gambar utama</p>
                <p class="text-xs text-gray-500 mt-1">Ukuran maks: 5MB • Format: JPG, PNG, GIF</p>
            `;
            document.getElementById(inputId).value = '';
        }

        // Remove gallery image
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

        // Form validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const price = document.querySelector('input[name="price"]').value;
            const stock = document.querySelector('input[name="stock"]').value;
            const weight = document.querySelector('input[name="weight"]').value;
            const category = document.querySelector('select[name="category_id"]').value;
            const mainImage = document.getElementById('mainImage').files[0];
            
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
            
            if (!mainImage) {
                e.preventDefault();
                alert('Silakan upload gambar utama produk!');
                return false;
            }
            
            return true;
        });

        // Format price input
        document.querySelector('input[name="price"]').addEventListener('blur', function(e) {
            const value = parseInt(e.target.value);
            if (!isNaN(value)) {
                e.target.value = value;
            }
        });
    </script>
</x-admin-layout>