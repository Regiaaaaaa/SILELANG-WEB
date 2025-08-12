@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10"
     x-data="{ openEditModal: false, editData: {} }">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
            Manajemen Kategori
        </h1>
        <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-600">
            {{ $kategoris->count() }} kategori
        </span>
    </div>

    {{-- Form Tambah --}}
    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-5 mb-8">
        <form action="{{ route('admin.kategori.store') }}" method="POST"
              class="flex flex-col sm:flex-row items-end gap-4">
            @csrf
            <div class="w-full sm:w-1/3">
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" placeholder="Contoh: Elektronik"
                       class="border-slate-300 rounded-md shadow-sm w-full
                              focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="w-full sm:w-1/3">
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <input type="text" name="deskripsi" placeholder="Optional"
                       class="border-slate-300 rounded-md shadow-sm w-full
                              focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit"
                    class="w-full sm:w-auto flex items-center gap-2
                           bg-indigo-600 hover:bg-indigo-700 text-white
                           px-5 py-2.5 rounded-md font-semibold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                     d="M12 4v16m8-8H4"/></svg>
                Tambah
            </button>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            Nama Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($kategoris as $kategori)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            {{ $kategori->nama_kategori }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $kategori->deskripsi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <button @click="openEditModal = true; editData = {{ $kategori }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-md
                                           bg-amber-100 text-amber-700 hover:bg-amber-200 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </button>

                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-md
                                               bg-rose-100 text-rose-700 hover:bg-rose-200 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                         stroke-width="2" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3"
                            class="px-6 py-12 text-center text-sm text-slate-500">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                              <path vector-effect="non-scaling-stroke" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada kategori</h3>
                            <p class="mt-1 text-sm text-slate-500">Silakan tambahkan kategori baru melalui form di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div x-show="openEditModal" x-transition.opacity
         class="fixed inset-0 bg-black/40 flex items-center justify-center z-50" x-cloak>
        <div x-show="openEditModal" x-transition
             class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Edit Kategori</h2>
            <form :action="`{{ route('admin.kategori.update', '') }}/${editData.id}`" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" x-model="editData.nama_kategori"
                           class="w-full border-slate-300 rounded-md shadow-sm
                                  focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <input type="text" name="deskripsi" x-model="editData.deskripsi"
                           class="w-full border-slate-300 rounded-md shadow-sm
                                  focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openEditModal = false"
                            class="px-4 py-2 text-sm font-semibold rounded-md bg-slate-100 text-slate-700
                                   hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-semibold rounded-md bg-indigo-600 text-white
                                   hover:bg-indigo-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection