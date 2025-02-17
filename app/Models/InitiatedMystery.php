<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InitiatedMystery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mystery_id',
        'date',
        'completed',
        'observations'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mystery(): BelongsTo
    {
        return $this->belongsTo(Mystery::class);
    }
}
