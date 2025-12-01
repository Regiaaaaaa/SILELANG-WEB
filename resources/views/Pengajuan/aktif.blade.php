@extends('layouts.app')

@section('title', 'Pengajuan Barang Aktif')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengajuan Aktif</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola pengajuan barang lelang yang sedang berjalan</p>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @php
            $totalAktif = $pengajuan->count();
            $sedangBerlangsung = $pengajuan->filter(function($item) {
                if (!$item->waktu_mulai || !$item->waktu_selesai) return false;
                $now = now();
                return $now >= $item->waktu_mulai && $now <= $item->waktu_selesai;
            })->count();
            $akanDimulai = $pengajuan->filter(function($item) {
                if (!$item->waktu_mulai) return false;
                return now() < $item->waktu_mulai;
            })->count();
            $belumDijadwalkan = $pengajuan->filter(function($item) {
                return !$item->waktu_mulai || !$item->waktu_selesai;
            })->count();
        @endphp

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Aktif</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalAktif }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Sedang Berlangsung</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $sedangBerlangsung }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Akan Dimulai</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $akanDimulai }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Belum Dijadwalkan</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $belumDijadwalkan }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR BARANG -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Barang</h2>
                <div class="flex items-center space-x-2">
                    <input type="text" id="searchInput" placeholder="Cari barang..." 
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @if($pengajuan->count() > 0)
            <table class="w-full border-collapse">
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
                    @php
                        $now = now();
                        $waktuMulai = $item->waktu_mulai ? \Carbon\Carbon::parse($item->waktu_mulai) : null;
                        $waktuSelesai = $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai) : null;
                        
                        $statusClass = 'bg-gray-100 text-gray-800';
                        $statusText = 'Belum Dijadwalkan';
                        
                        if($waktuMulai && $waktuSelesai) {
                            if($now < $waktuMulai) {
                                $statusClass = 'bg-blue-100 text-blue-800';
                                $statusText = 'Akan Dimulai';
                            } elseif($now >= $waktuMulai && $now <= $waktuSelesai) {
                                $statusClass = 'bg-green-100 text-green-800';
                                $statusText = 'Berlangsung';
                            } else {
                                $statusClass = 'bg-red-100 text-red-800';
                                $statusText = 'Selesai';
                            }
                        }
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                    @if($item->gambar)
                                        @php
                                            $gambarArray = is_string($item->gambar) ? json_decode($item->gambar, true) : $item->gambar;
                                            $firstImage = is_array($gambarArray) ? ($gambarArray[0] ?? $item->gambar) : $item->gambar;
                                        @endphp
                                        <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $item->nama_barang }}" class="w-full h-full object-cover">
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
                                    <p class="text-xs text-gray-500">{{ $item->user->name ?? '-' }}</p>
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
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <button
                                onclick="lihatDetail({{ $item->id }})"
                                class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition-colors">
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
                <p class="mt-1 text-sm text-gray-500">Belum ada pengajuan barang lelang yang aktif.</p>
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

</div>

