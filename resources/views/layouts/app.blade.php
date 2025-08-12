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

    <!-- Tambahkan ini: -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <div class="w-64 bg-gradient-to-b from-custom-blue to-indigo-700 text-white min-h-screen flex flex-col">

            <!-- Header Section with Logo -->
            <div class="p-6 border-b border-white border-opacity-20">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">SI - LELANG</h1>
                        <p class="text-sm opacity-80">Sistem Lelang Online</p>
                    </div>
                </div>
            </div>

            <!-- Menu Section -->
            <div class="flex-1 px-6 py-4">
                <div class="text-xs font-bold mb-4 opacity-90 uppercase tracking-wider">MENU</div>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-15' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.barang.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.auctions.*') ? 'bg-white bg-opacity-15' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Kelola Barang</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white bg-opacity-15' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        <span class="font-medium">Pengguna</span>
                    </a>

                    <!-- Parent menu -->
                    <div x-data="{ open: {{ request()->routeIs('admin.pengajuan.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200
        {{ request()->routeIs('admin.pengajuan.*') ? 'bg-white bg-opacity-15' : 'hover:bg-white hover:bg-opacity-10' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12H7v-2h2V7h2v3h2v2h-2v3H9v-3z"></path>
                                </svg>
                                <span class="font-medium">Pengajuan User</span>
                            </div>
                            <!-- Arrow Icon -->
                            <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Children menu -->
                        <div x-show="open" class="ml-8 mt-2 space-y-2" x-cloak>
                            <a href="{{ route('admin.pending.index') }}"
                                class="block px-4 py-2 rounded-lg text-sm transition-all duration-200
            {{ request()->routeIs('admin.pengajuan.pending') ? 'bg-white bg-opacity-20 font-semibold' : 'hover:bg-white hover:bg-opacity-10' }}">
                                Pengajuan Pending
                            </a>
                            <a href="{{ route('admin.pengajuan.aktif') }}"
                                class="block px-4 py-2 rounded-lg text-sm transition-all duration-200
            {{ request()->routeIs('admin.pengajuan.aktif') ? 'bg-white bg-opacity-20 font-semibold' : 'hover:bg-white hover:bg-opacity-10' }}">
                                Pengajuan Aktif
                            </a>
                            <a href="{{ route('admin.pengajuan.selesai') }}"
                                class="block px-4 py-2 rounded-lg text-sm transition-all duration-200
    {{ request()->routeIs('admin.pengajuan.selesai') ? 'bg-white bg-opacity-20 font-semibold' : 'hover:bg-white hover:bg-opacity-10' }}">
                                Pengajuan Selesai
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.kategori.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-white bg-opacity-15' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3h12a1 1 0 011 1v4H3V4a1 1 0 011-1zm13 6v7a1 1 0 01-1 1H4a1 1 0 01-1-1V9h14z"></path>
                        </svg>
                        <span class="font-medium">Kelola Kategori</span>
                    </a>

                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.payments.*') ? 'bg-white bg-opacity-15' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Pembayaran</span>
                    </a>

                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-white bg-opacity-15' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Laporan</span>
                    </a>
                </nav>
            </div>

            <!-- User Info -->
            <div class="p-6 border-t border-white border-opacity-20">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-base">Admin User</div>
                        <div class="text-sm opacity-80">admin@si-lelang.com</div>
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