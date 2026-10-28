<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'role',
        'start_time',
        'end_time',
        'is_night_shift',
        'grace_period_minutes',
        'description',
    ];

    protected $casts = [
        'is_night_shift' => 'boolean',
        'grace_period_minutes' => 'integer',
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function getFormattedTimeAttribute(): string
    {
        $start = substr($this->start_time, 0, 5);
        $end = substr($this->end_time, 0, 5);
        $nightSuffix = $this->is_night_shift ? ' (Hari Berikutnya)' : '';
        return "{$start} - {$end} WIB{$nightSuffix}";
    }
}
