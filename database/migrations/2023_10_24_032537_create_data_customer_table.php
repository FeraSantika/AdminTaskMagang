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
        Schema::create('data_customer', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->char('customer_kode');
            $table->integer('kategori_customer_id');
            $table->integer('distributor_id');
            $table->integer('depo_id');
            $table->string('customer_nama');
            $table->char('customer_nomor_hp');
            $table->char('customer_alamat');
            $table->double('latitude', 10,8);
            $table->double('longtitude', 10,8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_customer');
    }
};
