<aside id="sidebar" class="sidebar sidebar-open bg-green-600 text-white h-full p-4 shadow-2xl lg:block transition-transform duration-300">
    <nav>
        <ul>
            <li class="mb-4">
                <a href="/dashboard" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-speedometer2 mr-3 text-lg"></i>
                    <span class="sidebar-content">Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->level === 'Administrator')
            <li class="mb-4">
                <a href="/listdonate" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-list-task mr-3 text-lg"></i>
                    <span class="sidebar-content">Daftar Pendonasi</span>
                </a>
            </li>
            @endif
            <li class="mb-4">
                <a href="/managedonate" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-cash-stack mr-3 text-lg"></i>
                    <span class="sidebar-content">Data Donasi</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="/donate" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-hand-thumbs-up mr-3 text-lg"></i>
                    <span class="sidebar-content">Donasi Sekarang</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="/acceptdonate" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-handbag-fill mr-3 text-lg"></i>
                    <span class="sidebar-content">Terima Donasi</span>
                </a>
            </li>
            
            @if (Auth::user()->level === 'Administrator')
            <li class="mb-4">
                <a href="/manageuser" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-person-circle mr-3 text-lg"></i>
                    <span class="sidebar-content">Manajemen Pengguna</span>
                </a>
            </li>
            @endif
            
                
           
            <li class="mb-4">
                <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-bar-chart mr-3 text-lg"></i>
                    <span class="sidebar-content">Laporan</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-gear-fill mr-3 text-lg"></i>
                    <span class="sidebar-content">Pengaturan</span>
                </a>
            </li>
            {{-- <li>
                <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-green-500 hover:shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="bi bi-box-arrow-right mr-3 text-lg"></i>
                    <span class="sidebar-content">Logout</span>
                </a>
            </li> --}}
        </ul>
    </nav>
</aside>
