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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained('penawaran');
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('barang_lelang_id')->constrained('barang_lelang');
            $table->enum('status', ['menunggu', 'dibayar', 'selesai', 'gagal']);
            $table->string('order_id_midtrans')->unique();
            $table->integer('total_harga');
            $table->dateTime('waktu_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
