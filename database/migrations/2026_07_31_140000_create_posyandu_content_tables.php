<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posyandu_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bidan')->unique();
            $table->string('subtitle');
            $table->string('wilayah');
            $table->text('deskripsi');
            $table->string('foto_path')->nullable();
            $table->timestamps();
        });

        Schema::create('posyandu_officers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_posyandu')->index();
            $table->string('jabatan');
            $table->string('nama');
            $table->unsignedTinyInteger('level')->default(3);
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
            $table->unique(['nama_posyandu', 'jabatan']);
        });

        Schema::create('posyandu_educations', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['GIZI', 'IMUNISASI', 'PHBS'])->index();
            $table->string('judul')->unique();
            $table->text('deskripsi');
            $table->string('poster_url');
            $table->string('thumbnail_url')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('posyandu_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->unique();
            $table->date('tanggal')->index();
            $table->string('foto_url');
            $table->string('thumbnail_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posyandu_galleries');
        Schema::dropIfExists('posyandu_educations');
        Schema::dropIfExists('posyandu_officers');
        Schema::dropIfExists('posyandu_profiles');
    }
};