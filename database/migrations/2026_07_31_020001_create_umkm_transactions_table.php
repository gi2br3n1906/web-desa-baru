<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_transactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('book_type', ['jual', 'kaso', 'hp'])->index();
            $table->date('date')->index();
            $table->string('title_or_product');
            $table->string('category')->nullable();
            $table->enum('transaction_type', ['masuk', 'keluar', 'piutang', 'hutang'])->nullable()->index();
            $table->integer('qty')->nullable();
            $table->decimal('price_per_unit', 12, 2)->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['lunas', 'belum'])->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_transactions');
    }
};
