<x-pembeli-layout>
    {{-- ================= HEADER ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-6">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-plus-circle text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-blue-900">
                        Tambah <span class="text-blue-600">Alamat Baru</span>
                    </h1>
                    <p class="text-sm text-blue-600 mt-1">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Lengkapi data alamat pengiriman Anda
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mb-10">
        <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            
            {{-- Header Form --}}
            <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-address-card mr-2"></i>
                    Form Alamat Baru
                </h3>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('pembeli.alamat.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Nama Penerima --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-user mr-1 text-blue-500"></i>
                            Nama Penerima <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', auth()->user()->name ?? '') }}"
                               class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('name') border-red-300 @enderror"
                               placeholder="Masukkan nama penerima"
                               required>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-phone-alt mr-1 text-blue-500"></i>
                            No HP <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone', auth()->user()->phone ?? '') }}"
                               class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('phone') border-red-300 @enderror"
                               placeholder="Contoh: 081234567890"
                               required>
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Location Dropdowns --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    
                    {{-- Province --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i>
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <select id="province" class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" required>
                            <option value="" class="text-gray-500">Pilih Provinsi</option>
                        </select>
                        <input type="hidden" name="province_id" id="province_id">
                        <input type="hidden" name="province_name" id="province_name">
                    </div>

                    {{-- City --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-city mr-1 text-blue-500"></i>
                            Kota/Kabupaten <span class="text-red-500">*</span>
                        </label>
                        <select id="city" class="w-full px-4 py-3 bg-blue-50 border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" disabled required>
                            <option>Pilih Kota</option>
                        </select>
                        <input type="hidden" name="city_id" id="city_id">
                        <input type="hidden" name="city_name" id="city_name">
                    </div>

                    {{-- District --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-road mr-1 text-blue-500"></i>
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <select id="district" class="w-full px-4 py-3 bg-blue-50 border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" disabled required>
                            <option>Pilih Kecamatan</option>
                        </select>
                        <input type="hidden" name="subdistrict_id" id="subdistrict_id">
                        <input type="hidden" name="subdistrict_name" id="subdistrict_name">
                    </div>

                    {{-- Village --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-home mr-1 text-blue-500"></i>
                            Desa/Kelurahan
                        </label>
                        <select id="village" class="w-full px-4 py-3 bg-blue-50 border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" disabled>
                            <option>Pilih Desa</option>
                        </select>
                        <input type="hidden" name="village_id" id="village_id">
                        <input type="hidden" name="village_name" id="village_name">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Kode Pos --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-mail-bulk mr-1 text-blue-500"></i>
                            Kode Pos
                        </label>
                        <input type="text" 
                               name="postal_code" 
                               value="{{ old('postal_code') }}"
                               class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('postal_code') border-red-300 @enderror"
                               placeholder="Contoh: 40123">
                        @error('postal_code')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Placeholder untuk spacing --}}
                    <div></div>
                </div>

                {{-- Detail Alamat --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-blue-800 mb-2">
                        <i class="fas fa-address-book mr-1 text-blue-500"></i>
                        Detail Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea name="detail_alamat" 
                              rows="4"
                              class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('detail_alamat') border-red-300 @enderror"
                              placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 02"
                              required>{{ old('detail_alamat') }}</textarea>
                    @error('detail_alamat')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-blue-100">
                    <a href="{{ route('pembeli.alamat.index') }}" 
                       class="px-6 py-3 bg-white border-2 border-blue-200 text-blue-700 rounded-xl font-semibold hover:border-blue-400 hover:bg-blue-50 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= SCRIPT DROPDOWN (LOGIKA LAMA 100%) ================= --}}
    <script>
    document.addEventListener("DOMContentLoaded", async function () {

    const province = document.getElementById('province');
    const city = document.getElementById('city');
    const district = document.getElementById('district');
    const village = document.getElementById('village');


    // ================= LOAD PROVINCE =================
    async function loadProvinces() {

        const res = await fetch('/api/provinces');
        const data = await res.json();

        province.innerHTML = '<option value="">Pilih Provinsi</option>';

        data.forEach(item => {
            province.innerHTML += `<option value="${item.id}">${item.name}</option>`;
        });
    }


    // ================= LOAD CITY =================
    province.addEventListener('change', async function () {

        document.getElementById('province_id').value = this.value;
        document.getElementById('province_name').value =
            this.options[this.selectedIndex]?.text ?? "";

        city.innerHTML = '<option>Loading...</option>';
        city.disabled = true;
        city.classList.add('bg-blue-50');

        district.innerHTML = '<option>Pilih Kecamatan</option>';
        district.disabled = true;
        district.classList.add('bg-blue-50');

        village.innerHTML = '<option>Pilih Desa</option>';
        village.disabled = true;
        village.classList.add('bg-blue-50');

        if (!this.value) return;

        const res = await fetch(`/api/cities/${this.value}`);
        const data = await res.json();

        city.innerHTML = '<option value="">Pilih Kota</option>';

        data.forEach(item => {
            city.innerHTML += `<option value="${item.id}">${item.name}</option>`;
        });

        city.disabled = false;
        city.classList.remove('bg-blue-50');
    });


    // ================= LOAD DISTRICT =================
    city.addEventListener('change', async function () {

        document.getElementById('city_id').value = this.value;
        document.getElementById('city_name').value =
            this.options[this.selectedIndex]?.text ?? "";

        district.innerHTML = '<option>Loading...</option>';
        district.disabled = true;
        district.classList.add('bg-blue-50');

        village.innerHTML = '<option>Pilih Desa</option>';
        village.disabled = true;
        village.classList.add('bg-blue-50');

        if (!this.value) return;

        const res = await fetch(`/api/districts/${this.value}`);
        const data = await res.json();

        district.innerHTML = '<option value="">Pilih Kecamatan</option>';

        data.forEach(item => {
            district.innerHTML += `<option value="${item.id}">${item.name}</option>`;
        });

        district.disabled = false;
        district.classList.remove('bg-blue-50');
    });


    // ================= LOAD VILLAGE =================
    district.addEventListener('change', async function () {

        document.getElementById('subdistrict_id').value = this.value;
        document.getElementById('subdistrict_name').value =
            this.options[this.selectedIndex]?.text ?? "";

        village.innerHTML = '<option>Loading...</option>';
        village.disabled = true;
        village.classList.add('bg-blue-50');

        if (!this.value) return;

        const res = await fetch(`/api/villages/${this.value}`);
        const data = await res.json();

        village.innerHTML = '<option value="">Pilih Desa</option>';

        data.forEach(item => {
            village.innerHTML += `<option value="${item.id}">${item.name}</option>`;
        });

        village.disabled = false;
        village.classList.remove('bg-blue-50');
    });


    // ================= SIMPAN VILLAGE =================
    village.addEventListener('change', function () {

        document.getElementById('village_id').value = this.value;
        document.getElementById('village_name').value =
            this.options[this.selectedIndex]?.text ?? "";
    });


    // RUN
    loadProvinces();

    });
    </script>

</x-pembeli-layout>