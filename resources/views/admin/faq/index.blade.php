<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Manajemen FAQ / Bantuan') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Kelola pertanyaan dan jawaban yang sering diajukan</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">FAQ</span>
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
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#432C7A]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total FAQ</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $faq->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-question-circle text-[#432C7A] text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Aktif</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ $faq->where('is_active', true)->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Kategori</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ count($categories) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-folder text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- button tambah FAQ -->
            <div class="max-w-9xl mx-auto mb-6">
                <div class="flex space-x-2 text-sm text-gray-600">
                    <a href="{{ route('admin.faq.create') }}" 
                       class="px-6 py-3.5 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-xl hover:from-[#35205e] hover:to-[#432C7A] shadow-lg font-semibold flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Tambah FAQ Baru</span>
                    </a>
                </div>
            </div>

            <!-- FAQ Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Daftar FAQ</h3>
                            <p class="text-gray-600 text-sm">Menampilkan {{ $faq->count() }} FAQ</p>
                        </div>
                        
                        <!-- Search -->
                        <div class="relative mt-3 md:mt-0">
                            <input type="text" placeholder="Cari FAQ..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pertanyaan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($faq as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-purple-100 text-[#432C7A] border border-purple-200">
                                        <i class="fas fa-tag mr-1 text-xs"></i>
                                        {{ ucfirst($item->category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-md">
                                        <div class="text-sm font-bold text-gray-900 mb-1">{{ $item->question }}</div>
                                        <div class="text-xs text-gray-500 truncate">{{ Str::limit($item->answer, 100) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->is_active)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2"></div>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2"></div>
                                            Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <!-- Edit -->
                                        <a href="{{ route('admin.faq.edit', $item->id) }}" 
                                           class="text-[#432C7A] hover:text-[#35205e] transition-colors duration-200 flex items-center space-x-1 group relative"
                                           title="Edit FAQ">
                                            <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                                                <i class="fas fa-edit text-sm"></i>
                                            </div>
                                            <span class="hidden md:inline text-sm font-medium">Edit</span>
                                        </a>
                                        
                                        <!-- Delete -->
                                        <form action="{{ route('admin.faq.destroy', $item->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?');"
                                              class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 transition-colors duration-200 flex items-center space-x-1 group"
                                                    title="Hapus FAQ">
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

                @if($faq->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-question-circle text-gray-300 text-5xl mb-3"></i>
                    <p class="text-gray-500">Belum ada FAQ</p>
                    <a href="{{ route('admin.faq.create') }}" class="inline-block mt-3 text-[#432C7A] hover:text-[#35205e] font-medium">
                        + Tambah FAQ Baru
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>