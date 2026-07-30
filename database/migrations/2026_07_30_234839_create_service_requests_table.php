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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_service_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('nama_lengkap');
            $table->string('nik', 16);
            $table->text('alamat');
            $table->string('no_whatsapp', 20);
            $table->string('file_lampiran')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
