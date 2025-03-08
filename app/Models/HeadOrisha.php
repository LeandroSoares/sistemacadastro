<?php

namespace App\Models;
use App\Traits\CalculatesCompletion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeadOrisha extends Model
{
    use HasFactory, CalculatesCompletion;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'head_orishas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'ancestor',
        'front',
        'front_together',
        'adjunct',
        'adjunct_together', 
        'left_side',
        'left_side_together',
        'right_side',
        'right_side_together'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'walk_together' => 'array'
    ];

    /**
     * Get the user that owns the orisha.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCompletionRate(): int
    {
        return $this->calculateCompletion([
            'ancestor' => 30,
            'front' => 30,
            'adjunct' => 25,
            'left_side' => 7.5,
            'right_side' => 7.5
        ]);
    }
}
