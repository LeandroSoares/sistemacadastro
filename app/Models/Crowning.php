<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Crowning extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crownings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'guide_name',
        'priest_name',
        'temple_name'
    ];

    /**
     * Get the user that owns the crowning.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
