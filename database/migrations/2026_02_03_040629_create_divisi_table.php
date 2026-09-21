<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('divisi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_divisi');
            $table->text('deskripsi')->nullable();
            $table->integer('kuota')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('divisi');
    }
};