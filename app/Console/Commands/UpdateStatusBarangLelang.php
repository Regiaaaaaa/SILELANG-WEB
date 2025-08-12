<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BarangLelang;
use App\Models\Penawaran;
use Carbon\Carbon;

class UpdateStatusBarangLelang extends Command
{
    protected $signature = 'lelang:update-status';
    protected $description = 'Update status barang lelang yang telah selesai dan isi pemenang_id';

    public function handle()
    {
        $now = Carbon::now();

        $expiredBarang = BarangLelang::where('status', 'aktif')
            ->where('waktu_selesai', '<=', $now)
            ->get();

        foreach ($expiredBarang as $barang) {
            $penawaranTertinggi = Penawaran::where('barang_lelang_id', $barang->id)
                ->orderByDesc('jumlah_penawaran')
                ->first();

            $barang->status = 'selesai';
            $barang->pemenang_id = $penawaranTertinggi?->users_id; // pakai null-safe
            $barang->save();

            $this->info("Barang ID {$barang->id} selesai. Pemenang: " . ($barang->pemenang_id ?? 'Tidak ada'));
        }

        $this->info("Semua barang yang selesai telah diperbarui.");
        return 0;
    }
}
