<x-pembeli-layout>
    {{-- ================= HEADER CHECKOUT ================= --}}
    <div class="relative bg-gradient-to-b from-blue-50 to-white border-b border-blue-100 mb-6">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-md">
                    <i class="fas fa-shopping-cart text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-blue-900">Checkout</h1>
                    <p class="text-sm text-blue-600">Selesaikan pembayaran pesanan Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-4 min-h-screen">
        
        <form action="{{ route('pembeli.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            
            {{-- Hidden Inputs (LOGIKA LAMA) --}}
            <input type="hidden" name="total_berat" value="{{ $totalBerat }}">
            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
            <input type="hidden" name="ongkir" id="input_ongkir" value="0">
            <input type="hidden" name="grand_total" id="input_grand_total" value="{{ $subtotal }}">
            <input type="hidden" name="service" id="input_service">
            <input type="hidden" name="etd" id="input_etd">
            
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- ================= KOLOM KIRI ================= --}}
                <div class="lg:w-2/3 space-y-6">
                    
                    {{-- CARD ALAMAT --}}
                    <div class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden hover:shadow-lg transition">
                        <div class="p-5 bg-gradient-to-r from-blue-50 to-white border-b border-blue-100">
                            <h2 class="text-lg font-bold text-blue-900 flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                </div>
                                Alamat Pengiriman
                            </h2>
                        </div>
                        
                        <div class="p-5">
                            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <span class="font-bold text-blue-900 text-lg">{{ Auth::user()->name }}</span>
                                            <span class="ml-3 px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i> Utama
                                            </span>
                                        </div>
                                        
                                        <div class="space-y-1 text-sm text-blue-700">
                                            <p class="flex items-start">
                                                <i class="fas fa-home w-5 text-blue-400 mt-0.5"></i>
                                                <span>{{ $alamat->detail_alamat }}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <i class="fas fa-map-pin w-5 text-blue-400"></i>
                                                <span>Kec. {{ $alamat->subdistrict_name }}, {{ $alamat->city_name }}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <i class="fas fa-globe w-5 text-blue-400"></i>
                                                <span>Prov. {{ $alamat->province_name }} - {{ $alamat->postal_code }}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <i class="fas fa-phone-alt w-5 text-blue-400"></i>
                                                <span>{{ Auth::user()->phone ?? 'Nomor telepon belum diisi' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" id="destination_subdistrict" name="destination_id" value="{{ $alamat->subdistrict_id }}">
                                </div>
                            </div>
                            
                            <a href="{{ route('pembeli.profile.edit') }}" 
                               class="inline-flex items-center px-4 py-2 mt-4 bg-white border-2 border-blue-200 text-blue-700 rounded-lg text-sm font-medium hover:border-blue-400 hover:bg-blue-50 transition-all duration-300">
                                <i class="fas fa-edit mr-2"></i>
                                Ubah Alamat
                            </a>
                        </div>
                    </div>

                    {{-- CARD RINCIAN BARANG --}}
                    <div class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden hover:shadow-lg transition">
                        <div class="p-5 bg-gradient-to-r from-blue-50 to-white border-b border-blue-100">
                            <h2 class="text-lg font-bold text-blue-900 flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-box text-blue-600"></i>
                                </div>
                                Rincian Barang
                            </h2>
                        </div>
                        
                        <div class="p-5 space-y-4">
                            @foreach($carts as $cart)
                            <div class="flex gap-4 p-3 bg-blue-50/30 rounded-xl hover:bg-blue-50 transition border border-transparent hover:border-blue-200">
                                <div class="w-20 h-20 bg-gradient-to-b from-blue-50 to-white rounded-xl overflow-hidden flex-shrink-0 border border-blue-100 shadow-sm">
                                    @if($cart->product->image)
                                        <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <i class="fas fa-image text-blue-300 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <h4 class="font-bold text-blue-900 text-base mb-1">{{ $cart->product->name }}</h4>
                                    
                                    <div class="flex flex-wrap items-center gap-3 text-sm">
                                        <span class="text-blue-700 font-medium">
                                            {{ $cart->quantity }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-blue-400">|</span>
                                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-medium">
                                            <i class="fas fa-weight mr-1"></i>
                                            {{ $cart->product->weight ?? 1000 }}g
                                        </span>
                                    </div>
                                    
                                    @if($cart->product->stock > 0)
                                    <p class="text-xs text-green-600 mt-2 flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Tersedia
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 text-white mt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm opacity-90">Total Item</span>
                                    <span class="font-bold">{{ $carts->count() }} produk</span>
                                </div>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-sm opacity-90">Total Berat</span>
                                    <span class="font-bold">{{ number_format($totalBerat) }} gram</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= KOLOM KANAN (RINGKASAN) ================= --}}
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden sticky top-24">
                        
                        {{-- Header --}}
                        <div class="p-5 bg-gradient-to-r from-blue-600 to-blue-700">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-truck mr-2"></i>
                                Informasi Pengiriman
                            </h3>
                        </div>
                        
                        <div class="p-5 space-y-5">
                            
                            {{-- Pilih Kurir --}}
                            <div>
                                <label class="block text-xs font-bold text-blue-800 mb-2 uppercase tracking-wide">
                                    <i class="fas fa-shipping-fast mr-1"></i>
                                    Pilih Kurir
                                </label>
                                <select name="courier" id="courier_selector" 
                                        class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                                    <option value="" class="text-gray-500">-- Pilih Ekspedisi --</option>
                                    
                                    @foreach($couriers as $code => $name)
                                        <option value="{{ $code }}" class="text-blue-900">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Pilih Layanan --}}
                            <div class="hidden" id="service_container">
                                <label class="block text-xs font-bold text-blue-800 mb-2 uppercase tracking-wide">
                                    <i class="fas fa-tags mr-1"></i>
                                    Pilih Layanan
                                </label>
                                <select name="shipping_service" id="service_selector" 
                                        class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                                </select>
                                <p id="loading_text" class="text-sm text-blue-600 mt-3 hidden animate-pulse flex items-center">
                                    <i class="fas fa-circle-notch fa-spin mr-2"></i>
                                    Mengecek ongkos kirim...
                                </p>
                            </div>

                            {{-- Ringkasan Biaya --}}
                            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100 space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-blue-700">Total Berat</span>
                                    <span class="font-semibold text-blue-900">{{ number_format($totalBerat) }} gram</span>
                                </div>
                                
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-blue-700">Subtotal Barang</span>
                                    <span class="font-semibold text-blue-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center text-sm pt-2 border-t border-blue-200">
                                    <span class="text-blue-700 font-medium">Ongkos Kirim</span>
                                    <span id="display_ongkir" class="font-bold text-blue-600">-</span>
                                </div>
                                
                                <div class="flex justify-between items-center text-lg font-bold bg-gradient-to-r from-blue-600 to-blue-700 text-white p-3 rounded-lg mt-2">
                                    <span>Total Bayar</span>
                                    <span id="display_grand_total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            {{-- Tombol Bayar --}}
                            <button type="submit" id="btn_pay" disabled 
                                    class="w-full bg-gray-300 text-white py-4 rounded-xl font-bold transition cursor-not-allowed text-sm flex items-center justify-center">
                                <i class="fas fa-lock mr-2"></i>
                                Pilih Kurir Dulu
                            </button>

                            {{-- Informasi Tambahan --}}
                            <div class="text-xs text-blue-500 text-center mt-4 space-y-1">
                                <p><i class="fas fa-shield-alt mr-1"></i> Transaksi aman dan terenkripsi</p>
                                <p><i class="fas fa-credit-card mr-1"></i> Pembayaran via Midtrans</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ================= SCRIPT (LOGIKA LAMA 100% DIPERTAHANKAN) ================= --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Variabel Subtotal dari PHP
            let subtotal = {{ $subtotal }};
            
            // ==========================================
            // 1. LOGIKA ONGKIR (TIDAK DIUBAH)
            // ==========================================
            
            // Saat Kurir Dipilih
            $('#courier_selector').change(function() {
                let courier = $(this).val();
                let destination = $('#destination_subdistrict').val(); // Ambil ID Kecamatan
                let weight = {{ $totalBerat }};

                if(!courier) return;

                // Reset UI
                $('#service_container').removeClass('hidden');
                $('#service_selector').empty().append('<option>Loading...</option>');
                $('#loading_text').removeClass('hidden');
                $('#btn_pay').prop('disabled', true).addClass('bg-gray-300').removeClass('bg-[#432C7A] hover:bg-[#321f5e] shadow-lg');

                // Tembak Controller CheckOngkir
                $.ajax({
                    url: "{{ route('pembeli.checkout.ongkir') }}", 
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        destination: destination,
                        weight: weight,
                        courier: courier
                    },
                    success: function(response) {
                        $('#loading_text').addClass('hidden');
                        $('#service_selector').empty();
                        $('#service_selector').append('<option value="">-- Pilih Layanan --</option>');

                        // Ambil Data Costs (Handle format Standard vs Komerce)
                        let costs = [];
                        if (response.rajaongkir && response.rajaongkir.results.length > 0) {
                            costs = response.rajaongkir.results[0].costs;
                        } else if (response.data) {
                            costs = response.data;
                        }

                        if(costs && costs.length > 0) {
                            $.each(costs, function(index, cost) {
                                // Penyesuaian Nama Field
                                let serviceName = cost.service || cost.service_code; 
                                let price = cost.cost || cost.value; 
                                let etd = cost.etd || '-'; 

                                if (Array.isArray(price)) {
                                    price = price[0].value;
                                    etd = cost.cost[0].etd;
                                }

                                let formattedPrice = new Intl.NumberFormat('id-ID').format(price);

                                $('#service_selector').append(
                                    `<option value="${price}" 
                                        data-service="${serviceName}" 
                                        data-etd="${etd}">
                                        ${serviceName} - Rp ${formattedPrice} (${etd} Hari)
                                    </option>`
                                );
                            });
                        } else {
                            $('#service_selector').append('<option value="">Layanan tidak tersedia</option>');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Gagal mengambil data ongkir. Periksa koneksi internet.');
                        $('#loading_text').addClass('hidden');
                    }
                });
            });

            // Saat Layanan (REG/OKE) Dipilih
            $('#service_selector').change(function() {
                let ongkir = parseInt($(this).val()); 
                let serviceName = $(this).find(':selected').data('service');
                let etd = $(this).find(':selected').data('etd');

                // Validasi
                if(isNaN(ongkir)) {
                    $('#btn_pay').prop('disabled', true).addClass('bg-gray-300').removeClass('bg-[#432C7A] hover:bg-[#321f5e] shadow-lg');
                    $('#display_ongkir').text('-');
                    $('#display_grand_total').text('Rp ' + new Intl.NumberFormat('id-ID').format(subtotal));
                    return;
                }

                // Update UI Harga
                $('#display_ongkir').text('Rp ' + new Intl.NumberFormat('id-ID').format(ongkir));
                let grandTotal = subtotal + ongkir;
                $('#display_grand_total').text('Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal));

                // Isi Hidden Input Form
                $('#input_ongkir').val(ongkir);
                $('#input_grand_total').val(grandTotal);
                $('#input_service').val(serviceName);
                $('#input_etd').val(etd);

                // Aktifkan Tombol Bayar
                $('#btn_pay').prop('disabled', false)
                             .removeClass('bg-gray-300 cursor-not-allowed')
                             .addClass('bg-[#432C7A] hover:bg-[#321f5e] shadow-lg transform active:scale-95')
                             .html('<i class="fas fa-lock mr-2"></i> Bayar Sekarang');
            });


            // ==========================================
            // 2. LOGIKA POPUP MIDTRANS (BARU & PENTING)
            // ==========================================
            
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form reload halaman

                let btn = $('#btn_pay');
                let originalText = btn.html();
                
                // Ubah tombol jadi loading
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...');

                $.ajax({
                    url: "{{ route('pembeli.checkout.process') }}",
                    method: "POST",
                    data: $(this).serialize(), // Kirim semua data form
                    success: function(response) {
                        
                        // Jika Sukses, Munculkan Popup Midtrans
                        if(response.status == 'success') {
                            
                            // Panggil Snap Midtrans
                            window.snap.pay(response.snap_token, {
                                onSuccess: function(result){
                                    // Sukses Bayar -> Pindah ke Riwayat
                                    window.location.href = response.redirect_url;
                                },
                                onPending: function(result){
                                    // Menunggu Bayar (Tutup Popup tapi belum bayar) -> Pindah ke Riwayat
                                    window.location.href = response.redirect_url;
                                },
                                onError: function(result){
                                    // Error -> Pindah ke Riwayat
                                    window.location.href = response.redirect_url;
                                },
                                onClose: function(){
                                    // User tutup popup manual -> Pindah ke Riwayat
                                    alert('Anda belum menyelesaikan pembayaran. Silakan cek menu Riwayat Pesanan.');
                                    window.location.href = response.redirect_url;
                                }
                            });

                        } else {
                            // Jika ada error dari server
                            alert('Terjadi kesalahan: ' + (response.message || 'Unknown Error'));
                            btn.prop('disabled', false).html(originalText);
                        }
                    },
                    error: function(xhr) {
                        // Handle Error Validasi / Server Error
                        let errorMsg = 'Gagal memproses pesanan.';
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg += '\n' + xhr.responseJSON.message;
                        }
                        alert(errorMsg);
                        btn.prop('disabled', false).html(originalText);
                    }
                });
            });

        });
    </script>

    {{-- Tambahan style kecil untuk konsistensi --}}
    @push('styles')
    <style>
        /* Custom styles untuk select */
        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%233B82F6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-print-color-adjust: exact;
            appearance: none;
        }
        
        /* Animasi loading */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Hover effect untuk card */
        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
        }
    </style>
    @endpush

</x-pembeli-layout>