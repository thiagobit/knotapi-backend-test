<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'expiry_date',
        'cvv',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
