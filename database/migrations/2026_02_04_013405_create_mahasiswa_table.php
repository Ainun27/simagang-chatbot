<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nim');
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp');
            $table->string('universitas');
            
            // ===== PERBAIKI: PAKAI UUID JUGA =====
            $table->uuid('divisi_id');
            $table->foreign('divisi_id')
                  ->references('id')
                  ->on('divisi')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
};