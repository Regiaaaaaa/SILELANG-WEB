<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangLelang;
use App\Models\Penawaran;

class PantauLelangController extends Controller
{
    // Tampilkan view daftar lelang aktif (view akan panggil API via fetch)
    public function index()
    {
        return view('pantau.index');
    }

    // Tampilkan halaman detail lelang (view akan panggil API via fetch)
    public function show($id)
    {
        // Ambil lelang beserta relasi yang dibutuhkan (penawaran.user)
        $lelang = \App\Models\BarangLelang::with(['penawaran.user', 'user', 'kategori'])->findOrFail($id);

        // Ambil semua penawaran untuk lelang ini, urut tertinggi -> terendah
        $penawaran = $lelang->penawaran()
            ->with('user')
            ->orderBy('jumlah_penawaran', 'DESC')
            ->get();

        // Kirim ke view (tanpa pemenang / tanpa status selesai)
        return view('pantau.detail', compact('lelang', 'penawaran'));
    }




}
