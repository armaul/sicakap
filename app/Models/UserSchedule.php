<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'shift_id',
        'is_off',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'is_off' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isOff(): bool
    {
        return (bool) $this->is_off;
    }

    public function isWorking(): bool
    {
        return !$this->is_off;
    }
}
