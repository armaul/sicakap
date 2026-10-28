<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shift_id')->constrained()->cascadeOnDelete();
            $table->date('date'); // tanggal jadwal shift (e.g. 2026-10-26)
            $table->dateTime('jam_masuk')->nullable();
            $table->text('foto_masuk')->nullable(); // selfie url / path
            $table->string('lokasi_masuk')->nullable(); // GPS coordinates or label
            $table->dateTime('jam_pulang')->nullable();
            $table->text('foto_pulang')->nullable(); // selfie checkout url / path
            $table->string('lokasi_pulang')->nullable(); // GPS coordinates or label
            $table->integer('durasi_menit')->nullable(); // in minutes
            $table->string('durasi_kerja')->nullable(); // e.g. "8 Jam 15 Menit"
            $table->string('status')->default('Hadir'); // Tepat Waktu, Terlambat, Hadir, Pulang Cepat, Izin, Sakit
            $table->text('catatan')->nullable(); // catatan aktivitas / pos jaga
            $table->timestamps();

            $table->unique(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
