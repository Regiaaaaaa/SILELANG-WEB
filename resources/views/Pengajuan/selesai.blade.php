@extends('layouts.app')

@section('content')
<div x-data="{ open: false, selected: null }" class="p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengajuan Selesai</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola dan pantau pengajuan yang telah selesai</p>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Selesai</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pengajuan->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Pemenang</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pengajuan->whereNotNull('pemenang_id')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Belum Terjual</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pengajuan->whereNull('pemenang_id')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Barang</h2>
                <div class="flex items-center space-x-2">
                    <input type="text" placeholder="Cari barang..." class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @if($pengajuan->count() > 0)
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Merek</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kondisi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga Awal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach($pengajuan as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_barang }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $item->nama_barang }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->lokasi }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $item->merek }}</p>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium 
                                {{ $item->kondisi == 'baru' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($item->kondisi) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</p>
                        </td>

                        <td class="px-6 py-4">
                            @if($item->pemenang_id)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terjual
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                    Tidak Terjual
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <button
                                @click="open = true; selected = {{ json_encode($item, JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                                class="inline-flex items-center px-3 py-1.5 bg-custom-blue hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada pengajuan yang selesai.</p>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($pengajuan->count() > 0)
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-medium">{{ $pengajuan->count() }}</span> data
                </p>
            </div>
        </div>
        @endif
    </div>

    <!-- MODAL -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4"
        style="display: none;">
        
        <div 
            @click.away="open = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Detail Pengajuan</h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto flex-1">
                <template x-if="selected">
                    <div class="space-y-6">

                        <!-- Image -->
                        <div class="flex justify-center">
                            <div class="w-full max-w-md">
                                <img :src="selected.gambar ? '/storage/' + selected.gambar : '/images/no-image.png'"
                                    :alt="selected.nama_barang"
                                    class="w-full h-64 object-cover rounded-lg shadow-md">
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Nama Barang</p>
                                <p class="text-sm font-semibold text-gray-800" x-text="selected.nama_barang"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Merek</p>
                                <p class="text-sm font-semibold text-gray-800" x-text="selected.merek"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Kondisi</p>
                                <p class="text-sm font-semibold text-gray-800 capitalize" x-text="selected.kondisi"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Harga Awal</p>
                                <p class="text-sm font-semibold text-green-600">
                                    Rp <span x-text="new Intl.NumberFormat('id-ID').format(selected.harga_awal)"></span>
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                                <p class="text-xs text-gray-500 mb-1">Lokasi</p>
                                <p class="text-sm font-semibold text-gray-800" x-text="selected.lokasi"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                                <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                <p class="text-sm text-gray-700" x-text="selected.deskripsi ?? '-'"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Waktu Mulai</p>
                                <p class="text-sm text-gray-700" x-text="selected.created_at ? new Date(selected.created_at).toLocaleString('id-ID') : '-'"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Waktu Selesai</p>
                                <p class="text-sm text-gray-700" x-text="selected.updated_at ? new Date(selected.updated_at).toLocaleString('id-ID') : '-'"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                                <p class="text-xs text-gray-500 mb-1">Pemilik</p>
                                <p class="text-sm font-semibold text-gray-800" x-text="selected.user?.name ?? '-'"></p>
                            </div>
                        </div>

                        <!-- Winner Info -->
                        <template x-if="selected.pemenang_id">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center mb-3">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <h3 class="text-sm font-semibold text-green-800">Informasi Pemenang</h3>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-xs text-green-600">Nama Pemenang</p>
                                        <p class="text-sm font-semibold text-green-900" x-text="selected.pemenang?.name ?? 'User tidak ditemukan'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-green-600">Harga Menang</p>
                                        <p class="text-sm font-semibold text-green-900">
                                            Rp <span x-text="selected.jumlah_penawaran ? new Intl.NumberFormat('id-ID').format(selected.jumlah_penawaran) : '-'"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template x-if="!selected.pemenang_id">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm text-gray-500">Lelang selesai tanpa pemenang</p>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex justify-end">
                    <button
                        @click="open = false"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection