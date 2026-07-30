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
        Schema::create('tax_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kegiatan');
            $table->date('tanggal')->index();
            $table->text('keterangan')->nullable();
            $table->boolean('is_routine_monthly')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_schedules');
    }
};
