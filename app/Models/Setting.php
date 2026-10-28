<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Cache static settings in memory per request
     */
    protected static array $cache = [];

    /**
     * Get a setting by key with a fallback default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, static::$cache)) {
            return static::$cache[$key];
        }

        try {
            if (!Schema::hasTable('settings')) {
                return $default;
            }

            $record = static::where('key', $key)->first();
            $val = $record ? $record->value : $default;
            static::$cache[$key] = $val;
            return $val;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /**
     * Store or update a setting.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value]
        );
        static::$cache[$key] = (string) $value;
    }

    /**
     * Get all location geofencing settings in a structured array.
     */
    public static function getLocationSettings(): array
    {
        return [
            'office_name' => static::get('location_office_name', 'SMKN 1 Jatisari (Kampus Utama)'),
            'latitude' => (float) static::get('location_latitude', -6.3655),
            'longitude' => (float) static::get('location_longitude', 107.5312),
            'radius_meters' => (int) static::get('location_radius_meters', 100),
            'is_enabled' => static::get('location_restriction_enabled', '1') === '1',
        ];
    }
}
