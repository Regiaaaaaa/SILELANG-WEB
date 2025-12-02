<!-- resources/views/pantau/index.blade.php -->
@extends('layouts.app')

@section('title', 'Pantau Lelang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 flex items-center">
                <svg class="w-10 h-10 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Pantau Lelang
            </h1>
            <p class="text-gray-600 text-lg ml-13">Monitor lelang yang sedang aktif</p>
        </div>

        <!-- Loading State -->
        <div id="loading" class="flex items-center justify-center py-20">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-blue-600"></div>
        </div>

        <!-- Cards Grid -->
        <div id="cards" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- cards akan di-render di sini -->
        </div>

        <!-- Empty State -->
        <div id="empty" class="hidden text-center py-20">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-500 text-xl font-medium">Tidak ada lelang aktif saat ini.</p>
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

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    const cardsEl = document.getElementById('cards');
    const emptyEl = document.getElementById('empty');
    const loadingEl = document.getElementById('loading');

    try {
        const res = await fetch('/api/barang-lelang?status=aktif');
        if (!res.ok) throw new Error('Gagal load data');
        const json = await res.json();

        const items = json.data ?? json;

        loadingEl.classList.add('hidden');

        if (!items || items.length === 0) {
            emptyEl.classList.remove('hidden');
            return;
        }

        cardsEl.classList.remove('hidden');

        items.forEach(item => {
            let gambarUrl = null;
            try {
                const imgs = JSON.parse(item.gambar || '[]');
                gambarUrl = imgs.length ? `/storage/${imgs[0]}` : null;
            } catch(e) {
                gambarUrl = item.gambar ? `/storage/${item.gambar}` : null;
            }

            const card = document.createElement('div');
            card.className = 'bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group transform hover:-translate-y-1';

            card.innerHTML = `
                <div class="relative h-56 w-full bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden cursor-pointer" onclick="openImageModal('${gambarUrl || '/images/no-image.png'}', '${item.nama_barang}')">
                    ${gambarUrl ? `
                        <img src="${gambarUrl}" alt="${item.nama_barang}" class="object-cover h-full w-full group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    ` : `
                        <div class="flex items-center justify-center h-full">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    `}
                    <div class="absolute top-3 right-3 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                        Aktif
                    </div>
                </div>

                <div class="p-6">
                    <a href="/admin/pantau-lelang/${item.id}" class="block group">
                        <h2 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition-colors line-clamp-2">${item.nama_barang}</h2>
                    </a>

                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 mb-4 border-l-4 border-blue-500">
                        <p class="text-xs text-blue-600 font-semibold mb-1">Harga Awal</p>
                        <p class="text-lg font-bold text-blue-900">Rp ${Number(item.harga_awal).toLocaleString('id-ID')}</p>
                    </div>

                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Berakhir: ${new Date(item.waktu_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</span>
                    </div>

                    <a href="/admin/pantau-lelang/${item.id}" class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg">
                        Lihat Detail
                    </a>
                </div>
            `;
            cardsEl.appendChild(card);
        });

    } catch (err) {
        console.error(err);
        loadingEl.classList.add('hidden');
        emptyEl.innerHTML = `
            <svg class="w-24 h-24 mx-auto text-red-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-red-500 text-xl font-medium">Gagal memuat data. Silakan coba lagi.</p>
        `;
        emptyEl.classList.remove('hidden');
    }
});
</script>
@endsection