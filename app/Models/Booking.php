<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'model_id',
        'client_id',
        'title',
        'description',
        'event_date',
        'location',
        'status',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }

    public function model()
    {
        return $this->belongsTo(User::class, 'model_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            default => 'Pending',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_CONFIRMED => 'account-badge--success',
            self::STATUS_COMPLETED => 'account-badge--info',
            self::STATUS_CANCELLED => 'account-badge--danger',
            default => 'account-badge--warning',
        };
    }
}
