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
        Schema::create('transaksi_data_produk', function (Blueprint $table) {
            $table->bigIncrements('transaksi_id');
            $table->char('transaksi_kode');
            $table->char('customer_kode');
            $table->enum('status', ['', 'Selesai', 'Toko Tutup']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_data_produk');
    }
};
