<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // Sakit, Izin, Cuti, Dinas Luar
            $table->date('start_date');
            $table->date('end_date');
            $table->text('alasan');
            $table->string('surat_bukti')->nullable(); // path to uploaded file/photo
            $table->string('status')->default('Menunggu'); // Menunggu, Disetujui, Ditolak
            $table->text('catatan_atasan')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
