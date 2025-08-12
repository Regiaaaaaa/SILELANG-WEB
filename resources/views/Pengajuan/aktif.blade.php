@extends('layouts.app')

@section('title', 'Pengajuan Barang Aktif')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Pengajuan Barang Lelang Aktif</h1>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Nama Barang</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Merek</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Kondisi</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Harga Awal</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Lokasi</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Pemilik</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Status Lelang</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $item->nama_barang }}</td>
                    <td class="px-4 py-3">{{ $item->merek }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full {{ $item->kondisi == 'baru' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($item->kondisi) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $item->lokasi }}</td>
                    <td class="px-4 py-3">{{ $item->user->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php
                            $now = now();
                            $waktuMulai = $item->waktu_mulai ? \Carbon\Carbon::parse($item->waktu_mulai) : null;
                            $waktuSelesai = $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai) : null;
                        @endphp
                        
                        @if($waktuMulai && $waktuSelesai)
                            @if($now < $waktuMulai)
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    Akan Dimulai
                                </span>
                            @elseif($now >= $waktuMulai && $now <= $waktuSelesai)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Sedang Berlangsung
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                    Selesai
                                </span>
                            @endif
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                Belum Dijadwalkan
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <!-- Tombol Detail -->
                        <button onclick="lihatDetail('{{ $item->id }}')"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                        Belum ada pengajuan barang lelang yang disetujui.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal untuk Detail Barang -->
<div id="modalDetail" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header Modal -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Detail Barang Lelang Aktif</h3>
                <button onclick="tutupModalDetail()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Loading State -->
            <div id="detailLoading" class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                <p class="mt-2 text-gray-600">Memuat data...</p>
            </div>
            
            <!-- Content Detail -->
            <div id="detailContent" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informasi Barang -->
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Informasi Barang</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nama Barang:</span>
                                    <span id="detailNama" class="font-medium"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Merek:</span>
                                    <span id="detailMerek" class="font-medium"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kondisi:</span>
                                    <span id="detailKondisi" class="font-medium"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Harga Awal:</span>
                                    <span id="detailHarga" class="font-medium text-green-600"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Lokasi:</span>
                                    <span id="detailLokasi" class="font-medium"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Waktu Mulai:</span>
                                    <span id="detailWaktuMulai" class="font-medium"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Waktu Selesai:</span>
                                    <span id="detailWaktuSelesai" class="font-medium"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Pemilik:</span>
                                    <span id="detailPemilik" class="font-medium"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span id="detailStatus" class="font-medium text-green-600">Disetujui</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Deskripsi -->
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Deskripsi</h4>
                            <p id="detailDeskripsi" class="text-sm text-gray-600 leading-relaxed"></p>
                        </div>
                    </div>
                    
                    <!-- Gambar Barang -->
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Gambar Barang</h4>
                        <div id="detailGambar" class="space-y-2">
                            <!-- Gambar akan dimuat di sini -->
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons di Modal -->
                <div class="flex justify-end space-x-2 mt-6 pt-4 border-t">
                    <button onclick="tutupModalDetail()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
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
        // Coba ambil dari localStorage dulu
        let token = localStorage.getItem('auth_token') || localStorage.getItem('token');
        
        // Jika tidak ada, coba dari sessionStorage
        if (!token) {
            token = sessionStorage.getItem('auth_token') || sessionStorage.getItem('token');
        }
        
        // Jika tidak ada, coba dari meta tag
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
            return;
        }

        // Fetch detail barang dari API
        fetch(`/api/barang-lelang/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
            }
        })
        .then(async res => {
            const data = await res.json();
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

            // Handle berbagai format data gambar
            let gambarArray = [];
            
            if (item.gambar) {
                // Jika gambar adalah string JSON, parse dulu
                if (typeof item.gambar === 'string') {
                    try {
                        gambarArray = JSON.parse(item.gambar);
                    } catch (e) {
                        // Jika tidak bisa di-parse, anggap sebagai string tunggal
                        gambarArray = [item.gambar];
                    }
                } 
                // Jika sudah array
                else if (Array.isArray(item.gambar)) {
                    gambarArray = item.gambar;
                }
                // Jika object atau format lain
                else {
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
                    
                    // Handle error loading gambar
                    imgElement.onerror = function() {
                        this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+CiAgPHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkdhbWJhciB0aWRhayBkYXBhdCBkaW11YXQ8L3RleHQ+Cjwvc3ZnPg==';
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

    // Debug function untuk cek token
    console.log('Current auth token:', getAuthToken());
</script>
@endsection