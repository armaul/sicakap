<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default location settings untuk SMKN 1 Jatisari
        $now = now();
        DB::table('settings')->insert([
            [
                'key' => 'location_office_name',
                'value' => 'SMKN 1 Jatisari (Kampus Utama)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'location_latitude',
                'value' => '-6.3655',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'location_longitude',
                'value' => '107.5312',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'location_radius_meters',
                'value' => '100',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'location_restriction_enabled',
                'value' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
