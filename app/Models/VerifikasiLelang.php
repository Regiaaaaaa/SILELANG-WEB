<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiLelang extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_lelang';

    protected $fillable = [
        'barang_lelang_id', 'verified_by', 'status', 'catatan', 'waktu_verified'
    ];

    public function barangLelang() {
        return $this->belongsTo(BarangLelang::class);
    }

    public function verifiedBy() {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
