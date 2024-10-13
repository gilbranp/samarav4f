@extends('backend.layout.main')
@section('content')


        <!-- Konten Utama -->
        <main id="mainContent" class="main-content flex-1 p-6 overflow-y-auto transition-all duration-300">
            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                    <i class="bi bi-currency-exchange"></i>
                    <h3 class="text-xl font-bold">Total Donasi</h3>
                    <p class="text-2xl">100,000 IDR</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                    <i class="bi bi-cash"></i>
                    <h3 class="text-xl font-bold">Donasi Hari Ini</h3>
                    <p class="text-2xl">20,000 IDR</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                    <i class="bi bi-people"></i>
                    <h3 class="text-xl font-bold">Total Pengguna</h3>
                    <p class="text-2xl">150</p>
                </div>
            </div>

            <!-- Tabel Donasi -->
            <div class="bg-white p-4 rounded-lg shadow-lg overflow-x-auto">
                <h3 class="text-xl font-bold mb-4">Daftar Donasi</h3>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 px-4 border">Nama Donatur</th>
                            <th class="py-2 px-4 border">Jumlah Donasi</th>
                            <th class="py-2 px-4 border">Tanggal Donasi</th>
                            <th class="py-2 px-4 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border">Radenta</td>
                            <td class="py-2 px-4 border">50,000 IDR</td>
                            <td class="py-2 px-4 border">2024-10-01</td>
                            <td class="py-2 px-4 border">Sukses</td>
                        </tr>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border">Wati</td>
                            <td class="py-2 px-4 border">30,000 IDR</td>
                            <td class="py-2 px-4 border">2024-10-02</td>
                            <td class="py-2 px-4 border">Sukses</td>
                        </tr>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border">Ika</td>
                            <td class="py-2 px-4 border">20,000 IDR</td>
                            <td class="py-2 px-4 border">2024-10-03</td>
                            <td class="py-2 px-4 border">Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    
@endsection