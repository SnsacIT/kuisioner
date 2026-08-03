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
        Schema::create('kuisioner_jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuisioner_cabang_id');
            $table->boolean('is_melakukan')->default(false);
            $table->boolean('is_mengetahui')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuisioner_jawaban');
    }
};
