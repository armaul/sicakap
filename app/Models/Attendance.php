<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift_id',
        'date',
        'jam_masuk',
        'foto_masuk',
        'lokasi_masuk',
        'jam_pulang',
        'foto_pulang',
        'lokasi_pulang',
        'durasi_menit',
        'durasi_kerja',
        'status',
        'catatan',
    ];

    protected $casts = [
        'date' => 'date',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
        'durasi_menit' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function hasClockedIn(): bool
    {
        return !is_null($this->jam_masuk);
    }

    public function hasClockedOut(): bool
    {
        return !is_null($this->jam_pulang);
    }

    /**
     * Compute duration and status from clock-in and clock-out
     */
    public function computeMetrics(): void
    {
        if ($this->jam_masuk && $this->jam_pulang) {
            $in = Carbon::parse($this->jam_masuk);
            $out = Carbon::parse($this->jam_pulang);

            $diffMinutes = max(0, $in->diffInMinutes($out));
            $this->durasi_menit = $diffMinutes;

            $hours = intdiv($diffMinutes, 60);
            $mins = $diffMinutes % 60;
            $this->durasi_kerja = "{$hours} Jam {$mins} Menit";
        }

        // Determine punctuality status if shift is assigned
        if ($this->jam_masuk && $this->shift) {
            $shiftStartTime = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->shift->start_time);
            $tolerance = $shiftStartTime->copy()->addMinutes($this->shift->grace_period_minutes);

            if ($this->jam_masuk->greaterThan($tolerance)) {
                $lateMinutes = $tolerance->diffInMinutes($this->jam_masuk);
                $this->status = 'Terlambat (' . $lateMinutes . 'm)';
            } else {
                $this->status = 'Tepat Waktu';
            }
        }
    }
}
