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
        Schema::create('transaksi_masuks', function (Blueprint $table) {
    $table->id();
    $table->string('nama_barang');
    $table->integer('jumlah');
    $table->date('tanggal');
    $table->string('Atas_Nama')->nullable();
    $table->string('bukti_pembayaran')->nullable(); // ← untuk upload file
    $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuks');
    }
};
