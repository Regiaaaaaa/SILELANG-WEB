<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SI - LELANG')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-blue': '#4F6CC4'
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <div class="w-64 bg-white shadow-lg min-h-screen flex flex-col border-r border-gray-200">

            <!-- Header Section -->
            <div class="p-5 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-custom-blue rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">SI - LELANG</h1>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Menu Section -->
            <div class="flex-1 px-3 py-4 overflow-y-auto">
                <div class="text-xs font-semibold mb-3 px-3 text-gray-400 uppercase">Menu</div>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-custom-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.barang.index') }}"
                        class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.barang.*') ? 'bg-custom-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium text-sm">Kelola Barang</span>
                    </a>

                    <a href="{{ route('admin.pantau.lelang.index') }}"
                        class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.pantau.lelang.*') ? 'bg-custom-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M3 7h18M7 7v14h10V7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="font-medium text-sm">Pantau Lelang</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-custom-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        <span class="font-medium text-sm">Pengguna</span>
                    </a>

                    <!-- Dropdown Menu -->
                    <div x-data="{ open: {{ request()->routeIs('admin.pending.*') || request()->routeIs('admin.pengajuan.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.pending.*') || request()->routeIs('admin.pengajuan.*') ? 'bg-custom-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium text-sm">Pengajuan User</span>
                            </div>
                            <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition class="ml-8 mt-1 space-y-1">
                            <a href="{{ route('admin.pending.index') }}"
                                class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.pending.index') ? 'bg-blue-50 text-custom-blue font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                Pengajuan Pending
                            </a>
                            <a href="{{ route('admin.pengajuan.aktif') }}"
                                class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.pengajuan.aktif') ? 'bg-blue-50 text-custom-blue font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                Pengajuan Aktif
                            </a>
                            <a href="{{ route('admin.pengajuan.selesai') }}"
                                class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.pengajuan.selesai') ? 'bg-blue-50 text-custom-blue font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                Pengajuan Selesai
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.kategori.index') }}"
                        class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.kategori.*') ? 'bg-custom-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        <span class="font-medium text-sm">Kelola Kategori</span>
                    </a>

                    <a href="#"
                        class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.payments.*') ? 'bg-custom-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium text-sm">Pembayaran</span>
                    </a>

                    <a href="#"
                        class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-custom-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium text-sm">Laporan</span>
                    </a>
                </nav>
            </div>

            <!-- User Info -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-sm text-gray-800 truncate">Admin User</div>
                        <div class="text-xs text-gray-500 truncate">admin@si-lelang.com</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 bg-gray-50">
            @yield('content')
        </div>
    </div>

</body>

</html>