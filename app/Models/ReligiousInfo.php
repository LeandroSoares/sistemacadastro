<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReligiousInfo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'religious_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'start_date',
        'start_location',
        'charity_house_start',
        'charity_house_end',
        'charity_house_observations',
        'development_start',
        'development_end',
        'service_start',
        'umbanda_baptism',
        'cambone_experience',
        'cambone_start_date',
        'cambone_end_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'charity_house_start' => 'date',
        'charity_house_end' => 'date',
        'development_start' => 'date',
        'development_end' => 'date',
        'service_start' => 'date',
        'umbanda_baptism' => 'date',
        'cambone_experience' => 'boolean',
        'cambone_start_date' => 'date',
        'cambone_end_date' => 'date'
    ];

    /**
     * Get the user that owns the religious information.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
