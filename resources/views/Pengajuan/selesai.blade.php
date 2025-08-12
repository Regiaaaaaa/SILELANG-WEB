@extends('layouts.app')

@section('content')
<div x-data="{ open: false, selected: null }" class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-green-500 text-white px-4 py-3">
            <h1 class="text-lg font-bold">Daftar Pengajuan Selesai</h1>
            <p class="text-sm opacity-90">Total: {{ $pengajuan->count() }} pengajuan selesai</p>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @if($pengajuan->count() > 0)
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama Barang</th>
                        <th class="px-4 py-2 text-left">Merek</th>
                        <th class="px-4 py-2 text-left">Kondisi</th>
                        <th class="px-4 py-2 text-left">Harga Awal</th>
                        <th class="px-4 py-2 text-left">Lokasi</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $item->nama_barang }}</td>
                        <td class="px-4 py-2">{{ $item->merek }}</td>
                        <td class="px-4 py-2">{{ $item->kondisi }}</td>
                        <td class="px-4 py-2 text-green-600 font-semibold">
                            Rp {{ number_format($item->harga_awal, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2">{{ $item->lokasi }}</td>
                        <td class="px-4 py-2 text-center">
                            <button
                                @click="open = true; selected = {{ json_encode($item, JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                                class="px-2 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-10">
                <p class="text-gray-500">Tidak ada pengajuan selesai.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 overflow-y-auto max-h-[90vh]">
            <h2 class="text-lg font-bold mb-4">Detail Barang</h2>

            <template x-if="selected">
                <div class="space-y-3 text-sm">
                    <!-- Gambar Barang -->
                    <div class="flex justify-center">
                        <img :src="selected.gambar ? '/storage/' + selected.gambar : '/images/no-image.png'"
                            alt="Gambar Barang"
                            class="w-48 h-48 object-cover rounded shadow">
                    </div>

                    <!-- Info Barang -->
                    <p><span class="font-semibold">Nama Barang:</span> <span x-text="selected.nama_barang"></span></p>
                    <p><span class="font-semibold">Merek:</span> <span x-text="selected.merek"></span></p>
                    <p><span class="font-semibold">Kondisi:</span> <span x-text="selected.kondisi"></span></p>
                    <p><span class="font-semibold">Harga Awal:</span> Rp <span x-text="new Intl.NumberFormat('id-ID').format(selected.harga_awal)"></span></p>
                    <p><span class="font-semibold">Lokasi:</span> <span x-text="selected.lokasi"></span></p>
                    <p><span class="font-semibold">Deskripsi:</span> <span x-text="selected.deskripsi ?? '-'"></span></p>

                    <!-- Waktu Mulai -->
                    <p><span class="font-semibold">Waktu Mulai:</span> 
                        <span x-text="selected.created_at ? new Date(selected.created_at).toLocaleString('id-ID') : '-'"></span>
                    </p>

                    <!-- Waktu Selesai -->
                    <p><span class="font-semibold">Waktu Selesai:</span> 
                        <span x-text="selected.updated_at ? new Date(selected.updated_at).toLocaleString('id-ID') : '-'"></span>
                    </p>

                    <!-- Pemilik -->
                    <p><span class="font-semibold">Pemilik:</span> <span x-text="selected.user?.name ?? '-'"></span></p>

                    <!-- Pemenang -->
                    <template x-if="selected.pemenang_id">
                        <div>
                            <p><span class="font-semibold">Pemenang ID:</span> <span x-text="selected.pemenang_id"></span></p>
                            <p><span class="font-semibold">Nama Pemenang:</span> <span x-text="selected.pemenang?.name ?? 'User tidak ditemukan'"></span></p>
                            <p><span class="font-semibold">Jumlah Penawaran:</span>
                                <span x-text="selected.jumlah_penawaran ? 'Rp ' + new Intl.NumberFormat('id-ID').format(selected.jumlah_penawaran) : '-'"></span>
                            </p>
                        </div>
                    </template>
                    <template x-if="!selected.pemenang_id">
                        <p class="text-gray-500">Belum ada pemenang</p>
                    </template>
                </div>
            </template>

            <div class="mt-6 flex justify-end">
                <button
                    @click="open = false"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
