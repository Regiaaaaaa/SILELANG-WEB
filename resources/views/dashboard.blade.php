@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Integrated Header -->
    <div class="bg-white shadow-sm px-6 py-3 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <!-- Page Title -->
            <div>
                <h1 class="text-xl font-bold text-gray-800">Dashboard Admin</h1>
                <p class="text-xs text-gray-600">Ringkasan aktivitas sistem lelang</p>
            </div>
            
            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="relative hidden md:block">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari..." class="block w-48 pl-9 pr-3 py-1.5 border border-gray-300 rounded-lg bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>

                <!-- Notifications -->
                <button class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full transition-colors relative">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-0 right-0 block h-2 w-2 bg-red-500 rounded-full ring-1 ring-white"></span>
                </button>

                <!-- Profile -->
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-medium text-xs shadow-sm">
                            A
                        </div>
                        <span class="absolute bottom-0 right-0 block h-2 w-2 bg-green-500 rounded-full ring-1 ring-white"></span>
                    </div>
                    <div class="hidden md:block">
                        <div class="text-xs font-medium text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-4">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Lelang Aktif -->
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">{{ $stats['lelang_aktif']['label'] }}</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['lelang_aktif']['value'] }}</h3>
                        <p class="text-xs text-blue-600 mt-1">{{ $stats['lelang_aktif']['subtitle'] }}</p>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Total Pengguna -->
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">{{ $stats['total_pengguna']['label'] }}</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_pengguna']['value'] }}</h3>
                        <p class="text-xs text-green-600 mt-1">{{ $stats['total_pengguna']['subtitle'] }}</p>
                    </div>
                    <div class="p-2 bg-green-50 rounded-lg text-green-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Barang Terjual -->
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">{{ $stats['barang_terjual']['label'] }}</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['barang_terjual']['value'] }}</h3>
                        <p class="text-xs text-purple-600 mt-1">{{ $stats['barang_terjual']['subtitle'] }}</p>
                    </div>
                    <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h3v-8a1 1 0 011-1h4a1 1 0 011 1v8h3a1 1 0 001-1V7l-7-5zM9 17v-6h2v6H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Total Nilai Lelang -->
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">{{ $stats['pendapatan']['label'] }}</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $stats['pendapatan']['value'] }}</h3>
                        <p class="text-xs text-orange-600 mt-1">{{ $stats['pendapatan']['subtitle'] }}</p>
                    </div>
                    <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Riwayat Lelang -->
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 lg:col-span-2">
                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Riwayat Lelang</h3>
                        <p class="text-xs text-gray-600">Semua lelang yang telah selesai</p>
                    </div>
                    <a href="{{ route('admin.pengajuan.selesai') }}" class="text-xs text-blue-600 hover:text-blue-800">Lihat Semua</a>
                </div>
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @forelse($recentLelang as $lelang)
                    <div class="flex items-start justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-{{ ['blue', 'green', 'purple', 'yellow', 'pink', 'indigo'][($loop->index) % 6] }}-500 to-{{ ['blue', 'green', 'purple', 'yellow', 'pink', 'indigo'][($loop->index) % 6] }}-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($lelang->nama_barang, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 text-sm">{{ $lelang->nama_barang }}</h4>
                                <p class="text-xs text-gray-600">{{ $lelang->nama_kategori }} • {{ $lelang->pemilik }}</p>
                                @if($lelang->pemenang)
                                    <p class="text-xs text-gray-500">Pemenang: {{ $lelang->pemenang }}</p>
                                @else
                                    <p class="text-xs text-gray-500">Belum ada pemenang</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900 text-sm">Rp {{ number_format($lelang->harga_awal, 0, ',', '.') }}</p>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium 
                                @if($lelang->status == 'selesai') bg-green-100 text-green-800
                                @elseif($lelang->status == 'aktif') bg-blue-100 text-blue-800
                                @elseif($lelang->status == 'menunggu') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif rounded-full">
                                {{ ucfirst($lelang->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500 text-sm">Belum ada data lelang</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Summary Statistics -->
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Ringkasan</h3>
                        <p class="text-xs text-gray-600">Statistik sistem</p>
                    </div>
                </div>
                <div class="space-y-4 max-h-64 overflow-y-auto">
                    <!-- Kategori -->
                    <div>
                        <h4 class="text-xs font-semibold text-gray-900 mb-2">Kategori Terpopuler</h4>
                        <div class="space-y-2">
                            @foreach($summaryData['kategori'] as $kategori)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-{{ ['yellow', 'blue', 'green', 'purple', 'red'][($loop->index) % 5] }}-500 rounded-full"></div>
                                    <span class="text-xs text-gray-600">{{ $kategori->nama_kategori }}</span>
                                </div>
                                <span class="text-xs font-medium text-gray-900">Rp {{ number_format($kategori->total, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Additional Stats -->
                    <div class="border-t pt-3">
                        <h4 class="text-xs font-semibold text-gray-900 mb-2">Statistik Tambahan</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Total Penawaran</span>
                                <span class="text-xs font-medium text-gray-900">{{ $summaryData['additional']['total_penawaran'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Total Kategori</span>
                                <span class="text-xs font-medium text-gray-900">{{ $summaryData['additional']['total_kategori'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Lelang Diverifikasi</span>
                                <span class="text-xs font-medium text-gray-900">{{ $summaryData['additional']['verified_lelang'] }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Distribution -->
                    <div class="border-t pt-3">
                        <h4 class="text-xs font-semibold text-gray-900 mb-2">Status Lelang</h4>
                        <div class="space-y-2">
                            @foreach($summaryData['status'] as $status)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 
                                        @if($status->status == 'selesai') bg-green-500
                                        @elseif($status->status == 'aktif') bg-blue-500
                                        @elseif($status->status == 'menunggu') bg-yellow-500
                                        @else bg-gray-500
                                        @endif rounded-full"></div>
                                    <span class="text-xs text-gray-600">{{ ucfirst($status->status) }}</span>
                                </div>
                                <span class="text-xs font-medium text-gray-900">{{ $status->total }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection