<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Penawaran;
use App\Models\BarangLelang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use App\Http\Controllers\Controller;

class PenawaranController extends Controller
{
    // USER - Kirim Penawaran
    public function userStore(Request $request)
    {
        try {
            $request->validate([
                'barang_lelang_id'    => 'required|exists:barang_lelang,id',
                'jumlah_penawaran'    => 'required|numeric|min:1',
            ]);

            $user   = Auth::user();
            $barang = BarangLelang::findOrFail($request->barang_lelang_id);

            // Validasi status barang
            if ($barang->status !== 'aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu lelang telah berakhir, penawaran tidak bisa dilakukan'
                ], 403);
            }

            // Validasi waktu lelang
            $now = Carbon::now();
            $waktuMulai = Carbon::parse($barang->waktu_mulai);
            $waktuSelesai = Carbon::parse($barang->waktu_selesai);

            if ($now->isBefore($waktuMulai)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lelang belum dimulai'
                ], 403);
            }

            if ($now->isAfter($waktuSelesai)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lelang sudah berakhir'
                ], 403);
            }

            // Validasi user tidak boleh bid barang sendiri
            if ($barang->users_id === $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menawar barang sendiri'
                ], 403);
            }

            // Validasi harga penawaran harus lebih tinggi dari harga awal
            if ($request->jumlah_penawaran < $barang->harga_awal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah penawaran harus lebih tinggi dari harga awal'
                ], 422);
            }

            // Validasi harga penawaran lebih tinggi dari penawaran tertinggi
            $penawaranTertinggi = Penawaran::where('barang_lelang_id', $barang->id)
                ->orderBy('jumlah_penawaran', 'desc')
                ->first();

            if ($penawaranTertinggi) {
                if ($request->jumlah_penawaran <= $penawaranTertinggi->jumlah_penawaran) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jumlah penawaran harus lebih tinggi dari penawaran sebelumnya'
                    ], 422);
                }

                // Validasi user tidak boleh bid berturut-turut
                if ($penawaranTertinggi->users_id === $user->id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda sudah memiliki penawaran tertinggi'
                    ], 422);
                }
            }

            // Buat penawaran baru
            $penawaran = Penawaran::create([
                'users_id'          => $user->id,
                'barang_lelang_id'  => $request->barang_lelang_id,
                'jumlah_penawaran'  => $request->jumlah_penawaran,
                'waktu_penawaran'   => Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Penawaran berhasil dikirim',
                'data' => $penawaran
            ], 201);

        } catch (Exception $e) {
            Log::error('Bid Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses penawaran'
            ], 500);
        }
    }

    // USER - Lihat semua penawaran user
    public function userIndex()
    {
        try {
            $user = Auth::user();
            $penawaran = Penawaran::where('users_id', $user->id)
                ->with(['barangLelang:id,nama_barang,gambar,status'])
                ->orderBy('waktu_penawaran', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'message' => 'Data penawaran berhasil diambil',
                'data' => $penawaran
            ]);

        } catch (Exception $e) {
            Log::error('Get User Bids Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data penawaran'
            ], 500);
        }
    }

    // ADMIN - Lihat semua penawaran untuk barang tertentu
    public function adminIndex($barangLelangId)
    {
        try {
            $penawaran = Penawaran::where('barang_lelang_id', $barangLelangId)
                ->with(['user:id,name,email', 'barangLelang:id,nama_barang'])
                ->orderBy('jumlah_penawaran', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'message' => 'Data penawaran berhasil diambil',
                'data' => $penawaran
            ]);

        } catch (Exception $e) {
            Log::error('Get Admin Bids Error', [
                'barang_lelang_id' => $barangLelangId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data penawaran'
            ], 500);
        }
    }

    // Get penawaran tertinggi untuk barang tertentu
    public function getHighestBid($barangLelangId)
    {
        try {
            $penawaran = Penawaran::where('barang_lelang_id', $barangLelangId)
                ->with('user:id,name')
                ->orderBy('jumlah_penawaran', 'desc')
                ->first();

            return response()->json([
                'success' => true,
                'data' => $penawaran
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    // Get history penawaran untuk barang tertentu
    public function getBidHistory($barangLelangId)
    {
        try {
            $penawaran = Penawaran::where('barang_lelang_id', $barangLelangId)
                ->with('user:id,name')
                ->orderBy('waktu_penawaran', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $penawaran
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    // ADMIN - Get semua penawaran (untuk dashboard admin)
    public function getAllBids(Request $request)
    {
        try {
            $query = Penawaran::with([
                'user:id,name,email', 
                'barangLelang:id,nama_barang,status,harga_awal'
            ]);

            // Filter berdasarkan status barang jika ada
            if ($request->has('status')) {
                $query->whereHas('barangLelang', function($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }

            // Filter berdasarkan tanggal jika ada
            if ($request->has('date_from')) {
                $query->whereDate('waktu_penawaran', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('waktu_penawaran', '<=', $request->date_to);
            }

            // Search berdasarkan nama barang atau user
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('barangLelang', function($subQ) use ($search) {
                        $subQ->where('nama_barang', 'like', "%{$search}%");
                    })->orWhereHas('user', function($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%");
                    });
                });
            }

            $penawaran = $query->orderBy('waktu_penawaran', 'desc')->paginate(20);

            return response()->json([
                'success' => true,
                'message' => 'Data semua penawaran berhasil diambil',
                'data' => $penawaran
            ]);

        } catch (Exception $e) {
            Log::error('Get All Bids Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data penawaran'
            ], 500);
        }
    }

    // USER - Get semua penawaran untuk barang tertentu (public view)
    public function getPublicBids($barangLelangId)
    {
        try {
            // Validasi barang lelang exists dan aktif
            $barang = BarangLelang::where('id', $barangLelangId)
                ->where('status', 'aktif')
                ->first();

            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barang lelang tidak ditemukan atau tidak aktif'
                ], 404);
            }

            $penawaran = Penawaran::where('barang_lelang_id', $barangLelangId)
                ->with('user:id,name') // Hide email untuk privacy
                ->orderBy('jumlah_penawaran', 'desc')
                ->paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Data penawaran berhasil diambil',
                'data' => $penawaran
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    // Get statistik penawaran (untuk dashboard)
    public function getBidStatistics()
    {
        try {
            $today = Carbon::today();
            $thisMonth = Carbon::now()->startOfMonth();

            $stats = [
                'total_bids' => Penawaran::count(),
                'today_bids' => Penawaran::whereDate('waktu_penawaran', $today)->count(),
                'month_bids' => Penawaran::where('waktu_penawaran', '>=', $thisMonth)->count(),
                'active_auctions' => BarangLelang::where('status', 'aktif')->count(),
                'top_bidders' => Penawaran::select('users_id')
                    ->selectRaw('COUNT(*) as total_bids')
                    ->selectRaw('MAX(jumlah_penawaran) as highest_bid')
                    ->with('user:id,name')
                    ->groupBy('users_id')
                    ->orderBy('total_bids', 'desc')
                    ->limit(5)
                    ->get()
            ];

            return response()->json([
                'success' => true,
                'message' => 'Statistik penawaran berhasil diambil',
                'data' => $stats
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    // USER - Lihat semua penawaran pada barang yang user sudah bid
    public function getUserBidsOnItem($barangLelangId)
    {
        try {
            $user = Auth::user();
            
            // Cek apakah user pernah bid pada barang ini
            $userHasBid = Penawaran::where('barang_lelang_id', $barangLelangId)
                ->where('users_id', $user->id)
                ->exists();

            if (!$userHasBid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum pernah menawar barang ini'
                ], 403);
            }

            // Validasi barang lelang exists
            $barang = BarangLelang::find($barangLelangId);
            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barang lelang tidak ditemukan'
                ], 404);
            }

            // Get semua penawaran pada barang ini
            $penawaran = Penawaran::where('barang_lelang_id', $barangLelangId)
                ->with(['user:id,name', 'barangLelang:id,nama_barang,status'])
                ->orderBy('jumlah_penawaran', 'desc')
                ->paginate(15);

            // Get penawaran user sendiri untuk highlight
            $userBids = Penawaran::where('barang_lelang_id', $barangLelangId)
                ->where('users_id', $user->id)
                ->orderBy('jumlah_penawaran', 'desc')
                ->get();

            // Get penawaran tertinggi user
            $userHighestBid = $userBids->first();
            
            // Cek apakah user sedang leading
            $highestBid = Penawaran::where('barang_lelang_id', $barangLelangId)
                ->orderBy('jumlah_penawaran', 'desc')
                ->first();

            $isLeading = $highestBid && $highestBid->users_id === $user->id;

            return response()->json([
                'success' => true,
                'message' => 'Data penawaran berhasil diambil',
                'data' => [
                    'all_bids' => $penawaran,
                    'user_bids' => $userBids,
                    'user_highest_bid' => $userHighestBid,
                    'is_leading' => $isLeading,
                    'barang' => $barang
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Get User Bids On Item Error', [
                'user_id' => Auth::id(),
                'barang_lelang_id' => $barangLelangId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data penawaran'
            ], 500);
        }
    }

    // USER - Get barang-barang yang pernah user bid (untuk dashboard user)
    public function getUserBiddedItems()
    {
        try {
            $user = Auth::user();
            
            $biddedItems = BarangLelang::whereHas('penawaran', function($query) use ($user) {
                $query->where('users_id', $user->id);
            })
            ->with([
                'penawaran' => function($query) use ($user) {
                    // Get penawaran tertinggi user pada setiap barang
                    $query->where('users_id', $user->id)
                          ->orderBy('jumlah_penawaran', 'desc')
                          ->limit(1);
                }
            ])
            ->withCount(['penawaran as total_bids'])
            ->select('id', 'nama_barang', 'gambar', 'status', 'harga_awal', 'waktu_mulai', 'waktu_selesai')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

            // Tambahkan info apakah user sedang leading di setiap barang
            $biddedItems->getCollection()->transform(function ($item) use ($user) {
                $highestBid = Penawaran::where('barang_lelang_id', $item->id)
                    ->orderBy('jumlah_penawaran', 'desc')
                    ->first();
                
                $item->is_leading = $highestBid && $highestBid->users_id === $user->id;
                $item->current_highest_bid = $highestBid ? $highestBid->jumlah_penawaran : $item->harga_awal;
                
                return $item;
            });

            return response()->json([
                'success' => true,
                'message' => 'Barang yang pernah dibid berhasil diambil',
                'data' => $biddedItems
            ]);

        } catch (Exception $e) {
            Log::error('Get User Bidded Items Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }
}