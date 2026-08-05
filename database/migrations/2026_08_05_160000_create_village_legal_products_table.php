<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_legal_products', function (Blueprint $table) {
            $table->id();
            $table->string('judul_peraturan')->unique();
            $table->string('nomor_tahun');
            $table->string('kategori')->index();
            $table->text('tentang');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_legal_products');
    }
};