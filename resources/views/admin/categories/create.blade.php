<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Tambah Kategori Baru') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Buat kategori baru untuk pengelompokan produk</p>
            </div>
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto sm:px-8">
        <a href="{{ route('admin.categories.index') }}" class="hover:text-[#80489C]">
            <i class="fas fa-users mr-1"></i> Manajemen Kategori
        </a>
        <span>/</span>
        <span class="text-[#80489C] font-medium">Tambah</span>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-xl p-5 shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-plus-circle text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-90">Kategori Baru</p>
                            <p class="text-2xl font-bold">#NEW</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-info-circle text-[#432C7A] text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Kategori</p>
                            <p class="text-lg font-bold text-gray-900">{{ $totalCategories ?? 0 }} Kategori</p>
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
                            <i class="fas fa-folder-plus text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Form Tambah Kategori</h3>
                            <p class="text-sm text-gray-600">Masukkan informasi kategori baru</p>
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

                    <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
                        @csrf
                        
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
                                               value="{{ old('name') }}" 
                                               class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#432C7A] focus:outline-none transition-colors duration-200"
                                               placeholder="Misal: Elektronik, Pakaian Pria, Makanan"
                                               required
                                               oninput="generateSlugPreview(this.value)">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Gunakan nama yang jelas dan deskriptif</p>
                                    @error('name') 
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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
                                <button type="reset" 
                                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                                    <i class="fas fa-redo mr-2"></i>Reset Form
                                </button>
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-lg hover:from-[#35205e] hover:to-[#432C7A] transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                    <i class="fas fa-save mr-2"></i>Simpan Kategori
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
                        <h4 class="text-lg font-bold text-gray-900">Tips Membuat Kategori</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-font text-[#432C7A]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Nama Jelas</p>
                                    <p class="text-sm text-gray-600 mt-1">Gunakan nama yang mudah dipahami</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-sitemap text-[#432C7A]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Hierarki Logis</p>
                                    <p class="text-sm text-gray-600 mt-1">Rencanakan struktur kategori yang logis</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-project-diagram text-[#432C7A]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Jangan Terlalu Banyak</p>
                                    <p class="text-sm text-gray-600 mt-1">Batasi jumlah kategori agar tidak membingungkan</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-search text-[#432C7A]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">SEO Friendly</p>
                                    <p class="text-sm text-gray-600 mt-1">Nama kategori mempengaruhi SEO website</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Generate slug preview
        function generateSlugPreview(name) {
            if (!name) {
                document.getElementById('slugPreview').textContent = 'nama-kategori';
                return;
            }
            
            // Simple slug generation
            let slug = name
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-')     // Replace spaces with hyphens
                .replace(/-+/g, '-')      // Remove duplicate hyphens
                .trim();
            
            document.getElementById('slugPreview').textContent = slug;
        }

        // Form validation
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
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
            
            return true;
        });

        // Auto-focus on name input
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="name"]').focus();
        });
    </script>
</x-admin-layout>