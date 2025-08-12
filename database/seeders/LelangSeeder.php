<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\BarangLelang;

class LelangSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'no_telepon' => '081281881129',
            'password' => Hash::make('adminaja'),
        ]);

        // User biasa 1
        $user1 = User::create([
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'role' => 'user',
            'no_telepon' => '081234567890',
            'password' => Hash::make('password'),
        ]);

        // User biasa 2
        $user2 = User::create([
            'name' => 'User2',
            'email' => 'user2@gmail.com',
            'role' => 'user',
            'no_telepon' => '081234567891',
            'password' => Hash::make('password'),
        ]);

        // Tambahkan Kategori Lelang
        $kategoris = [
            ['nama_kategori' => 'Elektronik', 'deskripsi' => 'Barang elektronik seperti HP, Laptop, dll'],
            ['nama_kategori' => 'Kendaraan', 'deskripsi' => 'Mobil, motor, dan kendaraan lainnya'],
            ['nama_kategori' => 'Perhiasan', 'deskripsi' => 'Emas, berlian, dan perhiasan lainnya'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        // Dummy Barang Lelang dari User1 (status pending otomatis)
        BarangLelang::create([
            'users_id' => $user1->id,
            'nama_barang' => 'Honda Beat',
            'kategori_id' => 2, // Kendaraan
            'kondisi' => 'bekas',
            'merek' => 'HONDA',
            'deskripsi' => 'Kondisi Mulus, Unit Langka',
            'gambar' => json_encode([
                'speaker-depan.jpg',
                'speaker-belakang.jpg',
                'speaker-samping.jpg',
                'laptop.jpg'
            ]),
            'lokasi' => 'DEPOK BARU, BEJI JAWA BARAT',
            'harga_awal' => 1450000,
            'waktu_mulai' => '2025-08-09 14:50:00',
            'waktu_selesai' => '2025-08-09 14:55:00',
        ]);
    }
}
