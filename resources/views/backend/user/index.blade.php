@extends('backend.layout.main')
@section('content')

<div class="container mx-auto p-6">
    <!-- Header Manajemen Pengguna -->
    <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl lg:text-4xl font-semibold text-green-700 mb-4 lg:mb-0">Manajemen Pengguna</h1>
        <a href="#" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-green-700 transition duration-300 text-center w-full lg:w-auto">
            <i class="bi bi-plus-lg"></i> Tambah Pengguna
        </a>
    </div>

    <!-- Tabel Pengguna Responsif -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto"> <!-- Responsif dengan Scroll pada layar kecil -->
            <table class="min-w-full table-auto">
                <thead class="bg-green-600 text-white text-sm lg:text-lg">
                    <tr>
                        <th class="py-4 px-4 lg:px-6 text-left">#</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Nama Pengguna</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Email</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Role</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Status Persetujuan</th>
                        <th class="py-4 px-4 lg:px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm lg:text-base">
                    <!-- Contoh data -->
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="py-4 px-4 lg:px-6">1</td>
                        <td class="py-4 px-4 lg:px-6">John Doe</td>
                        <td class="py-4 px-4 lg:px-6">johndoe@gmail.com</td>
                        <td class="py-4 px-4 lg:px-6">Penerima</td>
                        <td class="py-4 px-4 lg:px-6">
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs lg:text-sm">Menunggu Persetujuan</span>
                        </td>
                        <td class="py-4 px-4 lg:px-6 flex">
                            <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-lg mr-4 hover:bg-green-600 transition duration-200" onclick="approveUser(1)">
                                <i class="bi bi-check-circle"></i> ACC
                            </a>
                            <a href="#" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-4 hover:bg-red-600 transition duration-200" onclick="rejectUser(1)">
                                <i class="bi bi-x-circle"></i> Tolak
                            </a>
                            <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
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

<script>
    function approveUser(userId) {
        if (confirm('Anda yakin ingin menyetujui pengguna ini?')) {
            // Lakukan AJAX untuk mengupdate status menjadi ACC
            // Contoh: axios.post('/approve-user', { id: userId });
            alert('Pengguna disetujui.');
        }
    }

    function rejectUser(userId) {
        if (confirm('Anda yakin ingin menolak pengguna ini?')) {
            // Lakukan AJAX untuk mengupdate status menjadi Tolak
            // Contoh: axios.post('/reject-user', { id: userId });
            alert('Pengguna ditolak.');
        }
    }
</script>

@endsection
