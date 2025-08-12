<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangLelang;
use Illuminate\Support\Facades\Auth;

class PengajuanUserController extends Controller
{
    /**
     * Menampilkan daftar pengajuan barang lelang yang statusnya menunggu
     */
    public function index()
    {
        $this->authorizeAdmin();

        $pengajuan = BarangLelang::with(['user', 'kategori'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengajuan.pending', compact('pengajuan'));
    }

    /**
     * Menampilkan daftar pengajuan barang lelang yang sudah disetujui/aktif
     */
    public function aktif()
{
    $this->authorizeAdmin();

    $pengajuan = BarangLelang::with(['user', 'kategori'])
        ->where('status', 'aktif')
        ->whereHas('user', function ($q) {
            $q->where('role', 'user'); // hanya barang dari user
        })
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('pengajuan.aktif', compact('pengajuan'));
}

    private function authorizeAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Access denied - Admin only');
        }
    }

   public function selesai()
{
    $this->authorizeAdmin();

    $pengajuan = BarangLelang::with(['user', 'kategori', 'pemenang', 'penawaran'])
        ->where('status', 'selesai')
        ->whereHas('user', function ($q) {
            $q->where('role', 'user');
        })
        ->orderBy('updated_at', 'desc')
        ->get()
        ->map(function ($item) {
            $item->jumlah_penawaran = $item->penawaran->max('jumlah_penawaran') ?? 0; // ganti 'harga_penawaran' sesuai nama kolom harga di tabel penawaran
            return $item;
        });

    return view('pengajuan.selesai', compact('pengajuan'));
}


}