<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nip',
        'email',
        'role', // satpam, caraka, supervisor, admin
        'position',
        'phone',
        'avatar',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(UserSchedule::class);
    }

    public function getScheduleForDate(string $date): ?UserSchedule
    {
        return $this->schedules()->whereDate('date', $date)->first();
    }

    public function isSatpam(): bool
    {
        return $this->role === 'satpam';
    }

    public function isCaraka(): bool
    {
        return $this->role === 'caraka';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSupervisor(): bool
    {
        return in_array($this->role, ['supervisor', 'admin']);
    }
}
