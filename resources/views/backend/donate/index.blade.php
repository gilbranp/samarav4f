@extends('backend.layout.main')
@section('content')

<div class="container mx-auto p-6">
    <!-- Header Manajemen Donasi -->
    <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl lg:text-4xl font-semibold text-green-700 mb-4 lg:mb-0">Manajemen Donasi</h1>
        <a href="#" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-green-700 transition duration-300 text-center w-full lg:w-auto">
            <i class="bi bi-plus-lg"></i> Tambah Donasi
        </a>
    </div>

    <!-- Tabel Donasi Responsif -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto"> <!-- Responsif dengan Scroll pada layar kecil -->
            <table class="min-w-full table-auto">
                <thead class="bg-green-600 text-white text-sm lg:text-lg">
                    <tr>
                        <th class="py-4 px-4 lg:px-6 text-left">#</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Nama Donatur</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Jumlah Donasi</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Tanggal Donasi</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Status</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm lg:text-base">
                    <!-- Contoh data -->
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="py-4 px-4 lg:px-6">1</td>
                        <td class="py-4 px-4 lg:px-6 flex items-center">
                            <img class="w-8 h-8 lg:w-10 lg:h-10 rounded-full mr-4" src="https://via.placeholder.com/150" alt="Donatur">
                            <span>John Doe</span>
                        </td>
                        <td class="py-4 px-4 lg:px-6">Rp. 1.000.000</td>
                        <td class="py-4 px-4 lg:px-6">12 Oktober 2024</td>
                        <td class="py-4 px-4 lg:px-6">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs lg:text-sm">Diterima</span>
                        </td>
                        <td class="py-4 px-4 lg:px-6 flex">
                            <a href="#" class="text-blue-500 hover:text-blue-600 mr-4"><i class="bi bi-eye"></i> Lihat</a>
                            <a href="#" class="text-yellow-500 hover:text-yellow-600 mr-4"><i class="bi bi-pencil"></i> Edit</a>
                            <a href="#" class="text-red-500 hover:text-red-600"><i class="bi bi-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <!-- Tambahkan data lainnya dengan loop -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Responsif -->
    <div class="mt-6 flex flex-col lg:flex-row justify-between items-center">
        <a href="#" class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg shadow hover:bg-gray-300 transition duration-200 w-full lg:w-auto mb-4 lg:mb-0 text-center">
            <i class="bi bi-arrow-left"></i> Sebelumnya
        </a>
        <a href="#" class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg shadow hover:bg-gray-300 transition duration-200 w-full lg:w-auto text-center">
            Berikutnya <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>

@endsection
