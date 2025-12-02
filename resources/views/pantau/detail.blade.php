@extends('layouts.app')

@section('title', 'Detail Lelang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <a href="/admin/pantau-lelang" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-8">
                <!-- Image Section -->
                <div>
                    @php
                        $raw = $lelang->gambar;

                        if (is_string($raw)) {
                            $decoded = json_decode($raw, true);
                            $imgs = is_array($decoded) ? $decoded : ($raw ? [$raw] : []);
                        } elseif (is_array($raw)) {
                            $imgs = $raw;
                        } else {
                            $imgs = [];
                        }

                        $img = count($imgs) ? '/storage/'.$imgs[0] : '/images/no-image.png';
                    @endphp

                    <div class="relative group cursor-pointer" onclick="openImageModal('{{ $img }}', '{{ $lelang->nama_barang }}')">
                        <img src="{{ $img }}" class="w-full h-96 object-cover rounded-xl shadow-lg transition-transform duration-300 group-hover:scale-105" alt="{{ $lelang->nama_barang }}">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-xl transition-all duration-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="flex flex-col justify-center">
                    <h1 class="text-4xl font-bold text-gray-800 mb-6">{{ $lelang->nama_barang }}</h1>

                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 border-l-4 border-blue-500">
                            <p class="text-sm text-blue-600 font-semibold mb-1">Harga Awal</p>
                            <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($lelang->harga_awal) }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-sm text-gray-500 mb-1">Waktu Mulai</p>
                                <p class="text-base font-semibold text-gray-800">{{ optional($lelang->waktu_mulai)->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-sm text-gray-500 mb-1">Waktu Selesai</p>
                                <p class="text-base font-semibold text-gray-800">{{ optional($lelang->waktu_selesai)->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bid History Section -->
        <div class="mt-8 bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Riwayat Penawaran
                </h2>
                <p class="text-blue-100 mt-1">Diurutkan dari tertinggi ke terendah</p>
            </div>

            <div class="p-8">
                @if($penawaran->count() > 0)
                    <div class="overflow-hidden rounded-xl border border-gray-200">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Peringkat</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Penawar</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Penawaran</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($penawaran as $i => $p)
                                <tr class="
                                    {{ $i === 0 ? 'bg-gradient-to-r from-yellow-50 to-amber-50 hover:from-yellow-100 hover:to-amber-100' : '' }}
                                    {{ $i === 1 ? 'bg-gradient-to-r from-gray-50 to-slate-50 hover:from-gray-100 hover:to-slate-100' : '' }}
                                    {{ $i === 2 ? 'bg-gradient-to-r from-orange-50 to-amber-50 hover:from-orange-100 hover:to-amber-100' : '' }}
                                    {{ $i > 2 ? 'bg-white hover:bg-gray-50' : '' }}
                                    transition-colors duration-150
                                ">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($i === 0)
                                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 text-white font-bold text-sm shadow-md">
                                                    🏆
                                                </span>
                                            @elseif($i === 1)
                                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-gray-300 to-gray-500 text-white font-bold text-sm shadow-md">
                                                    🥈
                                                </span>
                                            @elseif($i === 2)
                                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 text-white font-bold text-sm shadow-md">
                                                    🥉
                                                </span>
                                            @else
                                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 font-semibold text-sm">
                                                    {{ $i + 1 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium {{ $i < 3 ? 'text-gray-900' : 'text-gray-700' }}">
                                            {{ $p->user ? $p->user->name : 'User tidak ditemukan' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-bold {{ $i === 0 ? 'text-yellow-700 text-lg' : ($i < 3 ? 'text-gray-800 text-base' : 'text-gray-700') }}">
                                            Rp {{ number_format($p->jumlah_penawaran) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-sm">
                                        {{ $p->waktu_penawaran ?? ($p->created_at ? $p->created_at->format('d M Y, H:i') : '-') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 text-lg">Belum ada penawaran.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-6xl max-h-full" onclick="event.stopPropagation()">
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
    </div>
</div>

<script>
function openImageModal(src, alt) {
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('modalImage').src = src;
    document.getElementById('modalImage').alt = alt;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection