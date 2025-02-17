<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LastTemple extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'last_temples';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'leader_name',
        'function',
        'exit_reason'
    ];

    /**
     * Get the user that owns the last temple record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
