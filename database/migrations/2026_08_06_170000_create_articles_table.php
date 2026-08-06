<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', ['KKN', 'Karang Taruna', 'Pemerintah Desa'])->index();
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamp('published_at')->useCurrent()->index();
            $table->string('author_name')->default('Admin Desa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};