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
                    <td class="py-2 px-4 border text-center">
                        <a href="/tracking/{{$donation->id}}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                           Lacak
                        </a>
                    </td> 
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
                <form>
                    <!-- Pilih Jenis Donasi -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="jenisDonasi">
                            Jenis Donasi
                        </label>
                        <select id="jenisDonasi" class="form-select px-3 py-2 border rounded-lg w-full" onchange="toggleFoodOptions()">
                            <option value="">Pilih jenis donasi</option>
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

                    <!-- Jumlah Donasi -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="jumlahDonasi">
                            Jumlah Donasi
                        </label>
                        <input id="jumlahDonasi" type="number" class="form-input px-3 py-2 border rounded-lg w-full" placeholder="Masukkan jumlah donasi">
                    </div>

                   <!-- Pilih Penerima Donasi -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="penerimaDonasi">
                            Penerima Donasi
                        </label>
                        <select id="penerimaDonasi" class="form-select px-3 py-2 border rounded-lg w-full" onchange="showProfileButton()">
                            <option selected>Pilih Penerima Donasi</option>
                            <option value="penerimaA">Penerima A</option>
                            <option value="penerimaB">Penerima B</option>
                            <option value="penerimaC">Penerima C</option>
                        </select>
                    </div>

                    <!-- Placeholder untuk Tombol Profil -->
                    <div id="profileButtonContainer" class="mb-4 hidden">
                        <a id="profileButton" href="#" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                            Lihat Profil Penerima
                        </a>
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
</script>
<script>
    function showProfileButton() {
        const penerimaDonasi = document.getElementById('penerimaDonasi').value;
        const profileButtonContainer = document.getElementById('profileButtonContainer');
        const profileButton = document.getElementById('profileButton');

        if (penerimaDonasi !== 'Pilih Penerima Donasi') {
            // Set the href for the profile based on the selected recipient
            profileButton.href = `/profile/${penerimaDonasi.toLowerCase()}`;
            
            // Show the button container
            profileButtonContainer.classList.remove('hidden');
        } else {
            // Hide the button if no recipient is selected
            profileButtonContainer.classList.add('hidden');
        }
    }
</script>

@endsection
