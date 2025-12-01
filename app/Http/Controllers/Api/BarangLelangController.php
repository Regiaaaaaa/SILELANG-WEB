<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BarangLelang;
use App\Models\VerifikasiLelang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Penawaran;
use App\Http\Controllers\Controller;


class BarangLelangController extends Controller
{
    public function index()
{
    // Update otomatis barang yang sudah selesai
    $now = Carbon::now();
    BarangLelang::where('status', 'aktif')
        ->where('waktu_selesai', '<=', $now)
        ->get()
        ->each(function ($barang) {
            // Cari penawaran tertinggi
            $penawaranTertinggi = Penawaran::where('barang_lelang_id', $barang->id)
                ->orderByDesc('jumlah_penawaran')
                ->first();

            $barang->status = 'selesai';
            $barang->pemenang_id = $penawaranTertinggi ? $penawaranTertinggi->users_id : null;
            $barang->save();
        });

    // Ambil hanya barang yang statusnya AKTIF untuk ditampilkan di mobile
    $barangAktif = BarangLelang::with('user')
        ->where('status', 'aktif')
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $barangAktif,
    ]);
}


    public function show($id)
    {
        $barang = BarangLelang::with(['user', 'pemenang'])->findOrFail($id);
        return response()->json($barang);
    }
    // ====================== USER ======================

    public function userStore(Request $request)
    {
        // Pastikan hanya user yang bisa akses
        $user = Auth::user();
        if (!$user || $user->role !== 'user') {
            return response()->json([
                'message' => 'Access denied - User only',
                'your_role' => $user ? $user->role : 'no user'
            ], 403);
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'kondisi' => 'required|in:baru,bekas',
            'merek' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'gambar' => 'required|array|min:1|max:5', 
            'gambar.*' => 'string|max:255', 
            'lokasi' => 'required|string|max:255',
            'harga_awal' => 'required|numeric|min:1000',
            'waktu_mulai' => 'nullable|date|after_or_equal:now',
            'waktu_selesai' => 'nullable|date|after:waktu_mulai',
        ]);

        $barang = BarangLelang::create([
            'users_id' => Auth::id(),
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'kondisi' => $request->kondisi,
            'merek' => $request->merek,
            'deskripsi' => $request->deskripsi,
            'gambar' => json_encode($request->gambar), // Simpan sebagai JSON array
            'lokasi' => $request->lokasi,
            'harga_awal' => $request->harga_awal,
            'waktu_mulai' => $request->waktu_mulai ?? Carbon::now(),
            'waktu_selesai' => $request->waktu_selesai ?? Carbon::now()->addDays(3),
            'status' => 'menunggu',
        ]);

        // Format response dengan gambar sebagai array
        $barangResponse = $barang->toArray();
        $barangResponse['gambar'] = json_decode($barang->gambar, true);

        return response()->json([
            'message' => 'Barang berhasil diajukan untuk review admin', 
            'data' => $barangResponse
        ], 201);
    }

    public function userUpdate(Request $request, $id)
    {
        // Pastikan hanya user yang bisa akses
        $user = Auth::user();
        if (!$user || $user->role !== 'user') {
            return response()->json([
                'message' => 'Access denied - User only',
                'your_role' => $user ? $user->role : 'no user'
            ], 403);
        }

        $barang = BarangLelang::where('id', $id)
            ->where('users_id', Auth::id())
            ->firstOrFail();

        if ($barang->status !== 'menunggu') {
            return response()->json(['message' => 'Barang tidak bisa diubah setelah diverifikasi'], 403);
        }

        $request->validate([
            'nama_barang' => 'sometimes|string|max:255',
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'kondisi' => 'sometimes|in:baru,bekas',
            'merek' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string|max:1000',
            'gambar' => 'sometimes|array|min:1|max:5', // Array minimal 1, maksimal 5 gambar
            'gambar.*' => 'string|max:255', // Setiap gambar harus string
            'lokasi' => 'sometimes|string|max:255',
            'harga_awal' => 'sometimes|numeric|min:1000',
            'waktu_mulai' => 'sometimes|date|after_or_equal:now',
            'waktu_selesai' => 'sometimes|date|after:waktu_mulai',
        ]);

        $updateData = $request->only([
            'nama_barang',
            'kategori_id',
            'kondisi',
            'merek',
            'deskripsi',
            'lokasi',
            'harga_awal',
            'waktu_mulai',
            'waktu_selesai'
        ]);

        // Handle gambar jika ada
        if ($request->has('gambar')) {
            $updateData['gambar'] = json_encode($request->gambar);
        }

        $barang->update($updateData);

        // Format response dengan gambar sebagai array
        $barangResponse = $barang->fresh()->toArray();
        $barangResponse['gambar'] = json_decode($barang->gambar, true);

        return response()->json([
            'message' => 'Barang berhasil diupdate', 
            'data' => $barangResponse
        ]);
    }

    public function userDestroy($id)
    {
        // Pastikan hanya user yang bisa akses
        $user = Auth::user();
        if (!$user || $user->role !== 'user') {
            return response()->json([
                'message' => 'Access denied - User only',
                'your_role' => $user ? $user->role : 'no user'
            ], 403);
        }

        $barang = BarangLelang::where('id', $id)
            ->where('users_id', Auth::id())
            ->firstOrFail();

        $barang->delete();

        return response()->json(['message' => 'Barang berhasil dihapus']);
    }

    // ====================== ADMIN ======================

    public function adminStore(Request $request)
    {
        // Pastikan hanya admin yang bisa akses
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'message' => 'Access denied - Admin only',
                'your_role' => $user ? $user->role : 'no user',
                'user_id' => $user ? $user->id : 'no user'
            ], 403);
        }

        $request->validate([
            'users_id' => 'required|exists:users,id',
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'kondisi' => 'required|in:baru,bekas',
            'merek' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'gambar' => 'nullable|array|max:5', // Array maksimal 5 gambar
            'gambar.*' => 'string|max:255', // Setiap gambar harus string
            'lokasi' => 'required|string|max:255',
            'harga_awal' => 'required|numeric|min:1000',
            'waktu_mulai' => 'required|date|after_or_equal:now',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'status' => 'required|in:menunggu,aktif,selesai,ditolak'
        ]);

        $barang = BarangLelang::create([
            'users_id' => $request->users_id,
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'kondisi' => $request->kondisi,
            'merek' => $request->merek,
            'deskripsi' => $request->deskripsi,
            'gambar' => json_encode($request->gambar), 
            'lokasi' => $request->lokasi,
            'harga_awal' => $request->harga_awal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => $request->status,
        ]);

        // Format response dengan gambar sebagai array
        $barangResponse = $barang->toArray();
        $barangResponse['gambar'] = $barang->gambar ? json_decode($barang->gambar, true) : null;

        return response()->json([
            'message' => 'Barang berhasil ditambahkan oleh admin', 
            'data' => $barangResponse
        ], 201);
    }

    public function adminUpdate(Request $request, $id)
    {
        // Pastikan hanya admin yang bisa akses
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'message' => 'Access denied - Admin only',
                'your_role' => $user ? $user->role : 'no user'
            ], 403);
        }

        $barang = BarangLelang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'sometimes|string|max:255',
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'kondisi' => 'sometimes|in:baru,bekas',
            'merek' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string|max:1000',
            'gambar' => 'sometimes|nullable|array|max:5', // Array maksimal 5 gambar
            'gambar.*' => 'string|max:255', // Setiap gambar harus string
            'lokasi' => 'sometimes|string|max:255',
            'harga_awal' => 'sometimes|numeric|min:1000',
            'waktu_mulai' => 'sometimes|date',
            'waktu_selesai' => 'sometimes|date|after:waktu_mulai',
            'status' => 'sometimes|in:menunggu,aktif,selesai,ditolak'
        ]);

        $updateData = $request->only([
            'nama_barang',
            'kategori_id',
            'kondisi',
            'merek',
            'deskripsi',
            'lokasi',
            'harga_awal',
            'waktu_mulai',
            'waktu_selesai',
            'status'
        ]);

        // Handle gambar jika ada
        if ($request->has('gambar')) {
            $updateData['gambar'] = $request->gambar ? json_encode($request->gambar) : null;
        }

        $barang->update($updateData);

        // Format response dengan gambar sebagai array
        $barangResponse = $barang->fresh()->toArray();
        $barangResponse['gambar'] = $barang->gambar ? json_decode($barang->gambar, true) : null;

        return response()->json([
            'message' => 'Barang berhasil diupdate oleh admin', 
            'data' => $barangResponse
        ]);
    }

    public function adminDestroy($id)
    {
        // Pastikan hanya admin yang bisa akses
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'message' => 'Access denied - Admin only',
                'your_role' => $user ? $user->role : 'no user'
            ], 403);
        }

        $barang = BarangLelang::findOrFail($id);
        $barang->delete();

        return response()->json(['message' => 'Barang berhasil dihapus oleh admin']);
    }

    public function verify($id)
    {
        // Pastikan hanya admin yang bisa akses
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'message' => 'Access denied - Admin only',
                'your_role' => $user ? $user->role : 'no user'
            ], 403);
        }

        $barang = BarangLelang::findOrFail($id);

        if ($barang->status !== 'menunggu') {
            return response()->json(['message' => 'Barang sudah diverifikasi atau ditolak'], 400);
        }

        $barang->update(['status' => 'aktif']);

        VerifikasiLelang::updateOrCreate(
            ['barang_lelang_id' => $barang->id],
            [
                'verified_by' => $user->id,
                'status' => 'diterima',
                'catatan' => null,
                'waktu_verified' => now()
            ]
        );

        return response()->json(['message' => 'Barang berhasil disetujui']);
    }

    public function reject(Request $request, $id)
    {
        // Pastikan hanya admin yang bisa akses
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'message' => 'Access denied - Admin only',
                'your_role' => $user ? $user->role : 'no user'
            ], 403);
        }

        $request->validate([
            'catatan' => 'required|string'
        ]);

        $barang = BarangLelang::findOrFail($id);

        if ($barang->status !== 'menunggu') {
            return response()->json(['message' => 'Barang sudah diverifikasi atau ditolak'], 400);
        }

        $barang->update(['status' => 'ditolak']);

        VerifikasiLelang::updateOrCreate(
            ['barang_lelang_id' => $barang->id],
            [
                'verified_by' => $user->id,
                'status' => 'ditolak',
                'catatan' => $request->catatan,
                'waktu_verified' => now()
            ]
        );

        return response()->json(['message' => 'Barang berhasil ditolak', 'alasan' => $request->catatan]);
    }


    
}