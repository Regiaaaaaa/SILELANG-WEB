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
        Schema::create('verifikasi_lelang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_lelang_id')->constrained('barang_lelang');
            $table->foreignId('verified_by')->constrained('users');
            $table->enum('status', ['diterima', 'ditolak', 'menunggu']);
            $table->text('catatan')->nullable();
            $table->dateTime('waktu_verified')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_lelang');
    }
};
