<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const STATUS_FINISHED = 'finished';
    const STATUS_FAILED = 'failed';

    protected $fillable = [
        'user_id',
        'card_id',
        'merchant_id',
    ];

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
