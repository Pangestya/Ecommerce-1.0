<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Edit Kategori') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Edit kategori {{ $category->name }}</p>
            </div>
        </div>
    </x-slot>
        
    <div class="max-w-8xl mx-auto sm:px-8">
        <a href="{{ route('admin.categories.index') }}" class="hover:text-[#80489C]">
            <i class="fas fa-users mr-1"></i> Manajemen Kategori
        </a>
        <span>/</span>
        <span class="text-[#80489C] font-medium">Edit</span>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Category Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-[#432C7A]">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#432C7A] to-[#5a409e] flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">C{{ $category->id }}</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Category ID</p>
                            <p class="text-lg font-bold text-gray-900">#{{ $category->id }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 bg-green-100">
                            <i class="fas fa-box text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jumlah Produk</p>
                            <p class="text-lg font-bold text-gray-900">{{ $category->products->count() }} Produk</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Diperbarui</p>
                            <p class="text-lg font-bold text-gray-900">{{ $category->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-[#432C7A] to-[#5a409e] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Form Edit Kategori</h3>
                            <p class="text-sm text-gray-600">Perbarui informasi kategori</p>
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

                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" id="editCategoryForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Category Information Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-info-circle text-[#432C7A] mr-2"></i>
                                Informasi Kategori
                            </h4>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-tag text-gray-400"></i>
                                        </div>
                                        <input type="text" 
                                               name="name" 
                                               value="{{ old('name', $category->name) }}" 
                                               class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200"
                                               placeholder="Misal: Elektronik, Pakaian Pria, Makanan"
                                               required
                                               oninput="generateSlugPreview(this.value, '{{ $category->slug }}')">
                                    </div>
                                    @error('name') 
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Warning for existing products -->
                                @if($category->products->count() > 0)
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-yellow-400 mt-0.5"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-800">
                                                <span class="font-medium">Perhatian!</span> Kategori ini memiliki 
                                                <span class="font-bold">{{ $category->products->count() }} produk</span>. 
                                                Mengubah nama kategori akan mempengaruhi semua produk yang terkait.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between pt-6 border-t border-gray-200">
                            <div class="mb-4 md:mb-0">
                                <a href="{{ route('admin.categories.index') }}" 
                                   class="flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Kembali ke Daftar Kategori
                                </a>
                            </div>
                            <div class="flex space-x-4">
                                <button type="button" 
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

            <!-- Related Products -->
            @if($category->products->count() > 0)
            <div class="mt-8 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-box text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Produk dalam Kategori Ini</h3>
                                <p class="text-sm text-gray-600">{{ $category->products->count() }} produk terkait</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" 
                           class="text-[#432C7A] hover:text-[#35205e] font-medium text-sm">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($category->products->take(5) as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                                         class="h-10 w-10 rounded-lg object-cover">
                                                @else
                                                    <div class="h-10 w-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-box text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : 
                                               ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($category->products->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" 
                           class="text-[#432C7A] hover:text-[#35205e] font-medium text-sm">
                            Lihat {{ $category->products->count() - 5 }} produk lainnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Generate slug preview for edit form
        function generateSlugPreview(name, currentSlug) {
            if (!name) {
                document.getElementById('newSlugPreview').textContent = currentSlug;
                return;
            }
            
            // Simple slug generation
            let slug = name
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-')     // Replace spaces with hyphens
                .replace(/-+/g, '-')      // Remove duplicate hyphens
                .trim();
            
            document.getElementById('newSlugPreview').textContent = slug;
        }

        // Reset form
        function resetForm() {
            document.getElementById('editCategoryForm').reset();
            document.getElementById('newSlugPreview').textContent = '{{ Str::slug($category->name) }}';
        }

        // Form validation
        document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
            const name = document.querySelector('input[name="name"]').value.trim();
            
            if (!name) {
                e.preventDefault();
                alert('Silakan masukkan nama kategori!');
                return false;
            }
            
            if (name.length < 2) {
                e.preventDefault();
                alert('Nama kategori minimal 2 karakter!');
                return false;
            }
            
            // Show confirmation if category has products
            const productCount = {{ $category->products->count() }};
            if (productCount > 0) {
                const originalName = '{{ $category->name }}';
                if (name !== originalName) {
                    const confirmed = confirm(`Kategori ini memiliki ${productCount} produk.\n\nMengubah nama dari "${originalName}" ke "${name}" akan mempengaruhi semua produk terkait.\n\nLanjutkan?`);
                    if (!confirmed) {
                        e.preventDefault();
                        return false;
                    }
                }
            }
            
            return true;
        });

        // Auto-focus on name input
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="name"]').focus();
        });
    </script>
</x-admin-layout>