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
        Schema::create('kuisioner', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->date('date');
            $table->boolean('confirm_statement')->default(false);
            $table->boolean('confirm_cabang')->nullable();
            $table->boolean('confirm_cabang2')->nullable();
            $table->boolean('is_bersalah')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuisioner');
    }
};
