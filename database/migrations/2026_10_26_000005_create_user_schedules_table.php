<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->foreignId('shift_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_off')->default(false); // true if employee is off/libur
            $table->string('notes')->nullable(); // e.g. "Pos Depan", "Libur Rutin", "Piket"
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'date']);
            $table->index(['date', 'is_off']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_schedules');
    }
};
