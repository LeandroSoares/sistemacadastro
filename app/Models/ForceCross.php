<?php

namespace App\Models;
use App\Traits\CalculatesCompletion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForceCross extends Model
{
    use HasFactory, CalculatesCompletion;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'force_crosses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'top',
        'bottom',
        'left',
        'right'
    ];

    /**
     * Get the user that owns the force cross.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCompletionRate(): int
    {
        return $this->calculateCompletion([
            'top' => 25,
            'bottom' => 25,
            'left' => 25,
            'right' => 25
        ]);
    }
}
