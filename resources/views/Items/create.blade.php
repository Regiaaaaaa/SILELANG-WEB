@extends('layouts.app')

@section('content')
<div class="px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Tambah Barang Lelang</h1>
                    <p class="text-slate-600">Lengkapi informasi barang yang akan dilelang</p>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data" id="barangForm">
                @csrf
                
                <div class="p-6 space-y-6">
                    <!-- Basic Information Section -->
                    <div class="border-b border-slate-200 pb-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informasi Dasar
                        </h2>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Barang -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Barang <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    name="nama_barang" 
                                    type="text"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white" 
                                    placeholder="Masukkan nama barang"
                                    required
                                >
                            </div>


                            <div>
    <label class="block text-sm font-semibold text-slate-700 mb-2">
        Kategori <span class="text-red-500">*</span>
    </label>
    <div class="relative">
        <select 
            name="kategori_id" 
            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white appearance-none"
            required
        >
            <option value="">Pilih kategori</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" 
                    {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>
        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
</div>


                            <!-- Kondisi -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Kondisi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select 
                                        name="kondisi" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white appearance-none"
                                        required
                                    >
                                        <option value="">Pilih kondisi</option>
                                        <option value="baru">Baru</option>
                                        <option value="bekas">Bekas</option>
                                    </select>
                                    <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Merek -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Merek <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    name="merek" 
                                    type="text"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white" 
                                    placeholder="Masukkan merek barang"
                                    required
                                >
                            </div>

                            <!-- Deskripsi -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    name="deskripsi" 
                                    rows="4"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white resize-none" 
                                    placeholder="Deskripsikan barang secara detail..."
                                    required
                                ></textarea>
                                <p class="text-xs text-slate-500 mt-1">Jelaskan kondisi, fitur, dan detail penting lainnya</p>
                            </div>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="border-b border-slate-200 pb-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Upload Gambar
                        </h2>

                        <div class="space-y-4">
                            <!-- File Upload Area -->
                            <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors duration-200" id="uploadArea">
                                <div class="flex flex-col items-center space-y-3">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-medium text-slate-700">Upload gambar barang</p>
                                        <p class="text-sm text-slate-500">Pilih hingga 5 file gambar (JPG, PNG)</p>
                                    </div>
                                    <input 
                                        type="file" 
                                        name="gambar[]" 
                                        accept="image/*" 
                                        multiple 
                                        class="hidden" 
                                        id="fileInput"
                                        required
                                    >
                                    <button 
                                        type="button" 
                                        onclick="document.getElementById('fileInput').click()"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Pilih File
                                    </button>
                                </div>
                            </div>

                            <!-- File Preview -->
                            <div id="filePreview" class="hidden">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4" id="previewContainer">
                                </div>
                                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                    <div class="flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="text-sm text-blue-700">
                                            <p class="font-medium">Tips untuk foto yang baik:</p>
                                            <ul class="mt-1 space-y-1 list-disc list-inside">
                                                <li>Gunakan pencahayaan yang baik</li>
                                                <li>Ambil foto dari berbagai sudut</li>
                                                <li>Pastikan gambar jelas dan tidak blur</li>
                                                <li>Maksimal 2MB per file</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Price Section -->
                    <div class="border-b border-slate-200 pb-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Lokasi & Harga
                        </h2>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Lokasi -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    name="lokasi" 
                                    type="text"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white" 
                                    placeholder="Masukkan alamat lengkap"
                                    required
                                >
                            </div>

                            <!-- Harga Awal -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Harga Awal <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                                    <input 
                                        name="harga_awal" 
                                        type="number" 
                                        min="0"
                                        class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white" 
                                        placeholder="0"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Section -->
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Jadwal Lelang
                        </h2>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Waktu Mulai -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Waktu Mulai <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    name="waktu_mulai" 
                                    type="datetime-local" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white" 
                                    required
                                >
                            </div>

                            <!-- Waktu Selesai -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Waktu Selesai <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    name="waktu_selesai" 
                                    type="datetime-local" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-slate-50 focus:bg-white" 
                                    required
                                >
                            </div>
                        </div>

                        <!-- Schedule Info -->
                        <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div class="text-sm text-amber-700">
                                    <p class="font-medium">Perhatian:</p>
                                    <p class="mt-1">Pastikan waktu mulai dan selesai sudah benar. Jadwal tidak dapat diubah setelah lelang dimulai.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row sm:justify-between space-y-3 sm:space-y-0">
                    <div class="text-sm text-slate-500 flex items-center">
                        <span class="text-red-500">*</span>
                        <span class="ml-1">Field wajib diisi</span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button 
                            type="button"
                            onclick="window.history.back()"
                            class="inline-flex items-center px-6 py-3 border border-slate-300 text-slate-700 font-medium rounded-xl hover:bg-slate-50 transition-colors duration-200"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </button>
                        
                        <button 
                            type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 group"
                        >
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Barang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const previewContainer = document.getElementById('previewContainer');
    const uploadArea = document.getElementById('uploadArea');

    fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        
        if (files.length > 5) {
            alert('Maksimal 5 file yang dapat diupload');
            fileInput.value = '';
            return;
        }

        previewContainer.innerHTML = '';
        
        if (files.length > 0) {
            filePreview.classList.remove('hidden');
            
            files.forEach((file, index) => {
                if (file.size > 2 * 1024 * 1024) {
                    alert(`File ${file.name} terlalu besar. Maksimal 2MB per file.`);
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative group';
                    previewItem.innerHTML = `
                        <div class="aspect-square bg-slate-100 rounded-lg overflow-hidden border border-slate-200">
                            <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                            ${index + 1}
                        </div>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    `;
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        } else {
            filePreview.classList.add('hidden');
        }
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-blue-400', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
        
        const files = Array.from(e.dataTransfer.files);
        if (files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });

    // Form validation
    const form = document.getElementById('barangForm');
    form.addEventListener('submit', function(e) {
        const waktuMulai = new Date(document.querySelector('input[name="waktu_mulai"]').value);
        const waktuSelesai = new Date(document.querySelector('input[name="waktu_selesai"]').value);
        const now = new Date();

        if (waktuMulai < now) {
            e.preventDefault();
            alert('Waktu mulai tidak boleh kurang dari waktu sekarang');
            return;
        }

        if (waktuSelesai <= waktuMulai) {
            e.preventDefault();
            alert('Waktu selesai harus lebih besar dari waktu mulai');
            return;
        }
    });

    // Auto-format price input
    const priceInput = document.querySelector('input[name="harga_awal"]');
    priceInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });
});
</script>
@endsection