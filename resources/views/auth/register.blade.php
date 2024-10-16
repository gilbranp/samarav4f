<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Registrasi - Samara</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        #video {
            display: none; /* Sembunyikan elemen video */
        }

        #canvas {
            display: none; /* Sembunyikan elemen canvas */
        }
    </style>
</head>

<body class="bg-gray-100">
    <main>
        <div class="min-h-screen flex items-center justify-center bg-green-600">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-3xl font-bold text-center text-green-700 mb-6">REGISTRASI SAMARA</h2>

                <!-- Form Registrasi -->
                <form action="/register" method="POST" enctype="multipart/form-data" id="registrationForm">
                    @csrf

                    <div class="mb-4">
                        <label for="selfie" class="block text-green-700 font-semibold mb-2">Ambil Foto Selfie</label>
                        <button type="button" id="openCamera" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg w-full">Buka Kamera</button>
                        <video id="video" class="w-full border border-green-300 rounded-lg"></video>
                        <button type="button" id="snap" class="mt-2 bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg w-full hidden">Ambil Foto</button>
                        <canvas id="canvas"></canvas>
                        <input type="hidden" name="selfie" id="selfie">
                        <img id="selfiePreview" class="mt-2 w-full border border-green-300 rounded-lg hidden" alt="Selfie Preview">
                        
                        <!-- Menampilkan nama file foto -->
                        <div id="fileInfo" class="hidden mt-2 text-green-700 font-semibold"></div>

                        <!-- Tombol Oke dan Ulang -->
                        <div id="photoButtons" class="hidden mt-2">
                            <button type="button" id="confirm" class="bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg w-full">Oke</button>
                            <button type="button" id="retry" class="bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg w-full">Ulang</button>
                        </div>

                        <p class="text-sm text-gray-500">Tekan tombol untuk membuka kamera dan ambil foto.</p>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-green-700 font-semibold mb-2">Nama</label>
                        <input type="text" id="name" name="name" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-green-700 font-semibold mb-2">Username</label>
                        <input type="text" id="name" name="username" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-green-700 font-semibold mb-2">Alamat</label>
                        <textarea id="address" name="address" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="level" class="block text-green-700 font-semibold mb-2">Anda adalah seorang</label>
                        <select id="level" name="level" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                            <option value="">Pilih peran anda</option>
                            {{-- <option value="Kurir">Kurir</option> --}}
                            <option value="Pendonasi">Pendonasi</option>
                            <option value="Penerima">Penerima</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="organitation" class="block text-green-700 font-semibold mb-2">Organisasi (Opsional)</label>
                        <input type="text" id="organitation" name="organitation" class="w-full p-3 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nama organisasi (Opsional)">
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

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const selfieInput = document.getElementById('selfie');
        const selfiePreview = document.getElementById('selfiePreview');
        const openCameraButton = document.getElementById('openCamera');
        const snapButton = document.getElementById('snap');
        const photoButtons = document.getElementById('photoButtons');
        const confirmButton = document.getElementById('confirm');
        const retryButton = document.getElementById('retry');
        const fileInfo = document.getElementById('fileInfo');

        let stream;

        // Buka kamera saat tombol diklik
        openCameraButton.addEventListener('click', () => {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((mediaStream) => {
                    stream = mediaStream;
                    video.srcObject = stream;
                    video.style.display = 'block'; // Tampilkan elemen video
                    snapButton.style.display = 'block'; // Tampilkan tombol ambil foto
                    photoButtons.classList.add('hidden'); // Sembunyikan tombol Oke dan Ulang
                    video.play();
                })
                .catch((error) => {
                    console.error("Error accessing the camera: ", error);
                });
        });

        // Ambil foto
        snapButton.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Konversi gambar menjadi data URL dan masukkan ke input tersembunyi
            const dataURL = canvas.toDataURL('image/png');
            selfieInput.value = dataURL;
            selfiePreview.src = dataURL; // Set preview gambar
            selfiePreview.style.display = 'block'; // Tampilkan gambar yang diambil

            // Tampilkan tombol Oke dan Ulang
            photoButtons.classList.remove('hidden');

            // Hentikan aliran video
            stream.getTracks().forEach(track => track.stop());
            video.style.display = 'none'; // Sembunyikan video
            snapButton.style.display = 'none'; // Sembunyikan tombol ambil foto
            openCameraButton.style.display = 'none'; // Sembunyikan tombol buka kamera
        });

        // Simpan foto
        confirmButton.addEventListener('click', () => {
            // Menampilkan nama file foto
            const timestamp = new Date().getTime();
            const filename = `selfie_${timestamp}.png`;
            fileInfo.textContent = `Foto berhasil diambil: ${filename}`;
            fileInfo.classList.remove('hidden');

            // Sembunyikan tombol Oke dan Ulang
            photoButtons.classList.add('hidden');
        });

        // Ulangi pengambilan foto
        retryButton.addEventListener('click', () => {
            // Buka kembali kamera
            openCameraButton.click(); // Simulasi klik pada tombol buka kamera
            selfiePreview.style.display = 'none'; // Sembunyikan preview gambar
            fileInfo.classList.add('hidden'); // Sembunyikan informasi file
            photoButtons.classList.add('hidden'); // Sembunyikan tombol Oke dan Ulang
        });
    </script>
</body>

</html>
