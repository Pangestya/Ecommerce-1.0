<x-pengawas-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Audit Trail') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Rekaman aktivitas sistem dan pengguna</p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('pengawas.dashboard') }}" class="hover:text-[#80489C]">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </a>
                <span>/</span>
                <span class="text-[#80489C] font-medium">Audit Trail</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter Section --}}
            <div class="mb-6 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-filter text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Filter Aktivitas</h3>
                            <p class="text-sm text-gray-600">Saring berdasarkan jenis aksi dan periode waktu</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt text-[#80489C] mr-1"></i> Dari Tanggal
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" 
                                           class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                           placeholder="Dari tanggal">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt text-[#80489C] mr-1"></i> Sampai Tanggal
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-check text-gray-400"></i>
                                    </div>
                                    <input type="date" 
                                           class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200"
                                           placeholder="Sampai tanggal">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag text-[#80489C] mr-1"></i> Jenis Aksi
                                </label>
                                <select class="px-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-[#80489C] focus:outline-none transition-colors duration-200">
                                    <option value="">Semua Aksi</option>
                                    <option value="CREATE">Tambah Data</option>
                                    <option value="UPDATE">Edit Data</option>
                                    <option value="DELETE">Hapus Data</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button class="px-5 py-2.5 bg-gradient-to-r from-[#80489C] to-[#9a65b3] text-white rounded-lg hover:from-[#66337a] hover:to-[#80489C] transition-all duration-200 shadow-md hover:shadow-lg font-medium flex items-center">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <button class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 font-medium flex items-center">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus-circle text-green-600 text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Create</span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $logs->where('action', 'CREATE')->count() }}</h3>
                        <p class="text-sm text-gray-600">Penambahan Data</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-edit text-blue-600 text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Update</span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $logs->where('action', 'UPDATE')->count() }}</h3>
                        <p class="text-sm text-gray-600">Perubahan Data</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-trash-alt text-red-600 text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">Delete</span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $logs->where('action', 'DELETE')->count() }}</h3>
                        <p class="text-sm text-gray-600">Penghapusan Data</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border-2 border-[#80489C]">
                    <div class="p-6 bg-gradient-to-br from-purple-50 to-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center">
                                <i class="fas fa-history text-white text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-[#80489C] bg-purple-100 px-2 py-1 rounded-full">Total</span>
                        </div>
                        <h3 class="text-3xl font-bold text-[#80489C] mb-1">{{ $logs->count() }}</h3>
                        <p class="text-sm text-gray-600">Total Aktivitas</p>
                    </div>
                </div>
            </div>

            {{-- Activity Log Table --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-clipboard-list text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Daftar Aktivitas</h3>
                                <p class="text-sm text-gray-600">Rekaman semua perubahan dalam sistem</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                            <i class="fas fa-eye mr-2"></i>
                            Menampilkan {{ $logs->firstItem() ?? 0 }}-{{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }}
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                    <i class="fas fa-clock mr-1"></i> Waktu
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                    <i class="fas fa-user mr-1"></i> Pelaku
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                    <i class="fas fa-bolt mr-1"></i> Aksi
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                    <i class="fas fa-bullseye mr-1"></i> Target
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                    <i class="fas fa-info-circle mr-1"></i> Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <i class="fas fa-calendar-day text-gray-400 mr-1"></i>
                                        {{ $log->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-clock text-gray-400 mr-1"></i>
                                        {{ $log->created_at->format('H:i:s') }}
                                        <span class="ml-2 px-2 py-0.5 bg-gray-100 rounded-full text-gray-600">
                                            {{ $log->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-[#80489C] to-[#9a65b3] rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white text-sm font-bold">
                                                {{ strtoupper(substr($log->user->name ?? 'X', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $log->user->name ?? 'User Terhapus' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <i class="fas fa-envelope mr-1"></i>
                                                {{ $log->user->email ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($log->action == 'CREATE')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-plus-circle mr-1"></i> TAMBAH
                                        </span>
                                    @elseif($log->action == 'UPDATE')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-edit mr-1"></i> EDIT
                                        </span>
                                    @elseif($log->action == 'DELETE')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-trash-alt mr-1"></i> HAPUS
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            {{ $log->action }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ class_basename($log->model_type) }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-hashtag text-gray-400 mr-1"></i>
                                        {{ $log->model_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-md">
                                        {{ $log->details }}
                                    </div>
                                    @if($log->old_values || $log->new_values)
                                        <button class="mt-2 text-xs text-[#80489C] hover:text-[#66337a] font-medium flex items-center" 
                                               data-log-id="{{ $log->id }}" onclick="showLogDetails(this)">
                                            <i class="fas fa-eye mr-1"></i> Lihat Detail Perubahan
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-history text-gray-400 text-3xl"></i>
                                        </div>
                                        <h4 class="text-lg font-medium text-gray-900 mb-2">Belum ada aktivitas terekam</h4>
                                        <p class="text-gray-600 mb-4 max-w-md">Saat ini belum ada aktivitas yang tercatat dalam sistem.</p>
                                        <a href="{{ route('pengawas.dashboard') }}" class="text-[#80489C] hover:underline">
                                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="text-sm text-gray-600 mb-4 md:mb-0">
                            <i class="fas fa-eye mr-1"></i>
                            Menampilkan <span class="font-medium">{{ $logs->firstItem() }}</span> - 
                            <span class="font-medium">{{ $logs->lastItem() }}</span> dari 
                            <span class="font-medium">{{ $logs->total() }}</span> aktivitas
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($logs->onFirstPage())
                                <span class="px-4 py-2 border border-gray-300 rounded-lg text-gray-400 bg-gray-100 cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $logs->previousPageUrl() }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif
                            
                            <div class="flex items-center space-x-1">
                                @php
                                    $current = $logs->currentPage();
                                    $last = $logs->lastPage();
                                    $start = max($current - 2, 1);
                                    $end = min($current + 2, $last);
                                    
                                    if($start > 1) {
                                        echo '<a href="' . $logs->url(1) . '" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">1</a>';
                                        if($start > 2) {
                                            echo '<span class="px-4 py-2 text-gray-500">...</span>';
                                        }
                                    }
                                    
                                    for($page = $start; $page <= $end; $page++) {
                                        if($page == $current) {
                                            echo '<span class="px-4 py-2 border border-[#80489C] bg-[#80489C] text-white rounded-lg font-medium">' . $page . '</span>';
                                        } else {
                                            echo '<a href="' . $logs->url($page) . '" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">' . $page . '</a>';
                                        }
                                    }
                                    
                                    if($end < $last) {
                                        if($end < $last - 1) {
                                            echo '<span class="px-4 py-2 text-gray-500">...</span>';
                                        }
                                        echo '<a href="' . $logs->url($last) . '" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">' . $last . '</a>';
                                    }
                                @endphp
                            </div>
                            
                            @if($logs->hasMorePages())
                                <a href="{{ $logs->nextPageUrl() }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-[#80489C] transition-colors duration-200">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="px-4 py-2 border border-gray-300 rounded-lg text-gray-400 bg-gray-100 cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Info Box --}}
            <div class="mt-8 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-[#80489C] text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900">Tentang Audit Trail</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-shield-alt text-[#80489C]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Keamanan Sistem</p>
                                    <p class="text-sm text-gray-600 mt-1">Melacak semua perubahan data untuk akuntabilitas</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-history text-[#80489C]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Rekaman Perubahan</p>
                                    <p class="text-sm text-gray-600 mt-1">Setiap aksi pengguna terekam dengan waktu</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user-check text-[#80489C]"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Akuntabilitas</p>
                                    <p class="text-sm text-gray-600 mt-1">Mengidentifikasi pelaku setiap perubahan data</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showLogDetails(button) {
            const logId = button.getAttribute('data-log-id');
            // Implement modal or detail view for log changes
            alert(`Detail perubahan untuk log ID: ${logId}`);
            // You can implement a modal here with AJAX request
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(128, 72, 156, 0.15);
        }
    </style>
    @endpush
</x-pengawas-layout>