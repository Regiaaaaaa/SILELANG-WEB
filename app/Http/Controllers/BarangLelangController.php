<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangLelang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangLelangController extends Controller
{
    public function index()
{
    $this->authorizeAdmin();

    // Hanya ambil barang milik admin dan status aktif
    $barangs = BarangLelang::with('kategori')
        ->where('status', 'aktif')
        ->whereHas('user', function ($q) {
            $q->where('role', 'admin'); // cuma ambil barang dari admin
        })
        ->orderBy('created_at', 'desc')
        ->get();
        
    return view('Items.index', compact('barangs'));
}


    public function create()
    {
        $this->authorizeAdmin();

        $kategoris = Kategori::all(); // Ambil semua kategori
        return view('Items.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'kondisi' => 'required|in:baru,bekas',
            'merek' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'lokasi' => 'required|string|max:255',
            'harga_awal' => 'required|numeric|min:1000',
            'waktu_mulai' => 'required|date|after_or_equal:now',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('gambar', 'public');
                $gambarPaths[] = $path;
            }
        }

        BarangLelang::create([
            'users_id' => Auth::id(),
            'kategori_id' => $request->kategori_id,
            'nama_barang' => $request->nama_barang,
            'kondisi' => $request->kondisi,
            'merek' => $request->merek,
            'deskripsi' => $request->deskripsi,
            'gambar' => json_encode($gambarPaths),
            'lokasi' => $request->lokasi,
            'harga_awal' => $request->harga_awal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'aktif', // Admin langsung aktif (tidak perlu verifikasi)
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $barang = BarangLelang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('Items.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $barang = BarangLelang::findOrFail($id);

        // Validasi dengan required untuk field wajib
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'kondisi' => 'required|in:baru,bekas',
            'merek' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'lokasi' => 'required|string|max:255',
            'harga_awal' => 'required|numeric|min:1000',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        // Data yang akan diupdate
        $updateData = [
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'kondisi' => $request->kondisi,
            'merek' => $request->merek,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'harga_awal' => $request->harga_awal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ];

        // Handle gambar hanya jika ada file yang diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($barang->gambar) {
                foreach (json_decode($barang->gambar ?? '[]') as $oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Upload gambar baru
            $gambarPaths = [];
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('gambar', 'public');
                $gambarPaths[] = $path;
            }

            $updateData['gambar'] = json_encode($gambarPaths);
        }
        // Jika tidak ada file gambar yang diupload, biarkan gambar lama tetap ada

        // Update data
        $barang->update($updateData);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $barang = BarangLelang::findOrFail($id);

        if ($barang->gambar) {
            foreach (json_decode($barang->gambar) as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus');
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Access denied - Admin only');
        }
    }
}