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
        Schema::create('village_potentials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('title_id');
            $table->string('title_jp');
            $table->text('content_id');
            $table->text('content_jp');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_potentials');
    }
};
