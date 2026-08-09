<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table): void {
            $table->string('offline_sync_id', 100)->nullable()->unique()->after('id');
            $table->text('alamat_lengkap')->nullable()->after('rt_rw');
            $table->string('bentuk_usaha', 100)->nullable()->after('alamat_lengkap');
            $table->string('no_hp', 25)->nullable()->after('bentuk_usaha');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table): void {
            $table->dropUnique(['offline_sync_id']);
            $table->dropColumn(['offline_sync_id', 'alamat_lengkap', 'bentuk_usaha', 'no_hp']);
        });
    }
};