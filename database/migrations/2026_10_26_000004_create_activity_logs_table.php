<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('attendance_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('category'); // Patroli, Kebersihan, Pengiriman Surat, Cek APAR, Serah Terima Jaga, Insiden
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Selesai'); // Selesai, Pending
            $table->text('photo')->nullable();
            $table->time('time_recorded')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
