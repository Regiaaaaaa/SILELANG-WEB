@extends('layouts.app')

@section('content')
<div class="px-6 py-8">
    <div class="max-w-full">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 mb-2">Daftar Barang Lelang</h1>
                    <p class="text-slate-600">Kelola dan pantau semua barang lelang Anda dengan mudah</p>
                </div>
                <a href="{{ route('admin.barang.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Barang
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">{{ $barangs->count() }}</h3>
                        <p class="text-slate-600 text-sm font-medium">Total Barang</p>
                    </div>
                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-emerald-600">{{ $barangs->where('status', 'aktif')->count() }}</h3>
                        <p class="text-slate-600 text-sm font-medium">Aktif</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-amber-600">{{ $barangs->where('status', 'menunggu')->count() }}</h3>
                        <p class="text-slate-600 text-sm font-medium">Menunggu</p>
                    </div>
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-600">{{ $barangs->where('status', 'selesai')->count() }}</h3>
                        <p class="text-slate-600 text-sm font-medium">Selesai</p>
                    </div>
                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Barang</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Info</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Jadwal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach ($barangs as $barang)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <!-- Barang Column -->
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    @php
                                        $images = json_decode($barang->gambar ?? '[]');
                                        $firstImage = !empty($images) ? $images[0] : null;
                                    @endphp
                                    
                                    <div class="flex-shrink-0 w-12 h-12 mr-3">
                                        @if($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                                 alt="{{ $barang->nama_barang }}" 
                                                 class="w-12 h-12 rounded-lg object-cover shadow-sm border border-slate-200 cursor-pointer hover:shadow-md transition-shadow"
                                                 onclick="openImageModal('{{ $barang->id }}')">
                                        @else
                                            <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-base font-semibold text-slate-800 truncate">{{ $barang->nama_barang }}</h4>
                                        <button onclick="openDetailModal('{{ $barang->id }}')" 
                                                class="text-sm text-blue-600 hover:text-blue-800 mt-1 font-medium">
                                            Lihat Detail
                                        </button>
                                        @if(!empty($images) && count($images) > 1)
                                            <span class="inline-flex items-center mt-2 px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ count($images) }} foto
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Info Column -->
                            <td class="px-4 py-4">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-1">{{ $barang->merek }}</div>
                                    <div class="flex items-center text-slate-500 mb-2">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-md">
                                            {{ ucfirst($barang->kondisi) }}
                                        </span>
                                    </div>
                                    <button onclick="openDetailModal('{{ $barang->id }}')" 
                                            class="flex items-center text-slate-500 hover:text-blue-600 text-xs">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Lihat Lokasi
                                    </button>
                                </div>
                            </td>

                            <!-- Harga Column -->
                            <td class="px-4 py-4">
                                <div class="text-base font-bold text-slate-800">
                                    Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-slate-500">Harga Awal</div>
                            </td>

                            <!-- Jadwal Column -->
                            <td class="px-4 py-4">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-1">
                                        {{ \Carbon\Carbon::parse($barang->waktu_mulai)->format('d M Y') }}
                                    </div>
                                    <div class="text-slate-500 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($barang->waktu_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($barang->waktu_selesai)->format('H:i') }}
                                    </div>
                                </div>
                            </td>

                            <!-- Status Column -->
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full
                                    {{ $barang->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($barang->status === 'menunggu' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-800') }}">
                                    <span class="w-2 h-2 rounded-full mr-2
                                        {{ $barang->status === 'aktif' ? 'bg-emerald-400' : 
                                           ($barang->status === 'menunggu' ? 'bg-amber-400' : 'bg-slate-400') }}"></span>
                                    {{ ucfirst($barang->status) }}
                                </span>
                            </td>

                            <!-- Actions Column -->
                            <td class="px-4 py-4">
                                <div class="flex items-center space-x-2">
                                    <button onclick="openDetailModal('{{ $barang->id }}')"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Detail
                                    </button>
                                    
                                    <a href="{{ route('admin.barang.edit', $barang->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200 rounded-lg transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus {{ $barang->nama_barang }}?')"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded-lg transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($barangs->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-slate-800">Belum ada barang lelang</h3>
                    <p class="mt-1 text-slate-500">Mulai dengan menambahkan barang lelang pertama Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.barang.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Barang
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Detail Modal -->
@foreach ($barangs as $barang)
    <div id="detailModal{{ $barang->id }}" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="relative max-w-2xl w-full max-h-full bg-white rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <h3 class="text-xl font-semibold text-slate-800">{{ $barang->nama_barang }}</h3>
                <button onclick="closeDetailModal('{{ $barang->id }}')" 
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-6 max-h-96 overflow-y-auto">
                <!-- Detail Content -->
                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Merek</h4>
                            <p class="text-base text-slate-800">{{ $barang->merek }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Kondisi</h4>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium bg-slate-100 text-slate-700 rounded-lg">
                                {{ ucfirst($barang->kondisi) }}
                            </span>
                        </div>
                    </div>

                    <div>
        <h4 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Kategori</h4>
        <p class="text-base text-slate-800">{{ $barang->kategori->nama_kategori ?? '-' }}</p>
    </div>
</div>

                    <!-- Description -->
                    <div>
                        <h4 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Deskripsi</h4>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <p class="text-slate-700 leading-relaxed">{{ $barang->deskripsi }}</p>
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <h4 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Lokasi</h4>
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-slate-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div class="bg-slate-50 rounded-lg p-4 flex-1">
                                <p class="text-slate-700">{{ $barang->lokasi }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Schedule -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Harga Awal</h4>
                            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Jadwal Lelang</h4>
                            <div class="space-y-1">
                                <p class="text-base font-medium text-slate-800">
                                    {{ \Carbon\Carbon::parse($barang->waktu_mulai)->format('d M Y') }}
                                </p>
                                <p class="text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($barang->waktu_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($barang->waktu_selesai)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Images Button -->
                    @php
                        $images = json_decode($barang->gambar ?? '[]');
                    @endphp
                    @if(!empty($images))
                        <div class="pt-4 border-t border-slate-200">
                            <button onclick="closeDetailModal('{{ $barang->id }}'); openImageModal('{{ $barang->id }}')"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Lihat Galeri Foto ({{ count($images) }} foto)
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Image Modal -->
@foreach ($barangs as $barang)
    @php
        $images = json_decode($barang->gambar ?? '[]');
    @endphp
    @if(!empty($images))
        <div id="imageModal{{ $barang->id }}" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
            <div class="relative max-w-4xl max-h-full bg-white rounded-2xl shadow-2xl">
                <div class="flex items-center justify-between p-6 border-b border-slate-200">
                    <h3 class="text-xl font-semibold text-slate-800">{{ $barang->nama_barang }} - Galeri Foto</h3>
                    <button onclick="closeImageModal('{{ $barang->id }}')" 
                            class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto">
                        @foreach($images as $index => $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="{{ $barang->nama_barang }} - Gambar {{ $index + 1 }}" 
                                     class="w-full h-48 object-cover rounded-xl shadow-sm border border-slate-200">
                                <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $index + 1 }}/{{ count($images) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script>
// Detail Modal Functions
function openDetailModal(itemId) {
    document.getElementById('detailModal' + itemId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal(itemId) {
    document.getElementById('detailModal' + itemId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Image Modal Functions
function openImageModal(itemId) {
    document.getElementById('imageModal' + itemId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal(itemId) {
    document.getElementById('imageModal' + itemId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('bg-black')) {
        // Close detail modals
        const detailModals = document.querySelectorAll('[id^="detailModal"]');
        detailModals.forEach(modal => {
            modal.classList.add('hidden');
        });
        
        // Close image modals
        const imageModals = document.querySelectorAll('[id^="imageModal"]');
        imageModals.forEach(modal => {
            modal.classList.add('hidden');
        });
        
        document.body.style.overflow = 'auto';
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        // Close detail modals
        const detailModals = document.querySelectorAll('[id^="detailModal"]');
        detailModals.forEach(modal => {
            modal.classList.add('hidden');
        });
        
        // Close image modals
        const imageModals = document.querySelectorAll('[id^="imageModal"]');
        imageModals.forEach(modal => {
            modal.classList.add('hidden');
        });
        
        document.body.style.overflow = 'auto';
    }
});
</script>
@endsection