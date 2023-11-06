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
        Schema::create('list_data_produk', function (Blueprint $table) {
            $table->bigIncrements('list_id');
            $table->char('produk_kode');
            $table->char('transaksi_kode');
            $table->char('customer_kode');
            $table->integer('jumlah');
            $table->integer('satuan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_data_produk');
    }
};
