@extends('backend.layout.main')
@section('content')

<main class="main-content flex-1 p-6 overflow-y-auto transition-all duration-300">
    <div class="container mx-auto p-6">

        <!-- Header Section -->
        <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg mb-8 text-center lg:text-left">
            <h1 class="text-3xl font-bold">Kelola Donasi</h1>
            <p class="mt-2">
                Di halaman ini, Anda dapat melihat total donasi yang diterima dan menyalurkan donasi kepada penerima yang sesuai.
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                <strong class="font-bold">Terjadi kesalahan!</strong> 
                <span class="block sm:inline">Silakan perbaiki kesalahan berikut:</span>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Statistik Donasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <!-- Total Donasi Uang -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-2xl font-semibold text-green-700 mb-2">Total Donasi Uang</h2>
                <p class="text-4xl font-bold">Rp {{ number_format($totalCashDonate, 0, ',', '.') }}</p>
                <p class="text-gray-600 mt-2">Diterima dari 50 donatur</p>
            </div>
            <!-- Total Donasi Makanan -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-2xl font-semibold text-green-700 mb-2">Total Donasi Barang</h2>
                <p class="text-4xl font-bold">{{ $totalItemDonate }} Paket</p>
                <p class="text-gray-600 mt-2">Diterima dari 30 donatur</p>
            </div>
        </div>

        @if (Auth::user()->level === 'Administrator')
        <!-- Tombol untuk Salurkan Donasi Baru -->
        <div class="text-center mb-4">
            <button id="openModal" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition duration-300">
                Salurkan Donasi Baru
            </button>
        </div>      
        @endif

       <!-- Tabel Donasi yang Sudah Disalurkan -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-green-700 mb-4">Donasi yang Sudah Disalurkan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 px-4 border">#</th>
                            <th class="py-2 px-4 border">Jenis Donasi</th>
                            <th class="py-2 px-4 border">Jumlah</th>
                            <th class="py-2 px-4 border">Penerima</th>
                            <th class="py-2 px-4 border">Tanggal</th>
                            <th class="py-2 px-4 border">Status</th>
                            <th class="py-2 px-4 border">Lacak</th> <!-- Kolom baru untuk tracking -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donates as $no => $donation)
                        <tr class="hover:bg-gray-100">
                            <?php 
                                $jmlhDonasi = $donation->donation_type == "uang" 
                                    ? "RP. " . number_format($donation->amount, 0, ',', '.') 
                                    : number_format($donation->item_qty, 0, ',', '.') . " Paket";

                                    $date = new DateTime($donation->created_at);
                                    $formattedDate = $date->format('d F Y');

                            ?>
                            <td class="py-2 px-4 border">{{ $no + 1 }}</td>
                            <td class="py-2 px-4 border">{{ $donation->donation_type }}</td>
                            <td class="py-2 px-4 border">{{ $jmlhDonasi }}</td>
                            <td class="py-2 px-4 border">{{ $donation->penerima->name }}</td>
                            <td class="py-2 px-4 border">{{ $formattedDate ?? '-'}}</td>
                            <td class="py-2 px-4 border">
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">{{ $donation->status }}</span>
                            </td>
                            @if ($donation->donation_type != 'uang' || !is_null($donation->resi_number))
                                <td class="py-2 px-4 border text-center">
                                    <a href="/tracking/{{$donation->id}}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                                    Lacak
                                    </a>
                                </td> 
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-2 px-4 border text-center">Tidak ada donasi tersedia.</td>
                        </tr>
                        @endforelse
                        <!-- Tambahkan baris donasi lain di sini -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk Salurkan Donasi -->
        <div id="donationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">Salurkan Donasi</h2>
                <form action="{{ route('managedonate.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Pilih Jenis Donasi -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="jenisDonasi">
                            Jenis Donasi
                        </label>
                        <select id="jenisDonasi" name="donation_type" class="form-select px-3 py-2 border rounded-lg w-full" onchange="toggleFoodOptions()">
                            <option value="pilih">Pilih jenis donasi</option>
                            <option value="uang">Uang</option>
                            <option value="alat pertanian">Alat Pertanian</option> 
                            <option value="pupuk kimia">Pupuk Kimia</option> 
                            <option value="pupuk organik">Pupuk Organik</option> 
                            <option value="beras">Beras</option> 
                            <option value="sagu">Sagu</option> 
                            <option value="jagung">Jagung</option> 
                            <option value="lainnya">Lainnya</option> 
                        </select>
                    </div>

                    <!-- Jumlah Donasi Uang -->
                    <div id="amount_input" class="hidden">
                        <label for="amount" class="block text-lg font-semibold mb-1">Jumlah Donasi (IDR)</label>
                        <input type="number" id="amount" name="amount" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div id="item_qty" class="hidden">
                        <label for="item_qty" class="block text-lg font-semibold mb-1">Jumlah</label>
                        <input type="number" id="item_qty" name="item_qty" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                   <!-- Pilih Penerima Donasi -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="penerimaDonasi">
                            Penerima Donasi
                        </label>
                        <select id="penerimaDonasi" name="penerima_id" class="form-select px-3 py-2 border rounded-lg w-full" onchange="showProfileButton()">
                            <option selected>Pilih Penerima Donasi</option>
                            @foreach ($penerima as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>    
                            @endforeach
                        </select>
                    </div>

                    <!-- Placeholder untuk Tombol Profil -->
                    <div id="profileButtonContainer" class="mb-4 hidden">
                        <a id="profileButton" href="#" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                            Lihat Profil Penerima
                        </a>
                    </div>

                    <div id="distribusi_input" class="hidden">
                        <label for="jasa_distribusi" class="block text-lg font-semibold mb-1">Jasa Distribusi</label>
                        <select id="jasa_distribusi" name="jasa_distribusi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih jasa distribusi</option>
                            <option value="JNE">JNE</option>
                            <option value="TIKI">TIKI</option>
                            <option value="POS">POS</option>
                            <option value="jnt">J&T Express</option>
                            <option value="spx">Shopee Express</option>
                            <option value="sicepat">SiCepat</option>
                        </select>
                    </div>

                    <div id="resi_input" class="hidden">
                        <label for="resi_number" class="block text-lg font-semibold mb-1">Nomor Resi</label>
                        <input type="text" id="resi_number" name="resi_number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Pilihan Metode Pembayaran -->
                    <div id="payment_option_input" class="hidden">
                        <label for="payment_option" class="block text-lg font-semibold mb-1">Metode Pembayaran</label>
                        <select id="payment_option" name="payment_option" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih metode pembayaran</option>
                            <option value="manual">Manual</option>
                            <option value="otomatis">Otomatis</option>
                        </select>
                    </div>

                    <!-- Informasi Transfer Manual -->
                    <div id="manual_transfer_info" class="hidden mt-4">
                        <p class="text-lg font-semibold mb-1">Nomor Rekening/E-Wallet:</p>
                        <p class="text-gray-700">Bank Mandiri - 1800013687605 (a.n. Samara) atau E-Wallet Dana - 081268477296</p>
                        
                        <label for="transfer_receipt" class="block text-lg font-semibold mt-3 mb-1">
                            Unggah Bukti Transfer
                        </label>
                        <input type="file" id="transfer_receipt" name="transfer_receipt" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" aria-describedby="transferReceiptHelp">
                        <small id="transferReceiptHelp" class="text-gray-500">Hanya menerima file gambar (JPEG, PNG, JPG, GIF).</small>
                        
                    </div>

                    <!-- Tombol Salurkan -->
                    <div class="text-center">
                        <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition duration-300">
                            Salurkan Donasi
                        </button>
                    </div>
                </form>
                <div class="mt-4 text-right">
                    <button id="closeModal" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Tutup</button>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');
        const donationModal = document.getElementById('donationModal');

        openModalButton.addEventListener('click', () => {
            donationModal.classList.remove('hidden');
        });

        closeModalButton.addEventListener('click', () => {
            donationModal.classList.add('hidden');
        });
    });

    const donationTypeSelect = document.getElementById('jenisDonasi'); // Changed to correct ID
    const amountInput = document.getElementById('amount_input');
    const qtyItemInput = document.getElementById('item_qty');
    const resiInput = document.getElementById('resi_input');
    const distribusiInput = document.getElementById('distribusi_input');
    const paymentOptionInput = document.getElementById('payment_option'); 
    const paymentOptionContainer = document.getElementById('payment_option_input'); 
    const manualTransferInfo = document.getElementById('manual_transfer_info'); 

    donationTypeSelect.addEventListener('change', function() {
        console.log(this.value);
        
        if (this.value === 'uang') {
            amountInput.classList.remove('hidden');
            paymentOptionContainer.classList.remove('hidden');

            qtyItemInput.classList.add('hidden');
            distribusiInput.classList.add('hidden');
            resiInput.classList.add('hidden');
        } else if (this.value === 'pilih'){            
            amountInput.classList.add('hidden');
            paymentOptionContainer.classList.add('hidden');

            qtyItemInput.classList.add('hidden');
            distribusiInput.classList.add('hidden');
            resiInput.classList.add('hidden');
        }else {
            qtyItemInput.classList.remove('hidden');
            distribusiInput.classList.remove('hidden');
            resiInput.classList.remove('hidden');

            amountInput.classList.add('hidden');
            paymentOptionContainer.classList.add('hidden');
        } 
    });

    paymentOptionInput.addEventListener('change', function() {
        if (this.value === 'manual') {
            manualTransferInfo.classList.remove('hidden');
        } else {
            manualTransferInfo.classList.add('hidden');
        }
    });
</script>

@endsection
