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
        Schema::create('reservations', function (Blueprint $table) {
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('copy_id')->references('copy_id')->on('copies');
            
            $table->date('start')->default(now());
            $table->primary(['user_id', 'copy_id', 'start']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
