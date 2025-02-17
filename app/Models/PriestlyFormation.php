<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriestlyFormation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'priestly_formations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'theology_start',
        'theology_end',
        'priesthood_start',
        'priesthood_end'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'theology_start' => 'date',
        'theology_end' => 'date',
        'priesthood_start' => 'date',
        'priesthood_end' => 'date'
    ];

    /**
     * Get the user that owns the priestly formation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
