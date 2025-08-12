@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Barang</h1>

    <!-- Alert -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul><li>{{ $errors->first() }}</li></ul>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
            <!-- Kolom 1 -->
            <div>
                <label class="block font-medium mb-1">Nama Barang</label>
                <input name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required
                       class="w-full border px-3 py-1.5 rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">Kategori</label>
                <select name="kategori_id" required class="w-full border px-3 py-1.5 rounded">
                    <option value="">Pilih</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" @selected(old('kategori_id', $barang->kategori_id) == $k->id)>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Kondisi</label>
                <select name="kondisi" required class="w-full border px-3 py-1.5 rounded">
                    <option value="baru" @selected(old('kondisi', $barang->kondisi) == 'baru')>Baru</option>
                    <option value="bekas" @selected(old('kondisi', $barang->kondisi) == 'bekas')>Bekas</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Merek</label>
                <input name="merek" value="{{ old('merek', $barang->merek) }}" required
                       class="w-full border px-3 py-1.5 rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">Lokasi</label>
                <input name="lokasi" value="{{ old('lokasi', $barang->lokasi) }}" required
                       class="w-full border px-3 py-1.5 rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">Harga Awal</label>
                <input type="number" name="harga_awal" min="0"
                       value="{{ old('harga_awal', $barang->harga_awal) }}" required
                       class="w-full border px-3 py-1.5 rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">Waktu Mulai</label>
                <input type="datetime-local"
                       value="{{ old('waktu_mulai', \Carbon\Carbon::parse($barang->waktu_mulai)->format('Y-m-d\TH:i')) }}"
                       name="waktu_mulai" required class="w-full border px-3 py-1.5 rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">Waktu Selesai</label>
                <input type="datetime-local"
                       value="{{ old('waktu_selesai', \Carbon\Carbon::parse($barang->waktu_selesai)->format('Y-m-d\TH:i')) }}"
                       name="waktu_selesai" required class="w-full border px-3 py-1.5 rounded">
            </div>
        </div>

        <!-- Deskripsi & Gambar -->
        <div class="mt-4">
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" required
                      class="w-full border px-3 py-1.5 rounded">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
        </div>

        <!-- Gambar -->
        <div class="mt-4">
            <label class="block font-medium mb-1">Gambar</label>
            @php
                $images = is_string($barang->gambar) ? json_decode($barang->gambar, true) : $barang->gambar;
                $images = $images ?? [];
            @endphp
            @if($images)
                <div class="flex gap-2 mb-2">
                    @foreach($images as $img)
                        <img src="{{ asset('storage/'.$img) }}" class="h-16 w-16 object-cover rounded border">
                    @endforeach
                </div>
            @endif
            <input type="file" name="gambar[]" accept="image/*" multiple
                   class="w-full border px-3 py-1.5 rounded text-sm">
            <small class="text-gray-500">JPG/PNG, max 2 MB/gambar. Kosongkan jika tidak diubah.</small>
        </div>

        <!-- Tombol -->
        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-yellow-600 text-white px-5 py-2 rounded hover:bg-yellow-700">
                Update
            </button>
            <a href="{{ route('admin.barang.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded hover:bg-gray-600">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection