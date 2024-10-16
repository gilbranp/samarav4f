@extends('backend.layout.main')
@section('content')

<!-- Konten Utama -->
<main id="mainContent" class="main-content flex-1 p-6 overflow-y-auto transition-all duration-300">
    <!-- Header Manajemen Donasi -->
    <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl lg:text-4xl font-semibold text-green-700 mb-4 lg:mb-0 text-center lg:text-left">Daftar Pendonasi</h1>
        {{-- <a href="#" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-green-700 transition duration-300 text-center w-full lg:w-auto">
            <i class="bi bi-plus-lg"></i> Tambah Donasi
        </a> --}}
    </div>

    <!-- Tabel Donasi -->
    <div class="bg-white p-4 rounded-lg shadow-lg overflow-x-auto">
        <h3 class="text-xl font-bold mb-4">Daftar Donasi</h3>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">No</th>
                    <th class="py-2 px-4 border">Nama Donatur</th>
                    <th class="py-2 px-4 border">Jenis Donasi</th>
                    <th class="py-2 px-4 border">Jumlah Donasi</th>
                    <th class="py-2 px-4 border">Tanggal Donasi</th>
                    <th class="py-2 px-4 border">Status</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border">1</td>
                    <td class="py-2 px-4 border">Radenta</td>
                    <td class="py-2 px-4 border">Uang</td>
                    <td class="py-2 px-4 border">50,000 IDR</td>
                    <td class="py-2 px-4 border">2024-10-01</td>
                    <td class="py-2 px-4 border">Sukses</td>
                    <td class="py-2 px-4 border flex justify-around">
                        <a href="#" class="text-blue-500 hover:text-blue-600"><i class="bi bi-eye"></i></a>
                        <a href="#" class="text-yellow-500 hover:text-yellow-600"><i class="bi bi-pencil"></i></a>
                        <a href="#" class="text-red-500 hover:text-red-600"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <!-- Tambahkan data lainnya dengan loop -->
            </tbody>
        </table>
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
</main>

@endsection