<!-- MODAL DETAIL -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border max-w-4xl shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <!-- Header Modal -->
            <div class="flex justify-between items-center mb-4 pb-4 border-b">
                <h3 class="text-lg font-bold text-gray-900">Detail Barang Lelang</h3>
                <button onclick="tutupModalDetail()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Loading State -->
            <div id="detailLoading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                <p class="mt-4 text-gray-600">Memuat data...</p>
            </div>
            
            <!-- Content Detail -->
            <div id="detailContent" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Info Kiri -->
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">Nama Barang</p>
                            <p id="detailNama" class="text-sm font-semibold text-gray-800"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Merek</p>
                                <p id="detailMerek" class="text-sm font-semibold text-gray-800"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Kondisi</p>
                                <p id="detailKondisi" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">Harga Awal</p>
                            <p id="detailHarga" class="text-sm font-semibold text-green-600"></p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">Lokasi</p>
                            <p id="detailLokasi" class="text-sm text-gray-700"></p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">Pemilik</p>
                            <p id="detailPemilik" class="text-sm font-semibold text-gray-800"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Waktu Mulai</p>
                                <p id="detailWaktuMulai" class="text-xs text-gray-700"></p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Waktu Selesai</p>
                                <p id="detailWaktuSelesai" class="text-xs text-gray-700"></p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                            <p id="detailDeskripsi" class="text-sm text-gray-700"></p>
                        </div>
                    </div>

                    <!-- Gambar Kanan -->
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-3">Gambar Barang</h4>
                        <div id="detailGambar" class="space-y-3">
                            <!-- Gambar akan dimuat via JS -->
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="flex justify-end mt-6 pt-4 border-t">
                    <button onclick="tutupModalDetail()" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentBarangId = null;

    // Get token dari localStorage atau meta tag
    function getAuthToken() {
        let token = localStorage.getItem('auth_token') || localStorage.getItem('token');
        if (!token) {
            token = sessionStorage.getItem('auth_token') || sessionStorage.getItem('token');
        }
        if (!token) {
            const metaToken = document.querySelector('meta[name="api-token"]');
            if (metaToken) {
                token = metaToken.getAttribute('content');
            }
        }
        return token;
    }

    // Fungsi untuk melihat detail barang
    function lihatDetail(id) {
        currentBarangId = id;
        document.getElementById('modalDetail').classList.remove('hidden');
        document.getElementById('detailLoading').classList.remove('hidden');
        document.getElementById('detailContent').classList.add('hidden');
        
        const token = getAuthToken();
        
        if (!token) {
            alert('Token autentikasi tidak ditemukan. Silakan login ulang.');
            tutupModalDetail();
            return;
        }

        console.log('Fetching detail for ID:', id);

        fetch(`/api/barang-lelang/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            }
        })
        .then(async res => {
            console.log('Response status:', res.status);
            const data = await res.json();
            console.log('Response data:', data);
            
            if (!res.ok) {
                throw new Error(data.message || `HTTP ${res.status}`);
            }
            return data;
        })
        .then(data => {
            populateDetailModal(data.data || data);
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Terjadi kesalahan saat memuat detail barang: ' + err.message);
            tutupModalDetail();
        });
    }

    // Fungsi untuk mengisi data ke modal detail
    function populateDetailModal(item) {
        try {
            document.getElementById('detailNama').textContent = item.nama_barang || '-';
            document.getElementById('detailMerek').textContent = item.merek || '-';
            document.getElementById('detailKondisi').textContent = item.kondisi ? item.kondisi.charAt(0).toUpperCase() + item.kondisi.slice(1) : '-';
            document.getElementById('detailHarga').textContent = item.harga_awal ? 'Rp ' + new Intl.NumberFormat('id-ID').format(item.harga_awal) : '-';
            document.getElementById('detailLokasi').textContent = item.lokasi || '-';
            document.getElementById('detailWaktuMulai').textContent = item.waktu_mulai ? new Date(item.waktu_mulai).toLocaleString('id-ID') : '-';
            document.getElementById('detailWaktuSelesai').textContent = item.waktu_selesai ? new Date(item.waktu_selesai).toLocaleString('id-ID') : '-';
            document.getElementById('detailPemilik').textContent = (item.user && item.user.name) ? item.user.name : '-';
            document.getElementById('detailDeskripsi').textContent = item.deskripsi || 'Tidak ada deskripsi';

            // Tampilkan gambar
            const gambarContainer = document.getElementById('detailGambar');
            gambarContainer.innerHTML = '';

            let gambarArray = [];
            if (item.gambar) {
                if (typeof item.gambar === 'string') {
                    try {
                        gambarArray = JSON.parse(item.gambar);
                    } catch (e) {
                        gambarArray = [item.gambar];
                    }
                } else if (Array.isArray(item.gambar)) {
                    gambarArray = item.gambar;
                } else {
                    gambarArray = [item.gambar];
                }
            }

            if (gambarArray && gambarArray.length > 0) {
                gambarArray.forEach((gambar, index) => {
                    const imgElement = document.createElement('img');
                    imgElement.src = `/storage/${gambar}`;
                    imgElement.alt = `Gambar ${item.nama_barang} ${index + 1}`;
                    imgElement.className = 'w-full h-48 object-cover rounded-lg border shadow-sm cursor-pointer hover:shadow-md transition-shadow';
                    imgElement.onclick = () => window.open(`/storage/${gambar}`, '_blank');
                    
                    imgElement.onerror = function() {
                        this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+CiAgPHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkdhbWJhciB0aWRhayBkaW11YXQ8L3RleHQ+Cjwvc3ZnPg==';
                        this.onclick = null;
                        this.style.cursor = 'default';
                    };
                    
                    gambarContainer.appendChild(imgElement);
                });
            } else {
                gambarContainer.innerHTML = '<p class="text-gray-500 text-sm">Tidak ada gambar</p>';
            }

            // Sembunyikan loading dan tampilkan content
            document.getElementById('detailLoading').classList.add('hidden');
            document.getElementById('detailContent').classList.remove('hidden');
            
        } catch (error) {
            console.error('Error populating modal:', error);
            alert('Terjadi kesalahan saat menampilkan detail barang');
            tutupModalDetail();
        }
    }

    // Fungsi untuk menutup modal detail
    function tutupModalDetail() {
        document.getElementById('modalDetail').classList.add('hidden');
        currentBarangId = null;
    }

    // Event listener untuk menutup modal dengan ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            tutupModalDetail();
        }
    });

    // Event listener untuk menutup modal dengan klik backdrop
    document.getElementById('modalDetail').addEventListener('click', function(event) {
        if (event.target === this) {
            tutupModalDetail();
        }
    });

    // Search functionality
    document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    console.log('Current auth token:', getAuthToken());
</script>
@endsection