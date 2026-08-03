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
        Schema::create('kuisioner_cabang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuisioner_id');
            $table->unsignedBigInteger('dealercabang_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('mess')->nullable();
            $table->json('mekanik')->nullable(); // Untuk menyimpan array of string
            $table->string('atl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuisioner_cabang');
    }
};
