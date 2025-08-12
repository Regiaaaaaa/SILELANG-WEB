<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_lelang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('pemenang_id')->nullable()->constrained('users'); 
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->enum('kondisi', ['baru', 'bekas']);
            $table->string('merek'); 
            $table->text('deskripsi');
            $table->json('gambar')->nullable();
            $table->string('lokasi');
            $table->integer('harga_awal');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->enum('status', ['menunggu', 'aktif', 'selesai', 'gagal', 'ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_lelang');
    }
};
