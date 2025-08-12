<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'penawaran_id',
        'barang_lelang_id',
        'users_id',
        'harga_akhir',
        'order_id_midtrans',
        'status',
        'total_harga',
        'waktu_pembayaran',
    ];

    public function penawaran() {
        return $this->belongsTo(Penawaran::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function barangLelang() {
        return $this->belongsTo(BarangLelang::class);
    }

}
