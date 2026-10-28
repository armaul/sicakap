<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Shift Pagi, Shift Siang, Shift Malam, Shift Reguler
            $table->string('code')->unique(); // PAGI_SATPAM, SIANG_SATPAM, MALAM_SATPAM, PAGI_CARAKA
            $table->string('role')->default('all'); // satpam, caraka, all
            $table->time('start_time'); // 07:00:00
            $table->time('end_time'); // 15:00:00 or 07:00:00 (next day)
            $table->boolean('is_night_shift')->default(false); // true if shift crosses midnight
            $table->integer('grace_period_minutes')->default(15); // tolerance for late
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
