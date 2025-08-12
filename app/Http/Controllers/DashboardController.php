<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = $this->getDashboardStats();
        $recentLelang = $this->getRecentLelang();
        $summaryData = $this->getSummaryData();

        return view('dashboard', compact('stats', 'recentLelang', 'summaryData'));
    }

    private function getDashboardStats(): array
    {
        // Lelang aktif: status = aktif
        $lelangAktif = DB::table('barang_lelang')
            ->where('status', 'aktif')
            ->count();

        // Total pengguna (role = user, exclude admin)
        $totalPengguna = DB::table('users')
            ->where('role', 'user')
            ->count();

        // Total nilai penawaran tertinggi per barang (sebagai pendapatan estimasi)
        $totalPendapatan = DB::table('penawaran as p1')
            ->join('barang_lelang as bl', 'p1.barang_lelang_id', '=', 'bl.id')
            ->where('bl.status', 'selesai')
            ->where('p1.jumlah_penawaran', function($query) {
                $query->selectRaw('MAX(p2.jumlah_penawaran)')
                      ->from('penawaran as p2')
                      ->whereRaw('p2.barang_lelang_id = p1.barang_lelang_id');
            })
            ->sum('p1.jumlah_penawaran');

        // Barang terjual (status selesai)
        $barangTerjual = DB::table('barang_lelang')
            ->where('status', 'selesai')
            ->count();

        return [
            'lelang_aktif' => [
                'value' => $lelangAktif,
                'label' => 'Lelang Aktif',
                'subtitle' => 'Sedang Berjalan'
            ],
            'total_pengguna' => [
                'value' => $totalPengguna,
                'label' => 'Total User',
                'subtitle' => 'Pengguna Terdaftar'
            ],
            'pendapatan' => [
                'value' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'),
                'label' => 'Total Nilai Lelang',
                'subtitle' => 'Dari Barang Terjual'
            ],
            'barang_terjual' => [
                'value' => $barangTerjual,
                'label' => 'Barang Terjual',
                'subtitle' => 'Lelang Selesai'
            ]
        ];
    }

    private function getRecentLelang()
    {
        return DB::table('barang_lelang as bl')
            ->join('users as u', 'bl.users_id', '=', 'u.id')
            ->join('kategoris as k', 'bl.kategori_id', '=', 'k.id')
            ->leftJoin('users as winner', 'bl.pemenang_id', '=', 'winner.id')
            ->select(
                'bl.*',
                'u.name as pemilik',
                'k.nama_kategori',
                'winner.name as pemenang'
            )
             ->where('bl.status', 'selesai') //
             ->where('u.role', 'user')  
            ->orderBy('bl.created_at', 'desc')
            ->get();
    }

    private function getSummaryData()
    {
        // Kategori dengan nilai lelang
        $kategoriData = DB::table('kategoris as k')
            ->leftJoin('barang_lelang as bl', 'k.id', '=', 'bl.kategori_id')
            ->leftJoin('penawaran as p', function($join) {
                $join->on('bl.id', '=', 'p.barang_lelang_id')
                     ->whereRaw('p.jumlah_penawaran = (
                         SELECT MAX(p2.jumlah_penawaran) 
                         FROM penawaran p2 
                         WHERE p2.barang_lelang_id = bl.id
                     )');
            })
            ->where('bl.status', 'selesai')
            ->groupBy('k.id', 'k.nama_kategori')
            ->select('k.nama_kategori', DB::raw('COALESCE(SUM(p.jumlah_penawaran), 0) as total'))
            ->get();

        // Status distribution
        $statusData = DB::table('barang_lelang')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Additional stats
        $additionalStats = [
            'total_penawaran' => DB::table('penawaran')->count(),
            'total_kategori' => DB::table('kategoris')->count(),
            'verified_lelang' => DB::table('verifikasi_lelang')->where('status', 'diterima')->count()
        ];

        return [
            'kategori' => $kategoriData,
            'status' => $statusData,
            'additional' => $additionalStats
        ];
    }
}