<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CANCELLED = 'cancelled';

    public const PLANS = [
        'rookie' => [
            'name' => 'Rookie Trainer',
            'price' => 1500000,
            'duration_days' => 30,
            'duration_label' => '/month',
            'is_popular' => false,
            'btn_text' => 'Start Journey',
            'features' => [
                '1 Starter Pokémon of your choice',
                '5 Poké Balls',
                'Basic Trainer Card',
                'Access to Beginner Route',
            ],
        ],
        'challenger' => [
            'name' => 'Gym Challenger',
            'price' => 3500000,
            'duration_days' => 30,
            'duration_label' => '/month',
            'is_popular' => true,
            'btn_text' => 'Take The Challenge',
            'features' => [
                'Everything in Rookie',
                '10 Great Balls + 5 Potions',
                'Gym Badge Holder',
                'Type Matchup Cheat Sheet',
                'Free Nurse Joy visits',
            ],
        ],
        'elite' => [
            'name' => 'Elite Four Prep',
            'price' => 7000000,
            'duration_days' => 30,
            'duration_label' => '/month',
            'is_popular' => false,
            'btn_text' => 'Aim For Champion',
            'features' => [
                'Everything in Challenger',
                '5 Ultra Balls + Full Restore Kit',
                'Rare Candy (x3)',
                'TM library access',
                'Mock battles with Champion staff',
            ],
        ],
    ];

    public static function findPlan(string $key): ?array
    {
        return self::PLANS[$key] ?? null;
    }

    protected $fillable = [
        'user_id',
        'plan_name',
        'price',
        'status',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function planKey(): ?string
    {
        foreach (self::PLANS as $key => $plan) {
            if ($plan['name'] === $this->plan_name) {
                return $key;
            }
        }
        return null;
    }

    public function isCurrentlyActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE
            && $this->ends_at
            && $this->ends_at->isFuture();
    }

    public function isAwaitingPayment(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}
