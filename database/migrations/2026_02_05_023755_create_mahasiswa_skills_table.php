<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa_skills', function (Blueprint $table) {
            $table->id();
            $table->uuid('mahasiswa_id');
            $table->string('skill_name');
            $table->enum('skill_level', ['beginner', 'intermediate', 'advanced', 'expert']);
            $table->integer('years_experience')->default(0);
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
        });

        // Tabel skill requirements divisi
        Schema::create('divisi_skill_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('divisi_id')->constrained('divisi')->onDelete('cascade');
            $table->string('skill_name');
            $table->enum('min_level', ['beginner', 'intermediate', 'advanced', 'expert']);
            $table->boolean('is_required')->default(false);
            $table->integer('weight')->default(1); // Bobot untuk AI scoring
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa_skills');
        Schema::dropIfExists('divisi_skill_requirements');
    }
};