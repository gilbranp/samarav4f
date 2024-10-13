<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - BibakuTech</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Tailwind CSS 2.2.19 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100">

  <main>
    <div class="min-h-screen flex items-center justify-center bg-green-600">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-3xl font-bold text-center text-green-700 mb-6">REGISTRASI SAMARA</h2>
    
            <!-- Form Registrasi -->
            <form action="/register" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-green-700 font-semibold mb-2">Nama</label>
                    <input type="text" id="name" name="name" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nama lengkap" required>
                </div>
                
                <div class="mb-4">
                    <label for="address" class="block text-green-700 font-semibold mb-2">Alamat</label>
                    <textarea id="address" name="address" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                </div>
    
                <div class="mb-4">
                    <label for="level" class="block text-green-700 font-semibold mb-2">Anda adalah seorang</label>
                    <select id="level" name="level" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                        <option value="">Pilih peran anda</option>
                        <option value="Kurir">Kurir</option>
                        <option value="Pendonasi">Pendonasi</option>
                        <option value="Penerima">Penerima</option>
                    </select>
                </div>
    
                <div class="mb-4">
                    <label for="organitation" class="block text-green-700 font-semibold mb-2">Organisasi</label>
                    <input type="text" id="organitation" name="organitation" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nama organisasi" required>
                </div>
    
                <div class="mb-4">
                    <label for="phone" class="block text-green-700 font-semibold mb-2">Nomor Telepon</label>
                    <input type="number" id="phone" name="phone" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nomor telepon" required>
                </div>
    
                <div class="mb-4">
                    <label for="job" class="block text-green-700 font-semibold mb-2">Pekerjaan</label>
                    <input type="text" id="job" name="job" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan pekerjaan Anda" required>
                </div>
    
                <div class="mb-4">
                    <label for="password" class="block text-green-700 font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan password" required>
                </div>
    
                <!-- Tombol Registrasi -->
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition duration-300 shadow-lg">
                    Daftar
                </button>
            </form>
    
            <!-- Link Login -->
            <div class="mt-6 text-center">
                <a href="/login" class="text-yellow-500 hover:underline">Sudah punya akun? Login sekarang</a>
            </div>
        </div>
    </div>
    
  </main>

</body>

</html>
