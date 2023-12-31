<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    const STATUS_FINISHED = 'finished';
    const STATUS_FAILED = 'failed';
    const STATUS_FINISHED_CACHE_TAG = 'user_finished_tasks';

    protected $fillable = [
        'user_id',
        'card_id',
        'merchant_id',
    ];

    static public function getCacheKey(int $userId, string $status): ?string
    {
        return match ($status) {
            self::STATUS_FINISHED => "user_{$userId}_finished_tasks",
            self::STATUS_FAILED => "user_{$userId}_failed_tasks",
            default => null,
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function finish(): void
    {
        $this->status = self::STATUS_FINISHED;

        $this->save();
    }

    public function isFinished(): bool
    {
        return ($this->status === self::STATUS_FINISHED);
    }

    public function fail(): void
    {
        $this->status = self::STATUS_FAILED;

        $this->save();
    }

    public function isFailed(): bool
    {
        return ($this->status === self::STATUS_FAILED);
    }
}
