<x-pembeli-layout>
    {{-- ================= HEADER ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-6">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-blue-900">
                        Edit <span class="text-blue-600">Alamat</span>
                    </h1>
                    <p class="text-sm text-blue-600 mt-1">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Perbarui data alamat pengiriman Anda
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
                    Form Edit Alamat
                </h3>
            </div>

            {{-- Form --}}
            <form action="{{ route('pembeli.alamat.update', $alamat->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Nama Penerima --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-user mr-1 text-blue-500"></i>
                            Nama Penerima <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $alamat->name) }}"
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
                               value="{{ old('phone', $alamat->phone) }}"
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
                        <select id="province" name="province_id" class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        <input type="hidden" name="province_name" id="province_name" value="{{ $alamat->province_name }}">
                    </div>

                    {{-- City --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-city mr-1 text-blue-500"></i>
                            Kota/Kabupaten <span class="text-red-500">*</span>
                        </label>
                        <select id="city" name="city_id" class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" required>
                            <option value="">Pilih Kota</option>
                        </select>
                        <input type="hidden" name="city_name" id="city_name" value="{{ $alamat->city_name }}">
                    </div>

                    {{-- Subdistrict --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-road mr-1 text-blue-500"></i>
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <select id="subdistrict" name="subdistrict_id" class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <input type="hidden" name="subdistrict_name" id="subdistrict_name" value="{{ $alamat->subdistrict_name }}">
                    </div>

                    {{-- Village --}}
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">
                            <i class="fas fa-home mr-1 text-blue-500"></i>
                            Desa/Kelurahan
                        </label>
                        <select id="village" name="village_id" class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                            <option value="">Pilih Desa</option>
                        </select>
                        <input type="hidden" name="village_name" id="village_name" value="{{ $alamat->village_name }}">
                    </div>
                </div>

                {{-- Kode Pos --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-blue-800 mb-2">
                        <i class="fas fa-mail-bulk mr-1 text-blue-500"></i>
                        Kode Pos
                    </label>
                    <input type="text" 
                           name="postal_code"
                           value="{{ old('postal_code', $alamat->postal_code) }}"
                           class="w-full md:w-1/3 px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('postal_code') border-red-300 @enderror"
                           placeholder="Contoh: 40123">
                    @error('postal_code')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
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
                              required>{{ old('detail_alamat', $alamat->detail_alamat) }}</textarea>
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
                        Perbarui Alamat
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
        const subdistrict = document.getElementById('subdistrict');
        const village = document.getElementById('village');

        const provinceName = document.getElementById('province_name');
        const cityName = document.getElementById('city_name');
        const subdistrictName = document.getElementById('subdistrict_name');
        const villageName = document.getElementById('village_name');

        const oldProvinceId = "{{ $alamat->province_id }}";
        const oldCityId = "{{ $alamat->city_id }}";
        const oldSubdistrictId = "{{ $alamat->subdistrict_id }}";
        const oldVillageId = "{{ $alamat->village_id }}";


        // ===== INIT =====
        async function initLocations() {

            const resProv = await fetch('/api/provinces');
            const dataProv = await resProv.json();

            province.innerHTML = '<option value="">Pilih Provinsi</option>';

            dataProv.forEach(item => {
                const selected = item.id == oldProvinceId ? 'selected' : '';
                province.innerHTML += `<option value="${item.id}" ${selected}>${item.name}</option>`;
            });

            if (oldProvinceId) {
                await loadCities(oldProvinceId, oldCityId);
            }
        }


        // ===== LOAD CITY =====
        async function loadCities(provId, selectedId = null) {

            city.innerHTML = '<option>Loading...</option>';

            const resCity = await fetch(`/api/cities/${provId}`);
            const dataCity = await resCity.json();

            city.innerHTML = '<option value="">Pilih Kota</option>';

            dataCity.forEach(item => {
                const selected = item.id == selectedId ? 'selected' : '';
                city.innerHTML += `<option value="${item.id}" ${selected}>${item.name}</option>`;
            });

            if (selectedId) {
                await loadSubdistricts(selectedId, oldSubdistrictId);
            }
        }


        // ===== LOAD SUBDISTRICT =====
        async function loadSubdistricts(cityId, selectedId = null) {

            subdistrict.innerHTML = '<option>Loading...</option>';

            const resSub = await fetch(`/api/districts/${cityId}`);
            const dataSub = await resSub.json();

            subdistrict.innerHTML = '<option value="">Pilih Kecamatan</option>';

            dataSub.forEach(item => {
                const selected = item.id == selectedId ? 'selected' : '';
                subdistrict.innerHTML += `<option value="${item.id}" ${selected}>${item.name}</option>`;
            });

            if (selectedId) {
                await loadVillages(selectedId, oldVillageId);
            }
        }


        // ===== LOAD VILLAGE =====
        async function loadVillages(subdistrictId, selectedId = null) {

            village.innerHTML = '<option>Loading...</option>';

            const resVillage = await fetch(`/api/villages/${subdistrictId}`);
            const dataVillage = await resVillage.json();

            village.innerHTML = '<option value="">Pilih Desa</option>';

            dataVillage.forEach(item => {
                const selected = item.id == selectedId ? 'selected' : '';
                village.innerHTML += `<option value="${item.id}" ${selected}>${item.name}</option>`;
            });
        }


        // ===== EVENT =====
        province.addEventListener('change', async function () {
            provinceName.value = this.options[this.selectedIndex].text;
            await loadCities(this.value);
        });

        city.addEventListener('change', async function () {
            cityName.value = this.options[this.selectedIndex].text;
            await loadSubdistricts(this.value);
        });

        subdistrict.addEventListener('change', async function () {
            subdistrictName.value = this.options[this.selectedIndex].text;
            await loadVillages(this.value);
        });

        village.addEventListener('change', function () {
            villageName.value = this.options[this.selectedIndex].text;
        });


        initLocations();

    });
    </script>

</x-pembeli-layout>