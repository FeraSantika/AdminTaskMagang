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
        Schema::create('Data_user', function (Blueprint $table) {
            $table->bigIncrements('User_id');
            $table->char('User_name');
            $table->char('User_email');
            $table->char('User_password');
            $table->enum('User_gender', ['Male', 'Female']);
            $table->char('User_photo')->nullable();
            $table->bigInteger('Role_id');
            $table->char('User_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_user');
    }
};
