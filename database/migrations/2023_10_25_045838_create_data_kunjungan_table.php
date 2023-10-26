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
        Schema::create('data_kunjungan', function (Blueprint $table) {
            $table->bigIncrements('kunjungan_id');
            $table->integer('user_id');
            $table->integer('rute_id');
            $table->date('kunjungan_tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kunjungan');
    }
};
