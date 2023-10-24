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
        Schema::create('Data_menu', function (Blueprint $table) {
            $table->bigIncrements('Menu_id');
            $table->char('Menu_name');
            $table->char('Menu_link');
            $table->enum('Menu_category', ['Master Menu','Sub Menu']);
            $table->bigInteger('Menu_sub')->nullable();
            $table->bigInteger('Menu_position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_menus');
    }
};
