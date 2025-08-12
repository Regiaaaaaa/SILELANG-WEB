<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangLelang extends Model
{
    use HasFactory;

    protected $table = 'barang_lelang';

    protected $fillable = [
        'users_id',
        'pemenang_id',
        'nama_barang',
        'kategori_id',
        'kondisi', // 'baru' or 'bekas'
        'merek',
        'deskripsi',
        'gambar',
        'lokasi',
        'harga_awal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];
    
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'harga_awal' => 'decimal:0',
        'gambar' => 'array', // Otomatis convert JSON ke array
    ];

    public function user() {
        return $this->belongsTo(User::class , 'users_id');
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function penawaran() {
        return $this->hasMany(Penawaran::class);
    }

    public function pemenang() {
        return $this->belongsTo(User::class, 'pemenang_id');
    }

    public function verifikasi() {
        return $this->hasOne(VerifikasiLelang::class);
    }

    public function transaksi() {
        return $this->hasMany(Transaksi::class);
    }
}
