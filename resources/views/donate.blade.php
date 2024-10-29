@extends('frontend.layout.main')
@section('content')

<!-- Halaman Donasi -->
<section id="donate" class="py-16 bg-green-600 text-white">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-8">Donasi Sekarang</h2>
        <p class="text-lg md:text-xl text-center mb-12">Mari bersama membantu mereka yang membutuhkan. Setiap kontribusi sangat berarti untuk mewujudkan dunia tanpa kelaparan.</p>

        <div class="bg-white text-gray-800 p-8 rounded-lg shadow-2xl max-w-lg mx-auto">
            <form id="donationForm" action="" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="name" class="block text-lg font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>

                <div class="mb-6">
                    <label for="phone" class="block text-lg font-semibold mb-2">Nomor Telepon</label>
                    <input type="number" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>

                <!-- Pilihan Donasi -->
                <div class="mb-6">
                    <label for="donation_type" class="block text-lg font-semibold mb-2">Jenis Donasi</label>
                    <select id="donation_type" name="donation_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <option value="">Pilih jenis donasi</option>
                        <option value="uang">Uang</option>
                        <option value="barang">Barang</option>
                    </select>
                </div>

                <!-- Input untuk jumlah donasi uang -->
                <div id="amount_input" class="mb-6 hidden">
                    <label for="amount" class="block text-lg font-semibold mb-2">Jumlah Donasi (IDR)</label>
                    <input type="number" id="amount" name="amount" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Input untuk jenis barang dan perkiraan kadaluarsa -->
                <div id="item_input" class="hidden">
                    <div class="mb-6">
                        <label for="item_name" class="block text-lg font-semibold mb-2">Nama Barang</label>
                        <input type="text" id="item_name" name="item_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="mb-6">
                        <label for="item_qty" class="block text-lg font-semibold mb-2">Jumlah Barang</label>
                        <input type="number" id="item_qty" name="item_qty" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div class="mb-6">
                        <label for="expired_date" class="block text-lg font-semibold mb-2">Perkiraan Kadaluarsa</label>
                        <input type="date" id="expired_date" name="expired_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-lg font-semibold mb-2">Pesan (Opsional)</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition duration-300">Donasi Sekarang</button>
            </form>
        </div>
    </div>
</section>

<!-- Notifikasi menggunakan modal -->
<div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <p class="text-lg text-gray-800 mb-4">Anda harus login terlebih dahulu untuk melakukan donasi.</p>
        <div class="flex justify-end">
            <button id="loginBtn" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Login</button>
            <button id="closeModal" class="ml-4 bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700">Tutup</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simulasi pengecekan autentikasi dari backend
        let isAuthenticated = @json(Auth::check());

        const form = document.getElementById('donationForm');
        const modal = document.getElementById('loginModal');
        const loginBtn = document.getElementById('loginBtn');
        const closeModal = document.getElementById('closeModal');

        // Ketika tombol Donasi Sekarang diklik
        form.addEventListener('submit', function(event) {
            if (!isAuthenticated) {
                // Mencegah form dikirim jika belum login
                event.preventDefault();

                // Tampilkan modal login
                modal.classList.remove('hidden');
            }
        });

        // Arahkan ke halaman login ketika klik tombol Login di modal
        loginBtn.addEventListener('click', function() {
            window.location.href = '/login';
        });

        // Tutup modal ketika klik tombol Tutup
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // JavaScript untuk menampilkan input sesuai pilihan jenis donasi
        const donationTypeSelect = document.getElementById('donation_type');
        const amountInput = document.getElementById('amount_input');
        const itemInput = document.getElementById('item_input');

        donationTypeSelect.addEventListener('change', function() {
            const selectedValue = this.value;

            // Jika pilih uang, tampilkan input jumlah donasi
            if (selectedValue === 'uang') {
                amountInput.classList.remove('hidden');
                itemInput.classList.add('hidden');
            } 
            // Jika pilih barang, tampilkan input untuk jenis barang dan expired
            else if (selectedValue === 'barang') {
                itemInput.classList.remove('hidden');
                amountInput.classList.add('hidden');
            } 
            // Jika tidak ada yang dipilih, sembunyikan semua input
            else {
                amountInput.classList.add('hidden');
                itemInput.classList.add('hidden');
            }
        });
    });
</script>

@endsection
