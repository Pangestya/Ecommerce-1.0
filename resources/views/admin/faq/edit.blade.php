<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Edit FAQ') }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Perbarui pertanyaan dan jawaban</p>
            </div>
            <a href="{{ route('admin.faq.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-8">
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#80489C]">
                <i class="fas fa-tachometer mr-1"></i> Dashboard
            </a>
            <span>/</span>
            <a href="{{ route('admin.faq.index') }}" class="hover:text-[#80489C]">FAQ</a>
            <span>/</span>
            <span class="text-[#80489C] font-medium">Edit</span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <i class="fas fa-edit mr-2 text-[#432C7A]"></i>
                        Form Edit FAQ
                    </h3>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    <i class="fas fa-folder mr-1 text-[#432C7A]"></i> Kategori
                                </label>
                                <select name="category" class="w-full border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none" required>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}" {{ $faq->category == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    <i class="fas fa-question-circle mr-1 text-[#432C7A]"></i> Pertanyaan
                                </label>
                                <input type="text" name="question" value="{{ $faq->question }}" 
                                       class="w-full border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none" 
                                       placeholder="Contoh: Bagaimana cara melakukan pembayaran?" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    <i class="fas fa-comment-dots mr-1 text-[#432C7A]"></i> Jawaban
                                </label>
                                <textarea name="answer" rows="6" 
                                          class="w-full border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none" 
                                          placeholder="Jelaskan jawaban secara detail..." required>{{ $faq->answer }}</textarea>
                                <p class="text-xs text-gray-500 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i> Gunakan Enter untuk baris baru.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    <i class="fas fa-toggle-on mr-1 text-[#432C7A]"></i> Status
                                </label>
                                <div class="relative">
                                    <select name="is_active" class="w-full border-gray-300 rounded-lg focus:border-[#432C7A] focus:ring-2 focus:ring-purple-200 focus:outline-none appearance-none">
                                        <option value="1" {{ $faq->is_active ? 'selected' : '' }} class="py-2">Aktif (Tampil di halaman publik)</option>
                                        <option value="0" {{ !$faq->is_active ? 'selected' : '' }} class="py-2">Non-Aktif (Sembunyikan)</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i> Status aktif akan menampilkan FAQ ini di halaman bantuan publik.
                                </p>
                            </div>

                            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                                <a href="{{ route('admin.faq.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#432C7A] to-[#5a409e] text-white rounded-lg hover:from-[#35205e] hover:to-[#432C7A] shadow-md font-medium flex items-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Update FAQ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>