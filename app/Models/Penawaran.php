<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;

    protected $table = 'penawaran';

    protected $fillable = [
        'users_id',
        'barang_lelang_id',
        'jumlah_penawaran',
        'waktu_penawaran',
        
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function barangLelang() {
        return $this->belongsTo(BarangLelang::class);
    }

    public function transaksi() {
        return $this->hasOne(Transaksi::class);
    }
}
